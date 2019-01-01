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
        $this->add("FORM_INCOMPLETE",       -1,     "Err(1): Form incomplete.");
        $this->add("CANNOT_CONNECT_SERVER", -2,     "Err(2): Database connection lost.");
        $this->add("INVALID_USER_ID",       -3,     "Err(3): Invalid user.");
        $this->add("USER_BANNED",           -4,     "Err(4): User banned.");
        $this->add("UNKNOWN_ERROR",         -128,   "Err: Unknown error.");
    }
    public function get_val(string $name) {
        return $this->name_val[$name];
    }
    public function get_com(string $name) {
        return $this->comment[$this->name_val[$name]];
    }
}