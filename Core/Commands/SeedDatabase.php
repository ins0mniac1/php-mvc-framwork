<?php

namespace App\Core\Commands;

use App\Core\Commands\Kernel\Command;
use App\database\seeders\DataBaseSeeder;

class SeedDatabase extends Command
{
    public static function run(array $args = [])
    {
        self::chekHasHelpKey($args);
        Migrate::run();
        $dbSeeder = new DataBaseSeeder();
        $dbSeeder->call();
    }
}
