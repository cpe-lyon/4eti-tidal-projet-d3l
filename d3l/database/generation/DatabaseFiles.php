<?php

class DatabaseFiles {

    const MIGRATION_FOLDER_PATH = "app/database/migrations/";

    static function clean() {
        $files = glob(self::MIGRATION_FOLDER_PATH . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    static function generate(string $name, string $query) {
        $path = self::MIGRATION_FOLDER_PATH . $name;

        file_put_contents($path, $query);
    }

    static function load(string $name): string {
        $path = self::MIGRATION_FOLDER_PATH . $name;

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
}