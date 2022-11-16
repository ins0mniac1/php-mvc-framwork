<?php

namespace App\Http\Middlewares;

use App\Core\Exceptions\AccessDeniedException;
use App\Core\Middlewares\BaseMiddleware;

class AuthMiddleware extends BaseMiddleware
{
    /**
     * @throws AccessDeniedException
     */
    public function execute()
    {
        if (isGuest()) {
            if (empty($this->actions) || in_array(getAction(), $this->actions[0])) {
                throw new AccessDeniedException();
            }
        }
    }
}
