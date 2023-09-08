<?php

class DatabaseScriptFile {

    static $migrationPath = "app/database/migrations/";

    static function clean() {
        $files = glob(self::$migrationPath . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    static function generate(string $fileName, string $query) {
        $filePath = self::$migrationPath . $fileName;

        file_put_contents($filePath, $query);
    }

    static function saveTableLogs(string $fileName, array $tables) {
        $filePath = self::$migrationPath . $fileName;

        $data = [
            "is_executed" => false,
            "tables" => $tables
        ];

        $json = json_encode($data);

        file_put_contents($filePath, $json);
    }
}