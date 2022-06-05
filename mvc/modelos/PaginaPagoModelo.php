<?php
    class PaginaPagoModelo {
        public function getDatos($datos_in){
            // validar codigo
            // generar el codigo aleatorio y el id de empleados también
            // hacer insert en reserva
            // en reservahist
            // reservaservicios
            $idHotel = $datos_in["input-hotel"];
            $nombreServicio = $datos_in["input-servicios"];
            $idTipo= $datos_in["input-tipo"];
            $fechaInicio = $datos_in["fecha-llegada"];
            $fechaSalida = $datos_in["fecha-salida"];

            print_r($datos_in);

            function generarCodigo($length)
            {
                $key = "";
                $pattern = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                $max = strlen($pattern)-1;
                for($i = 0; $i < $length; $i++){
                    $key .= substr($pattern, mt_rand(0,$max), 1);
                }
                return $key;
            }

            $codigo=generarCodigo(6);
            $idEmpleado=mt_rand(1,1000000);

            try {
                //create a query to DB inserting all user data if form is valid
                // $insertQuery = DatabaseConnection::query('procedure');
                $query_tipo = DatabaseConnection::query('select * from tipo where id = "'.$idTipo.'"');
                $query_hotel = DatabaseConnection::query('select * from servicio where id = "'.$idHotel.'"');
                $query_servicio = DatabaseConnection::query('select * from servicio where idHotel = "'.$idHotel.'" and nombre = "'.$nombreServicio.'"');
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

            // print_r($tipos);
            // echo($tipos[0][2]);

            while($row = mysqli_fetch_array($query_hotel)) 
            {
                $hotel[] = $row;
            }

            while($row = mysqli_fetch_array($query_servicio)) 
            {
                $servicio[] = $row;
            }

            $datos = array([$tipos],[$hotel],[$servicio]);

            // print_r($datos);
            echo($datos[0][0][0][2]);
            return $datos;
        }
    }
?>