<?php
    class HomeModelo {

        private $link;

        public function HomeModelo($link) {
            $this->link = $link;
        }

        public function getDatos($datos_in){
        /*Realiza todas las acciones necesarias con el array $datos_in
        ...
        */
        #Recoge los resultados en un array y lo devuelve
        $this->link->query('select * from reserva');
        echo $this->link;

        $salida=["datoX"=>"ValorX", "datosY"=>"ValorY", "datosZ"=>"ValorZ"];
        return $salida;
        }
    }
?>