<?php
    class AdminHabitacionesModelo {
        public function getDatos($datos_in){
            #Si no hay datos como parámetros, se muestran las 40 habitaciones del primer hotel
            if(count($datos_in) == 0){
                try {
                    $query = DatabaseConnection::query('SELECT ha.id, ho.nombre, ha.numero, t.descripcion, ha.vistas, IF(ha.estaLimpia,\'SI \',\'NO\'), IF(ha.estaOcupada,\'SI\',\'NO\'), IF(ha.esAdaptada,\'SI\',\'NO\') FROM habitacion ha, tipo t , hotel ho WHERE ha.idHotel=ho.id AND ha.idTipo = t.id ORDER BY ha.id LIMIT 40;');
                } catch (Exception $e) {
                    echo $e->getMessage();
                    exit();
                }
            }
            elseif(count($datos_in) == 1){
                try {
                    $query = DatabaseConnection::query('DELETE from habitacion where id = '.$datos_in['id'].';');
                    $query = DatabaseConnection::query('SELECT ha.id, ho.nombre, ha.numero, t.descripcion, ha.vistas, IF(ha.estaLimpia,\'SI \',\'NO\'), IF(ha.estaOcupada,\'SI\',\'NO\'), IF(ha.esAdaptada,\'SI\',\'NO\') FROM habitacion ha, tipo t , hotel ho WHERE ha.idHotel=ho.id AND ha.idTipo = t.id ORDER BY ha.id LIMIT 40;');
                } catch (Exception $e) {
                    echo $e->getMessage();
                    exit();
                }
            }
            #Si recibimos un ID como parámetro, mostramos ese hotel.
            else{
                try {
                    $query = DatabaseConnection::query('SELECT ha.id, ho.nombre, ha.numero, t.descripcion, ha.vistas, IF(ha.estaLimpia,\'SI \',\'NO\'), IF(ha.estaOcupada,\'SI\',\'NO\'), IF(ha.esAdaptada,\'SI\',\'NO\') FROM habitacion ha, tipo t , hotel ho WHERE ha.idHotel=ho.id AND ha.idTipo = t.id AND ho.id = '.$datos_in['hotel'].' AND ha.numero LIKE (\'%'.$datos_in['numero'].'%\') ORDER BY ha.id LIMIT 40;');
                } catch (Exception $e) {
                    echo $e->getMessage();
                    exit();
                }
            }

            $hotels = array();

            while($row = mysqli_fetch_array($query)) 
            {
                $hotels[] = $row;
            }
            return $hotels;
        }
    }
?>