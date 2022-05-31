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
require_once 'vendor/autoload.php';

#Inicializa
$faker = Faker\Factory::create('es_ES');

#Cantidad de datos a generar
$CANTIDAD_SEEDS=300000;

ini_set('memory_limit', '2G');

$ficheroTemporal=tempnam(sys_get_temp_dir(), "Usuarios_");
echo "El fichero temporal es $ficheroTemporal";
$fout=fopen($ficheroTemporal,'w');

$letras = ["T", "R", "W", "A", "G", "M", "Y", "F", "P", "D", "X", "B", "N", "J", "Z", "S", "Q", "V", "H", "L", "C", "K", "E"];
$MAX_AMOUNT_OF_REGISTERS = 100000;
$id = 1;
$coma = ',';
for ($i = 1; $i <= $CANTIDAD_SEEDS/$MAX_AMOUNT_OF_REGISTERS; $i++) {
    fwrite($fout, "INSERT INTO cliente values ");
    for ($j = 1; $j <= $MAX_AMOUNT_OF_REGISTERS; $j++) {
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
        $serial = 700000 + $id;
        $clienteInsertStatement = $j == $MAX_AMOUNT_OF_REGISTERS
            ? "($serial, '$nombre', '$apellidos', '$password', '$dni', '$correo', '$telefono', '$fecha', '$pais', '$vacunado', $serial)"
            : "($serial, '$nombre', '$apellidos', '$password', '$dni', '$correo', '$telefono', '$fecha', '$pais', '$vacunado', $serial)".$coma;
        
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