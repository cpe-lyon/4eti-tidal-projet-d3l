<?php

include_once("./d3l/database/D3LDatabaseTable.php");

class Country extends D3LDatabaseTable {

    var $name = "country";

    var $columns = array(
        array(
            "name" => "id",
            "type" => "int",
            "length" => 11,
            "primary_key" => true,
            "auto_increment" => true
        ),
        array(
            "name" => "name",
            "type" => "varchar",
            "length" => 255,
            "nullable" => false
        ),
        array(
            "name" => "code",
            "type" => "varchar",
            "length" => 255,
            "nullable" => false
        ),
        array(
            "name" => "continent",
            "type" => "varchar",
            "length" => 255,
            "nullable" => false
        ),
        array(
            "name" => "region",
            "type" => "varchar",
            "length" => 255,
            "nullable" => false
        ),
    );
}