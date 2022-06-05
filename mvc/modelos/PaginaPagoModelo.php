<?php
    class PaginaPagoModelo {
        public function getDatos($datos_in){

            $idHotel = $datos_in["input-hotel"];
            $nombreServicio = $datos_in["input-servicios"];
            $idTipo= $datos_in["input-tipo"];
            $fechaInicio = $datos_in["fecha-llegada"];
            $fechaSalida = $datos_in["fecha-salida"];

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
            $idEmpleado=mt_rand(1,20000);

            try {
                session_start();
                    if (!isSet($_SESSION['user'])) {
                        return header("Location: login");
                    }
                $user = $_SESSION['user'];
                //create a query to DB inserting all user data if form is valid
                DatabaseConnection::query("SET NAMES 'utf8'");
                $comprobarDisponibilidad = DatabaseConnection::query('select get_HabitacionLibre('.$idHotel.',"'.$fechaInicio.'", "'.$fechaSalida.'", '.$idTipo.')');
                $habitacion = mysqli_fetch_array($comprobarDisponibilidad);

                if (is_null($habitacion[0])){
                    echo("ERROR");
                }
                else{
                    $insertQuery = DatabaseConnection::query('INSERT INTO reserva (Identificador, fechaInicio, fechaFin) values ("'.$codigo.'","'.$fechaInicio.'", "'.$fechaSalida.'")');
                    $procedureHabitacion = DatabaseConnection::query('call introducirDatosReservaHabitacion("'.$codigo.'",'."{$user["id"]}".','.$habitacion[0].',"'.$fechaInicio.'",'.$datos_in["input-personas"].')');
                    $procedureServicio = DatabaseConnection::query('call introducirDatosReservaServicio('.$idHotel.',"'.$nombreServicio.'","'.$codigo.'",'.$idEmpleado.',"'.$fechaInicio.'")');
                    
                    $codigoReserva_query= DatabaseConnection::query('SELECT Codigo FROM reserva WHERE Identificador = "'.$codigo.'"LIMIT 1');
                    $codigoReserva = mysqli_fetch_array($codigoReserva_query);

                    $query_habitacionPrecio = DatabaseConnection::query('select * from mostrarReservaAgrupadoPorTipo where codigo = "'.$codigoReserva[0].'"');

                    $query_tipo = DatabaseConnection::query('select * from tipo where id = "'.$idTipo.'"');
                    $query_hotel = DatabaseConnection::query('select * from hotel where id = "'.$idHotel.'"');
                    $query_servicio = DatabaseConnection::query('select * from servicio where idHotel = "'.$idHotel.'" and nombre like "%'.$nombreServicio.'%"');
                    $query_direccion = DatabaseConnection::query('select * from direccion where id = "'.$idHotel.'"');
                    $query_reserva = DatabaseConnection::query('select * from reserva where Identificador = "'.$codigo.'"');
                }
                
            } catch (Exception $e) {
                echo $e->getMessage();
                exit();
            }

            $fechaInicio = date("d-m-Y", strtotime($datos_in["fecha-llegada"]));
            $fechaSalida = date("d-m-Y", strtotime($datos_in["fecha-salida"]));

            $tipos = array();
            $hotel = array();
            $servicio = array();
            $direccion = array();
            $reserva = array();
    
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

            while($row = mysqli_fetch_array($query_reserva)) 
            {
                $reserva[] = $row;
            }

            while($row = mysqli_fetch_array($query_direccion)) 
            {
                $direccion[] = $row;
            }

            while($row = mysqli_fetch_array($query_habitacionPrecio)) 
            {
                $reservaHabitacion[] = $row;
            }

            $totalPrecio = (float)$reservaHabitacion[0][2] + (float)$reservaHabitacion[1][2];

            $datos = array([$tipos],[$hotel],[$servicio], [$direccion], [$reserva], [$reservaHabitacion], $fechaInicio, $fechaSalida, $totalPrecio);

            return $datos;
        }
    }
?>