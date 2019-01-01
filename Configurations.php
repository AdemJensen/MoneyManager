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
        'development' => array(

        )
    );
    public static function get() {
        return self::$configs;
    }
}