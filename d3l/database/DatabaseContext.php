<?php

include_once './app/config.json';

class DatabaseContext {

    var $profile;
    var $connection;

    function __construct(string $profile) {
        $config = json_decode(file_get_contents('./app/config.json'), true);
        $this->profile = $config[$profile];
        $this->connection = $this->generateConnection();
    }

    private function generateConnection() {
        $database = $this->profile['database'];
        $host = $this->profile['host'];
        $user = $this->profile['user'];
        $password = $this->profile['password'];

        return new PDO("mysql:host={$host};dbname={$database}", $user, $password);
    }
}