<?php

class DatabaseGeneration {

    function generateDatabaseScriptFile() {
        $tables = $this->loadTables();
        $tableCreationScript = $this->generateDatabaseCreationScript($tables);

        $outputFile = "database_script.sql";
        $filePath = "app/database/" . $outputFile;

        // Write the SQL script to the output file
        file_put_contents($filePath, $tableCreationScript);
    }

    private function generateTableCreationScript(D3LDatabaseTable $table) {
        $columns = $table->columns;
        $sql = "";

        foreach ($columns as $column) {
            $columnName = $column["name"];
            $columnType = $column["type"];
            $columnLength = isset($column["length"]) ? $column["length"] : null;
            $isPrimaryKey = isset($column["primary_key"]) ? $column["primary_key"] : false;
            $isAutoIncrement = isset($column["auto_increment"]) ? $column["auto_increment"] : false;
            $isNullable = isset($column["nullable"]) ? $column["nullable"] : true;

            $sql .= "\t{$columnName} {$columnType}";

            if ($columnLength !== null) {
                $sql .= "({$columnLength})";
            }

            if ($isPrimaryKey) {
                $sql .= " PRIMARY KEY";
                if ($isAutoIncrement) {
                    $sql .= " AUTO_INCREMENT";
                }
            }

            if (!$isNullable) {
                $sql .= " NOT NULL";
            }

            $sql .= ",\n";
        }

        // Retirez la virgule finale
        $sql = rtrim($sql, ",\n");

        $sql .= "\n);";

        return $sql;
    }

    private function generateTableDropScript(D3LDatabaseTable $table) {
        return "\nDROP TABLE IF EXISTS {$table->name};";
    }

    private function generateDatabaseCreationScript(array $tables) {
        $sql = "CREATE DATABASE IF NOT EXISTS D3LDatabase;\n";

        foreach ($tables as $table) {
            if (!$table->isTableValid()) {
                throw new Exception("Table {$table->name} is not valid");
            }
            $sql .= $this->generateTableDropScript($table) . "\n";
            $sql .= $this->generateTableCreationScript($table) . "\n";
        }

        return $sql;
    }

    private function loadTables() {
        $tables = array();

        $files = scandir("app/database/tables");

        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                include_once("app/database/tables/" . $file);
                $className = str_replace(".php", "", $file);
                $tables[] = new $className();
            }
        }

        return $tables;
    }
}