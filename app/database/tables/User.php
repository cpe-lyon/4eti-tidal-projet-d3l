<?php

include_once "d3l/database/models/D3LDatabaseTable.php";
include_once "d3l/database/models/D3LDatabaseColumn.php";

class User extends D3LDatabaseTable {

    var string $name = "user";

    function __construct() {
        $id = new D3LDatabaseColumn();
        $id->integerField("id");
        $id->primaryKey();

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
            $id,
            $firstname,
            $lastname,
            $email,
            $password,
            $comment
        ));
    }
}