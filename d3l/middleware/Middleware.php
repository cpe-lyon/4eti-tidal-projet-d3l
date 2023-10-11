<?php

namespace D3l\Middleware;

class Middleware
{
    public function handle($request, $nextMiddleware)
    {
        // Handle the request with the next middleware
        return $nextMiddleware->handle($request);
    }
}