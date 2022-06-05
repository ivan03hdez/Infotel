<?php
    class ServicioHabitacionesModelo {
       // Con esta saco el precio de las habitaciones
    public function getDatos($datos_in){
        if (isset($datos_in['reservaCodigo'])) {
            $codReserva = $datos_in['reservaCodigo'];
            $codReserva = 3;
            try {
                $queryhoteles = DatabaseConnection::query('select rh.precio, h.numero from reservaHist rh, reserva r, habitacion h where r.Codigo = rh.CodReserva AND rh.idHabitacion = h.id AND rh.CodReserva = "'.$codReserva.'"');
               
            } catch (Exception $e) {
                echo $e->getMessage();
                exit();
            }
            try {
                $queryservicios = DatabaseConnection::query('select rs.precio, s.nombre from reserva r, reservaServicio rs, servicio s where r.Codigo = rs.CodReserva AND s.id = rs.idServicio AND rs.CodReserva = "'.$codReserva.'"');
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