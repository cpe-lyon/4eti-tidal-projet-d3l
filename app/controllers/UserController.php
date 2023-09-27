<?php

namespace App\UserController;

require_once "./app/database/tables/User.php";
require_once "./d3l/database/models/D3LController.php";

use AttributesRouter\Attribute\Route;

class UserController extends \D3LController {

    var $tableName = "user";
    var $primaryKey;

    var $dbProfile = "profile";

    function __construct() {
        parent::__construct("profile");
        $user = new \User();
        $this->tableName = $user->name;
    }

    #[Route('/getall', name: 'test', methods: ['GET'])]
    function getUsers() {
        return $this->getAll();
    }

    #[Route('/test_user', name: 'test', methods: ['GET'])]
    function test_user(){
        echo "working test_user";
    }
}