<?php

namespace App;

require_once './d3l/templates/Template.php';
require_once './d3l/parser/Parsedown.php';
include_once 'd3l/api/D3LApiLinkBuilder.php';
include_once 'd3l/api/service/D3LApiService.php';

use D3l\Template\Template;
use AttributesRouter\Attribute\Route;
use D3LApiLinkBuilder;
use D3LApiService;
use Parser\Parsedown;

class IndexPage {

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index()
    {
        $link = D3LApiLinkBuilder::BasicLinkBuilder("https://api.open-meteo.com/v1/meteofrance", 
                                                    array("latitude" => "45.7485",
                                                    "longitude" => "4.8467",
                                                    "current" => "temperature_2m,weathercode"));
        $request = D3LApiService::GetRequest($link, "json");
        $weather = $request['current']['temperature_2m'] . $request['current_units']['temperature_2m'];
        $context = [
            'title' => 'D3L Framework',
            'weather' => $weather,
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