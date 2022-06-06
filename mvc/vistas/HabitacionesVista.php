<?php
    require_once "plantillas/PlantillaHtmlVista.php";
    require_once "plantillas/MenuPrincipalVista.php";

    class HabitacionesVista extends PlantillaHtmlVista {
        public function render($datos_in){
            $datos = [
                'tituloPagina' => 'Habitaciones'
            ];
            $this->tituloPagina = "Habitaciones";
            $mainMenu = MenuPrincipalVista::getMainMenu($datos);
            $tipos_habitaciones = HabitacionesVista::generarHTMLtiposhabitaciones($datos_in);
            $this->bodyPagina = <<<HTML
                $mainMenu
                <div>
                    <section>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="aligncenter">
                                        <h2 style="margin-bottom:2vh;"class="aligncenter">Tipos de habitaciones</h2>
                                        En todos los hoteles de Infotel, pueden disfrutar de los tipos de habitaciones que a continuación les mostramos
                                        <br>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            $tipos_habitaciones
                        </div>
                    </section>
                </div>
            HTML; 

            echo parent::render(NULL);
        }

        public function generarHTMLtiposhabitaciones($datos_in){
            $codHTML = "";
            foreach($datos_in as $row){
                $codHTML .= <<< HTML
                <div style="margin-top: 10px" >
                    <div class="col-md-12 md-margin-bottom-40">
                        <img class="img-responsive" style="width:100%" src="{$row['imagen']}" alt>
                    </div>
                    <div class="col-md-12 md-margin-bottom-40" style="background-color: #14274a; height: 60px">
                        <div style=" height:100%; width:50%; float:left; background-color: #14274a; text-align: center;">
                            <span style="color: white; font-size:large">{$row['Descripcion']}</span>
                            <br>
                            <span style="color:white; font-size:large"> Nº de personas: {$row['nPers']} </span>
                        </div>
                        <div style="height:100%; width:50%; float:right; background-color: #14274a; text-align: center;">
                            <div style="height:100%; width: 100%;">
                                <span style="color: white; font-size: xx-large;">Precio: {$row['precioBase']}€/noche</span>
                            </div>
                        </div>
                    </div>
                </div>
                HTML; 
            }
            return $codHTML;
        }
    }
?>