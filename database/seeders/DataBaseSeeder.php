<?php

namespace App\database\seeders;

use App\Core\DB\DBSeed;

class DataBaseSeeder extends DBSeed
{
    public function seeders(): array
    {
        return [
            RoleTableSeeder::class,
            UserTableSeeder::class,
        ];
    }
}
