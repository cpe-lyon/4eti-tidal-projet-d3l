<?php

include_once "d3l/database/models/D3LDatabaseTable.php";
include_once "d3l/database/models/D3LDatabaseColumn.php";
require_once "./app/database/models/Country.php";

class Country extends D3LDatabaseTable {

    var string $name = "country";

    function __construct() {
        
        $refl_count = new \ReflectionClass("Models\Country");

        $country_arr = $this->parseClass($refl_count);

        $this->addColumns($country_arr);
    }
}