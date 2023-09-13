<?php

include_once "d3l/database/generation/utils/DatabaseFiles.php";

class DatabaseMigrationLogs {

    static function save(string $name, array $tables) {
        $data = [
            "is_executed" => false,
            "tables" => $tables
        ];

        $json = json_encode($data);

        DatabaseFiles::generateLog($name, $json);
    }

    static function loadLastLogTables(): array {
        $files = glob(DatabaseFiles::LOG_DIR . "*.json");
        if (count($files) == 0) return array();

        $lastFilePath = $files[count($files) - 1];
        $file = file_get_contents($lastFilePath);
        $data = json_decode($file);

        return $data->tables;
    }

    static function setExecuted(string $name) {
        $file = DatabaseFiles::loadMigrationLog($name);
        $data = json_decode($file);

        $data->is_executed = true;
        $json = json_encode($data);

        DatabaseFiles::generateLog($name, $json);
    }
}