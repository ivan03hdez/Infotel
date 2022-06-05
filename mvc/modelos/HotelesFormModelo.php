<?php
    class HotelesFormModelo {
        public function getDatos($datos_in){
            if(array_key_exists('edit',$datos_in)){
                $query = DatabaseConnection::query('SELECT hotel.id AS \'ID\', nombre AS \'Nombre\', direccion.direccion AS \'Direccion\', direccion.ciudad AS \'Ciudad\' , nEstrellas AS \'Nº de Estrellas\' FROM hotel, direccion WHERE idDireccion=direccion.id LIMIT 10;');
                return $datos_in;
            }
            else{
                return array();
            }
        }
    }
?>