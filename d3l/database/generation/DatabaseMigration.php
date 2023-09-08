<?php

include_once "d3l/database/generation/DatabaseInit.php";
include_once "d3l/database/generation/utils/DatabaseFiles.php";
include_once "d3l/database/generation/utils/DatabaseMigrationLogs.php";

class DatabaseMigration {

    const MIGRATION_FILE_BASE = "migration";
    var $tables = array();

    function __construct() {
        $this->tables = DatabaseFiles::loadTables();
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

        //TODO : generate migration script

        return $script;
    }

    private function saveFiles(string $script) {
        $fileId = DatabaseFiles::getNextMigrationId();
        $sqlFileName = $fileId . "-" . self::MIGRATION_FILE_BASE . ".sql";
        $logFileName = $fileId . "-" . self::MIGRATION_FILE_BASE . ".json";

        echo "Saving migration script {$fileId}\n";
        DatabaseFiles::generate($sqlFileName, $script);

        echo "Saving migration log {$fileId}\n";
        DatabaseMigrationLogs::save($logFileName, $this->tables);
    }
}