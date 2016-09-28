<?php

class Page {

    private $total;     //总的记录数
    private $pagesize;
    private $current;
    private $pagenum;  //总页数
    private $first;
    private $last;
    private $prev;
    private $next;
    private $url;

    function __construct($total,$pagesize,$current,$script,$params=array()) {
        $this->total = $total;
        $this->pagesize = $pagesize;
        $this->current = $current;
        $this->pagenum = ceil( $total/ $pagesize );

        $temp = array();
        foreach ($params as $k => $v) {
            //p = admin c = brand a = index
            $temp[] = "$k=$v";
        }

        $str = implode("&",$temp);  //p=admin&c=brand&a=index
        $this->url = "$script?{$str}&page=";
        $this->first = $this->getFirst();
        $this->last = $this->getLast();
        $this->prev = $this->getPrev();
        $this->next = $this->getNext();

    }

    private function getFirst() {
        if ($this->current == 1) {
            return "[首页]";
        } else {
            return "<a href='{$this->url}1'>[首页]</a>";
        }
    }

    private function getLast() {

        if ($this->current == $this->pagenum) {
            return "[末页]";
        } else {
            return "<a href='{$this->url}{$this->pagenum}'>[末页]</a>";
        }
    }

    private function getPrev() {
        if ($this->current == 1) {
            return "[上一页]";
        } else {
            return "<a href='{$this->url}".($this->current - 1)."'>[上一页]</a>";
        }
    }

    private function getNext() {
        if ($this->current == $this->pagenum) {
            return "[下一页]";
        } else {
            return "<a href='{$this->url}".($this->current + 1)."'>[下一页]</a>";
        }
    }

    public function showPage() {
        if ($this->pagenum >= 1) {
            return "共有 {$this->total} 条记录,每页显示 {$this->pagesize} 条记录, 当前为 {$this->current}/{$this->pagenum} {$this->first} {$this->prev} {$this->next} {$this->last}";
        } else {
            return "";
        }
    }


}