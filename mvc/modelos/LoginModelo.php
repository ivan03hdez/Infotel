<?php
    class LoginModelo {
        public function getDatos($datos_in){
            if (isset($datos_in['usuario']) && isset($datos_in['contrasenya'])) {
                $usuario = $datos_in['usuario'];
                $password = $datos_in['contrasenya'];
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
                session_start();
                $_SESSION['user'] = $client[0];
                return $client[0];
            } else {
                return null;
            }
        }
    }
?>