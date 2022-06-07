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
                select DISTINCT r.Codigo, Identificador, fechaInicio, fechaFin, mrat.Precio AS precioTotal, idCliente
                from reserva r 
                      INNER JOIN reservaHist rh
                      ON r.Codigo = rh.CodReserva 
                      INNER JOIN 
                      (SELECT codigo, SUM(Precio) AS "Precio" FROM mostrarReservaAgrupadoPorTipo GROUP BY codigo) mrat
                      ON mrat.codigo = r.Codigo
                      WHERE rh.idCliente = '.$userid);
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