<?php
    require_once "plantillas/PlantillaHtmlVista.php";
    require_once "MenuPrincipalVista.php";

    class MiCuentaVista extends PlantillaHtmlVista {
        public function render($datos_in){
            $datos = [
                'tituloPagina' => 'Mi Cuenta'
            ];
            $mainMenu = MenuPrincipalVista::getMainMenu($datos);
            $this->bodyPagina = <<<HTML
                $mainMenu
                
                <table>
                <tr><td>Correo Electrónico</td><td>Fecha de nacimiento</td></tr>
                <tr><td>${datos_in["email"]}</td><td>${datos_in["fechaNac"]}</td></tr>
                <tr><td>NIF</td><td>Nacionalidad</td></tr>
                <tr><td>${datos_in["nif"]}</td><td>${datos_in["nacionalidad"]}</td></tr>
                <tr><td>Dirección</td><td>Municipio</td></tr>
                <tr><td>${datos_in["idDireccion"]}</td><td>${datos_in["fechaNac"]}</td></tr>
                <tr><td>Provincia</td><td>Código postal</td></tr>
                </table>

            HTML;
            $this->tituloPagina = "Mi Cuenta";

            echo parent::render(NULL);
        }
    }
?>