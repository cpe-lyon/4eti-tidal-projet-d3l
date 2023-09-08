<?php

include_once './app/services/TemplateService.php';
require_once './d3l/routing/Router.php';

use AttributesRouter\Router;
use App\Controller\HomeController;


$router = new Router([HomeController::class]);

if ($match = $router->match()) {
    $controller = new $match['class']();
    $controller->{$match['method']}($match['params']);
}