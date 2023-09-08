<?php

include_once "d3l/database/models/D3LController.php";
include_once "app/database/tables/User.php";

class UserController extends D3LController {

    var $tableName;
    var $primaryKey;

    var $dbProfile = "profile";

    function __construct() {
        parent::__construct("profile");
        $user = new User();
        $this->tableName = $user->name;
    }

    function getUsers() {
        return $this->getAll();
    }
}