<?php

require_once 'config/configuration.php';

class DatabaseConnection{

    private static $hostname = HOST_NAME;
    private static $database = DATABASE_NAME;
    private static $user = USER;
    private static $password = PASSWORD;
    private $charset = CHARSET;
    private static $link;

    static function createConnection() {
        if(!isset(self::$link)) {
            self::$link = new mysqli(self::$hostname, self::$user, self::$password, self::$database);
            if(!isset(self::$link)) {
                die("Error:no pudo conectar". mysqli_connect_error());
                self::$link = null;
            }
        }

        return self::$link;
    }

    static function closeConnection() {
        mysqli_close(self::$link);
    }

    static function query($query) {
         self::$link->query("SET NAMES 'UTF8'");
        return self::$link->query($query);
    }
}
?>