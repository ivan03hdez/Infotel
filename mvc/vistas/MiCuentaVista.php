<?php
    require_once "plantillas/PlantillaHtmlVista.php";
    require_once "plantillas/MenuPrincipalVista.php";

    class MiCuentaVista extends PlantillaHtmlVista {
        public function render($datos_in){
            session_start();
            if (!isSet($_SESSION['user'])) {
                return header("Location: login");
            }

            $user = $_SESSION['user'];
            $datos = [
                'tituloPagina' => 'Mi Cuenta'
            ];
            $mainMenu = MenuPrincipalVista::getMainMenu($datos);
            $this->bodyPagina = <<<HTML
                $mainMenu
                <table>
                    <tr><td>Correo Electrónico</td><td>Fecha de nacimiento</td></tr>
                    <tr><td>{$user["email"]}</td><td>{$user["fechaNac"]}</td></tr>
                    <tr><td>NIF</td><td>Nacionalidad</td></tr>
                    <tr><td>{$user["nif"]}</td><td>{$user["nacionalidad"]}</td></tr>
                    <tr><td>Dirección</td><td>Municipio</td></tr>
                    <tr><td>{$user["idDireccion"]}</td><td>{$user["fechaNac"]}</td></tr>
                    <tr><td>Provincia</td><td>Código postal</td></tr>
                </table>
            HTML;
            $this->tituloPagina = "Mi Cuenta";

            echo parent::render(NULL);
        }
    }
?>