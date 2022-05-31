<?php
    include './helpers.php';

    require_once 'modelos/database_connection.php';
    $link = new database_connection();

    define("BASE_DIR","C:/xampp/htdocs/infotel/mvc");
    define("MOD_DIR",BASE_DIR."/modelos/");
    define("VIEW_DIR",BASE_DIR."/vistas/");
    #Recoge por GET el identificador de la página a mostrar.
    if (array_key_exists("ID",$_GET)){
        $pagina=$_GET["ID"];
        $datos=$_POST;
    }else{ // Clase a cargar por defecto)
        $pagina="Home";
        $datos=array();
    }
    // si no existe la pagina demandada le mandamos al Home
    $modelo="${pagina}Modelo";
    if (!file_exists_ci($modelo))
        $pagina="Home";

    $modelo="${pagina}Modelo";
    require (MOD_DIR."$modelo.php");
    $m=new $modelo($link->getConnection());
    $resultado=$m->getDatos($datos);

    #Carga la vista y la ejecuta
    $vista="${pagina}Vista";
    require (VIEW_DIR."$vista.php");
    $v=new $vista;
    $v->render($resultado);
    //echo phpinfo()
?>