<?php

class AttributeModel extends Model {
    public function getAttrs($type_id) {
        $sql = "SELECT a.*,b.type_name FROM cy_attribute AS A INNER JOIN cy_goods_type AS b ON a.type_id = b.type_id WHERE a.type_id = $type_id";
        return $this->db->getAll($sql);
    }

    public function getPageAttrs($type_id, $offset, $pagesize) {
        $sql = "SELECT a.*, b.type_name FROM cy_attribute AS a INNER JOIN cy_goods_type AS b ON a.type_id = b.type_id WHERE a.type_id = $type_id LIMIT $offset,$pagesize";
        return $this->db->getAll($sql);
    }

    public function getAttrsForm($type_id) {
        $sql = "SELECT * FROM {$this->table} WHERE type_id = $type_id";
        $attrs = $this->db->getAll($sql);
        $res = "<table width='100%' id='attrTable'>";
        $res .= "<tbody>";
        foreach ($attrs as $attr) {
            $res .= "<tr>";
            $res .= "<td class='label'>{$attr['attr_name']}</td>";
            $res .= "<td>";
            $res .= "<input type='hidden' name='attr_id_list[]' value='".$attr['attr_id']."'>";

            switch ($attr['attr_input_type']){
                case 0: #文本框
                    $res .= "<input name='attr_value_list[]' type='text' size='40'>";
                    break;
                case 1: #下拉列表
                    $res .= "<select name='attr_value_list[]'>";
                    $res .= "<option value=''>请选择...</option>";
                    $opts = explode(PHP_EOL, $attr['attr_value']);
                    foreach ($opts as $opt){
                        $res .= "<option value='$opt'>$opt</option>";
                    }
                    $res .= "</select>";
                    break;
                case 2: #多行文本
                    $res .= "<textarea name='attr_value_list[]'></textarea>";
                    break;
            }
            $res .= "<input type='hidden' name='attr_price_list[]' value='0'>";
            $res .= "</td>";
            $res .= "</tr>";
        }
        $res .= "</tbody>";
        $res .= "</table>";
        return $res;

    }

}