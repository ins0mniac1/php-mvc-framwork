<?php

namespace App\Core;

use JetBrains\PhpStorm\Pure;

class Request extends BaseRequest
{
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? false;
        $position = strpos($path, '?');

        if ($position === false) {
            return $path;
        }

        return substr($path, 0, $position);
    }

    public function method(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    #[Pure] public function isGet(): bool
    {
        return $this->method() === 'get';
    }

    #[Pure] public function isPost(): bool
    {
        return $this->method() === 'post';
    }

    #[Pure] public function all(): array
    {
        $body = [];

        if ($this->method() === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->method() === 'post') {
            foreach ($_POST as $key => $item) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }

    #[Pure] public function get($key): string|null
    {
        $param = null;

        if ($this->method() === 'get') {
            if (isset($_GET[$key])) {
                $param = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->method() === 'post') {
            if (isset($_POST[$key])) {
                $param = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $param;
    }
}
