<?php

namespace App\Core\Middlewares;

abstract class BaseMiddleware
{
    public array $actions = [];

    abstract public function execute();

    public function __construct(...$actions)
    {
        $this->actions = $actions;
    }
}
