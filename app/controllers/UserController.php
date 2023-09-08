<?php

include_once("d3l/controller/D3LController.php");
include_once("app/database/tables/User.php");

class UserController extends D3LController {

    var $tableName;

    function __construct() {
        $this->table = new User();
    }

    function getUsers() {
        return $this->getAll();
    }
}