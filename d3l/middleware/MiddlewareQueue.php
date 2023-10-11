<?php

namespace D3l\Middleware;
class MiddlewareQueue
{
    private $middlewares = [];
    private $currentIndex = 0;

    // Add a middleware to the queue
    public function addMiddleware($middleware) 
    {
        $this->middlewares[] = $middleware;
    }

    // Handle the request with the middlewares
    public function handle($request)
    {
        if ($this->currentIndex < count($this->middlewares)) {
            $middleware = $this->middlewares[$this->currentIndex];
            $this->currentIndex++;
            return $middleware->handle($request, $this);
        }

        // If there are no more middlewares, return the request
        return $request;
    }
}
