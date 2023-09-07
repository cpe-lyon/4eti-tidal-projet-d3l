<?php

abstract class D3LDatabaseTable {

    var $name = "";
    var $columns = array();
    
    function isTableValid() {
        return $this->hasTableName() & $this->hasOnlyOnePrimaryKey() & $this->hasAtLeastTwoColumns();
    }

    private function hasTableName() {
        return $this->name != "";
    }

    private function hasOnlyOnePrimaryKey() {
        // check if columns has only one primary key
        $primaryKeys = array_filter($this->columns, function($column) {
            return isset($column["primary_key"]) && $column["primary_key"];
        });
        return count($primaryKeys) != 1;
    }

    private function hasAtLeastTwoColumns() {
        return count($this->columns) >= 2;
    }
}