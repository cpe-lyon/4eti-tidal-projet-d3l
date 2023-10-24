<?php

class DatabaseFiles {

    const MIGRATION_DIR = "app/database/migrations/";
    const LOG_DIR = self::MIGRATION_DIR . "logs/";
    const EXECUTION_LOG = self::LOG_DIR . "execution_log.json";

    static function clean() {
        echo "Cleaning migrations\n";
        $migrationFiles = glob(self::MIGRATION_DIR . '*');
        foreach ($migrationFiles as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        $logFiles = glob(self::LOG_DIR . '*');
        foreach ($logFiles as $file) {
            if (is_file($file) && substr($file, -5) == ".json" && $file != self::EXECUTION_LOG) {
                unlink($file);
            }
        }
    }

    static function generateMigration(string $name, string $query) {
        if (substr($name, -4) != ".sql") {
            $name .= ".sql";
        }
        $path = self::MIGRATION_DIR . $name;

        file_put_contents($path, $query);
    }

    static function generateLog(string $name, string $content) {
        if (substr($name, -5) != ".json") {
            $name .= ".json";
        }
        $path = self::LOG_DIR . $name;

        file_put_contents($path, $content);
    }

    static function loadMigration(string $name): string {
        if (substr($name, -4) != ".sql") {
            $name .= ".sql";
        }
        $path = self::MIGRATION_DIR . $name;

        return file_get_contents($path);
    }

    static function loadMigrationLog(string $name): string {
        if (substr($name, -5) != ".json") {
            $name .= ".json";
        }
        $path = self::LOG_DIR . $name;

        return file_get_contents($path);
    }

    static function loadTables(): array {
        $tables = array();

        $files = scandir("app/database/tables");

        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                
                include_once("app/database/tables/" . $file);
                $className = str_replace(".php", "", $file);

                $table = new $className();
                $table->addPrimaryKeyIfNotExists();
                $tables[] = $table;
            }
        }

        return $tables;
    }

    static function getNextMigrationId(): int {
        $files = scandir(self::MIGRATION_DIR);

        $maxId = 0;

        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                $id = intval(explode("-", $file)[0]);
                $maxId = max($maxId, $id);
            }
        }

        return $maxId + 1;
    }

    static function initFileExists(): bool {
        $files = scandir(self::MIGRATION_DIR);

        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                if (strpos($file, "init") !== false) {
                    return true;
                }
            }
        }

        return false;
    }

    static function getNotExecutedMigrations(): array {
        $files = scandir(self::LOG_DIR);

        $migrations = array();

        foreach ($files as $file) {
            if ($file != "." && $file != ".." && $file != ".gitkeep") {

                $json = DatabaseFiles::loadMigrationLog($file);
                $data = json_decode($json, true);

                $isExecuted = $data["is_executed"];
                if (!$isExecuted) {
                    $fileBase = str_replace(".json", "", $file);
                    $migrations[] = $fileBase;
                }
            }
        }

        return $migrations;
    }
}