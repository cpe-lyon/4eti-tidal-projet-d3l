<?php

abstract class Model {

    var $meta = array(
        "table" => "",
    );

    function __construct() {
        $this->meta['table'] = strtolower(get_called_class());
    }

    function getAll() {
        return 'SELECT * FROM ' . $this->meta['table'];
    }

    function get($id) {
        return 'SELECT * FROM ' . $this->meta['table'] . ' WHERE id = ' . $id;
    }

    function sendRawQuery($query) {
        return $query;
    }
}