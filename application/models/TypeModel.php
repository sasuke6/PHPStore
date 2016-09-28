<?php

class TypeModel extends Model {

    //get all the googd type
    public function getTypes() {
        $sql = "SELECT * FROM {$this->table} ORDER BY type_id";
        return $this->db->getAll($sql);
    }

    public function getPageTypes($offset,$pagesize) {
        $sql = "SELECT * FROM {$this->table} ORDER BY type_id LIMIT $offset,$pagesize";
        return $this->db->getAll($sql);
    }


}