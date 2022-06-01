<?php

function generarCodigo($length)
{
    $key = "";
    $pattern = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $max = strlen($pattern)-1;
    for($i = 0; $i < $length; $i++){
        $key .= substr($pattern, mt_rand(0,$max), 1);
    }
    return $key;
}

function fecha_aleatoria($formato = "Y-m-d", $limiteInferior = "2019-01-01", $limiteSuperior = "2024-01-01"){
	// Convertimos la fecha como cadena a milisegundos
	$milisegundosLimiteInferior = strtotime($limiteInferior);
	$milisegundosLimiteSuperior = strtotime($limiteSuperior);

	// Buscamos un número aleatorio entre esas dos fechas
	$milisegundosAleatorios = mt_rand($milisegundosLimiteInferior, $milisegundosLimiteSuperior);

	// Regresamos la fecha con el formato especificado y los milisegundos aleatorios
    return date($formato, $milisegundosAleatorios);
}

# Load Fakers own autoloaders
require_once 'C:\Users\Dani\vendor\autoload.php';

#Inicializa
$faker = Faker\Factory::create('es_ES');

#Cantidad de datos a generar
$CANTIDAD_SEEDS=50000;

ini_set('memory_limit', '2G');

$ficheroTemporal=tempnam(sys_get_temp_dir(), "Usuarios_");
echo "El fichero temporal es $ficheroTemporal";
$fout=fopen($ficheroTemporal,'w');

$letras = ["T", "R", "W", "A", "G", "M", "Y", "F", "P", "D", "X", "B", "N", "J", "Z", "S", "Q", "V", "H", "L", "C", "K", "E"];
$MAX_AMOUNT_OF_REGISTERS = 10000;
$id = 1;
$coma = ',';
for ($i = 1; $i <= $CANTIDAD_SEEDS/$MAX_AMOUNT_OF_REGISTERS; $i++) {
    fwrite($fout, "INSERT INTO reserva values ");
    for ($j = 1; $j <= $MAX_AMOUNT_OF_REGISTERS; $j++) {
        #Genera datos aleatorios
        $codigo=generarCodigo(6);
        $fechaInicio=fecha_aleatoria();
        $fechaFin=fecha_aleatoria("Y-m-d", $fechaInicio, date("Y-m-d", strtotime($fechaInicio."+ ".mt_rand(0,16)." days")));
        $precioTotal= mt_rand(100, 15000);
        #poner fecha inicio y fecha fin con días mt_rand(1-15)

        $reservaInsertStatement = $j == $MAX_AMOUNT_OF_REGISTERS
            ? "($id, '$codigo', '$fechaInicio', '$fechaFin', '$precioTotal')"
            : "($id, '$codigo', '$fechaInicio', '$fechaFin', '$precioTotal')".$coma;
        
        $id++;
        fwrite($fout, "$reservaInsertStatement");
        if($id % 100 == 0){
            gc_collect_cycles();
        }
    }

    fwrite($fout, ";\n");
}
fclose($fout);
?>