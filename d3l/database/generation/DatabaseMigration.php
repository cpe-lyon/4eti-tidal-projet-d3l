<?php

include_once "d3l/database/generation/DatabaseInit.php";
include_once "d3l/database/generation/utils/DatabaseTable.php";
include_once "d3l/database/generation/utils/DatabaseFiles.php";
include_once "d3l/database/generation/utils/DatabaseMigrationLogs.php";
include_once "d3l/database/generation/utils/DatabaseColumn.php";

class DatabaseMigration {

    const MIGRATION_FILE_BASE = "migration";
    var $currentTables = array();
    var $updatedTables = array();

    function __construct() {
        $this->updatedTables = DatabaseFiles::loadTables();
        $this->currentTables = DatabaseMigrationLogs::loadLastLogTables();
    }

    function generate() {

        if (!DatabaseFiles::initFileExists()) {
            echo "No init script found, generating init script\n";
            $dbInit = new DatabaseInit();
            $dbInit->generate();
            return;
        }

        $script = $this->generateScript();
        $this->saveFiles($script);
    }

    private function generateScript(): string {
        $script = "";

        echo "Generating migration script\n";

        $script .= $this->dropRemovedTables();
        $script .= $this->generateNewTables();

        return $script;
    }

    private function generateNewTables(): string {
        $currentTables = $this->currentTables;
        $updatedTables = $this->updatedTables;
        $script = "";

        foreach ($updatedTables as $updatedTable) {
            $isTableToAdd = true;
            
            foreach ($currentTables as $currentTable) {
                if ($currentTable->name == $updatedTable->name) {
                    $isTableToAdd = false;
                    break;
                }
            }

            if ($isTableToAdd) {
                echo "-> Adding table {$updatedTable->name}\n";
                $script .= DatabaseTable::create($updatedTable->name, $updatedTable->columns);
            }
        }

        return $script;
    }

    private function dropRemovedTables(): string {
        $currentTables = $this->currentTables;
        $updatedTables = $this->updatedTables;
        $script = "";

        foreach ($currentTables as $currentTable) {
            $isTableToDrop = true;
            
            foreach ($updatedTables as $updatedTable) {
                if ($currentTable->name == $updatedTable->name) {
                    $isTableToDrop = false;
                    break;
                }
            }

            if ($isTableToDrop) {
                echo "-> Dropping table {$currentTable->name}\n";
                $script .= DatabaseTable::drop($currentTable->name);
            }
        }

        return $script;
    }

    private function saveFiles(string $script) {
        $fileId = DatabaseFiles::getNextMigrationId();
        $sqlFileName = $fileId . "-" . self::MIGRATION_FILE_BASE . ".sql";
        $logFileName = $fileId . "-" . self::MIGRATION_FILE_BASE . ".json";

        echo "Saving migration {$fileId} script\n";
        DatabaseFiles::generate($sqlFileName, $script);

        echo "Saving migration {$fileId} log\n";
        DatabaseMigrationLogs::save($logFileName, $this->updatedTables);
    }
}