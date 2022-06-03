<?php

    function file_exists_ci($file) {
        if (file_exists($file))
            return true;

        $lowerfile = strtolower($file);

        foreach (glob(dirname($file).'/modelos/*')  as $file){
            //echo baseName(strtolower($file))."<br>";
            if (baseName(strtolower($file)) == $lowerfile.'.php')
                return true;
        }


        return false;
    }
    
    function isAdminUser() {
        $isAdmin = false;
        session_start();
        if (array_key_exists('user', $_SESSION)) {
            $user = $_SESSION['user'];
            if ($user['puestoTrabajo'] == 'Administrador')
                $isAdmin = true;
        }
        return $isAdmin;
    }
?>