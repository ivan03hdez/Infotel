<?php
    class AdminTablasModelo {
        public function getDatos($datos_in){
            $datos_in = 'hotel';
            try {
                $query = DatabaseConnection::query('SELECT hotel.id AS \'ID\', nombre AS \'Nombre\', direccion.direccion AS \'Direccion\', direccion.ciudad AS \'Ciudad\' , nEstrellas AS \'Nº de Estrellas\' FROM hotel, direccion WHERE idDireccion=direccion.id LIMIT 10;');
            } catch (Exception $e) {
                echo $e->getMessage();
                exit();
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