<?php

class User {

    var $meta = array(
        "table" => "user",
        "primary_key" => "id"
    );

    var $id;
    var $firstname;
    var $lastname;
    var $username;
    var $email;
    var $password;
}