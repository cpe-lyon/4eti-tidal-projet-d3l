<?php

include_once 'd3l/routing/router.php';

$router = new Router($_SERVER['REQUEST_URI']);
$router->get('/:id', function($id){ echo 'ton id:' . $id;});
$router->get('/test/lol', function(){ echo 'lel';});

$router->run();

die();
echo "string";