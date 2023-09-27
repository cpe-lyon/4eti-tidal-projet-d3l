<?php 

if (!isset($argv[1])) {
    echo "Please provide a command\n";
    exit;
}

switch ($argv[1]) {
    case "init":
        include_once "d3l/database/scripts/init.php";
        break;
    case "newMigration":
        include_once "d3l/database/scripts/newMigration.php";
        break;
    case "migrate":
        include_once "d3l/database/scripts/migrate.php";
        break;
    default:
        echo "Command not found\n";
        break;
}