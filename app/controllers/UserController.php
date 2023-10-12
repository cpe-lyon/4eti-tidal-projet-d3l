<?php

namespace App;

require_once "./app/database/models/User.php";
require_once "./d3l/database/models/D3LController.php";

use AttributesRouter\Attribute\Route;

class UserController extends \D3LController {

    var $primaryKey;
    var $dbProfile = "profile";

    function __construct() {
        parent::__construct("profile");
        $this->tableName = '"user"';
    }

    #[Route('/getall', name: 'tes2', methods: ['GET'])]
    function getUsers() {
        header('Content-Type: application/json; charset=utf-8');
        echo $this->getAll();
    }

    #[Route('/update/{id<\d+>}', name: 'update', methods: ['GET'])]
    function updateReq($id) {
        header('Content-Type: application/json; charset=utf-8');
        $this->tableName = '"user"';
        $user = $this->findById($id['id'], NULL);
        $user['firstname'] = 'TIBO';
        $this->update($user);
        echo $this->findById($id['id']);
    }

    #[Route('/delete/{id<\d+>}', name: 'delete', methods: ['GET'])]
    function deleteReq($id) {
        header('Content-Type: application/json; charset=utf-8');
        $ret = $this->delete($id['id']);
        echo json_encode(["deleted" => $ret]);
    }

    #[Route('/test_user', name: 'test', methods: ['GET'])]
    function test_user(){
        echo "working test_user";
    }

    #[Route('/insert', name: 'insert_test', methods: ['GET'])]
    function insert_test() {
        $user = new \Models\User(
            1337,
            'Louis',
            'Trésorier',
            'louis@cresus.fr',
            'root',
            'léon'
        );
        $ret = $this->save($user);
        echo "saved : " . $ret;
    }
}