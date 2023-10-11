<?php

class D3LDatabaseColumn {

    var $name = null;
    var $type  = null;
    var $length = null;
    var $primary_key = false;
    var $foreign_key = null;
    var $nullable = null;

    function toArray(): array {
        return array(
            "name" => $this->name,
            "type" => $this->type,
            "length" => $this->length,
            "primary_key" => $this->primary_key,
            "nullable" => $this->nullable,
            "foreign_key" => $this->foreign_key
        );
    }

    function charField(string $name, int $length = 255, bool $nullable = false) {
        $this->name = $name;
        $this->type = "char";
        $this->length = $length;
        $this->nullable = $nullable;
    }

    function textField(string $name, bool $nullable = false) {
        $this->name = $name;
        $this->type = "text";
        $this->nullable = $nullable;
    }

    function integerField(string $name, bool $nullable = false) {
        $this->name = $name;
        $this->type = $this->primary_key ? "serial" : "integer";
        $this->nullable = $nullable;
    }

    function primaryKey() {
        if ($this->type == "integer") $this->type = "serial";
        $this->primary_key = true;
        $this->nullable = true;
    }

    function foreignKey(string $name, D3LDatabaseTable $table, D3LDatabaseColumn $column) {
        $this->name = $name;
        $this->type = $column->type == "serial" ? "integer" : $column->type;
        $this->length = $column->length;
        $this->nullable = $column->nullable;

        $this->foreign_key = array(
            "table" => $table->name,
            "column" => $column->name
        );
    }
}