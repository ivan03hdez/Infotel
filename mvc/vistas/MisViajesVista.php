<?php
    require_once "plantillas/PlantillaHtmlVista.php";
    require_once "plantillas/MenuPrincipalVista.php";

    class MisViajesVista extends PlantillaHtmlVista {
        public function render($datos_in) {
            /*session_start(); 
            $user = $_SESSION['user'];*/
            $datos = [
                'tituloPagina' => 'Mis Viajes'
            ];
            $mainMenu = MenuPrincipalVista::getMainMenu($datos);
            $this->bodyPagina = <<<HTML
                $mainMenu
            HTML;
            $this->tituloPagina = "Mis Viajes";

            echo parent::render(NULL);
        }
    }
?>