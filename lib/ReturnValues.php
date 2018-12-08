<?php

class ReturnValues{
    private $val_name = array();
    private $name_val = array();
    private $comment = array();
    public function add(string $name, int $val, $comment = "") {
        if (!isset($this->name_val[$name])) {
            $this->name_val[$name] = $val;
            $this->val_name[$val] = $name;
            $this->comment[$val] = $comment;
        }
    }
    public function override(string $name, int $val, $comment = "") {
        if (isset($this->val_name[$val]) && !isset($this->name_val[$name])) {
            unset($this->name_val[$this->val_name[$val]]);
            $this->name_val[$name] = $val;
            $this->val_name[$val] = $name;
            $this->comment[$val] = $comment;
        }
    }
    public function __construct() {
        $this->add("FORM_INCOMPLETE",       -1,     "出现未知错误(1)，请尝试重新启动客户端");
        $this->add("CANNOT_CONNECT_SERVER", -2,     "错误(2)：无法连接到服务器");
        $this->add("INVALID_USER_ID",       -3,     "错误(3)：用户不存在或不合法");
        $this->add("USER_BANNED",           -4,     "错误(4)：用户已被封禁");
        $this->add("UNKNOWN_ERROR",         -128,   "发生未知错误，请联系客服");
    }
    public function get_val(string $name) {
        return $this->name_val[$name];
    }
    public function get_com(string $name) {
        return $this->comment[$this->name_val[$name]];
    }
}