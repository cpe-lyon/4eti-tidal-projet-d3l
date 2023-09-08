<?php

include_once "d3l/database/generation/utils/DatabaseFiles.php";
include_once "d3l/database/generation/utils/DatabaseTable.php";
include_once "d3l/database/generation/utils/DatabaseMigrationLogs.php";

class DatabaseInit {

    const INIT_FILE_BASE = "init";
    var $tables = array();

    function __construct() {
        $this->tables = DatabaseFiles::loadTables();
    }

    function generate() {
        $script = $this->generateScript();
        $this->saveFiles($script);
    }

    private function generateScript(): string {
        $script = "";

        echo "Generating init script\n";

        foreach ($this->tables as $table) {
            if (!$table->isTableValid()) {
                throw new Exception("Table {$table->name} is not valid");
            }

            $script .= DatabaseTable::drop($table->name) . "\n";
            echo "-> Dropped table {$table->name}\n";

            $script .= DatabaseTable::create($table->name, $table->columns) . "\n";
            echo "-> Created table {$table->name}\n";
        }

        return $script;
    }

    private function saveFiles(string $script) {
        $fileId = DatabaseFiles::getNextMigrationId();
        $sqlFileName = $fileId . "-" . self::INIT_FILE_BASE . ".sql";
        $logFileName = $fileId . "-" . self::INIT_FILE_BASE . ".json";

        echo "Saving init script {$fileId}\n";
        DatabaseFiles::generate($sqlFileName, $script);

        echo "Saving init log {$fileId}\n";
        DatabaseMigrationLogs::save($logFileName, $this->tables);
    }
}