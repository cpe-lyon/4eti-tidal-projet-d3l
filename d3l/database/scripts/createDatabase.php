#!/bin/php
<?php

include_once 'd3l/database/DatabaseCreation.php';
include_once 'd3l/database/DatabaseMigration.php';
include_once 'd3l/database/DatabaseContext.php';

$dbCreation = new DatabaseCreation();
$dbMigration = new DatabaseMigration();

$dbMigration->clearMigrationFolder();
$dbCreation->generateDatabaseScriptFile();

$scriptPath = "app/database/migrations/1-init.sql";

if (!file_exists($scriptPath)) {
    throw new ErrorException("Script file not found");
}

$query = file_get_contents($scriptPath);

//$dbContext = new DatabaseContext("profile");
//$dbContext->executeQuery($query);