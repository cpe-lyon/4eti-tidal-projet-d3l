<?php

abstract class D3LController {

    var $table;
    var $db;

    function __construct(string $profile) {
        $this->db = new DatabaseContext($profile);
        
        //Turn off emulated prepared statements.
        $this->db->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this->db->connection->query('SET NAMES gbk');
    }

    protected function getAll() {
        //Query
        $stmt = $this->db->connection->prepare('SELECT * FROM :tablename');
        $stmt->execute(['tablename' => $this->table->name]);

        //Return data
        return $stmt->fetchAll();
    }

    /*protected function get($primaryKeyValue) {
        //Query
        $stmt = $this->db->connection->prepare('SELECT * FROM :tableName WHERE :primaryKey = :primaryKeyValue');
        $stmt->execute(['tablename' => $this->table->name, 'primaryKey' => $this->primaryKey, 'primaryKeyValue' => $primaryKeyValue]);

        //Return data
        return $stmt->fetchAll();
    }

    protected function insert($data) {
        $columns = implode(", ", array_keys($data));
        $values = "'" . implode("', '", $data) . "'";
        $sql = "INSERT INTO {$this->table->name} ({$columns}) VALUES ({$values})";

        // Exécutez la requête SQL ici
        // $sql contient la requête d'insertion

        // Exemple de code pour exécuter la requête (vous devrez utiliser un objet de connexion à la base de données)
        // $pdo = new PDO(...); // Initialisez votre connexion PDO ici
        // $pdo->exec($sql);

        return $sql;
    }

    protected function update($primaryKeyValue, $data) {
        $setClause = [];
        foreach ($data as $key => $value) {
            $setClause[] = "{$key} = '{$value}'";
        }
        $setClause = implode(", ", $setClause);

        $sql = "UPDATE {$this->table->name} SET {$setClause} WHERE {$this->primaryKey} = {$primaryKeyValue}";

        // Exécutez la requête SQL ici

        return $sql;
    }

    protected function delete($primaryKeyValue) {
        $sql = "DELETE FROM {$this->table->name} WHERE {$this->primaryKey} = {$primaryKeyValue}";

        // Exécutez la requête SQL ici

        return $sql;
    }

    protected function findByField($field, $value) {
        $sql = "SELECT * FROM {$this->table->name} WHERE {$field} = '{$value}'";

        // Exécutez la requête SQL ici

        return $sql;
    }*/

    protected function sendRawQuery($query) {
        return $query;
    }
}