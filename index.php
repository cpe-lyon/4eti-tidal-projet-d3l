<?php

include_once './app/controllers/TemplateController.php';
include_once './src/d3l/routing/router.php';

$router = new Router($_GET['path']);
$router->get('/', function(){echo 'welcome on the best framework'; });
$router->get('/:id', function($id){ echo 'ton id:' . $id;});
$router->get('/test/lol', function(){ echo 'lel';});

$router->get('/template', function(){
    $template = new TemplateController();
    $template->index();
});

$router->run();