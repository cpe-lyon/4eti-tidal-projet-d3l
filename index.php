<?php

require_once 'd3l/middleware/MiddlewareQueue.php';
require_once 'd3l/middleware/CorsMiddleware.php';
require_once 'd3l/middleware/ExceptionsMiddleware.php';
require_once 'd3l/middleware/RoutingMiddleware.php';
require_once 'app/controllers/UserController.php';
require_once 'app/index.php';

use D3l\Middleware\MiddlewareQueue;
use D3l\Middleware\CorsMiddleware;
use D3l\Middleware\ExceptionsMiddleware;
use D3l\Middleware\RoutingMiddleware;

// Create a middleware queue
$middlewareQueue = new MiddlewareQueue();

// Add middlewares to the queue
$middlewareQueue->addMiddleware(new CorsMiddleware());
$middlewareQueue->addMiddleware(new ExceptionsMiddleware());
$middlewareQueue->addMiddleware(new RoutingMiddleware([
    \App\UserController::class,
    \App\IndexPage::class
]));

// Handle the request with the middlewares
$response = $middlewareQueue->handle($_REQUEST);