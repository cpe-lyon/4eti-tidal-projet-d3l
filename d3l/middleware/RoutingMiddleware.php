<?php

namespace D3l\Middleware;

require_once './d3l/middleware/Middleware.php';
require_once './d3l/middleware/exceptions/RouteNotFoundException.php';
require_once 'app/services/TemplateService.php';
require_once 'd3l/routing/Router.php';

use App\Service\TemplateService;
use D3l\Middleware\Exceptions\RouteNotFoundException;
use AttributesRouter\Router;

class RoutingMiddleware extends Middleware
{
    public function handle($request, $nextMiddleware)
    {
        $router = new Router([TemplateService::class]);

        if ($match = $router->match()) { // If the route matches
            $controller = new $match['class']();
            $controller->{$match['method']}($match['params']);
        } else { // If the route doesn't match
            throw new RouteNotFoundException();
        }

        // Call the next middleware
        return $nextMiddleware->handle($request);
    }
}