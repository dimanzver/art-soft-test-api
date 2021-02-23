<?php

class DB{

    protected static $connection;

    public static function getConnection() {
        if(!self::$connection) {
            // TODO: to .env
            self::$connection = new PDO('mysql:host=localhost;dbname=art_soft_test', 'root', 'qaz');;
        }
        return self::$connection;
    }

}
