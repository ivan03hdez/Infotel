<?php
    class AdminHotelesModelo {
        public function getDatos($datos_in){
            #Si no hay datos como parámetros, se muestran los 10 primeros hoteles
            if(count($datos_in) == 0){
                try {
                    $query = DatabaseConnection::query('SELECT hotel.id AS \'ID\', nombre AS \'Nombre\', direccion.direccion AS \'Direccion\', direccion.ciudad AS \'Ciudad\' , nEstrellas AS \'Nº de Estrellas\' FROM hotel, direccion WHERE idDireccion=direccion.id LIMIT 10;');
                } catch (Exception $e) {
                    echo $e->getMessage();
                    exit();
                }
            }
            elseif(array_key_exists('id',$datos_in)){
                try{
                    $query = DatabaseConnection::query('DELETE from hotel where id ='.$datos_in['id'].';');
                    $query = DatabaseConnection::query('SELECT hotel.id AS \'ID\', nombre AS \'Nombre\', direccion.direccion AS \'Direccion\', direccion.ciudad AS \'Ciudad\' , nEstrellas AS \'Nº de Estrellas\' FROM hotel, direccion WHERE idDireccion=direccion.id LIMIT 10;');
                }catch (Exception $e){
                    echo $e->getMessage();
                    exit();
                }
            }
            #Si recibimos un nombre como parámetro, mostramos ese hotel.
            else{
                try {
                    $query = DatabaseConnection::query('SELECT hotel.id AS \'ID\', nombre AS \'Nombre\', direccion.direccion AS \'Direccion\', direccion.ciudad AS \'Ciudad\' , nEstrellas AS \'Nº de Estrellas\' FROM hotel, direccion WHERE idDireccion=direccion.id and nombre LIKE (\'%'.$datos_in['nombre'].'%\');');
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