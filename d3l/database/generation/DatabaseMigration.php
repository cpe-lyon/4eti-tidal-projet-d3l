<?php

include_once "d3l/database/generation/DatabaseFiles.php";
include_once "d3l/database/generation/DatabaseMigrationLogs.php";

class DatabaseMigration {

    const MIGRATION_FILE_BASE = "migration";
    var $tables = array();

    function __construct() {
        $this->tables = DatabaseFiles::loadTables();
    }

    function generate() {
        $script = "";

        // generate migration script

        $fileId = DatabaseFiles::getNextMigrationId();
        $sqlFileName = $fileId . "-" . self::MIGRATION_FILE_BASE . ".sql";
        $logFileName = $fileId . "-" . self::MIGRATION_FILE_BASE . ".json";

        DatabaseFiles::generate($sqlFileName, $script);
        DatabaseMigrationLogs::save($logFileName, $this->tables);
    }
}