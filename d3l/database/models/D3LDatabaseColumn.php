<?php

class D3LDatabaseColumn {

    var $name;
    var $type;
    var $length;
    var $primary_key;
    var $nullable;

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