<?php

class LoginController extends Controller {
    public function loginAction() {
        include CUR_VIEW_PATH . "login.html";
    }

    public function signAction() {
        $captcha = trim($_POST['captcha']);
        if (strtolower($captcha) != $_SESSION['captcha']) {
            $this->jump("index.php?p=admin&c=login&a=login","没有通过",3);
        }

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);


        $this->helper('input');
        $username = deepslashes($username);
        $password = deepslashes($password);

        $adminModel = new AdminModel("admin");
        $userinfo = $adminModel->checkUser($username,$password);
        if (empty($userinfo)) {
            $this->jump("index.php?p=admin&c=login&a=login","用户名和密码错误,请重试",3);
        } else {
            $_SESSION['admin'] = $userinfo;
            $this->jump("index.php?p=admin&c=index&a=index", "" , 0);
        }
    }

    public function logoutAction() {
        unset($_SESSION['admin']);
        session_destroy();
        $this->jump("index.php?p=admin&c=login&a=login","",0);
    }

    public function captchaAction() {
        $this->library("Captcha");
        $captcha = new Captcha();
        $captcha->generateCode();

        $_SESSION['captcha'] = $captcha->getCode();

    }

}