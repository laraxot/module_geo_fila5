<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Traits\Fixtures;

/**
 * Marker fixture for PasswordValidationRules trait tests.
 *
 * Intentionally does not use the trait: PHPStan would analyze passwordRules()
 * against the missing Modules\User\Rules\Password class in test context.
 */
final class PasswordValidationRulesFixture
{
}
