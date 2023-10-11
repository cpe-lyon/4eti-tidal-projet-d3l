<?php

require_once './d3l/database/DatabaseContext.php';

abstract class D3LController {

    var $tableName;
    var $db;

    function __construct(string $profile) {
        $this->db = new DatabaseContext($profile);
        $this->db->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    protected function getAll() {
        $query = "SELECT * FROM " . $this->tableName;
        $stmt = $this->db->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    protected function findById(int $id){
        $query = "SELECT * FROM " . $this->tableName . " WHERE id = " . $id;
        $stmt = $this->db->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll()[0];
    }

    
    protected function save($data) {
        $data_arr = (array) $data;
        array_diff($data_arr, ['id']);
        unset($data_arr['id']);
        $columns = implode(", ", array_keys($data_arr));
        $values = implode(", ", $this->getValuesFormatted(array_values($data_arr)));
        $sql = "INSERT INTO {$this->tableName} ({$columns}) VALUES ({$values})";
        echo $sql;
        $stmt = $this->db->connection->prepare($sql);
        return $stmt->execute();
    }

    private function getValuesFormatted($params){
        $values = [];
        foreach($params as $param){
            array_push($values, $this->formatValues($param));
        }
        return $values;
    }

    private function formatValues($param){
        if(gettype($param) === "string"){
            return "'" . $param . "'";
        }
        return $param;
    }

    /*
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