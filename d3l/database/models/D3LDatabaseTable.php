<?php

abstract class D3LDatabaseTable {

    var $name = "";
    var $columns = array();

    function addColumn($column) {
        array_push($this->columns, $column);
    }

    function addColumns($columns) {
        foreach ($columns as $column) {
            $this->addColumn($column);
        }
    }

    function getPrimaryKeys(): array {
        return array_filter($this->columns, function($column) {
            return isset($column["primary_key"]) && $column["primary_key"];
        });
    }
    
    function isTableValid(): bool {
        return $this->hasTableName() & $this->hasAtLeastTwoColumns();
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

        $idColumn = array(
            "name" => "id",
            "type" => "serial",
            "primary_key" => true,
            "nullable" => false,
        );

        array_unshift($this->columns, $idColumn);
    }

    private function hasAtLeastTwoColumns(): bool {
        return count($this->columns) >= 2;
    }
}