<?php

namespace Models;

class User {

    var $id;
    var $firstname;
    var $lastname;
    var $email;
    var $password;

    function __construct(int $id = null, string $firstname = null, string $lastname = null, string $email = null, string $password = null){
        
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;

    }
}