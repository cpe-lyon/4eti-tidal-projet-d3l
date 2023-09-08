<?php

class DatabaseColumn {

    const COLUMN_PARAMS = ["name", "type", "length", "primary_key", "nullable"];

    static function generate(array $column): string {
        $query = "";

        $params = array_merge(array_fill_keys(self::COLUMN_PARAMS, null), $column);

        $query .= "\t{$params['name']} {$params['type']}";

        if ($params['length'] !== null) {
            $query .= "({$params['length']})";
        }

        if ($params['primary_key']) {
            $query .= " PRIMARY KEY";
        }

        if (!$params['nullable']) {
            $query .= " NOT NULL";
        }

        $query .= ",\n";

        return $query;
    }

    static function generateWithAlterTable(string $table, array $column): string {
        $query = "ALTER TABLE \"{$table}\" ADD COLUMN";
        $query .= DatabaseColumn::generate($column);
        return $query;
    }

    static function drop(string $table, string $name): string {
        $query = "ALTER TABLE \"{$table}\" DROP COLUMN \"{$name}\";\n";
        return $query;
    }

    static function compareColumns($currentColumn, $newColumn): bool {
        $currentParams = array_merge(array_fill_keys(self::COLUMN_PARAMS, null), $currentColumn);
        $newParams = array_merge(array_fill_keys(self::COLUMN_PARAMS, null), $newColumn);

        return $currentParams['name'] == $newParams['name'] &&
            $currentParams['type'] == $newParams['type'] &&
            $currentParams['length'] == $newParams['length'] &&
            $currentParams['primary_key'] == $newParams['primary_key'] &&
            $currentParams['nullable'] == $newParams['nullable'];
    }

    static function getColumnByName(array $columns, string $name) {
        foreach ($columns as $column) {
            if ($column['name'] == $name) {
                return $column;
            }
        }

        return null;
    }
}