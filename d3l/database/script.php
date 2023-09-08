#!/bin/php
<?php

include_once 'd3l/database/DatabaseGeneration.php';
include_once 'd3l/database/DatabaseContext.php';

$dbGeneration = new DatabaseGeneration();
$dbContext = new DatabaseContext("profile");

$dbGeneration->generateDatabaseScriptFile();

// check if file exist
$scriptPath = "app/database/database_script.sql";

if (!file_exists("app/database/database_script.sql")) {
    echo "Script file not found";
    return;
}

$query = file_get_contents($scriptPath);

$stmt = $dbContext->connection->prepare($query);

if ($stmt->execute()) {
    echo "Success";
}
else {
    echo "Fail";
}
