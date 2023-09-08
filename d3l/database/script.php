<?php

include_once './d3l/database/DatabaseGeneration.php';

$databaseGeneration = new DatabaseGeneration();

$databaseGeneration->generateDatabaseScriptFile();