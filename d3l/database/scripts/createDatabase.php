#!/bin/php
<?php

include_once 'd3l/database/generation/DatabaseCreation.php';
include_once 'd3l/database/generation/DatabaseScriptFile.php';
include_once 'd3l/database/DatabaseContext.php';

$dbCreation = new DatabaseCreation();

DatabaseScriptFile::clean();
$query = $dbCreation->generateDatabaseScriptFile();
DatabaseScriptFile::generate("1-init.sql", $query);


//$dbContext = new DatabaseContext("profile");
//$dbContext->executeQuery($query);