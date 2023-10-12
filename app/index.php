<?php

namespace App;

require_once './d3l/templates/Template.php';
require_once './d3l/parser/Parsedown.php';

use D3l\Template\Template;
use AttributesRouter\Attribute\Route;
use Parser\Parsedown;

class IndexPage {

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index()
    {
        $context = [
            'title' => 'D3L Framework',
            'description' => 'A simple PHP framework for building REST APIs',
            'features' => [
                'Gestion des middlewares pour la personnalisation du traitement des requêtes.',
                'Système de routage flexible pour diriger les requêtes vers les contrôleurs appropriés.',
                'Middleware de gestion des exceptions pour un meilleur contrôle des erreurs.',
                'ORM intégré pour la gestion des données.',
                'Simplification des appels API avec le client HTTP intégré.',
            ]
        ];
        $engine = new Template($context);
        $output = $engine->render('index.html');
        echo $output;
    }

    #[Route('/documentation', name: 'documentation', methods: ['GET'])]
    public function documentation()
    {
        // Lisez le contenu du fichier README.md
        $readmeContent = file_get_contents('README.md');

        // Convertissez le contenu Markdown en HTML
        $parsedown = new Parsedown();
        $documentationHTML = $parsedown->text($readmeContent);

        $context = [
            'title' => 'Documentation',
            'description' => 'Documentation du framework D3L',
            'documentation' => $documentationHTML
        ];
        
        $engine = new Template($context);
        $output = $engine->render('documentation.html');
        echo $output;
    }
}