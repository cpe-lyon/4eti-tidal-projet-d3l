#!/bin/php
<?php

include_once 'd3l/database/generation/DatabaseInit.php';
include_once 'd3l/database/generation/DatabaseFiles.php';
include_once 'd3l/database/DatabaseContext.php';

$dbInit = new DatabaseInit();

DatabaseFiles::clean();
$dbInit->generate();


//$dbContext = new DatabaseContext("profile");
//$dbContext->executeQuery($query);