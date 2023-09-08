<?php

include_once "d3l/database/generation/DatabaseFiles.php";
include_once "d3l/database/generation/DatabaseTable.php";
include_once "d3l/database/generation/DatabaseMigrationLogs.php";

class DatabaseInit {

    const INIT_FILE_BASE = "init";
    var $tables = array();

    function __construct() {
        $this->tables = DatabaseFiles::loadTables();
    }

    function generate() {
        $script = "";

        foreach ($this->tables as $table) {
            if (!$table->isTableValid()) {
                throw new Exception("Table {$table->name} is not valid");
            }

            $script .= DatabaseTable::drop($table->name) . "\n";
            $script .= DatabaseTable::create($table->name, $table->columns) . "\n";
        }

        $fileId = DatabaseFiles::getNextMigrationId();
        $sqlFileName = $fileId . "-" . self::INIT_FILE_BASE . ".sql";
        $logFileName = $fileId . "-" . self::INIT_FILE_BASE . ".json";

        DatabaseFiles::generate($sqlFileName, $script);
        DatabaseMigrationLogs::save($logFileName, $this->tables);
    }
}