#!/bin/php
<?php

include_once 'd3l/database/generation/DatabaseMigration.php';
include_once 'd3l/database/generation/utils/DatabaseFiles.php';
include_once 'd3l/database/DatabaseContext.php';

$dbMigration = new DatabaseMigration();

$dbMigration->generate();