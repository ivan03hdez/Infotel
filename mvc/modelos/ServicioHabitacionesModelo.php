<?php
    class ServicioHabitacionesModelo {
       // Con esta saco el precio de las habitaciones
    public function getDatos($datos_in){
        if (isset($datos_in['reservaCodigo']) && isset($datos_in['idCliente'])) {
            $codReserva = $datos_in['reservaCodigo'];
            $idCliente = $datos_in['idCliente'];
            try {
                $queryhoteles = DatabaseConnection::query('
                    select rh.precio, h.numero, t.descripcion
                    from reservaHist rh, habitacion h, tipo t
                    where t.id = h.idTipo AND rh.idCliente = '.$idCliente.' AND rh.idHabitacion = h.id AND rh.CodReserva = "'.$codReserva.'"');
               
            } catch (Exception $e) {
                echo $e->getMessage();
                exit();
            }
            try {
                $queryservicios = DatabaseConnection::query('
                    select rs.precio, s.nombre
                    from reservaServicio rs, servicio s
                    where s.id = rs.idServicio AND rs.CodReserva = "'.$codReserva.'"');
            } catch (Exception $e) {
                echo $e->getMessage();
                exit();
            }
          
            $hoteles = array();
            $servicios= array();

        while($row = mysqli_fetch_array($queryhoteles)) 
        {
            $hoteles[] = $row;
        }
        
        while($rowser = mysqli_fetch_array($queryservicios)) 
        {
           
            $servicios[] = $rowser;
        }
        return ['hoteles' => $hoteles, 'servicios' => $servicios];

    }
    }
    }
?>