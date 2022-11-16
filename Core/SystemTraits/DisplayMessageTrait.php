<?php

namespace App\Core\SystemTraits;

trait DisplayMessageTrait
{
    private static function log($msg)
    {
        echo '[' . date('Y-m-d H:i:s') . '] ' . $msg . PHP_EOL;
    }
}
