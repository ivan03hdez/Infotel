<?php
    class MiCuentaModelo {
        public function getDatos($datos_in){
        try {
            $query = DatabaseConnection::query('select * from empleado where id = '.$datos_in['id']);
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }

        $user = array();

        while($row = mysqli_fetch_array($query)) 
        {
            $user[] = $row;
        }
        return $user;
        }
    }
?>