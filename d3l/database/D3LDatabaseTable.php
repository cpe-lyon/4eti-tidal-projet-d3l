<?php

abstract class D3LDatabaseTable {

    var $name = "";
    var $columns = array();
    
    function isTableValid() {
        return $this->hasTableName() & $this->hasAtLeastOnePrimaryKey() & $this->hasAtLeastTwoColumns();
    }

    private function hasTableName() {
        return $this->name != "";
    }

    private function hasAtLeastOnePrimaryKey() {
        // check if columns has only one primary key
        $primaryKeys = array_filter($this->columns, function($column) {
            return isset($column["primary_key"]) && $column["primary_key"];
        });
        return count($primaryKeys) > 0;
    }

    private function hasAtLeastTwoColumns() {
        return count($this->columns) >= 2;
    }
}