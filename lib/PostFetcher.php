<?php

class PostFetcher
{
    private $_content;
    public function __construct(array $array = null) {
        if ($array) $this->_content = array($array);
        else $this->_content = array();
    }
    public function add($var_name) {
        array_push($this->_content, $var_name);
    }
    public function simulate($var_name, $val) {
        if (Configurations::get()["development"]["simulate_post_data"] && !isset($_POST[$var_name]) && !strlen($_POST[$var_name])) {
            $_POST[$var_name] = $val;
        }
    }
    public function validate() {
        foreach ($this->_content as $content) {
            if (!isset($_POST[$content]) || !strlen($_POST[$content])) {
                return $content;
            }
        }
    }
    public function valueOf($content) {
        return $_POST[$content];
    }
}