<?php
    class AdminTiposModelo {
        public function getDatos($datos_in){
            #Si no hay datos como parámetros, se muestran los 10 primeros hoteles
            try {
                if(count($datos_in) == 1){
                    $query = DatabaseConnection::query('DELETE FROM tipo where tipo.tipo = \''.$datos_in['tipo'].'\';');
                }
                $query = DatabaseConnection::query('SELECT tipo,descripcion, precioBase, tamanyo, nPers FROM tipo');
            } catch (Exception $e) {
                echo $e->getMessage();
                exit();
            }

            $tipos = array();

            while($row = mysqli_fetch_array($query)) 
            {
                $tipos[] = $row;
            }
            return $tipos;
        }
    }
?>