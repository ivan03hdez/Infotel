<?php
    require_once "plantillas/PlantillaHtmlVista.php";
    require_once "plantillas/MenuPrincipalVista.php";

    class ServiciosVista extends PlantillaHtmlVista {
        public function render($datos_in){
            $datos = [
                'tituloPagina' => 'Servicios'
            ];
            $this->tituloPagina = "Servicios";

            $mainMenu = MenuPrincipalVista::getMainMenu($datos);

            # $mapa = ServiciosVista::generarHTMLmapa($paises);
            
            // OBTENER TODOS LOS SERVICIOS DISTINTOS DE LA BBDD 
            try {
                $query = DatabaseConnection::query("select nombre, descripcion, COUNT(*) AS 'Hoteles', ROUND(AVG(precio),2) AS 'Precio medio' from servicio GROUP BY nombre, descripcion;");
                # $tailandes_query = DatabaseConnection::query("SELECT COUNT(*) AS 'Hoteles', AVG(precio) AS 'Precio medio' FROM servicio WHERE nombre = 'Masaje tailandés';");
            } catch (Exception $e) {
                echo $e->getMessage();
                exit();
            }
            # $tailandes = mysqli_fetch_array($tailandes_query );
            # print_r($tailandes);
            $servicios_generales = array();
            $servicios_especificos = array();
        
            while($row = mysqli_fetch_array($query)) 
            {
                if($row[0] == 'Pensión completa' or $row[0] == 'Media pensión' or $row[0] == 'Desayuno incluido')
                {
                    $servicios_generales[] = $row;
                } else {
                    $servicios_especificos[] = $row;
                }
                
            }


            # $paises = ServiciosVista::generarHTMLselectorpaises($datos_in);
            $servicios_generales = ServiciosVista::generarHTMLtiposservicios($servicios_generales);
            $servicios_especificos = ServiciosVista::generarHTMLtiposservicios($servicios_especificos);
            $this->bodyPagina = <<<HTML
                $mainMenu
                <div>
                    <section>
                        <div class="container">
                        <!-- <select name="country_select" class="country_select">
                            <option class="" name="" value="" >-- País --</option> 
                            $paises
                        </select> -->
                            <h2><b>Servicios generales</b></h2>
                            <p>A continuación se listan todos los servicios que están disponibles para todos los hoteles de la cadena Infotel.</p>
                            $servicios_generales
                            <br>
                            <br>
                            <br>
                            <h2><b>Servicios específicos del hotel</b></h2>
                            <p>A continuación se listan los servicios que no están disponibles en todos los hoteles. Para más información sobre estos servicios contacte con el hotel en cuestión.</p>
                            $servicios_especificos
                        </div>
                    </section>
                </div>
            HTML; 

            echo parent::render(NULL);
        }

        public function generarHTMLtiposservicios($datos_in){
            $codHTML = "";
            //print_r($datos_in);
            foreach($datos_in as $row){
                if($row[2] == 1000)
                {
                    $row[2] = "todos nuestros";
                }
                //echo($row);
                $codHTML .= <<< HTML
                    <html>
                    <head>
                        <style>
                            :root{
                            --card-color: #14274A;
                            --card-header-color: crimson;
                            --card-body-color: #14274A;
                            --card-footer-color: indigo;
                            }
                            .card{
                                margin: 0 auto;
                                background: var(--card-color);
                                color:rgb(255, 255, 255);
                                width: 600px;
                                padding: 20px;
                                box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.377);
                                border-radius: 20px;            
                            }
                            .card-header{
                                background: var(--card-header-color);            
                                margin: -20px;
                                padding: 20px;
                                border-radius: 20px 20px 0px 0px;
                            }
                            .card-body{
                                background: var(--card-body-color);
                                margin: -20px;
                                padding: 20px;
                                border-radius: 00px 00px 20px 20px;
                            }
                            .card-footer{
                                background: var(--card-footer-color);
                                margin: -20px;
                                padding: 20px;
                                border-radius: 00px 00px 20px 20px;
                                display: flex;
                                justify-content: space-between
                            }
                            a{
                                padding: 8px;
                                margin: 2px;
                                border-radius: 5px;
                                border: 1px solid white;
                                width: 100%;
                                text-align: center;
                                color: white;
                                text-decoration: none;
                            }
                            a:hover{
                                color: var(--card-body-color);
                                background:white;
                            }
                        </style>
                    </head>

                    <body>
                        <!--this is the div that will hold the pie chart-->
                        <div class="card" style="margin-top:20px;">
                            <h2><b>$row[0]</b></h2>
                            <br>
                            <p><b>Descripción:</b>"<i>$row[1].</i>"</p>
                            <p><b>Precio medio:</b> $row[3] €</p>
                            <p>Disponible en $row[2] hoteles alrededor del mundo.</p>
                        </div>
                    </body>
                    </html>

                HTML; 
            }
            
            return $codHTML;
        }

        
        /*public function generarHTMLselectorpaises($datos_in){
            $codHTML = "";
            foreach($datos_in as $row) { 
            # print_r($datos_in);
            $country = $row[0];
            # echo($country);
            $codHTML .= <<< HTML
                <option class='' name='' value='$country' > $country </option>"; 
            HTML; 
            }
            
            return $codHTML;
        }

        public function generarHTMLmapa($datos_in){
            $codHTML = "";
            
            $codHTML .= <<< HTML
                <html>
                <head>
                <script type="text/javascript" src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCe30oLPh7uH3vWngw96bjZ0HLPq51Byf8'></script>
                <script>
                    google.charts.load('current', {
                    'packages': ['map'],
                    // Note: you will need to get a mapsApiKey for your project.
                    // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
                    'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
                    
                    });
                    google.charts.setOnLoadCallback(drawMap);

                    function drawMap() {
                    var data = google.visualization.arrayToDataTable([
                        ['Country', 'Population'],
                        ['China', 'China: 1,363,800,000'],
                        ['India', 'India: 1,242,620,000'],
                        ['US', 'US: 317,842,000'],
                        ['Indonesia', 'Indonesia: 247,424,598'],
                        ['Brazil', 'Brazil: 201,032,714'],
                        ['Pakistan', 'Pakistan: 186,134,000'],
                        ['Nigeria', 'Nigeria: 173,615,000'],
                        ['Bangladesh', 'Bangladesh: 152,518,015'],
                        ['Russia', 'Russia: 146,019,512'],
                        ['Japan', 'Japan: 127,120,000']
                    ]);

                    var options = {
                    showTooltip: true,
                    showInfoWindow: true
                    };

                    var map = new google.visualization.Map(document.getElementById('chart_div'));

                    map.draw(data, options);
                };
                </script>
                </head>
                <body>
                    <div id="chart_div"></div>
                </body>
                </html>
            HTML; 
            
            return $codHTML;
        }*/
    }
?>