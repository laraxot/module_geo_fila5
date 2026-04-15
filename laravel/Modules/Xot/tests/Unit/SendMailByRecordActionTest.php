<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
use Illuminate\Mail\Mailable;
>>>>>>> 4ffe7f41e (.)
>>>>>>> 9506daa5 (.)
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailable;
use Modules\Xot\Actions\Mail\SendMailByRecordAction;

it('throws if record has no email', function (): void {
    $record = new class extends Model {
        // no email attribute
        public function option(string $key): ?string
        {
            return null;
        }

        public function myLogs()
        {
            return new class {
                public function create(array $data): void
                {
                }
            };
        }
    };

    expect(fn () => app(SendMailByRecordAction::class)->execute($record, Mailable::class))
        ->toThrow(InvalidArgumentException::class);
});
