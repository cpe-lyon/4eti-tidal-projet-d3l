<?php

include_once "d3l/database/generation/utils/DatabaseFiles.php";
include_once "d3l/database/generation/utils/DatabaseTable.php";
include_once "d3l/database/generation/utils/DatabaseMigrationLogs.php";
include_once "d3l/database/DatabaseContext.php";

class DatabaseInit {

    const INIT_FILE_BASE = "init";
    var array $tables = array();

    function __construct() {
        $this->tables = DatabaseFiles::loadTables();
    }

    function generate(): string {
        $script = $this->generateScript();
        return $this->saveFiles($script);
    }

    function execute(string $fileName) {
        $query = DatabaseFiles::loadMigration($fileName);
        $dbContext = new DatabaseContext("profile");
        $dbContext->executeQuery($query);
        DatabaseMigrationLogs::setExecuted($fileName);
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

            $script .= DatabaseTable::create($table) . "\n";
            echo "-> Created table {$table->name}\n";
        }

        foreach ($this->tables as $table) {
            $script .= DatabaseTable::generateForeignKeyConstraints($table) . "\n";
            echo "-> Generated foreign key cosntraints for table {$table->name}\n";
        }

        return $script;
    }

    private function saveFiles(string $script): string {
        $fileId = DatabaseFiles::getNextMigrationId();
        $baseFileName = time() . "-" . self::INIT_FILE_BASE;
        $sqlFileName = $baseFileName . ".sql";
        $logFileName = $baseFileName . ".json";

        echo "Saving init script\n";
        DatabaseFiles::generateMigration($sqlFileName, $script);

        echo "Saving init log\n";
        DatabaseMigrationLogs::save($logFileName, $this->tables);
        return $baseFileName;
    }
}