<?php

declare(strict_types=1);

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UserDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Model::unguard();

        $this->call([
            UserSeeder::class,
            DemoUserSeeder::class,
        ]);
    }
}
