<?php

namespace App\Core;

use App\Core\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;

class Router
{
    protected array $routes = [];

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * @throws NotFoundException
     */
    public function resolve()
    {
        $path = request()->getPath();

        $method = request()->method();

        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            throw new NotFoundException();
        }

        if (is_string($callback)) {
            return view()->renderView($callback);
        }

        if (is_array($callback)) {

            /** @var Controller $callback[0] */

            $callback[0] = new $callback[0];
            setAction($callback[1]);

            foreach ($callback[0]->getMiddlewares() as $middleware) {
                $middleware->execute();
            }
        }

        return call_user_func($callback, request(), response());
    }

}
