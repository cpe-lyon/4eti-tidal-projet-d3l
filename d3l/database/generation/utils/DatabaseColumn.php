<?php

class DatabaseColumn {

    const COLUMN_PARAMS = ["name", "type", "length", "primary_key", "nullable"];

    static function generate(D3LDatabaseColumn $column): string {
        $query = "";

        $params = array_merge(array_fill_keys(self::COLUMN_PARAMS, null), $column->toArray());

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

    static function generateForeignKeyConstraint(string $tableName, D3LDatabaseColumn $column): string {
        if ($column->foreign_key === null) return "";

        $params = array_merge(array_fill_keys(self::COLUMN_PARAMS, null), $column->toArray());

        return "\nALTER TABLE \"{$tableName}\" ADD CONSTRAINT \"{$tableName}_{$params['name']}_fkey\" FOREIGN KEY (\"{$params['name']}\") REFERENCES \"{$params['foreign_key']['table']}\" (\"{$params['foreign_key']['column']}\");\n";
    }

    static function generateWithAlterTable(string $table, D3LDatabaseColumn $column): string {
        $query = "\nALTER TABLE \"{$table}\" ADD COLUMN";
        $query .= DatabaseColumn::generate($column);
        return $query;
    }

    static function drop(string $table, string $name): string {
        $query = "\nALTER TABLE \"{$table}\" DROP COLUMN \"{$name}\";\n";
        return $query;
    }

    static function dropForeignKeyConstraint(string $table, D3LDatabaseColumn $column): string {
        if ($column->foreign_key === null) return "";

        $params = array_merge(array_fill_keys(self::COLUMN_PARAMS, null), $column->toArray());

        return "\nALTER TABLE \"{$table}\" DROP CONSTRAINT \"{$table}_{$params['name']}_fkey\";\n";
    }

    static function compareColumns(D3LDatabaseColumn $currentColumn, D3LDatabaseColumn $newColumn): bool {
        $currentParams = array_merge(array_fill_keys(self::COLUMN_PARAMS, null), $currentColumn->toArray());
        $newParams = array_merge(array_fill_keys(self::COLUMN_PARAMS, null), $newColumn->toArray());

        return $currentParams['name'] == $newParams['name'] &&
            $currentParams['type'] == $newParams['type'] &&
            $currentParams['length'] == $newParams['length'] &&
            $currentParams['primary_key'] == $newParams['primary_key'] &&
            $currentParams['nullable'] == $newParams['nullable'];
    }

    static function getColumnByName(array $columns, string $name) {
        foreach ($columns as $column) {
            if ($column->name == $name) {
                return $column;
            }
        }
        return null;
    }
}