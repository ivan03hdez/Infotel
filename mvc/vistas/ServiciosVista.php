<?php
    require_once "plantillas/PlantillaHtmlVista.php";
    require_once "plantillas/MenuPrincipalVista.php";

    class ServiciosVista extends PlantillaHtmlVista {
        public function render($datos_in){
            /*session_start();
            $user = $_SESSION['user'];*/
            $datos = [
                'tituloPagina' => 'Servicios'
            ];
            $mainMenu = MenuPrincipalVista::getMainMenu($datos);
            $this->bodyPagina = <<<HTML
                $mainMenu
            HTML;
            $this->tituloPagina = "Servicios";

            echo parent::render(NULL);
        }
    }
?>