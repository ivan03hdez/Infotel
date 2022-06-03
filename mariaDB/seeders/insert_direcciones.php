<?php
# Load Fakers own autoloader
require_once 'vendor/autoload.php';

#Inicializa
$faker = Faker\Factory::create('es_ES');

#Cantidad de datos a generar
$CANTIDAD_SEEDS=1000000;

$ficheroTemporal=tempnam(sys_get_temp_dir(), "Usuarios_");
echo "El fichero temporal es $ficheroTemporal\n";
$fout=fopen($ficheroTemporal,'w');

$MAX_AMOUNT_OF_REGISTERS = 100000;
$coma = ',';
$id = 1;
for ($i = 1; $i <= $CANTIDAD_SEEDS/$MAX_AMOUNT_OF_REGISTERS; $i++) {
    fwrite($fout, "INSERT INTO direccion values ");
    for ($j = 1; $j <= $MAX_AMOUNT_OF_REGISTERS; $j++) {
         #Genera datos aleatorios
        $direccion=addslashes($faker->streetAddress);
        $cpostal=$faker->postcode;
        $ciudad=addslashes($faker->city);
        $pais=addslashes($faker->country);

        $direccionInsertStatement = $j == $MAX_AMOUNT_OF_REGISTERS
            ? "($id, '$direccion', '$cpostal', '$ciudad', '$pais')"
            : "($id, '$direccion', '$cpostal', '$ciudad', '$pais')".$coma;
            
        $id++;

        fwrite($fout, "$direccionInsertStatement");
    }
    
    fwrite($fout, ";\n");
}
    fclose($fout);
?>