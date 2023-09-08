<?php

namespace App\UserController;

require_once("src/d3l/controller/D3LController.php");
require_once("src/models/User.php");

class UserController extends D3LController {

    var $tableName;

    var $dbProfile = "profile";

    function __construct() {
        $this->table = new User();
    }

    function getUsers() {
        return $this->getAll();
    }
}