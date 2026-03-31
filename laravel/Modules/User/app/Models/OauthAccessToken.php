<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\Token as PassportToken;
use Modules\User\Database\Factories\OauthAccessTokenFactory;

/**
 * Passport Token model for User module.
 *
 * Extends Laravel\Passport\Token to provide custom behavior
 * and use the user connection for multi-tenancy.
 *
 * @property string              $id
 * @property string              $user_id
 * @property string              $client_id
 * @property string|null         $name
 * @property string|null         $scopes
 * @property bool                $revoked
 * @property \Carbon\Carbon|null $expires_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class OauthAccessToken extends PassportToken
{
    use HasFactory;

    /** @var string */
    protected $connection = 'user';

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): OauthAccessTokenFactory
    {
        return OauthAccessTokenFactory::new();
    }
}
