<?php

include_once "d3l/database/models/D3LDatabaseColumn.php";

abstract class D3LDatabaseTable {

    var string $name = "";
    var array $columns = array();

    public function parseClass($refl_clas){
        $user_arr = [];
        foreach($refl_clas->getConstructor()->getParameters() as $param){
            $type = $param->getType()->getName();
            $key = $param->name;
            $col = new D3LDatabaseColumn();



            if($type === 'string'){
                $col->textField($key);
            } else if ($type === 'int'){
                $col->integerField($key);
            }

            if($key === 'id'){
                $col->primaryKey();
            }

            array_push($user_arr, $col);
        }
        return $user_arr;
    }

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
        $primaryKey->primaryKey();

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
        $hasNecessaryFields = isset($column->name) && isset($column->type);
        $isForeignKeyValid = $this->isForeignKeyValid($column);

        return $hasNecessaryFields && $isForeignKeyValid;
    }

    private function isForeignKeyValid(D3LDatabaseColumn $column) {
        if ($column->foreign_key === null) return true;

        $hasTable = isset($column->foreign_key['table']);
        $hasColumn = isset($column->foreign_key['column']);
        return $hasTable && $hasColumn;
    }

    function getColumnsName(): array {
        $names = [];
        foreach($this->columns as $col){
            array_push($names, $col->name);
        }
        return $names;
    }
}