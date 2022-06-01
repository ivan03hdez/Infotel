<?php
    class LoginModelo {
        public function getDatos($datos_in){
            if (isset($datos_in['usuario']) && isset($datos_in['password'])) {
                $usuario = $datos_in['usuario'];
                $password = $datos_in['password'];
                try {
                    $query = DatabaseConnection::query('select * from cliente where email = "'.$usuario.'" and password = "'.$password.'"');
                } catch (Exception $e) {
                    echo $e->getMessage();
                    exit();
                }
    
                $client = array();
    
                while($row = mysqli_fetch_array($query)) 
                {
                    $client[] = $row;
                }
                return $client;
            } else {
                return false;
            }
        }
    }
?>