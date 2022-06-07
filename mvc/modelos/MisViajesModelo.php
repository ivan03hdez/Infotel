<?php
    class MisViajesModelo {
        public function getDatos($datos_in) {
            session_start();
            if(!isset($_SESSION['user'])) {
                return null;
            }
            $userid = $_SESSION['user']['id'];
            try{
                //Consulta a partir del id de la dirección de un usuario
                $query = DatabaseConnection::query('
                    select DISTINCT Codigo, Identificador, fechaInicio, fechaFin, precioTotal, idCliente
                    from reserva r, reservaHist rh
                    where r.Codigo = rh.CodReserva AND rh.idCliente = '.$userid);
            } catch (Exception $e) {
                echo $e->getMessage();
                exit();
            }
            $dire = array();
            while($row = mysqli_fetch_array($query)) {
               $dire[] = $row;
            }
            return $dire;
        }
  
    }
?>