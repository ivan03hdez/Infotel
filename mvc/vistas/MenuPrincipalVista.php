<?php
    require_once "plantillas//PlantillaHtmlVista.php";

    class MenuPrincipalVista extends PlantillaHtmlVista {
        function render($datos_in){
            $this->bodyPagina = <<<HTML
            <H1>Datos de Salida</H1>
            <table class="table table-bordered">
                <tr><td>DATO</td><td>VALOR</td></tr>
                <tr><td>datoX</td><td>4</td></tr>
            </table>
            HTML;

            echo parent::render(NULL);
        }
    }
?>