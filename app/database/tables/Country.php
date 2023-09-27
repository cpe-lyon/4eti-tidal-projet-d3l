<?php

include_once "d3l/database/models/D3LDatabaseTable.php";
include_once "d3l/database/models/D3LDatabaseColumn.php";

class Country extends D3LDatabaseTable {

    var string $name = "country";

    function __construct() {
        $name = new D3LDatabaseColumn();
        $name->charField("name", 50);

        $capital = new D3LDatabaseColumn();
        $capital->charField("capital", 50);

        $population = new D3LDatabaseColumn();
        $population->integerField("population");

        $this->addColumns(array(
            $name,
            $capital,
            $population
        ));
    }
}