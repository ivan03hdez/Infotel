<?php

// Find a randomDate between $start_date and $end_date
function randomDate($start_date, $end_date)
{
    // Convert to timetamps
    $min = strtotime($start_date);
    $max = strtotime($end_date);

    // Generate random number using above bounds
    $val = rand($min, $max);

    // Convert back to desired date format
    return date('Y-m-d H:i:s', $val);
}

#Cantidad de datos a generar
$CANTIDAD_SEEDS=150000;

#Total de datos 
$TOTAL_OFERTAS=15;
$TOTAL_SERVICIOS=10000;
$TOTAL_RESERVAS=50000;
$TOTAL_EMPLEADOS=20000;

$MAX_AMOUNT_OF_REGISTERS = 75000;

ini_set('memory_limit', '2G');

$ficheroTemporal=tempnam(sys_get_temp_dir(), "Reservahist_");
echo "El fichero temporal es $ficheroTemporal";
$fout=fopen($ficheroTemporal,'w');


$id = 1;
$coma = ',';
for ($i = 1; $i <= $CANTIDAD_SEEDS/$MAX_AMOUNT_OF_REGISTERS; $i++) {
    fwrite($fout, "INSERT INTO reservaServicio values ");
    for ($j = 1; $j <= $MAX_AMOUNT_OF_REGISTERS; $j++) {
        #Genera datos aleatorios
        $servicio=rand(1, $TOTAL_SERVICIOS);
        $reserva=rand(1, $TOTAL_RESERVAS);
        $empleado=rand(1, $TOTAL_EMPLEADOS);
        $v_startdate="get_startdate(".strval($reserva).")";
        # $v_enddate="get_enddate(".strval($reserva).")";
        $fecha = $v_startdate;# randomDate($v_startdate, $v_enddate);
        $precio= 0.0; #"get_precioServicio(".strval($servicio).",".strval($fecha).")";
        $oferta=rand(1, $TOTAL_OFERTAS);

        $clienteInsertStatement = $j == $MAX_AMOUNT_OF_REGISTERS
            ? "('', $servicio, $reserva, $empleado, $precio, $oferta)"
            : "('', $servicio, $reserva, $empleado, $precio, $oferta)".$coma;
        
        $id++;
        fwrite($fout, "$clienteInsertStatement");
        if($id % 100 == 0){
            gc_collect_cycles();
        }
    }

    fwrite($fout, ";\n");
}
fclose($fout);
?>