<?php

namespace App\Core\Commands;

use App\Core\Commands\Kernel\Command;

class DropDB extends Command
{

    public static function run(array $args = [])
    {
        self::chekHasHelpKey($args);
        db()->dropTables();
    }
}
