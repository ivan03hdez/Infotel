<?php
    class AdminServiciosModelo {
        public function getDatos($datos_in){
            #Si no hay datos como parámetros, se muestran los 10 primeros hoteles
            if(count($datos_in) == 0){
                try {
                    $query = DatabaseConnection::query('SELECT servicio.id, hotel.nombre, servicio.nombre, servicio.precio FROM hotel, servicio WHERE hotel.id = servicio.idHotel LIMIT 50;');
                } catch (Exception $e) {
                    echo $e->getMessage();
                    exit();
                }
            }
            elseif(array_key_exists('update',$datos_in)){
                try{
                    $idHotel = mysqli_fetch_array(DatabaseConnection::query('select id from hotel where nombre = \''.$datos_in['hotel'].'\''))[0];
                    $query = DatabaseConnection::query('UPDATE servicio SET nombre = \''.$datos_in['nombre'].'\', idHotel = \''.$idHotel.'\', descripcion = \''.$datos_in['descripcion'].'\', precio = \''.$datos_in['precio'].'\' where id = \''.$datos_in['update'].'\';');
                    $query = DatabaseConnection::query('SELECT servicio.id, hotel.nombre, servicio.nombre, servicio.precio FROM hotel, servicio WHERE hotel.id = servicio.idHotel LIMIT 50;');
                }catch (Exception $e){
                    echo $e->getMessage();
                    exit();
                }
            }
            elseif(array_key_exists('insert',$datos_in)){
                try{
                    $idHotel = mysqli_fetch_array(DatabaseConnection::query('select id from hotel where nombre = \''.$datos_in['hotel'].'\''))[0];
                    $query = DatabaseConnection::query('INSERT INTO servicio (idHotel,nombre,descripcion,precio) values (\''.$idHotel.'\', \''.$datos_in['nombre'].'\', \''.$datos_in['descripcion'].'\', \''.$datos_in['precio'].'\');');
                    
                    $query = DatabaseConnection::query('SELECT servicio.id, hotel.nombre, servicio.nombre, servicio.precio FROM hotel, servicio WHERE hotel.id = servicio.idHotel LIMIT 50;');
                }catch (Exception $e){
                    echo $e->getMessage();
                    exit();
                }
            }
            elseif(array_key_exists('id',$datos_in)){
                try{
                    $query = DatabaseConnection::query('DELETE from servicio where id ='.$datos_in['id'].';');
                    $query = DatabaseConnection::query('SELECT servicio.id, hotel.nombre, servicio.nombre, servicio.precio FROM hotel, servicio WHERE hotel.id = servicio.idHotel LIMIT 50;');
                }catch (Exception $e){
                    echo $e->getMessage();
                    exit();
                }
            }
            #Si recibimos un ID como parámetro, mostramos ese hotel.
            else{
                try {
                    $query = DatabaseConnection::query('SELECT servicio.id, hotel.nombre, servicio.nombre, servicio.precio FROM hotel, servicio WHERE hotel.id = servicio.idHotel AND hotel.nombre LIKE (\'%'.$datos_in['hotel'].'%\') and servicio.nombre LIKE (\'%'.$datos_in['servicio'].'%\')');
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