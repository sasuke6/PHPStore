<?php


class CategoryController extends Controller {


    //show add category action
    public function addAction() {
        include CUR_VIEW_PATH . "cat_add.html";
    }

    public function insertAction() {
        //collect form data
        $data['cat_name'] = trim($_POST['cat_name']);
        $data['parent_id'] = ($_POST['parent_id']);
        $data['unit'] = trim($_POST['unit']);
        $data['sort_order'] = trim($_POST['sort_order']);
        $data['is_show'] = ($_POST['is_show']);
        $data['cat_desc'] = trim($_POST['cat_desc']);



        //valited and deal

        if ($data['cat_name'] === "") {
            $this->jump("index.php?p=admin&c=category&a=add","分类名称不能为空",3);
        }


        //use model,insert into mysql and show status
        $categoryModel = new CategoryModel("category");
        if ($categoryModel->insert($data)) {
            $this->jump("index.php?p=admin&c=category&a=index", "添加分类成功", 2);
        } else {
            $this->jump("index.php?p=admin&c=category&a=add","添加分类失败",3);
        }
    }
}
