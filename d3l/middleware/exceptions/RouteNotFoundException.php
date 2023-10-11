<?php

namespace D3l\Middleware\Exceptions;

class RouteNotFoundException extends \Exception
{
    public function __construct($message = "Page not found", $code = 404, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}