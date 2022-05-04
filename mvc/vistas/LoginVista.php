<?php
    require_once "plantillas/PlantillaHtmlVista.php";

    class LoginVista extends PlantillaHtmlVista {
        public function render($datos_in){
            $this->tituloPagina = "Login";
            $this->bodyPagina = <<<HTML
                <h1>AUN FALTA POR HACER</h1>
            HTML;

            echo parent::render(NULL);
        }
    }
?>