<?php

namespace App\Core\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    protected $message = 'The page is not found!';
    protected $code = 404;
}
