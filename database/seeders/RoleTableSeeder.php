<?php

namespace App\database\seeders;

use App\database\Seeder;
use App\Models\Auth\Role;

class RoleTableSeeder extends Seeder
{

    const ROLES = [
        [
            'name' => 'Administrator',
        ],
        [
            'name' => 'User',
        ],
    ];

    public function __construct()
    {
        $this->model = new Role();
    }

    public function seed()
    {
        foreach (self::ROLES as $role) {
            $this->bindData($role);
            $this->loadModelAndExecute();
        }
    }
}
