<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

use Modules\Xot\Actions\Cast\SafeStringCastAction;

final class SmsData
{
    public string $from;

    public string $recipient;

    public string $body;

    /**
     * Create a new SmsData instance.
     *
     * @param  array  $data
     */
    public function __construct(array<string, mixed> $data = [])
    {
        $this->from = SafeStringCastAction::cast($data['from'] ?? '');
        $this->recipient = SafeStringCastAction::cast($data['recipient'] ?? '');
        $this->body = SafeStringCastAction::cast($data['body'] ?? '');
    }

    /**
     * Named constructor for convenience.
     *
     * @param  array  $data
     */
    public static function from(array $data): self
    {
        return new self($data);
    }
}
