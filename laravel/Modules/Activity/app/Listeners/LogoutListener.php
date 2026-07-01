<?php

declare(strict_types=1);

namespace Modules\Activity\Listeners;

use DateTimeInterface;
use Illuminate\Auth\Events\Logout;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;
use Modules\Activity\Models\Activity;

class LogoutListener
{
    /**
     * Handle the event.
     */
    public function handle(Logout $event): void
    {
        if (! $event->user) {
            return;
        }

        $activity = new Activity;
        $activity->log_name = 'auth';
        $activity->description = 'User logged out'; // specific string not enforced but 'logout' must be contained
        $activity->event = 'logout';

        // Type narrowing for $event->user to ensure it's a Model
        if ($event->user instanceof Model) {
            $activity->causer()->associate($event->user);
        }

        $activity->properties = $this->buildProperties($event);
        $activity->save();
    }

    /**
     * @return array<string, mixed>
     */
    private function buildProperties(Logout $event): array
    {
        $properties = [
            'guard' => $event->guard,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'timestamp' => now()->timestamp,
        ];

        $sessionDuration = $this->resolveSessionDuration($event);
        if ($sessionDuration !== null) {
            $properties['session_duration'] = $sessionDuration;
        }

        if (Request::has('logout_reason')) {
            $properties['logout_reason'] = Request::input('logout_reason');
        }

        return $properties;
    }

    private function resolveSessionDuration(Logout $event): ?int
    {
        // Handle session duration if last_login_at is available
        // Assuming last_login_at is a Casted Carbon instance or string
        if (! isset($event->user->last_login_at)) {
            return null;
        }

        /** @var mixed $lastLoginRaw */
        $lastLoginRaw = $event->user->last_login_at;

        if (! is_string($lastLoginRaw) && ! $lastLoginRaw instanceof DateTimeInterface) {
            return null;
        }

        /** @var Carbon $lastLogin */
        $lastLogin = Carbon::parse($lastLoginRaw);

        return (int) abs(now()->diffInSeconds($lastLogin));
    }
}
