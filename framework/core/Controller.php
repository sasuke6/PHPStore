<?php


class Controller {
    //jump define

    public function jump($url, $message, $wait = 3) {
        if ($wait == 0) {
            header("Location:$url");
        } else {
            include CUR_VIEW_PATH . "message.html";
        }

        exit();
    }


    //input_helper.php
    public function helper($helper) {
        require HELPER_PATH . "{$helper}_helper.php";
    }


    //page.php
    public function library($lib) {
        require LIB_PATH . "{$lib}.php";
    }
}