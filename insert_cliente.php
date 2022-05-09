<?php

function generatePassword($length)
{
    $key = "";
    $pattern = "1234567890abcdefghijklmnopqrstuvwxyz#.?!";
    $max = strlen($pattern)-1;
    for($i = 0; $i < $length; $i++){
        $key .= substr($pattern, mt_rand(0,$max), 1);
    }
    return $key;
}

# Load Fakers own autoloader
require_once 'C:/Users/Dani/vendor/autoload.php';

#Inicializa
$faker = Faker\Factory::create('es_ES');

#Cantidad de datos a generar
$CANTIDAD=1000000;

$ficheroTemporal=tempnam(sys_get_temp_dir(), "Usuarios_");
echo "El fichero temporal es $ficheroTemporal";
$fout=fopen($ficheroTemporal,'w');

$letras = ["T", "R", "W", "A", "G", "M", "Y", "F", "P", "D", "X", "B", "N", "J", "Z", "S", "Q", "V", "H", "L", "C", "K", "E"];
$MAX_AMOUNT_OF_REGISTERS = 100000;
$count = 0;
$coma = ',';
for ($i = 1; $i <= $CANTIDAD; $i++) {
    if ($count > $MAX_AMOUNT_OF_REGISTERS) {
        $clienteInsertStatement = "INSERT INTO cliente values ";
	    $count = 0;
    } else {
        if($count == $MAX_AMOUNT_OF_REGISTERS) {
	        $clienteInsertStatement += "($i, '$nombre', '$apellidos', '$password', '$dni', '$correo', '$telefono', '$fecha', '$pais', '$vacunado', $i)";
        } else {
	        $clienteInsertStatement += "($i, '$nombre', '$apellidos', '$password', '$dni', '$correo', '$telefono', '$fecha', '$pais', '$vacunado', $i)".$coma;
        }
    }

    #Genera datos aleatorios
    $nombre=addslashes($faker->name);
    $apellidos=addslashes($faker->lastName);
    $direccion=addslashes($faker->streetAddress);
    $cpostal=$faker->postcode;
    $ciudad=addslashes($faker->city);
    $password=generatePassword(8);
    $telefono=addslashes($faker->phoneNumber);
    $fecha=date("Y-m-d", mt_rand(0, 500000000));
    $pais=addslashes($faker->country);

    $n_dni = $faker->unique()->randomNumber($nbDigits = 8);
    $letra_dni = $letras[$n_dni%23];
    $dni = addslashes(strval($n_dni).$letra_dni);

    $gmail= "@gmail.com";
    $correo= addslashes(str_replace(' ', '', strval($nombre.$faker->randomNumber($nbDigits = 5))).$gmail);

    $vacunado= mt_rand(0,1);

    $cliente = substr($clienteInsertStatement, 0, $MAX_AMOUNT_OF_REGISTERS);

    #Crea los insert para luego insertarlos en la base de datos
    fwrite($fout, "$cliente;\n");
    $count++;
}
fclose($fout);
?>