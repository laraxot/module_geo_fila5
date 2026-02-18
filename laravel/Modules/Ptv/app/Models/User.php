<?php

declare(strict_types=1);

namespace Modules\Ptv\Models;

use Modules\User\Models\BaseUser;

class User extends BaseUser
{
    protected $connection = 'user';
}
