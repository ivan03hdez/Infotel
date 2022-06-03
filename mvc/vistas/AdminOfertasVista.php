<?php
    require_once "plantillas/PlantillaHtmlVista.php";
    require_once "plantillas/MenuPrincipalVista.php";

    class AdminOfertasVista extends PlantillaHtmlVista {
        public function render($datos_in){
            if(!isAdminUser()){
                return header("Location: login");
            }

            $datos = [
                'tituloPagina' => 'Administrador'
            ];
            $mainMenu = MenuPrincipalVista::getMainMenu($datos);
            $this->bodyPagina = <<<HTML
                $mainMenu
            HTML;
            $this->tituloPagina = "Ofertas Administrador";

            echo parent::render(NULL);
        }
    }
?>