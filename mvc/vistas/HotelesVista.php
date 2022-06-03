<?php
    require_once "plantillas/PlantillaHtmlVista.php";
    require_once "plantillas/MenuPrincipalVista.php";

    class HotelesVista extends PlantillaHtmlVista {
        public function render($datos_in){
            /*session_start();
            $user = $_SESSION['user'];*/
            $datos = [
                'tituloPagina' => 'Hoteles'
            ];
            $this->tituloPagina = "Hoteles";
            $mainMenu = MenuPrincipalVista::getMainMenu($datos);
            $this->bodyPagina = <<<HTML
                $mainMenu
            HTML; 

            echo parent::render(NULL);
        }
    }
?>