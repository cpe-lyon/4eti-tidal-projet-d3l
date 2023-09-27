<?php

include_once "d3l/database/models/D3LDatabaseColumn.php";

abstract class D3LDatabaseTable {

    var string $name = "";
    var array $columns = array();

    function addColumn(D3LDatabaseColumn $column) {
        array_push($this->columns, $column);
    }

    function addColumns(array $columns) {
        foreach ($columns as $column) {
            $this->addColumn($column);
        }
    }

    function getPrimaryKeys(): array {
        return array_filter($this->columns, function($column) {
            return isset($column->primary_key) && $column->primary_key;
        });
    }
    
    function isTableValid(): bool {
        echo "Checking table {$this->name}...\n";
        return $this->hasTableName() &
            $this->hasAtLeastTwoColumns() &
            $this->isColumnsValid();
    }

    private function hasTableName(): bool {
        return $this->name != "";
    }

    private function hasAtLeastOnePrimaryKey(): bool {
        $primaryKeys = $this->getPrimaryKeys(); 
        return count($primaryKeys) > 0;
    }

    function addPrimaryKeyIfNotExists() {
        if ($this->hasAtLeastOnePrimaryKey()) return;

        $primaryKey = new D3LDatabaseColumn();
        $primaryKey->integerField("id");
        $primaryKey->primary_key = true;

        array_unshift($this->columns, $primaryKey);
    }

    private function hasAtLeastTwoColumns(): bool {
        return count($this->columns) >= 2;
    }

    private function isColumnsValid(): bool {
        return array_reduce($this->columns, function($carry, $column) {
            return $carry && $this->isColumnValid($column);
        }, true);
    }

    private function isColumnValid(D3LDatabaseColumn $column): bool {
        return isset($column->name) && isset($column->type);
    }
}