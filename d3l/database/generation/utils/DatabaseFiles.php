<?php

class DatabaseFiles {

    const MIGRATION_DIR = "app/database/migrations/";

    static function clean() {
        echo "Cleaning migrations\n";
        $files = glob(self::MIGRATION_DIR . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    static function generate(string $name, string $query) {
        $path = self::MIGRATION_DIR . $name;

        file_put_contents($path, $query);
    }

    static function load(string $name): string {
        $path = self::MIGRATION_DIR . $name;

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
                $id = intval(explode("-", $file)[0]);
                if ($id == 1) {
                    return true;
                }
            }
        }

        return false;
    }
}