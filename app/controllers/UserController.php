<?php

include_once("d3l/database/D3LController.php");
include_once("app/database/table/User.php");

class UserController extends D3LController {

    var $tableName;
    var $primaryKey;

    var $dbProfile = "profile";

    function __construct() {
        parent::__construct();
        $user = new User();
        $this->tableName = $user->name;
    }

    function getUsers() {
        return $this->getAll();
    }

    function getUser($id) {
        return $this->get($id);
    }

}