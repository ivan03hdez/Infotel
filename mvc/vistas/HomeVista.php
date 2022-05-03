<?php
    require_once "plantillas//PlantillaHtmlVista.php";
    require_once "MenuPrincipalVista.php";

    class HomeVista extends PlantillaHtmlVista {
        public function render($datos_in){
            $datos = [
                'tituloPagina' => 'Bienvenido a Infotel'
            ];
            $mainMenu = MenuPrincipalVista::getMainMenu($datos);
            $this->bodyPagina = <<<HTML
                $mainMenu
            HTML;
            $this->tituloPagina = "Inicio";

            echo parent::render(NULL);
        }
    }
?>