<?php


class CategoryController extends Controller {

    //show goods category
    public function indexAction() {
        $categoryModel = new CategoryModel("category");
        $cats = $categoryModel->getCats();

        include CUR_VIEW_PATH . "cat_list.html";
    }

    //show add category action
    public function addAction() {
        $categoryModel = new CategoryModel("category");
        $cats = $categoryModel->getCats();
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

    public function editAction() {
        $cat_id = $_GET['cat_id'] + 0;
        $categoryModel = new CategoryModel('category');
        $cat = $categoryModel->selectByPk($cat_id);

        $cats = $categoryModel->getCats();

        include CUR_VIEW_PATH . "cat_edit.html";

    }

    public function updateAction() {
        $data['cat_name'] = trim($_POST['cat_name']);
        $data['parent_id'] = ($_POST['parent_id']);
        $data['unit'] = trim($_POST['unit']);
        $data['sort_order'] = trim($_POST['sort_order']);
        $data['is_show'] = ($_POST['is_show']);
        $data['cat_desc'] = trim($_POST['cat_desc']);
        $data['cat_id'] = $_POST['cat_id'];

        if ($data['cat_name'] === "") {
            $this->jump("index.php?p=admin&c=category&a=add","分类名称不能为空",3);
        }

        $categoryModel = new CategoryModel("category");

        $ids = $categoryModel->getSubIds($data['cat_id']);

        $ids[] = $data['cat_id'];
        if (in_array($data['parent_id'],$ids)) {
            $this->jump("index.php?p=admin&c=category&a=edit&cat_id=".$data['cat_id'],"不能将当前节点及其子节点当作上级节点",3);
        }

        if ($categoryModel->update($data)) {
            $this->jump("index.php?p=admin&c=category&a=index", "更新成功", 2);
        } else {
            $this->jump("index.php?p=admin&c=category&a=edit&cat_id=".$data['cat_id'],"更新失败",3);
        }
    }

    public function deleteAction() {
        $cat_id = $_GET['cat_id'] + 0;

        $categoryModel = new CategoryModel('category');
        $cats = $categoryModel->getSubIds($cat_id);

        if (!empty($cats)) {
            $this->jump("index.php?p=admin&c=category&a=index", "当前分类不是叶子分类,不能删除", 3);
        }

        if ($categoryModel->delete($cat_id)) {
            $this->jump("index.php?p=admin&c=category&a=index", "删除商品分类成功", 2);
        } else {
            $this->jump("index.php?p=admin&c=category&a=index", "删除商品分类失败", 2);
        }
    }


}
