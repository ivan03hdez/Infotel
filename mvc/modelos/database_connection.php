<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/Infotel/mvc/config/configuration.php';

class database_connection{

    private $hostname = HOST_NAME;
    private $database = DATABASE_NAME;
    private $user = USER;
    private $password = PASSWORD;
    private $charset = CHARSET;
    private $link;

    function getConnection(){

        $link=new mysqli($this->hostname,$this->user,$this->password,$this->database);
        if(!$link)
        die("Error:no pudo conectar");
        return $this->link;
    }
} 

?>