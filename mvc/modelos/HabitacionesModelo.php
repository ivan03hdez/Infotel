<?php
    class HabitacionesModelo {
        public function getDatos($datos_in){
        /*Realiza todas las acciones necesarias con el array $datos_in
        ...
        */
        #Recoge los resultados en un array y lo devuelve
        try {
            $query = DatabaseConnection::query('select * from tipo');
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }

        $tipos = array();

        while($row = mysqli_fetch_array($query)) 
        {
            $tipos[] = $row;
        }

        #$salida=["datoX"=>"ValorX", "datosY"=>"ValorY", "datosZ"=>"ValorZ"];
        return $tipos;
        }
    }
?>