<?php

include_once 'd3l/database/generation/DatabaseMigration.php';

$dbMigration = new DatabaseMigration();
$dbMigration->execute();