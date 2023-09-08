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

    static function generateForExistingTable(array $column): string {
        $query = "ADD COLUMN ";
        $query .= DatabaseColumn::generate($column);
        return $query;
    }
}