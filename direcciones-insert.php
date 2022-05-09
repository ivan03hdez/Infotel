<?php
# Load Fakers own autoloader
require_once 'C:/Users/dani/vendor/autoload.php';

#Inicializa
$faker = Faker\Factory::create('es_ES');

#Cantidad de datos a generar
$CANTIDAD=100000;

$ficheroTemporal=tempnam(sys_get_temp_dir(), "Usuarios_");
echo "El fichero temporal es $ficheroTemporal";
$fout=fopen($ficheroTemporal,'w');

$letras = ["T", "R", "W", "A", "G", "M", "Y", "F", "P", "D", "X", "B", "N", "J", "Z", "S", "Q", "V", "H", "L", "C", "K", "E"];
$MAX_AMOUNT_OF_REGISTERS = 100000;
$count = 0;
$coma = ',';
$direccionInsertStatement = "INSERT INTO direccion values ";
for ($i = 1; $i <= $CANTIDAD; $i++) {
     #Genera datos aleatorios
     $direccion=addslashes($faker->streetAddress);
     $cpostal=$faker->postcode;
     $ciudad=addslashes($faker->city);
     $pais=addslashes($faker->country);

    if ($count > $MAX_AMOUNT_OF_REGISTERS) {
        $direccionInsertStatement = "INSERT INTO direccion values ";
	    $count = 0;
    } else {
        if($count == $MAX_AMOUNT_OF_REGISTERS) {
            $direccionInsertStatement += "($i, '$direccion','$cpostal','$ciudad','$pais')";
        } else {
            $direccionInsertStatement += "($i, '$direccion','$cpostal','$ciudad','$pais')".$coma;
        }
    }

    $direccionInsert = substr($direccionInsertStatement, 0, $MAX_AMOUNT_OF_REGISTERS);
     #Crea los insert para luego insertarlos en la base de datos
    fwrite($fout, "$direccionInsert;\n");
    $count++;
}
    fclose($fout);
?>