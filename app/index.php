<?php

require_once './app/services/TemplateService.php';
require_once './d3l/routing/Router.php';
require_once './app/controllers/UserController.php';

use AttributesRouter\Router;
use App\Service\TemplateService;
use App\UserController\UserController;

function init(){
    $router = new Router([TemplateService::class, UserController::class]);

    if ($match = $router->match()) {
        $controller = new $match['class']();
        $controller->{$match['method']}($match['params']);
    }
}

