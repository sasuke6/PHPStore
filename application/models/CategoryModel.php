<?php

/**
 * Class CategoryModel
 */
class CategoryModel extends AdminModel {

    public function getCats() {
        $sql = "SELECT * FROM {$this->table}";
        $cats = $this->db->getAll($sql);
        return $this->tree($cats);
    }


    /**
     * @param $arr array
     * @param int $pid  where to find the pid
     * @param $level
     * @return array 构造好的数组
     */
    public function tree($arr, $pid = 0,$level = 0) {
       static $tree = array();
        foreach ($arr as $v) {
            if ($v['parent_id'] == $pid) {
                $v['level'] = $level;
                $tree[] = $v;
                $this->tree($arr, $v['cat_id'], $level + 1);
            }
        }

        return $tree;

    }

    //define a method to get current node of all the grandson node
    public function getSubIds($pid) {
        $sql = "SELECT * FROM {$this->table}";
        $cats = $this->db->getAll($sql);
        $cats = $this->tree($cats, $pid);
        $list = array();
        foreach ($cats as $cat) {
            $list[] = $cat['cat_id'];
        }
        return $list;
    }

}