<?php

namespace Framework\Exceptions;

use Exception;
use Throwable;

class PathNotFoundException extends Exception
{
    public function __construct($message = "Path has not been found.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}