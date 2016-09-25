<?php

class BaseController extends Controller {

    public function __construct() {
        $this->checklogin();
    }

    public function checklogin() {
        if (empty($_SESSION['admin'])) {
            $this->jump("index.php?p=admin&c=login&a=login","你需要登录",3);
        }
    }
}