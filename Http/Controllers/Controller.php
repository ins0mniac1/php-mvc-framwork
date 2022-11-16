<?php

namespace App\Http\Controllers;

use App\Core\Middlewares\BaseMiddleware;

class Controller
{
    /**
     * @var BaseMiddleware[]
     */
    private array $registeredMiddlewares = [];

    protected function middleware(...$baseMiddleware)
    {
        if ($baseMiddleware[0] instanceof BaseMiddleware) {
            $this->registeredMiddlewares[] = $baseMiddleware[0];
            return;
        }

        $middleware = $baseMiddleware[0];
        unset($baseMiddleware[0]);

        $this->registeredMiddlewares[] = new (config('middlewares.aliases')[$middleware])($baseMiddleware);
    }

    protected function render($view, $params = []): bool|array|string
    {
        return view()->renderView($view,  $params);
    }

    protected function setLayout($layout)
    {
        view()->setLayout($layout);
    }

    public function getMiddlewares(): array
    {
        return $this->registeredMiddlewares;
    }
}
