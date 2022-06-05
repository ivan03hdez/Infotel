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
            elseif(array_key_exists('update',$datos_in)){
                try{
                    $query = DatabaseConnection::query('UPDATE hotel SET nombre = \''.$datos_in['nombre'].'\', nEstrellas = \''.$datos_in['estrellas'].'\' where id = \''.$datos_in['update'].'\';');
                    $query = DatabaseConnection::query('UPDATE direccion SET direccion = \''.$datos_in['direccion'].'\', cp = \''.$datos_in['cp'].'\', ciudad = \''.$datos_in['ciudad'].'\', paisResidencia = \''.$datos_in['pais'].'\' where id = \''.$datos_in['idDireccion'].'\';');
                    $query = DatabaseConnection::query('SELECT hotel.id AS \'ID\', nombre AS \'Nombre\', direccion.direccion AS \'Direccion\', direccion.ciudad AS \'Ciudad\' , nEstrellas AS \'Nº de Estrellas\' FROM hotel, direccion WHERE idDireccion=direccion.id LIMIT 10;');
                }catch (Exception $e){
                    echo $e->getMessage();
                    exit();
                }
            }
            elseif(array_key_exists('insert',$datos_in)){
                try{
                    $query = DatabaseConnection::query('INSERT INTO direccion (direccion,cp,ciudad,paisResidencia) values (\''.$datos_in['direccion'].'\', \''.$datos_in['cp'].'\', \''.$datos_in['ciudad'].'\', \''.$datos_in['pais'].'\');');
                    $idDir = mysqli_fetch_array(DatabaseConnection::query('select LAST_INSERT_ID();'))[0];
                    $query = DatabaseConnection::query('INSERT INTO hotel (idDireccion,nombre,nEstrellas,imagenCiudad) values (\''.$idDir.'\',\''.$datos_in['nombre'].'\',\''.$datos_in['estrellas'].'\',LOAD_FILE(\''.$datos_in['imagen'].'\'));');
                    
                    $query = DatabaseConnection::query('SELECT hotel.id AS \'ID\', nombre AS \'Nombre\', direccion.direccion AS \'Direccion\', direccion.ciudad AS \'Ciudad\' , nEstrellas AS \'Nº de Estrellas\' FROM hotel, direccion WHERE idDireccion=direccion.id LIMIT 10;');
                }catch (Exception $e){
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