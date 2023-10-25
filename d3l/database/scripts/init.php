#!/bin/php
<?php

include_once 'd3l/database/generation/DatabaseInit.php';
include_once 'd3l/database/generation/utils/DatabaseFiles.php';
include_once 'd3l/database/DatabaseContext.php';

$dbInit = new DatabaseInit();

DatabaseFiles::clean();
$file = $dbInit->generate();
$dbInit->execute($file);

echo "Init script executed successfully\n";