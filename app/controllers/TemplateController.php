// app/controllers/HomeController.php
<?php

require_once './d3l/templates/Template.php';

class HomeController
{
    public function index()
    {
        $template = new Template();
        $template->assign('title', 'My Framework');
        $template->assign('content', 'Welcome to my PHP framework!');
        echo $template->render('layout.html');
    }
}