<?php

class AttributeController extends BaseController {
    public function indexAction() {
        $typeModel = new TypeModel("goods_type");
        $types = $typeModel->getTypes();


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
}