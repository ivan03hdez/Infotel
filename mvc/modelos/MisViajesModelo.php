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
                $query = DatabaseConnection::query('select * from reserva r, reservaHist rh, cliente c where r.Codigo = rh.CodReserva and c.id = 3 AND rh.idCliente = c.id ;');
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