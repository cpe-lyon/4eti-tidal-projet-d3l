<?php

include_once("d3l/controller/D3LController.php");
include_once("app/database/table/User.php");

class UserController extends D3LController {

    var $tableName;
    var $primaryKey;

    function __construct() {
        $user = new User();
        $this->tableName = $user->name;
        $this->primaryKey = $user->getPrimaryKeys();
    }

    function getUsers() {
        return $this->getAll();
    }

    function getUser($id) {
        return $this->get($id);
    }

}