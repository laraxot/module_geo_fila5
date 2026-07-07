<?php

namespace Spatie\QueueableAction;

use Illuminate\Contracts\Queue\Job;

/**
 * Stub for PHPStan static analysis of Spatie QueueableAction trait.
 * Provides type information for the trait methods during static analysis.
 *
 * @see https://github.com/spatie/laravel-queueable-action
 */
trait QueueableAction
{
    public ?Job $job = null;

    /**
     * Set the queue this job should be dispatched to.
     *
     * @param string|null $queue
     * @return static
     */
    public function onQueue(?string $queue = null): static
    {
    }

    /**
     * Get the middleware the action should pass through.
     *
     * @return array<string>
     */
    public function middleware(): array
    {
        return [];
    }

    /**
     * Get the tags the action should be tagged with.
     *
     * @return array<string>
     */
    public function tags(): array
    {
        return [];
    }

    /**
     * Get the backoff strategy for the action.
     *
     * @return array<int, int>|int
     */
    public function backoff(): array|int
    {
        return 0;
    }

    /**
     * Get the queue method to use for the action.
     *
     * @return string
     */
    public function queueMethod(): string
    {
        return 'dispatch';
    }
}
