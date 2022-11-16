<?php

namespace App\Core\Commands;

use App\Core\Commands\Kernel\Command;

class Help extends Command
{
    public static function run( array $args = [])
    {
        self::chekHasHelpKey($args);
        foreach (config('commands.commands_with_information') as $method => $message) {
            $baseCommand = config('commands.base_command') . ' ' . $method;
            $message = str_replace('^^command^^' , $baseCommand, $message);
            echo $method . ' - ' .  $message;
            echo PHP_EOL;
            echo PHP_EOL;
        }
    }
}
