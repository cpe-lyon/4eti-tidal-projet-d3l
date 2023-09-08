<?php

include_once "d3l/database/generation/DatabaseFiles.php";
include_once "d3l/database/generation/DatabaseTable.php";
include_once "d3l/database/generation/DatabaseMigrationLogs.php";

class DatabaseInit {


    const MIGRATION_FILE_BASE = "1-init";
    var $tables = array();
    var $script = "";

    function __construct() {
        $this->tables = DatabaseFiles::loadTables();
    }

    function generate() {
        foreach ($this->tables as $table) {
            if (!$table->isTableValid()) {
                throw new Exception("Table {$table->name} is not valid");
            }

            $this->script .= DatabaseTable::drop($table->name) . "\n";
            $this->script .= DatabaseTable::create($table->name, $table->columns) . "\n";
        }

        DatabaseFiles::generate(self::MIGRATION_FILE_BASE . ".sql", $this->script);
        DatabaseMigrationLogs::save(self::MIGRATION_FILE_BASE . ".json", $this->tables);
    }
}