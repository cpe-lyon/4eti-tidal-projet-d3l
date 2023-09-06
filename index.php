<?php

include_once './app/controllers/TemplateController.php';
include_once './app/routing/router.php';

if(!isset($_GET['path'])){
    $_GET['path'] = '/';
}
$router = new Router($_GET['path']);
$router->get('/', function(){echo 'welcome on the best framework'; });
$router->get('/id/:id', function($id){ echo 'ton id:' . $id;});
$router->get('/test/lol', function(){ echo 'lel';});

$router->get('/template', function(){
    $template = new HomeController();
    $template->index();
});

$router->run();