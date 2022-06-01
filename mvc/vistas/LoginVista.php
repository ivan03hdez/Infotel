<?php
    require_once "plantillas/PlantillaHtmlVista.php";
	require_once "plantillas/MenuPrincipalVista.php";

    class LoginVista extends PlantillaHtmlVista {
        public function render($datos_in){
            $datos = [
                'tituloPagina' => 'Login'
            ];
            $this->tituloPagina = "Login";
            $mainMenu = MenuPrincipalVista::getMainMenu($datos);
            $this->bodyPagina = <<<HTML
                $mainMenu
            HTML; 

            echo parent::render(NULL);
        }
    }
?>