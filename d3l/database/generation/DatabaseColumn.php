<?php

class DatabaseColumn {

    static function generate(array $column): string {
        $query = "";

        $columnName = $column["name"];
        $columnType = $column["type"];
        $columnLength = isset($column["length"]) ? $column["length"] : null;
        $isPrimaryKey = isset($column["primary_key"]) ? $column["primary_key"] : false;
        $isNullable = isset($column["nullable"]) ? $column["nullable"] : true;

        $query .= "\t{$columnName} {$columnType}";

        if ($columnLength !== null) {
            $query .= "({$columnLength})";
        }

        if ($isPrimaryKey) {
            $query .= " PRIMARY KEY";
        }

        if (!$isNullable) {
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