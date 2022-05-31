<?php
    class MiCuentaModelo {
        public function getDatos($datos_in){
        /*Realiza todas las acciones necesarias con el array $datos_in
        ...
        */
        #Recoge los resultados en un array y lo devuelve
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
    
        $salida=["nombre"=>"nombre","correo"=>"correo","dni"=>"dni","direccion"=>"direccion","fnac"=>"fnac","pais"=>"pais","cuidad"=>"cuidad","cp"=>"cp"];
            return $salida;
        }
    }
?>