<?php
    class HotelesFormModelo {
        public function getDatos($datos_in){
            if(array_key_exists('edit',$datos_in)){
                $query = DatabaseConnection::query('SELECT hotel.id,direccion.id,hotel.nombre, direccion.direccion, direccion.cp, direccion.ciudad, direccion.paisResidencia, hotel.nEstrellas FROM hotel, direccion WHERE idDireccion=direccion.id and hotel.id = \''.$datos_in['edit'].'\';');
                
                $hotel = array();

                while($row = mysqli_fetch_array($query)) 
                {
                    $hotel[] = $row;
                }
                
                return $hotel;
            }
            else{
                return array();
            }
        }
    }
?>