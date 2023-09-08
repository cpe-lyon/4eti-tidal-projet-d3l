<?php

include_once "d3l/database/generation/utils/DatabaseColumn.php";

class DatabaseTable {

    static function create(string $name, array $columns): string {
        $query = "\nCREATE TABLE IF NOT EXISTS \"{$name}\" (\n";

        foreach ($columns as $column) {
            $query .= DatabaseColumn::generate($column);
        }

        // Retirez la virgule finale
        $query = rtrim($query, ",\n");
        $query .= "\n);";

        return $query;
    }

    static function drop(string $name): string {
        $query = "\nDROP TABLE IF EXISTS \"{$name}\";\n";
        return $query;
    }
}