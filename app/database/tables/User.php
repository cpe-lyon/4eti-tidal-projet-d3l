<?php

include_once "d3l/database/models/D3LDatabaseTable.php";
include_once "d3l/database/models/D3LDatabaseColumn.php";

class User extends D3LDatabaseTable {

    var $name = "user";

    function __construct() {
        $firstname = new D3LDatabaseColumn();
        $firstname->charField("firstname", 50);

        $lastname = new D3LDatabaseColumn();
        $lastname->charField("lastname", 50);

        $email = new D3LDatabaseColumn();
        $email->charField("email", 50);

        $password = new D3LDatabaseColumn();
        $password->charField("password", 50);

        $comment = new D3LDatabaseColumn();
        $comment->textField("comment");

        $this->addColumns(array(
            $firstname,
            $lastname,
            $email,
            $password,
            $comment
        ));
    }
}