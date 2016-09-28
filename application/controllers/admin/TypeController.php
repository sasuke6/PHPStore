<?php

class TypeController extends Controller {

    public function indexAction() {
        $typeModel = new TypeModel("goods_type");
//        $types = $typeModel->getTypes();
        $current = isset($_GET['page']) ? $_GET['page'] : 1;
        $pagesize = 2;
        $offset = ($current - 1) * $pagesize;
        $types = $typeModel->getPageTypes($offset, $pagesize);
        $where = "";
        $total = $typeModel->total($where);
        $this->library("Page");
        $page = new Page($total,$pagesize,$current,'index.php', array('p'=>'admin','c'=>'type','a'=>'index'));
        $pageInfo = $page->showPage();

        include CUR_VIEW_PATH . "goods_type_list.html";
    }

    public function addAction() {
        include CUR_VIEW_PATH . "goods_type_add.html";
    }

    public function insertAction() {
        $data['type_name'] = trim($_POST['type_name']);

        if ($data['type_name'] === '') {
            $this->jump("index.php?p=admin&c=type&a=add", "商品类型名称不能为空",3);
        }

        $this->helper('input');
        $data = deepspecialchars($data);
        $data = deepslashes($data);

        $typeModel = new TypeModel('goods_type');
        if ($typeModel->insert($data)) {
            $this->jump("index.php?p=admin&c=type&a=index", "添加商品类型成功",2);
        } else {
            $this->jump("index.php?p=admin&c=type&a=add", "添加商品类型失败",3);
        }
    }
}