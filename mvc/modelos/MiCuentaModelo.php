<?php
    class MiCuentaModelo {
        public function getDatos($datos_in){
                    try {
                        session_start();
                        if (!isSet($_SESSION['user'])) {
                            return header("Location: login");
                        }
                        $user = $_SESSION['user'];
                        //Consulta a partir del id de la dirección de un usuario
                        $query = DatabaseConnection::query('select * from direccion where id = "'."{$user["idDireccion"]}".'"');
                        // $query->query("SET NAMES 'utf8'");
                    } catch (Exception $e) {
                        echo $e->getMessage();
                        exit();
                    }
    
                $dire = array();
    
                while($row = mysqli_fetch_array($query)) 
                {
                    $dire[] = $row;
                }

                $isQueryOk = count($dire) > 0;
                if ($isQueryOk) {
                    //session_start();
                    $direccion = $dire[0];
                    $_SESSION['direccion'] = $direccion;
                    return $direccion;
                }

                return false;
        }
        }
    
?>