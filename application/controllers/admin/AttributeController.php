<?php

class AttributeController extends BaseController {
    public function indexAction() {
        $typeModel = new TypeModel("goods_type");
        $types = $typeModel->getTypes();


        include  CUR_VIEW_PATH . "attribute_list.html";
    }
}