<?php
    require_once "plantillas/PlantillaHtmlVista.php";
    require_once "plantillas/MenuPrincipalVista.php";

    class HomeVista extends PlantillaHtmlVista {
        public function render($datos_in){
            /*session_start();
            $user = $_SESSION['user'];*/

            $datos = [
                'tituloPagina' => 'Bienvenido a Infotel'
            ];
            $mainMenu = MenuPrincipalVista::getMainMenu($datos);

            // mb_convert_encoding(data, "UTF-8") convierte texto a UTF-8;
            $this->bodyPagina = <<<HTML
                $mainMenu
            HTML;
            $this->tituloPagina = "Inicio";

            echo parent::render(NULL);
        }
    }
?>