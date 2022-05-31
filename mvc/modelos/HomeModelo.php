<?php
    class HomeModelo {
        public function getDatos($datos_in){
            try {
                $query = DatabaseConnection::query('select * from hotel');
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            $hotels = array();

            while($row = mysqli_fetch_array($query)) 
            {
                $hotels[] = $row;
            }
            return $hotels; //Array tal que asi: [[0]=>[id,idDireccion,nombre,estrellas,imagenCiudad]]
        }
    }
?>