<?php

include_once "d3l/database/models/D3LDatabaseTable.php";
include_once "d3l/database/generation/utils/DatabaseColumn.php";

class DatabaseTable {

    static function create(D3LDatabaseTable $table): string {
        $query = "\nCREATE TABLE IF NOT EXISTS \"{$table->name}\" (\n";

        foreach ($table->columns as $column) {
            $query .= DatabaseColumn::generate($column);
        }

        // Retirez la virgule finale
        $query = rtrim($query, ",\n");
        $query .= "\n);";

        return $query;
    }

    static function drop(string $name): string {
        $query = "\nDROP TABLE IF EXISTS \"{$name}\";";
        return $query;
    }

    static function generateForeignKeyConstraints(D3LDatabaseTable $table): string {
        $query = "";

        foreach ($table->columns as $column) {
            if ($column->foreign_key == null) continue;
            $query .= DatabaseColumn::generateForeignKeyConstraint($table->name, $column);
        }

        return $query;
    }

    static function getTableByName(array $tables, string $name) {
        foreach ($tables as $table) {
            if ($table->name == $name) {
                return $table;
            }
        }
        return null;
    }
}