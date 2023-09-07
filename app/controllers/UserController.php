<?php

include_once("src/d3l/controller/D3LController.php");
include_once("src/models/User.php");

class UserController extends D3LController {

    var $user;

    function __construct() {
        $this->user = new User();
        parent::setTableMetaData($this->user->meta);
    }

    function getUsers() {
        return $this->getAll();
    }

    function getUser($id) {
        return $this->get($id);
    }

}