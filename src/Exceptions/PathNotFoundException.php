<?php

namespace Framework\Exceptions;

use Exception;
use Throwable;

class PathNotFoundException extends Exception
{
    /**
     * @var string
     */
    private $path;

    public function __construct(string $path, $message = "Path has not been found.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}