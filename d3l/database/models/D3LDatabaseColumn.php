<?php

class D3LDatabaseColumn {

    var $name = null;
    var $type  = null;
    var $length = null;
    var $primary_key = false;
    var $nullable = null;

    function toArray(): array {
        return array(
            "name" => $this->name,
            "type" => $this->type,
            "length" => $this->length,
            "primary_key" => $this->primary_key,
            "nullable" => $this->nullable
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
        $this->type = "integer";
        $this->nullable = $nullable;
    }
}