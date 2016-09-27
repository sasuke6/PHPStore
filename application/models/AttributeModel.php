<?php

class AttributeModel extends Model {
    public function getAttrs($type_id) {
        $sql = "SELECT a.*,b.type_name FROM cy_attribute AS A INNER JOIN cy_goods_type AS b ON a.type_id = b.type_id WHERE a.type_id = $type_id";
        return $this->db->getAll($sql);
    }
}