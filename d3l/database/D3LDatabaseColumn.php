<?php

class D3LDatabaseColumn {

    static function charField(string $name, int $length = 255, bool $nullable = false) {
        return array(
            "name" => $name,
            "type" => "varchar",
            "length" => $length,
            "nullable" => $nullable
        );
    }

    static function textField(string $name, bool $nullable = false) {
        return array(
            "name" => $name,
            "type" => "text",
            "nullable" => $nullable
        );
    }

    static function integerField(string $name, bool $nullable = false) {
        return array(
            "name" => $name,
            "type" => "int",
            "nullable" => $nullable
        );
    }
}