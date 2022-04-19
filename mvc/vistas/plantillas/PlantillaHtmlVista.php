<?php
    class PlantillaHtmlVista {
        protected $codigoHtml = NULL;
        protected $plantilla = <<<HTML
            <HTML>
                <HEAD>
                    <meta charset="utf-8"/>
                    <meta name="viewport" content="width=device-width, initial-scale=1"/>
                    <!-- own CSS styles -->
                    <link rel="stylesheet/less" type="text/css" href="styles/styles.less" />
                    <!-- Bootstrap CSS -->
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"/>
                </HEAD>
                <BODY class=infotel>
        HTML;

        function render($datos_in){
            $cuerpoPagina = isset($this->codigoHtml) ? $this->codigoHtml : '';
            $salida = <<<HTML
                    $this->plantilla
                    $cuerpoPagina
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
                    <script src="https://cdn.jsdelivr.net/npm/less@4" ></script>
                </BODY>
            </HTML>
            HTML;

            echo $salida;
        }
    }
?>