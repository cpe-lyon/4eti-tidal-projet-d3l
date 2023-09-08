<?php

include_once("./d3l/database/D3LDatabaseTable.php");
include_once("./d3l/database/D3LDatabaseColumn.php");

class Country extends D3LDatabaseTable {

    var $name = "country";

    function __construct() {
        $name = D3LDatabaseColumn::charField("name", 50);
        $capital = D3LDatabaseColumn::charField("capital", 50);
        $population = D3LDatabaseColumn::integerField("population", true);

        $this->addColumns(array(
            $name,
            $capital,
            $population
        ));
    }
}