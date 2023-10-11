<?php

namespace App;

require_once './d3l/templates/Template.php';

use D3l\Template\Template;
use AttributesRouter\Attribute\Route;

class IndexPage {

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index()
    {
        $context = [
            'title' => 'D3L Framework',
            'description' => 'A simple PHP framework for building REST APIs'
        ];
        $engine = new Template($context);
        $output = $engine->render('index.html');
        echo $output;
    }
}