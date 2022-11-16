<?php

namespace App\Core\Commands;

use App\Core\Commands\Kernel\Command;

class FreshMigrate extends Command
{

    public static function run(array $args = [])
    {
        self::chekHasHelpKey($args);
        DropDB::run();
        Migrate::run();
    }
}
