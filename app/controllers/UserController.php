<?php

namespace App;

require_once "./app/database/models/User.php";
require_once "./d3l/database/models/D3LController.php";
require_once "./d3l/templates/Template.php";

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

    #[Route('/update/{id<\d+>}/{nom}', name: 'update', methods: ['GET'])]
    function updateReq($param) {
        header('Content-Type: application/json; charset=utf-8');
        $this->tableName = '"user"';
        $user = $this->findById($param['id'], NULL);
        $user['firstname'] = $param['nom'];
        $this->update($user);
        echo $this->findById($param['id']);
    }

    #[Route('/delete/{id<\d+>}', name: 'delete', methods: ['GET'])]
    function deleteReq($id) {
        header('Content-Type: application/json; charset=utf-8');
        $ret = $this->delete($id['id']);
        echo json_encode(["deleted" => $ret]);
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

    #[Route('/add', name: 'post_insert', methods: ['POST'])]
    function post_insert(){
        //var_dump($_POST);
        $user = new \Models\User(
            NULL,
            $_POST['prenom'],
            $_POST['nom'],
            $_POST['email'],
            $_POST['password'],
            isset($_POST['commentaire']) ? $_POST['commentaire'] : NULL
        );
        $this->save($user);
        header("Location: /getall");
        die();
    }


    #[Route('/add', name: 'get_insert', methods: ['GET'])]
    function get_insert(){
        $context = [
            'title' => 'Créer un utilisateur',
            'weather' => 'Regarde comme il faut beau dehors'];
        $engine = new \D3l\Template\Template($context);
        echo $engine->render('form.html');
    }
}