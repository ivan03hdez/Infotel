<?php
    class ServiciosModelo {
        public function getDatos($datos_in){
            
            try {
                DatabaseConnection::query("SET NAMES 'utf8'");
                $query = DatabaseConnection::query("select DISTINCT paisResidencia from direccion;");
            } catch (Exception $e) {
                echo $e->getMessage();
                exit();
            }
            

            $paises = array();
    
            while($row = mysqli_fetch_array($query)) 
            {
                $paises[] = $row;
            }
            
            #$salida=["datoX"=>"ValorX", "datosY"=>"ValorY", "datosZ"=>"ValorZ"];
            return $paises;
            
        }
    }
?>