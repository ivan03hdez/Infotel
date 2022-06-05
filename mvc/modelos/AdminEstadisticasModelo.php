<?php
    class AdminEstadisticasModelo {
        public function getDatos($datos_in){
            
            try {
                $query = DatabaseConnection::query("# Calculating disk space usage per MySQL Table 
                SELECT 
                    ENGINE AS 'Engine',
                    TABLE_SCHEMA AS 'Database',
                    TABLE_NAME AS 'Name', 
                    (data_length+index_length)/power(1024,2) Size, 
                    TABLE_ROWS AS 'Rows', 
                    DATA_FREE/power(1024,2) AS 'Free space', 
                    CREATE_TIME AS 'Creation time', 
                    TABLE_COLLATION AS 'Collation'
                FROM 
                    information_schema.tables
                WHERE 
                    table_schema='gi_infotel' AND table_type = 'BASE TABLE'
                ORDER BY TABLE_NAME; ");
            } catch (Exception $e) {
                echo $e->getMessage();
                exit();
            }
    
            $bbdd_info = array();
    
            while($row = mysqli_fetch_array($query)) 
            {
                $bbdd_info[] = $row;
            }
    
            #$salida=["datoX"=>"ValorX", "datosY"=>"ValorY", "datosZ"=>"ValorZ"];
            return $bbdd_info;
            
        }
    }
?>