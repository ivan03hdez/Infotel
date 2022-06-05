<?php
    class MisViajesModelo {
       /* public function getDatos($datos_in){
            try {
                //Consulta a partir del id de la dirección de un usuario
                $query = DatabaseConnection::query('select * from reserva LIMIT 10');
            } catch (Exception $e) {
                echo $e->getMessage();
                exit();
            }

        $dire = array();

        while($row = mysqli_fetch_array($query)) 
        {
            $dire[] = $row;
        }
        session_start();
        $_SESSION['reserva'] = count($dire) > 0 ? $dire[0] : null;
     

        return $dire;
   
    }*/
    
       // Con esta saco el precio de las habitaciones
    public function getDatos($datos_in){
            try {
                $datos_in = 1;
                //Consulta a partir del id de la dirección de un usuario
                $query = DatabaseConnection::query('select precio from reservaHist rh, reserva r where r.Codigo = rh.CodReserva AND rh.CodReserva = "'.$datos_in.'"');
            } catch (Exception $e) {
                echo $e->getMessage();
                exit();
            }

        $dire = array();

        while($row = mysqli_fetch_array($query)) 
        {
            $dire[] = $row;
        }
        session_start();
        $_SESSION['reserva'] = count($dire) > 0 ? $dire[0] : null;
    

        return $dire;

    }

    }
?>