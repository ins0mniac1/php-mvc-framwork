<?php

namespace App\Core\Commands;

use App\Core\Commands\Kernel\Command;

class Migrate extends Command
{
    public static function run(array $args = [])
    {
        self::chekHasHelpKey($args);
        db()->applyMigrations();
    }
}
