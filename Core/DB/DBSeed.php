<?php

namespace App\Core\DB;

abstract class DBSeed
{
    abstract public function seeders();

    public function call()
    {
        foreach ($this->seeders() as $seeder) {
            $seeder = new $seeder();
            $seeder->seed();
        }
    }
}
