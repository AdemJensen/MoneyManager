<?php

class Configurations
{
    private static $configs = array(
        'database' => array(
            'host' => '127.0.0.1',
            'user' => 'root',
            'password' => 'root',
            'database' => 'money_manager_database'
        ),
        'BaiDu_api' => array(
            'application_key' => "jSTXMLzhdVKTXYoRUCqDpWV0WFtOpm7T"
        ),
        'development' => array(

        )
    );
    public static function get() {
        return self::$configs;
    }
}