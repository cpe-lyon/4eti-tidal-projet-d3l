<?php

require_once './d3l/database/DatabaseContext.php';

abstract class D3LController {

    public $tableName;
    var $db;

    function __construct(string $profile) {
        $this->db = new DatabaseContext($profile);
        $this->db->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    protected function getAll($formatting_func="json_encode"){
        $query = "SELECT * FROM " . $this->tableName;
        $stmt = $this->db->connection->prepare($query);
        $stmt->execute();
        return $formatting_func($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    protected function findById(int $id, $formatting_func="json_encode"){
        $query = "SELECT * FROM " . $this->tableName . " WHERE id = " . $id;
        $stmt = $this->db->connection->prepare($query);
        $stmt->execute();
        $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if($formatting_func !== NULL){
            return $formatting_func($ret[0]);
        }
        return $ret[0];
    }

    
    protected function save($data) {
        $data_arr = (array) $data;
        array_diff($data_arr, ['id']);
        unset($data_arr['id']);
        $columns = implode(", ", array_keys($data_arr));
        $values = implode(", ", $this->getValuesFormatted(array_values($data_arr)));
        $sql = "INSERT INTO {$this->tableName} ({$columns}) VALUES ({$values})";
        $stmt = $this->db->connection->prepare($sql);
        //echo $sql;
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

    protected function update($data) {
        $arr_data = (array) $data;

        $id = $arr_data['id'];
        unset($arr_data['id']);
        
        $setClause = [];
        
        foreach ($arr_data as $key => $value) {
            $setClause[] = "{$key} = {$this->formatValues($value)}";
        }
        $setClause = implode(", ", $setClause);

        $sql = "UPDATE {$this->tableName} SET {$setClause} WHERE id = {$id}";

        $stmt = $this->db->connection->prepare($sql);
        return $stmt->execute();
    }

    protected function delete($primaryKeyValue) {
        $sql = "DELETE FROM {$this->tableName} WHERE id = {$primaryKeyValue}";
        $stmt = $this->db->connection->prepare($sql);
        return $stmt->execute();
    }

    protected function findByField($field, $value) {
        $sql = "SELECT * FROM {$this->tableName} WHERE {$field} = '{$value}'";
        $stmt = $this->db->connection->prepare($sql);
        return $stmt->execute();
    }

    protected function sendRawQuery($query) {
        $stmt = $this->db->connection->prepare($query);
        return $stmt->execute();
    }
}