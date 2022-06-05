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
                            <h2 class="mb-5">Reserva Histórico</h2>
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
            foreach($datos_in as $reserva){
                $codHTML .= <<< HTML
                <div class="card-body">
                  <div class="row" data-id = "{$reserva["Codigo"]}">
                         <div class="col">
                            <div class="form-group focused">
                            <label class="form-control-label" for="input-Codigoreserva">Código reserva</label>
                            <input type="text" id="input-Codigoreserva" class="form-control form-control-alternative" placeholder="codigo" value="{$reserva["Identificador"]}">
                        </div>
                        </div>
                        <div class="col">
                        <div class="form-group focused">
                            <label class="form-control-label" for="input-fi">Fecha Inicio</label>
                            <input type="text" id="input-last-name" class="form-control form-control-alternative" placeholder="Last name" value="{$reserva["fechaInicio"]}">
                        </div>
                        </div>
                        <div class="col">
                        <div class="form-group focused">
                            <label class="form-control-label" for="input-ff">Fecha Fin</label>
                            <input type="text" id="input-ff" class="form-control form-control-alternative" placeholder="Last name" value="{$reserva["fechaFin"]}">
                        </div>
                        </div>
                        <div class="col">
                        <div class="form-group focused">
                            <label class="form-control-label" for="input-pt">PrecioTotal</label>
                            <input type="text" id="input-pt" class="form-control form-control-alternative" placeholder="Last name" value="{$reserva["precioTotal"]}">
                        </div>
                        </div>
                 </div>
                 <div class = "row">
                    <div class="col">
                        <form action = "serviciohabitaciones" method = "POST">
                         <div class="form-group focused">
                        <hr class="my-4">
                        <input type="hidden" name = "reservaCodigo" class="btn btn-primary"  value = "{$reserva["Codigo"]}">  
                        <input type="submit" class="btn btn-primary" value="Mostrar Reserva">    
                        </div>
                         </div>
                     </form>
                 </div>
                 </div>
                 </div>

                HTML; 
            }
            return $codHTML;
        }
    }
?>