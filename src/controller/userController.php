<?php

class UserController {
        
    function getAll() {
        $user = new User();
        $users = $user->getAll();
        return $users;
    }
}