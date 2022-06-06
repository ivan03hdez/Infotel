<?php
    require_once 'Encrypt.php';
    class LoginModelo {
        public function getDatos($datos_in){
            if (isset($datos_in['usuario']) && isset($datos_in['contrasenya'])) {
                $usuario = $datos_in['usuario'];
                $password = $datos_in['contrasenya'];
                $encryptObject = new Encrypt();
                $password = $encryptObject->encryptData($password);
                try {
                    // cliente --> correo: ivanPrueba@gmail.com contraseña: ivanPrueba
                    $query = DatabaseConnection::query('select * from cliente where email = "'.$usuario.'" and contrasenya = "'.$password.'"');
                } catch (Exception $e) {
                    echo $e->getMessage();
                    exit();
                }
    
                $client = array();
    
                while($row = mysqli_fetch_array($query)) 
                {
                    $client[] = $row;
                }

                $isQueryOk = count($client) > 0;
                if ($isQueryOk) {
                    session_start();
                    $user = $client[0];
                    $_SESSION['user'] = $user;
                    return $user;
                }

                try {
                    // empleado administrador --> correo: ivan@gmail.com contraseña: ivan
                    $query = DatabaseConnection::query('select * from empleado where email = "'.$usuario.'" and contrasenya = "'.$password.'"');
                } catch (Exception $e) {
                    echo $e->getMessage();
                    exit();
                }

                $client = array();
    
                while($row = mysqli_fetch_array($query)) 
                {
                    $client[] = $row;
                }

                $isQueryOk = count($client) > 0;
                if ($isQueryOk) {
                    session_start();
                    $user = $client[0];
                    $_SESSION['user'] = $user;
                    return $user;
                }

                return false;
            } else {
                return null;
            }
        }
    }
?>