<?php

namespace App\database\seeders;

use App\database\Seeder;
use App\Models\Auth\User;

class UserTableSeeder extends Seeder
{

    const USERS = [
        [
            'firstname' => 'Admin',
            'lastname' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => 'admin'
        ],
        [
            'firstname' => 'Test2',
            'lastname' => 'Test2',
            'email' => 'admin2@admin.com',
            'password' => 'test'
        ],
    ];

    public function __construct()
    {
        $this->model = new User();
    }

    public function seed()
    {
        foreach (self::USERS as $user) {
            $this->bindData($user);
            $this->loadModelAndExecute();
        }
    }
}
