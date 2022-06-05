<?php
    class ServiciosFormModelo {
        public function getDatos($datos_in){
            if(array_key_exists('edit',$datos_in)){
                $query = DatabaseConnection::query('SELECT servicio.id,servicio.nombre,hotel.nombre,servicio.descripcion,servicio.precio FROM servicio,hotel WHERE servicio.idHotel=hotel.id and servicio.id= \''.$datos_in['edit'].'\';');
                
                $hotel = array();

                while($row = mysqli_fetch_array($query)) 
                {
                    $hotel[] = $row;
                }
                /*
                echo (implode($hotel[0]));
                exit();
                */
                return $hotel;
            }
            else{
                return array();
            }
        }
    }
?>