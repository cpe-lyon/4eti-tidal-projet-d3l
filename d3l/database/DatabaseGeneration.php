<?php

class DatabaseGeneration {

    function generateTableCreationScript(D3LDatabaseTable $model) {
        $tableName = $model->table;
        $columns = $model->columns;
        
        $sql = "CREATE TABLE IF NOT EXISTS {$tableName} (";

        foreach ($columns as $column) {
            $columnName = $column["name"];
            $columnType = $column["type"];
            $columnLength = isset($column["length"]) ? $column["length"] : null;
            $isPrimaryKey = isset($column["primary_key"]) ? $column["primary_key"] : false;
            $isAutoIncrement = isset($column["auto_increment"]) ? $column["auto_increment"] : false;
            $isNullable = isset($column["nullable"]) ? $column["nullable"] : true;

            $sql .= "{$columnName} {$columnType}";

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

            $sql .= ",";
        }

        // Remove the trailing comma
        $sql = rtrim($sql, ",");

        $sql .= ");";

        return $sql;
    }

    function generateDatabaseScript(D3LDatabaseTable $model, $outputFile = "database_script.sql") {
        $tableCreationScript = $this->generateTableCreationScript($model);

        // Write the SQL script to the output file
        file_put_contents($outputFile, $tableCreationScript);
    }

}