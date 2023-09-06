<?php

abstract class D3LController {

    var $meta = array(
        "table" => "",
        "primary_key" => ""
    );

    protected function setTableMetaData($meta) {
        $this->meta = $meta;
    }

    protected function getAll() {
        $sql = "SELECT * FROM {$this->meta['table']}";

        // Exécutez la requête SQL ici

        return $sql;
    }

    protected function get($primary_key) {
        $sql = "SELECT * FROM {$this->meta['table']} WHERE {$this->meta["primary_key"]} = \"{$primary_key}\"";

        // Exécutez la requête SQL ici

        return $sql;
    }

    protected function insert($data) {
        $columns = implode(", ", array_keys($data));
        $values = "'" . implode("', '", $data) . "'";
        $sql = "INSERT INTO {$this->meta['table']} ({$columns}) VALUES ({$values})";

        // Exécutez la requête SQL ici
        // $sql contient la requête d'insertion

        // Exemple de code pour exécuter la requête (vous devrez utiliser un objet de connexion à la base de données)
        // $pdo = new PDO(...); // Initialisez votre connexion PDO ici
        // $pdo->exec($sql);

        return $sql;
    }

    protected function update($id, $data) {
        $setClause = [];
        foreach ($data as $key => $value) {
            $setClause[] = "{$key} = '{$value}'";
        }
        $setClause = implode(", ", $setClause);

        $sql = "UPDATE {$this->meta['table']} SET {$setClause} WHERE id = {$id}";

        // Exécutez la requête SQL ici

        return $sql;
    }

    protected function delete($id) {
        $sql = "DELETE FROM {$this->meta['table']} WHERE id = {$id}";

        // Exécutez la requête SQL ici

        return $sql;
    }

    protected function findByField($field, $value) {
        $sql = "SELECT * FROM {$this->meta['table']} WHERE {$field} = '{$value}'";

        // Exécutez la requête SQL ici

        return $sql;
    }

    protected function sendRawQuery($query) {
        return $query;
    }
}