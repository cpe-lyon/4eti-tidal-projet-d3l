<?php

require_once 'app/services/TemplateService.php';
require_once 'd3l/routing/Router.php';

use AttributesRouter\Router;
use App\Service\TemplateService;


$router = new Router([TemplateService::class]);

if ($match = $router->match()) {
    $controller = new $match['class']();
    $controller->{$match['method']}($match['params']);
}