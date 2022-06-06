<?php
    require_once 'Encrypt.php';
    class RegistroModelo {
        public function getDatos($datos_in){
            if (count($datos_in) == 0) {
                return null;
            }

            if (!isSet($datos_in['nombre']) || !isSet($datos_in['apellidos'])|| !isSet($datos_in['contrasenya'])
                || !isSet($datos_in['dni']) || !isSet($datos_in['email']) || !isSet($datos_in['telefono'])
                || !isSet($datos_in['nacionalidad']) || !isSet($datos_in['fechaNac'])) {
                    return false;
            }

            $nombre = $datos_in['nombre'];
            $apellidos = $datos_in['apellidos'];
            $dni = $datos_in['dni'];
            $email = $datos_in['email'];
            $contrasenya = $datos_in['contrasenya'];
            $encryptObject = new Encrypt();
            $contrasenya = $encryptObject->encryptData($contrasenya);
            //echo "contraseña cifrada: ".print_r($contrasenya, true);
            $telefono = $datos_in['telefono'];
            $fecha_nacimiento = $datos_in['fechaNac'];
            $nacionalidad = $datos_in['nacionalidad'];

            try {
                //create a query to DB inserting all user data if form is valid
                $insertQuery = DatabaseConnection::query('INSERT INTO cliente (nombre, apellidos, nif, email, contrasenya, telefono, fechaNac, nacionalidad) VALUES ("'.$nombre.'", "'.$apellidos.'", "'.$dni.'", "'.$email.'", "'.$contrasenya.'", "'.$telefono.'", "'.$fecha_nacimiento.'", "'.$nacionalidad.'");');
                return true;
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }

        }
    }
?>