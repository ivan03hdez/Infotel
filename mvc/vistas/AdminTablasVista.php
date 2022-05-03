<?php
    require_once "plantillas//PlantillaHtmlVista.php";
    require_once "MenuPrincipalVista.php";

    class AdminTablasVista extends PlantillaHtmlVista {
        public function render($datos_in){
            $datos = [
                'tituloPagina' => 'Administrador'
            ];
            $mainMenu = MenuPrincipalVista::getMainMenu($datos);
            $this->bodyPagina = <<<HTML
                $mainMenu
            HTML;
            $this->tituloPagina = "Tablas Administrador";

            echo parent::render(NULL);
        }
    }
?>