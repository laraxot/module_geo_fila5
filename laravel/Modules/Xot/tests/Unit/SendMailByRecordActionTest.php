<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Actions\Mail\SendMailByRecordAction;

it('throws if record has no email', function (): void {
    /** @var Modules\Xot\Tests\TestCase $this */
    $record = new class extends Model {
        public function option(string $key): null
        {
            return null;
        }

        public function myLogs(): object
        {
            return new class {
                /** @param array<mixed> $data */
                public function create(array $data): void
                {
                }
            };
        }
    };

    $this->expectThrowable(InvalidArgumentException::class);

    app(SendMailByRecordAction::class)->execute($record, stdClass::class);
});
