<?php

include_once "d3l/database/models/D3LDatabaseTable.php";
include_once "d3l/database/models/D3LDatabaseColumn.php";
require_once "./app/database/models/User.php";

class User extends D3LDatabaseTable {

    var string $name = "user";

    function __construct() {
        
        $refl_user = new \ReflectionClass("Models\User");

        $user_arr = $this->parseClass($refl_user);

        $this->addColumns($user_arr);
    }
}