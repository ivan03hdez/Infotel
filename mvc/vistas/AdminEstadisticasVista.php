<?php
    require_once "plantillas/PlantillaHtmlVista.php";
    require_once "plantillas/MenuPrincipalVista.php";

    class AdminEstadisticasVista extends PlantillaHtmlVista {
        public function render($datos_in){
            if(!isAdminUser()){
                return header("Location: login");
            }

            $datos = [
                'tituloPagina' => 'Cuadro de mandos de mantenimiento'
            ];
            $this->tituloPagina = "Cuadro de mandos de mantenimiento";
            $mainMenu = MenuPrincipalVista::getMainMenu($datos);
            $information = AdminEstadisticasVista::generarHTMLmaintenancedashboard($datos_in);
            $this->bodyPagina = <<<HTML
                $mainMenu
                <div>
                    <section>
                        <div class="container">
                            $information
                        </div>
                    </section>
                </div>
            HTML; 

            echo parent::render(NULL);
            $this->bodyPagina = <<<HTML
                $mainMenu
            HTML;
        }


        public function generarHTMLmaintenancedashboard($datos_in){
            $codHTML = "";
            # $data = array(['Tabla', 'Tamaño']);
            
            $engine = $datos_in[0][0];
            $database = $datos_in[0][1];
            $collation = $datos_in[0][7];
            $total_size = 0;
            foreach($datos_in as $row){
                $total_size = $total_size+$row[3];
            }
            
            ########################### OBTENCIÓN DE DATOS DE TAMAÑO ###########################
            $data = array();
            $data['cols'] = array(

                // Labels for your chart, these represent the column titles
                // Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
                array('label' => 'Tabla', 'type' => 'string'),
                array('label' => 'Tamaño', 'type' => 'number')
            
            );

            $rows = array();
            foreach($datos_in as $row){
                $temp = array();
                // the following line will be used to slice the Pie chart
                $temp[] = array('v' => (string) $row[2]); 

                // Values of each slice
                $temp[] = array('v' => (float) $row[3]); 
                $rows[] = array('c' => $temp);
            }
            $data['rows'] = $rows;
            $jsonTable = json_encode($data);
            //echo $jsonTable;

            ########################### OBTENCIÓN DE DATOS DE REGISTROS ###########################
            $data1 = array();
            $data1['cols'] = array(

                // Labels for your chart, these represent the column titles
                // Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
                array('label' => 'Tabla', 'type' => 'string'),
                array('label' => 'Tamaño', 'type' => 'number')
            
            );

            $rows1 = array();
            foreach($datos_in as $row){
                $temp = array();
                // the following line will be used to slice the Pie chart
                $temp[] = array('v' => (string) $row[2]); 

                // Values of each slice
                $temp[] = array('v' => (float) $row[4]); 
                $rows1[] = array('c' => $temp);
            }
            $data1['rows'] = $rows1;
            $jsonTable1 = json_encode($data1);
            //echo $jsonTable;

            ########################### OBTENCIÓN DE DATOS DE TAMAÑO LIBRE ###########################
            $data2 = array();
            $data2['cols'] = array(

                // Labels for your chart, these represent the column titles
                // Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
                array('label' => 'Tabla', 'type' => 'string'),
                array('label' => 'Tamaño', 'type' => 'number')
            
            );

            $rows2 = array();
            foreach($datos_in as $row){
                $temp = array();
                // the following line will be used to slice the Pie chart
                $temp[] = array('v' => (string) $row[2]); 

                // Values of each slice
                $temp[] = array('v' => (float) $row[5]); 
                $rows2[] = array('c' => $temp);
            }
            $data2['rows'] = $rows2;
            $jsonTable2 = json_encode($data2);
            //echo $jsonTable;
            # print_r($jsonTable);
            $codHTML .= <<< HTML
            <html>
            <head>
                <!--Load the Ajax API-->
                <script type="text/javascript" src="https://www.google.com/jsapi"></script>
                <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
                <script type="text/javascript">

                // Load the Visualization API and the piechart package.
                google.load('visualization', '1', {'packages':['corechart']});

                // Set a callback to run when the Google Visualization API is loaded.
                google.setOnLoadCallback(drawChart);

                function drawChart() {

                // Create our data table out of JSON data loaded from server.
                var data = new google.visualization.DataTable($jsonTable);
                var options = {
                    title: 'Tamaño por tabla (MB)',
                    is3D: 'true',
                    width: 800,
                    height: 600
                    };
                // Instantiate and draw our chart, passing in some options.
                // Do not forget to check your div ID
                var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                chart.draw(data, options);
                }
                </script>
                <script type="text/javascript">

                // Load the Visualization API and the piechart package.
                google.load('visualization', '1', {'packages':['corechart']});

                // Set a callback to run when the Google Visualization API is loaded.
                google.setOnLoadCallback(drawChart);

                function drawChart() {

                // Create our data table out of JSON data loaded from server.
                var data = new google.visualization.DataTable($jsonTable1);
                var options = {
                    title: 'Total de registros por tabla',
                    is3D: 'true',
                    width: 800,
                    height: 600
                    };
                // Instantiate and draw our chart, passing in some options.
                // Do not forget to check your div ID
                var chart = new google.visualization.PieChart(document.getElementById('chart_div_rows'));
                chart.draw(data, options);
                }
                </script>
                <script type="text/javascript">

                // Load the Visualization API and the piechart package.
                google.load('visualization', '1', {'packages':['corechart']});

                // Set a callback to run when the Google Visualization API is loaded.
                google.setOnLoadCallback(drawChart);

                function drawChart() {

                // Create our data table out of JSON data loaded from server.
                var data = new google.visualization.DataTable($jsonTable2);
                var options = {
                    title: 'Espacio libre asignado en la base de datos por tabla (MB)',
                    is3D: 'true',
                    width: 800,
                    height: 600
                    };
                // Instantiate and draw our chart, passing in some options.
                // Do not forget to check your div ID
                var chart = new google.visualization.BarChart(document.getElementById('chart_div_freespace'));
                chart.draw(data, options);
                }
                </script>
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
                        width: 400px;
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
                <div class="card">
                    <h2>Información general</h2>
                    <p>Base de datos: $database</p>
                    <p>Motor: $engine</p>
                    <p>Intercalación: $collation</p>
                    <p>Tamaño total: $total_size MB</p>
                </div>
                <div id="chart_div"  style="margin-top:20px;" ></div>
                <div id="chart_div_rows"  style="margin-top:20px;" ></div>
                <div id="chart_div_freespace"  style="margin-top:20px;" ></div>
            </body>
            </html>

            HTML; 
            return $codHTML;
        }


    }
?>