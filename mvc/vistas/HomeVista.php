<?php
    require_once "plantillas/PlantillaHtmlVista.php";
    require_once "MenuPrincipalVista.php";

    class HomeVista extends PlantillaHtmlVista {
        public function render($datos_in){
            $datos = [
                'tituloPagina' => 'Bienvenido a Infotel'
            ];
            $row = mb_convert_encoding($datos_in[11]['nombre'], "UTF-8");
            $row = $datos_in[11]['nombre'];
            $mainMenu = MenuPrincipalVista::getMainMenu($datos);
            $this->bodyPagina = <<<HTML
                $mainMenu
                $row
            HTML;
            $this->tituloPagina = "Inicio";

            echo parent::render(NULL);
        }
    }
?>