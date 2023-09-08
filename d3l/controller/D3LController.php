<?php

abstract class D3LController {

    var $table;

    protected function getAll() {
        $sql = "SELECT * FROM {$this->table->name}";

        // Exécutez la requête SQL ici

        return $sql;
    }

    /*protected function get($primaryKeyValue) {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = {$primaryKeyValue}";

        // Exécutez la requête SQL ici

        return $sql;
    }

    protected function insert($data) {
        $columns = implode(", ", array_keys($data));
        $values = "'" . implode("', '", $data) . "'";
        $sql = "INSERT INTO {$this->tableName} ({$columns}) VALUES ({$values})";

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

        $sql = "UPDATE {$this->tableName} SET {$setClause} WHERE {$this->primaryKey} = {$primaryKeyValue}";

        // Exécutez la requête SQL ici

        return $sql;
    }

    protected function delete($primaryKeyValue) {
        $sql = "DELETE FROM {$this->tableName} WHERE {$this->primaryKey} = {$primaryKeyValue}";

        // Exécutez la requête SQL ici

        return $sql;
    }

    protected function findByField($field, $value) {
        $sql = "SELECT * FROM {$this->tableName} WHERE {$field} = '{$value}'";

        // Exécutez la requête SQL ici

        return $sql;
    }*/

    protected function sendRawQuery($query) {
        return $query;
    }
}