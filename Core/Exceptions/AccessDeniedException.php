<?php

namespace App\Core\Exceptions;

use Exception;

class AccessDeniedException extends Exception
{
    protected $message = 'You have not permission to access this resource!';
    protected $code = 403;
}
