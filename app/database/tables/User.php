<?php

include_once "d3l/database/models/D3LDatabaseTable.php";
include_once "d3l/database/models/D3LDatabaseColumn.php";

class User extends D3LDatabaseTable {

    var $name = "user";

    function __construct() {
        $firstname = D3LDatabaseColumn::charField("firstname", 50);
        $lastname = D3LDatabaseColumn::charField("lastname", 50);
        $email = D3LDatabaseColumn::charField("email", 50);
        $password = D3LDatabaseColumn::charField("password", 50);
        $comment = D3LDatabaseColumn::textField("comment", true);

        $this->addColumns(array(
            $firstname,
            $lastname,
            $email,
            $password,
            $comment
        ));
    }
}