// public/index.php
<?php

include_once './app/controllers/TemplateController.php';

$route = $_GET['route'] ?? '';

switch ($route) {
    case 'home':
        $controller = new HomeController();
        $controller->index();
        break;
    // Add more routes/controllers as needed
}
