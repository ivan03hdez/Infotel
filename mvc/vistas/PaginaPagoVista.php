<?php
    require_once "plantillas/PlantillaHtmlVista.php";
    require_once "MenuPrincipalVista.php";

    class PaginaPagoVista extends PlantillaHtmlVista {
        public function render($datos_in){
            $datos = [
                'tituloPagina' => 'Pagina de Pago'
            ];
            $mainMenu = MenuPrincipalVista::getMainMenu($datos);
            $this->bodyPagina = <<<HTML
                $mainMenu
            HTML;
            $this->tituloPagina = "Pagina de Pago";

            echo parent::render(NULL);
        }
    }
?>