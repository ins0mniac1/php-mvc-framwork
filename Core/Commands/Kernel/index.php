<?php

function methods(): array
{
    return array_keys(config('commands.commands_with_information'));
}

function executeCommand($command, array $arg = [])
{
    (config('commands.aliases.' . $command))::run($arg);
}
