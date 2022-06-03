<?php
    class RegistroModelo {
        public function getDatos($datos_in){
            if (count($datos_in) == 0) {
                return null;
            }

            if (!isSet($datos_in['nombre']) || !isSet($datos_in['apellidos']) || !isSet($datos_in['email'])
                || !isSet($datos_in['contrasenya']) || !isSet($datos_in['dni']) || !isSet($datos_in['telefono'])
                || !isSet($datos_in['direccion']) || !isSet($datos_in['fecha_nacimiento'])) {
                return false;
            }

            $nombre = $datos_in['nombre'];
            $apellidos = $datos_in['apellidos'];
            $email = $datos_in['email'];
            $contrasenya = $datos_in['contrasenya'];
            $dni = $datos_in['dni'];
            $fecha_nacimiento = $datos_in['fecha_nacimiento'];
            $nacionalidad = $datos_in['nacionalidad'];
            $telefono = $datos_in['telefono'];
            try {
                //create a query to DB inserting all user data if form is valid
                $insertQuery = DatabaseConnection::query('INSERT INTO cliente (nombre, apellidos, email, contrasenya, dni, fecha_nacimiento, nacionalidad, telefono) values ("'.$nombre.'", "'.$apellidos.'", "'.$email.'", "'.$contrasenya.'", "'.$dni.'", "'.$fecha_nacimiento.'", "'.$nacionalidad.'", "'.$telefono.'")');
                return true;
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }

        }
    }
?>