#!/usr/bin/php
<?php

// Déterminez le chemin absolu du dossier contenant les fichiers de classe
$classesFolder = realpath(__DIR__ . "/../../app/database/tables/");

if (!is_dir($classesFolder)) {
    echo "Le dossier '{$classesFolder}' n'existe pas.\n";
    exit(1);
}

// Obtenez la liste des fichiers dans le dossier
$files = scandir($classesFolder);


// Parcourez les fichiers
foreach ($files as $file) {
    if ($file != "." && $file != ".." && pathinfo($file, PATHINFO_EXTENSION) == "php") {
        $className = pathinfo($file, PATHINFO_FILENAME);

        echo($className . "\n");

        // Incluez le fichier de classe
        //require_once($classesFolder . "/" . $file);

        // Vérifiez si la classe hérite de D3LDatabaseTable
        /*if (class_exists($className) && is_subclass_of($className, 'D3LDatabaseTable')) {
            // Créez une instance de la classe
            $table = new $className();

            // Générez le script SQL et spécifiez le nom du fichier de sortie
            $generator = new DatabaseGeneration();
            $outputFile = "database_script_{$className}.sql";
            $generator->generateDatabaseScript($table, $outputFile);

            echo "Script SQL généré avec succès dans '{$outputFile}'.\n";
        }*/
    }
}