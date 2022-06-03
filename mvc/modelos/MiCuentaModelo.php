<?php
    class MiCuentaModelo {
        public function getDatos($datos_in){
                if (isset($datos_in['direccion'])) {
                    $direccion = $datos_in['direccion'];
                    try {
                        //Consulta a partir del id de la dirección de un usuario
                        $query = DatabaseConnection::query('select * from direccion where id = "'.$direccion.'"');
                    } catch (Exception $e) {
                        echo $e->getMessage();
                        exit();
                    }
    
                $dire = array();
    
                while($row = mysqli_fetch_array($query)) 
                {
                    $dire[] = $row;
                }
                session_start();
                $_SESSION['direccion'] = count($dire) > 0 ? $dire[0] : null;
                return $dire[0];
            } else {
                return null;
            }
        }
        }
    
?>