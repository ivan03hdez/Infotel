<?php
    class AdminEstadisticasModelo {

        public function AdminEstadisticasModelo($PDOConnection) {
            $this->$PDOConnection = $PDOConnection;
        }

        public function getDatos($datos_in){
        /*Realiza todas las acciones necesarias con el array $datos_in
        ...
        */
        
        $PDOConnection->query('select * from reserva')

        #Recoge los resultados en un array y lo devuelve
        $salida=["datoX"=>"ValorX", "datosY"=>"ValorY", "datosZ"=>"ValorZ"];
        return $salida;
        }
    }
?>