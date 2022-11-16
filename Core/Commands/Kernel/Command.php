<?php

namespace App\Core\Commands\Kernel;

use JetBrains\PhpStorm\NoReturn;

abstract class Command
{
    abstract public static function run(array $args = []);

    #[NoReturn]
    protected static function showInfo($command)
    {
        $baseCommand = config('commands.base_command') . ' ' . $command;
        $message = str_replace('^^command^^' , $baseCommand, config('commands.commands_with_information.' . $command));
        echo $command . ' - ' .  $message;
        exit;
    }

    protected static function chekHasHelpKey($args)
    {
        foreach ($args as $arg){
            if (in_array($arg, config('commands.help_keys'))) {
                self::showInfo($args[1]);
            }
        }
    }
}
