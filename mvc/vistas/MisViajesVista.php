<?php
    require_once "plantillas/PlantillaHtmlVista.php";
    require_once "plantillas/MenuPrincipalVista.php";

    class MisViajesVista extends PlantillaHtmlVista {
        public function render($datos_in) {
            session_start();
            if (!isSet($_SESSION['user'])) {
                return header("Location: login");
            }
            $datos = [
                'tituloPagina' => 'Mis Viajes'
            ];
            $mainMenu = MenuPrincipalVista::getMainMenu($datos);
            $tipos_habitaciones = MisViajesVista::generarHTMLtiposhabitaciones($datos_in);
            $this->bodyPagina = <<<HTML
                $mainMenu
                <body>
                    <div class="main-content">
                        <div class="container mt-7">
                            <div class="card-body">
                                <!-- Table -->
                                <h2 class="mb-5">Viajes realizados</h2>
                                $tipos_habitaciones
                            </div>
                        </div>
                    </div>
                </body>
            HTML;
            $this->tituloPagina = "Mis Viajes";

            echo parent::render(NULL);
        }
        public function generarHTMLtiposhabitaciones($datos_in){
            $codHTML = "";
            //check if there are any results, if not display a message to the user saying that there are no Viajes
            if (count($datos_in) == 0) {
                $codHTML .= <<<HTML
                    <div class="alert alert-warning" role="alert">
                        <p>No hay viajes registrados en el sistema.</p>
                    </div>
                HTML;
            } else {
                foreach($datos_in as $reserva){
                    $codHTML .= <<< HTML
                        <div style="margin-top:3vh;margin-bottom:3vh;" class="row">
                            <div class="col">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="input-Codigoreserva">Código reserva</label>
                                    <input type="text" id="input-Codigoreserva" class="form-control form-control-alternative" placeholder="codigo" value="{$reserva['Identificador']}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="input-fi">Fecha Inicio</label>
                                    <input type="text" id="input-last-name" class="form-control form-control-alternative" placeholder="YY-MM-DD" value="{$reserva['fechaInicio']}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="input-ff">Fecha Fin</label>
                                    <input type="text" id="input-ff" class="form-control form-control-alternative" placeholder="YY-MM-DD" value="{$reserva['fechaFin']}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="input-pt">PrecioTotal</label>
                                    <input type="text" id="input-pt" class="form-control form-control-alternative" placeholder="euros" value="{$reserva['precioTotal']}">
                                </div>
                            </div>
                            <div style="padding-top:3vh;" class="col">
                                <form action = "serviciohabitaciones" method = "POST">
                                    <div class="form-group focused">
                                        <input type="hidden" name = "reservaCodigo" class="btn btn-primary"  value ="{$reserva['Codigo']}">  
                                        <input type="hidden" name = "idCliente" class="btn btn-primary"  value = "{$reserva['idCliente']}">  
                                        <input type="submit" class="btn btn-primary" value="Mostrar Reserva">    
                                    </div>
                                </form>
                            </div>
                        </div>
                    HTML; 
                }
            }
            return $codHTML;
        }
    }
?>