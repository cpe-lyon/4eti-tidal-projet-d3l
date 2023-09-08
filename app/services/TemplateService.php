<?php

namespace App\Service;

require_once './d3l/templates/Template.php';

use D3l\Template\Template;
use AttributesRouter\Attribute\Route;

class TemplateService {

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index()
    {
        $template = new Template();
        $template->assign('title', 'My Framework');
        $template->assign('content', 'Welcome to my PHP framework!');
        echo $template->render('layout.html');
    }
}