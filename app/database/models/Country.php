<?php

namespace Models;

class Country {

    var $id;
    var $name;
    var $capital;
    var $population;
    var $fk_id_user_president;

    function __construct(int $id = null, string $name = null, string $capital = null, int $population = null , \Models\User $fk_id_user_president = null){

        $this->id = $id;
        $this->name = $name;
        $this->capital = $capital;
        $this->population = $population;
        $this->fk_id_user_president = $fk_id_user_president;
    }
}