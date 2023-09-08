<?php

include_once "d3l/database/generation/utils/DatabaseFiles.php";

class DatabaseMigrationLogs {

    static function save(string $name, array $tables) {
        $data = [
            "is_executed" => false,
            "tables" => $tables
        ];

        $json = json_encode($data);

        DatabaseFiles::generate($name, $json);
    }

    static function setExecuted(string $name) {
        $file = DatabaseFiles::load($name);
        $data = json_decode($file);

        $data->is_executed = true;
        $json = json_encode($data);

        DatabaseFiles::generate($name, $json);
    }
}