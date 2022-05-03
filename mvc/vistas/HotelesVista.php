<?php
    require_once "plantillas//PlantillaHtmlVista.php";
    require_once "MenuPrincipalVista.php";

    class HotelesVista extends PlantillaHtmlVista {
        public function render($datos_in){
            $mainMenu = MenuPrincipalVista::getMainMenu($datos_in);
            $this->bodyPagina = <<<HTML
                $mainMenu
                <div>CONTENIDO</div
            HTML; 
            $this->tituloPagina = "Inicio";

            echo parent::render(NULL);
        }
    }
?>