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
            echo "No init script found\n";
            $dbInit = new DatabaseInit();
            $dbInit->generate();
            return;
        }

        $script = $this->generateScript();
        if ($script == "") {
            echo "No changes detected\n";
            return;
        }
        $this->saveFiles($script);
    }

    function execute() {
        $files = DatabaseFiles::getNotExecutedMigrations();

        if (count($files) == 0) {
            echo "No migrations to execute\n";
            return;
        }
        $dbContext = new DatabaseContext("profile");

        foreach ($files as $file) {
            $query = DatabaseFiles::loadMigration($file);
            $dbContext->executeQuery($query);
            DatabaseMigrationLogs::setExecuted($file);

            $id = explode("-", $file)[0];
            echo "Migration {$id} executed successfully\n";
        }
    }

    private function generateScript(): string {
        $script = "";

        echo "Generating migration script\n";

        $script .= $this->dropRemovedTables();
        $script .= $this->createNewTables();
        $script .= $this->dropRemovedColumns();
        $script .= $this->createNewColumns();

        return $script;
    }

    private function createNewTables(): string {
        $currentTables = $this->currentTables;
        $updatedTables = $this->updatedTables;
        $script = "";

        foreach ($updatedTables as $updatedTable) {
            $currentTable = DatabaseTable::getTableByName($currentTables, $updatedTable->name);

            if ($currentTable == null) {
                echo "-> Adding table {$updatedTable->name}\n";
                $script .= DatabaseTable::create($updatedTable);
            }
        }

        return $script;
    }

    private function dropRemovedTables(): string {
        $script = "";

        foreach ($this->currentTables as $currentTable) {            
            $updatedTable = DatabaseTable::getTableByName($this->updatedTables, $currentTable->name);

            if ($updatedTable == null) {
                echo "-> Dropping table {$currentTable->name}\n";
                $script .= DatabaseTable::drop($currentTable->name);
            }
        }

        return $script;
    }

    private function createNewColumns(): string {
        $script = "";

        foreach ($this->updatedTables as $updatedTable) {
            $currentTable = DatabaseTable::getTableByName($this->currentTables, $updatedTable->name);

            foreach ($updatedTable->columns as $updatedColumn) {
                $currentColumn = DatabaseColumn::getColumnByName($currentTable->columns, $updatedColumn->name);

                if ($currentColumn == null) {
                    echo "-> Adding column {$updatedColumn->name} to table {$updatedTable->name}\n";
                    $script .= DatabaseColumn::generateWithAlterTable($updatedTable->name, $updatedColumn);
                }
            }
        }

        return $script;
    }

    private function dropRemovedColumns(): string {
        $script = "";

        foreach ($this->currentTables as $currentTable) {
            $updatedTable = DatabaseTable::getTableByName($this->updatedTables, $currentTable->name);

            $currentColumns = $currentTable->columns;

            foreach ($currentColumns as $currentColumn) {
                $updatedColumn = DatabaseColumn::getColumnByName($updatedTable->columns, $currentColumn->name);

                if ($updatedColumn == null) {
                    echo "-> Dropping column {$currentColumn->name} from table {$currentTable->name}\n";
                    $script .= DatabaseColumn::drop($currentTable->name, $currentColumn->name);
                }
            }
        }

        return $script;
    }

    private function saveFiles(string $script) {
        $fileId = DatabaseFiles::getNextMigrationId();
        $baseFileName = time() . "-" . self::MIGRATION_FILE_BASE;
        $sqlFileName = $baseFileName . ".sql";
        $logFileName = $baseFileName . ".json";

        echo "Saving migration {$fileId} script\n";
        DatabaseFiles::generateMigration($sqlFileName, $script);

        echo "Saving migration {$fileId} log\n";
        DatabaseMigrationLogs::save($logFileName, $this->updatedTables);
    }
}