<?php
# Load Fakers own autoloader
require_once 'vendor/autoload.php';

#Inicializa
$faker = Faker\Factory::create('es_ES');

#Cantidad de datos a generar
$CANTIDAD_SEEDS=40000;

$ficheroTemporal=tempnam(sys_get_temp_dir(), "Usuarios_");
echo "El fichero temporal es $ficheroTemporal\n";
$fout=fopen($ficheroTemporal,'w');

$coma = ',';
$id = 1;
for ($i = 1; $i <= 1; $i++) {
    fwrite($fout, "INSERT INTO hotel values ");
    for ($j = 1; $j <= $CANTIDAD_SEEDS; $j++) {
        # Genera datos aleatorios
        $ciudad = addslashes($faker->city);
        $nombre = addslashes($faker->name);
        $estrellas = mt_rand(1,5);
        $imagenCiudadUrl = $faker->imageUrl(640, 480, $ciudad, true);
        $imagenCiudadBLOB = base64_encode($imagenCiudadUrl);
        
        $hotelesInsertStatement = $j == $CANTIDAD_SEEDS
            ? "($id, $id, '$nombre', $estrellas, '$imagenCiudadBLOB')"
            : "($id, $id, '$nombre', $estrellas, '$imagenCiudadBLOB')".$coma;
            
        $id++;

        fwrite($fout, "$hotelesInsertStatement");
    }
    
    fwrite($fout, ";\n");
}
    fclose($fout);
?>