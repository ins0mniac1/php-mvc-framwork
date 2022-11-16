<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Core/helpers/functions.php';
require_once __DIR__ . '/Core/Commands/Kernel/index.php';

startApp(__DIR__, null, false);

foreach ($argv as $key => $command) {
    if (in_array($command, methods())) {
        echo PHP_EOL;
        executeCommand($command, $argv);
    }
}
