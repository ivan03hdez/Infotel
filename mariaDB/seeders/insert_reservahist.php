<?php

function generateStatus()
{
    $status = "Activa";
    $seed = mt_rand(1,50);
    if ($seed == 1){$status="Inactiva";}
    return $status;
}

function generatePagada()
{
    $pagada = TRUE;
    $seed = mt_rand(1,3);
    if ($seed == 1){$pagada = FALSE;}
    return $pagada;
}


#Cantidad de datos a generar
$CANTIDAD_SEEDS=75000;

#Total de datos 
$TOTAL_OFERTAS=10;
$TOTAL_HABITACIONES=40000;
$TOTAL_RESERVAS=50000;
$TOTAL_CLIENTES=1000000;

$MAX_AMOUNT_OF_REGISTERS = 75000;

ini_set('memory_limit', '2G');

$ficheroTemporal=tempnam(sys_get_temp_dir(), "Reservahist_");
echo "El fichero temporal es $ficheroTemporal";
$fout=fopen($ficheroTemporal,'w');


$id = 75003;
$coma = ',';
for ($i = 1; $i <= $CANTIDAD_SEEDS/$MAX_AMOUNT_OF_REGISTERS; $i++) {
    fwrite($fout, "INSERT INTO reservaHist values ");
    for ($j = 1; $j <= $MAX_AMOUNT_OF_REGISTERS; $j++) {
        #Genera datos aleatorios
        # $status=generateStatus();
        # $pagada=generateStatus();
        $status = rand(0,1);
        $pagada = rand(0,1);
        $nPersonas=rand(1,4);
        $oferta=rand(1, $TOTAL_OFERTAS);
        # $codOferta="get_codigo(".strval($oferta).")";
        $reserva=rand(1, $TOTAL_RESERVAS);
        $cliente=rand(1, $TOTAL_CLIENTES);
        $habitacion=rand(1, $TOTAL_HABITACIONES);
        # $v_startdate="get_startdate(".strval($reserva).")";
        #$v_startdate = trim($v_startdate, "");
        $precio= 0.0; # "get_precioHabitacion(".strval($habitacion).",".strval($v_startdate).",".strval($codOferta).")";

        $clienteInsertStatement = $j == $MAX_AMOUNT_OF_REGISTERS
            ? "($id, $reserva, $oferta, $cliente, $habitacion, $precio, '$status', '$pagada', $nPersonas)"
            : "($id, $reserva, $oferta, $cliente, $habitacion, $precio, '$status', '$pagada', $nPersonas)".$coma;
        
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