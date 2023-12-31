<?php

class DatabaseContext {

    var $profile;
    var $connection;

    function __construct(string $profile) {
        $file = file_get_contents('./app/config.json');
        $config = json_decode($file, true);
        $this->profile = $config[$profile];
        $this->generateConnection();
    }

    private function generateConnection() {
        $database = $this->profile['database'];
        $host = $this->profile['host'];
        $user = $this->profile['user'];
        $password = $this->profile['password'];

        try {
            $this->connection = new PDO("pgsql:host={$host};dbname={$database}", $user, $password);
        }
        catch (PDOException $e) {
            throw new ErrorException("PDO connection failed: " . $e->getMessage());
        }
    }

    function executeQuery(string $query) {
        if ($this->connection == null) {
            throw new ErrorException("Connection is null");
        }

        try {
            $this->connection->exec($query);
        }
        catch (PDOException $e) {
            throw new ErrorException("PDO query failed: " . $e->getMessage());
        }
    }
}