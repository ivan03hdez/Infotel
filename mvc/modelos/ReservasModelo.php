<?php
    class ReservasModelo {
        public function getDatos($datos_in){
            try {
                DatabaseConnection::query("SET NAMES 'utf8'");
                $query_tipo = DatabaseConnection::query('select * from tipo');
                $query_hotel = DatabaseConnection::query('select * from hotel');
                $query_servicio = DatabaseConnection::query('select * from servicio');
            } catch (Exception $e) {
                echo $e->getMessage();
                exit();
            }
    
            $tipos = array();
            $hotel = array();
            $servicio = array();
    
            while($row = mysqli_fetch_array($query_tipo)) 
            {
                $tipos[] = $row;
            }

            while($row = mysqli_fetch_array($query_hotel)) 
            {
                $hotel[] = $row;
            }

            while($row = mysqli_fetch_array($query_servicio)) 
            {
                $servicio[] = $row;
            }

            $datos = array([$tipos],[$hotel],[$servicio]);

            return $datos;
        }
    }
?>