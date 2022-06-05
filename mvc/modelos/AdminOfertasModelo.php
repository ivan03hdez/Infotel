<?php
    class AdminOfertasModelo {
        public function getDatos($datos_in){
            #Si no hay datos como parámetros, se muestran los 10 primeros hoteles
            if(count($datos_in) == 0){
                try {
                    $query = DatabaseConnection::query('SELECT codigo, titulo, descripcion, descuento, fechaFin, IF(activa,\'Activa\',\'Inactiva\') FROM oferta LIMIT 10;');
                } catch (Exception $e) {
                    echo $e->getMessage();
                    exit();
                }
            }
            elseif(array_key_exists('codigo',$datos_in)){
                try{
                    $query = DatabaseConnection::query('DELETE from oferta where codigo =\''.$datos_in['codigo'].'\';');
                    $query = DatabaseConnection::query('SELECT codigo, titulo, descripcion, descuento, fechaFin, IF(activa,\'Activa\',\'Inactiva\') FROM oferta LIMIT 10;');
                }catch (Exception $e){
                    echo $e->getMessage();
                    exit();
                }
            }
            #Si recibimos un titulo como parámetro, mostramos ese hotel.
            else{
                try {
                    $query = DatabaseConnection::query('SELECT codigo, titulo, descripcion, descuento, fechaFin, IF(activa,\'Activa\',\'Inactiva\') FROM oferta where titulo LIKE (\'%'.$datos_in['titulo'].'%\') LIMIT 10;');
                } catch (Exception $e) {
                    echo $e->getMessage();
                    exit();
                }
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