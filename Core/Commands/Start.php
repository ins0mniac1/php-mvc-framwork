<?php

namespace App\Core\Commands;

use App\Core\Commands\Kernel\Command;

class Start extends Command
{
    public static function run(array $args = [])
    {
        self::chekHasHelpKey($args);
        $host = config('app.appURL') ?? 'localhost';
        $port = config('app.appPORT') ?? '8001';

        $command = 'php -S ' . $host . ':' . $port . ' -t ' . rootPath() . '\\public\\';

        exec($command);
    }
}
