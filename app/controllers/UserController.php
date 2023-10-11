<?php

namespace App\UserController;

require_once "./app/database/tables/User.php";
require_once "./d3l/database/models/D3LController.php";

use AttributesRouter\Attribute\Route;

class UserController extends \D3LController {

    var $primaryKey;
    var $dbProfile = "profile";

    function __construct() {
        parent::__construct("profile");
        $user = new \User();
        $this->tableName = '"users"';
    }

    #[Route('/getall', name: 'tes2', methods: ['GET'])]
    function getUsers() {
        header('Content-Type: application/json; charset=utf-8');
        $fetched = $this->getAll();
        $full = array();
        foreach($fetched as $row){
            array_push($full, [
                "id" => $row["id"],
                "lastname" => $row["lastname"],
                "firstname" => $row["firstname"],
                "email" => $row["email"],
                "password" => $row["password"],
                "comment" => $row["comment"]
            ]);
        }
        echo json_encode($full);
    }

    #[Route('/test_user', name: 'test', methods: ['GET'])]
    function test_user(){
        echo "working test_user";
    }
}