<?php
    require_once "plantillas//PlantillaHtmlVista.php";
    require_once "MenuPrincipalVista.php";

    class HomeVista extends PlantillaHtmlVista {
        public function render($datos_in){
            $mainMenu = MenuPrincipalVista::getMainMenu($datos_in);
            $this->bodyPagina = <<<HTML
                $mainMenu
            HTML; 
            $this->tituloPagina = "Home";

            echo parent::render(NULL);
        }
    }
?>