<?php

class AttributeController extends BaseController {
    public function indexAction() {
        $typeModel = new TypeModel("goods_type");
        $types = $typeModel->getTypes();
        $attrModel = new AttributeModel("attribute");

        $type_id = $_GET['type_id'] + 0;
        $current = isset($_GET['page']) ? $_GET['page'] : 1;

        $pagesize = 2;
        $where = "$type_id";
        $total = $attrModel->total($where);

        $offset = ($current - 1) * $pagesize;
        $attrs = $attrModel->getAttrs($type_id,$offset,$pagesize);

        $this->library("Page");
        $page = new Page($total,$pagesize,$current,'index.php',
                            array('p'=>'admin','c'=>'attribute','a'=>'index','type_id' => $type_id));

        $pageinfo = $page->showPage();


        include  CUR_VIEW_PATH . "attribute_list.html";
    }


    //显示添加页面
    public function addAction() {
        $typeModel = new TypeModel("goods_type");
        $types = $typeModel->getTypes();

        include CUR_VIEW_PATH . "attribute_add.html";
    }

    public function insertAction() {
        $data['attr_name'] = trim($_POST['attr_name']);
        $data['type_id'] = $_POST['type_id'];
        $data['attr_type'] = $_POST['attr_type'];
        $data['attr_input_type'] = $_POST['attr_input_type'];

        $data['attr_value'] = isset($_POST['attr_value']) ? $_POST['attr_value'] : "";

        $this->helper('input');
        $data = deepspecialchars($data);
        $data = deepslashes($data);

        $attrModel = new AttributeModel("attribute");
        if ($attrModel->insert($data)) {
            $this->jump("index.php?p=admin&c=attribute&a=index","添加属性成功",2);
        } else {
            $this->jump("index.php?p=admin&c=attribute&a=add","添加属性失败",2);
        }
    }

    public function getAttrsAction() {
        $type_id = $_GET['type_id'] + 0;
        $attrModel = new AttributeModel('attribute');
        $attrs = $attrModel->getAttrsForm($type_id);
        echo <<<STR
<script type="text/javascript">
  window.parent.document.geyElementById("tbody-goodsAttr").innerHTML = "$attrs";
<script>
STR;


    }
}