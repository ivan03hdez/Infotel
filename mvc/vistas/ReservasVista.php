<?php
    require_once "plantillas/PlantillaHtmlVista.php";
    require_once "plantillas/MenuPrincipalVista.php";

    class ReservasVista extends PlantillaHtmlVista {
        public function render($datos_in) {
            $datos = [
                'tituloPagina' => 'Reservas'
            ];
            
            $mainMenu = MenuPrincipalVista::getMainMenu($datos);
            $tipos_habitaciones = ReservasVista::generarHTMLtiposhabitaciones($datos_in[0]);
            $hoteles = ReservasVista::generarHTMLhoteles($datos_in[1]);
            $servicios = ReservasVista::generarHTMLservicios($datos_in[2]);
                $this->bodyPagina = <<<HTML
                    $mainMenu
                    <div class="main-content">
                        <div class="container mt-7">
                        <!-- Table -->
                        <h2 class="mb-5">Formulario de reserva</h2>
                        <div class="row">
                            <div class="col-xl-8 m-auto order-xl-1">
                                <div class="card-body">
                                <form action="paginapago" method="POST">
                                <h6 class="heading-small text-muted mb-4">Seleccione hotel, tipo de habitación y una fecha para la reserva</h6>
                                    <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-address">Hotel</label>
                                            <select class="col-lg-12" name="input-hotel" id="input-hotel">
                                             $hoteles
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="fecha-llegada">Fecha de llegada</label>
                                            <input type="date" id="fecha-llegada" name="fecha-llegada" required>
                                        </div>
                                        </div>
                                        <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="fecha-salida">Fecha de salida</label>
                                            <input type="date" id="fecha-salida" name="fecha-salida" required>
                                        </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <div class="row">
                                        <div class="col-lg-8">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-tipo">Tipo de habitación</label>
                                            <select class="col-lg-12" name="input-tipo" id="input-tipo">
                                             $tipos_habitaciones
                                            </select>
                                        </div>
                                        </div>
                                        <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-personas">Personas</label>
                                            <select class="col-lg-8" name="input-personas" id="input-personas">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                                <option>6</option>
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-tipo">Servicios</label>
                                            <select class="col-lg-12" name="input-servicios" id="input-servicios">
                                             $servicios
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <!-- <div class="row">
                                        <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <div style="width:auto;" class="col-md-12">
                                                <a href="http://localhost/infotel/mvc/reservas" class="btn btn-primary">Hacer otra reserva</a>
                                            </div>
                                            </div>
                                        </div> -->
                                        <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <div style="width:auto;" class="col-md-12">
                                                <input type="submit" class="btn btn-primary" value="Reservar">
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </form>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </body>

                    HTML;
                
            $this->tituloPagina = "Reservas";

            echo parent::render(NULL);
        }

        public function generarHTMLtiposhabitaciones($datos_in){
            $codHTML = "";
            $contador = 0;
            while($contador != 7){
                foreach($datos_in as $row){
                        $codHTML .= <<< HTML
                            <option value={$row[$contador][0]}>{$row[$contador][1]} - {$row[$contador][2]}</option>
                        HTML;                     
                }
                $contador++;
            }
            return $codHTML;
        }

        public function generarHTMLhoteles($datos_in){
            $codHTML = "";
            $contador = 0;
            while($contador != 50){
                foreach($datos_in as $row){
                        $codHTML .= <<< HTML
                            <option value={$row[$contador][0]}>{$row[$contador][2]}</option>
                        HTML;                     
                }
                $contador++;
            }
            return $codHTML;
        }

        public function generarHTMLservicios($datos_in){
            $codHTML = "";
            $contador = 0;
            while($contador != 3){
                foreach($datos_in as $row){
                        $codHTML .= <<< HTML
                            <option value={$row[$contador][2]}>{$row[$contador][2]}</option>
                        HTML;                     
                }
                $contador++;
            }
            return $codHTML;
        }
    }
?>