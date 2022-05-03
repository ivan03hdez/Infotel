<?php
    require_once "plantillas//PlantillaHtmlVista.php";

    class LoginVista extends PlantillaHtmlVista {
        public function render($datos_in){
            $this->bodyPagina = <<<HTML

            HTML;
            $this->tituloPagina = "Login";

            echo parent::render(NULL);
        }
    }
?>