<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\GeoData;

use Modules\Geo\Actions\GeoData\GeoDataValidationRules;

it('returns validation rules and messages with string keys', function (): void {
    $payload = app(GeoDataValidationRules::class)->execute();

    expect($payload)
        ->toHaveKeys(['rules', 'messages'])
        ->and($payload['rules'])->toBe(GeoDataValidationRules::RULES)
        ->and($payload['messages'])->toBe(GeoDataValidationRules::MESSAGES);
});
