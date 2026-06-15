<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Traits\Fixtures;

/**
 * Mockable stand-in for password rule consumers in unit tests.
 */
class PasswordValidationRulesMockableFixture
{
    /**
     * @return array<int, string>
     */
    public function getPasswordRules(): array
    {
        return ['required', 'string', 'confirmed'];
    }
}
