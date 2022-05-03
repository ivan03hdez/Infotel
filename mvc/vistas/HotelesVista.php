<?php
    require_once "plantillas//PlantillaHtmlVista.php";
    require_once "MenuPrincipalVista.php";

    class HotelesVista extends PlantillaHtmlVista {
        public function render($datos_in){
            $datos = [
                'tituloPagina' => 'Hoteles'
            ];
            $mainMenu = MenuPrincipalVista::getMainMenu($datos);
            $this->bodyPagina = <<<HTML
                $mainMenu
                <div>CONTENIDO</div>
            HTML; 
            $this->tituloPagina = "Hoteles";

            echo parent::render(NULL);
        }
    }
?>