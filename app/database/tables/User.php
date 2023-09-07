<?php

include_once("./d3l/database/D3LDatabaseTable.php");

class User extends D3LDatabaseTable {

    var $name = "user";

    var $columns = array(
        array(
            "name" => "id",
            "type" => "int",
            "length" => 11,
            "primary_key" => true,
            "auto_increment" => true
        ),
        array(
            "name" => "firstname",
            "type" => "varchar",
            "length" => 255,
            "nullable" => false
        ),
        array(
            "name" => "lastname",
            "type" => "varchar",
            "length" => 255,
            "nullable" => false
        ),
        array(
            "name" => "email",
            "type" => "varchar",
            "length" => 255,
            "nullable" => false
        ),
        array(
            "name" => "password",
            "type" => "varchar",
            "length" => 255,
            "nullable" => false
        ),
        array(
            "name" => "comment",
            "type" => "text",
            "nullable" => true
        ),
    );
}