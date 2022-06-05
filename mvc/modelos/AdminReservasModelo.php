<?php
    class AdminReservasModelo {
        public function getDatos($datos_in){
            #Solo mostramos datos si se indica el número de reserva
            if(count($datos_in) == 1){
                try {
                    $query_habs = DatabaseConnection::query('SELECT m.id, m.codigo, identificador, m.fechaInicio, m.fechaFin, ho.nombre, h.numero, m.precio FROM mostrarReserva m, reserva r, habitacion h, hotel ho WHERE m.codigo=r.codigo AND m.id=h.id AND h.idHotel = ho.id AND m.`habitacion/servicio` = \'habitacion\' AND r.Identificador = \''.$datos_in['codigo'].'\'');
                    $query_serv = DatabaseConnection::query('SELECT m.id,m.codigo, identificador, m.fecha_servicio,h.nombre, s.nombre, m.precio FROM mostrarReserva m, reserva r, servicio s, hotel h WHERE m.codigo=r.codigo AND s.idHotel = h.id AND m.id=s.id AND m.`habitacion/servicio` = \'servicio\' AND r.Identificador = \''.$datos_in['codigo'].'\'');
                } catch (Exception $e) {
                    echo $e->getMessage();
                    exit();
                }
                $reservas = array(array(),array());

                while($row = mysqli_fetch_array($query_habs)) 
                {
                    $reservas[0][] = $row;
                }

                while($row = mysqli_fetch_array($query_serv)) 
                {
                    $reservas[1][] = $row;
                }
                return $reservas;
            }
            elseif(array_key_exists('habitacion',$datos_in)){
                $query_habs = DatabaseConnection::query('DELETE FROM reservaHist where CodReserva = '.$datos_in['reserva'].' AND idHabitacion = '.$datos_in['habitacion'].';');
                return array();
            }
            elseif(array_key_exists('servicio',$datos_in)){
                $query_serv = DatabaseConnection::query('DELETE FROM reservaServicio where codReserva = '.$datos_in['reserva'].' AND idServicio = '.$datos_in['servicio'].';');
                return array();
            }
            else{
                return array();
            }
        }
    }
?>