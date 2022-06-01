<?php
    class AdminTablasModelo {
        public function getDatos($datos_in){
            $datos_in = 'hotel';
            try {
                $query = DatabaseConnection::query('SELECT * FROM '.$datos_in.' LIMIT 2');
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