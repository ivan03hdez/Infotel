<?php
    require_once "plantillas/PlantillaHtmlVista.php";
    require_once "plantillas/MenuPrincipalVista.php";

    class MisViajesVista extends PlantillaHtmlVista {
        public function render($datos_in) {
            /*session_start(); 
            $user = $_SESSION['user'];*/
            session_start();
            if (!isSet($_SESSION['user'])) {
                return header("Location: login");
            }
        
            $user = $_SESSION['user'];
            $reserva = $_SESSION['reserva'];
            $datos = [
                'tituloPagina' => 'Mis Viajes'
            ];
            $mainMenu = MenuPrincipalVista::getMainMenu($datos);
            $tipos_habitaciones = MisViajesVista::generarHTMLtiposhabitaciones($datos_in);
            $res = MisViajesVista::getReserva($datos_in);
            $reshabitacion =  MisViajesVista::reservaHabitacion($datos_in);
            $this->bodyPagina = <<<HTML
                $mainMenu
                <body>
                <div class="main-content">
                    <div class="container mt-7">
                    <!-- Table -->
                    <h2 class="mb-5">Reserva Histórico</h2>
                    
                             $reshabitacion
                        
                    </div>
                </body>
            HTML;
            $this->tituloPagina = "Mis Viajes";

            echo parent::render(NULL);
        }
        public function reservaHabitacion($datos_in){
            $codHTML = "";
            foreach($datos_in as $reserva){
                    $pos = 1 ;
                $codHTML .= <<< HTML
                  <div class="row">
                                    <div class="col">
                                        <label class="form-control-label" for="input-DNI">Precio de la habitacion {$pos}</label>
                                        <input type="text" id="input-DNI" class="form-control form-control-alternative" placeholder="DNI" value="{$reserva["precio"]}">
                                    </div>               
                 </div>
                HTML; 
              
            }
            return $codHTML;
        }
        public function generarHTMLtiposhabitaciones($datos_in){
            $codHTML = "";
            foreach($datos_in as $reserva){
                $codHTML .= <<< HTML
                  <div class="row">
                                    <div class="col">
                                        <label class="form-control-label" for="input-DNI">Código reserva</label>
                                        <input type="text" id="input-DNI" class="form-control form-control-alternative" placeholder="DNI" value="{$reserva["Identificador"]}">
                                    </div>
                                    <div class="col">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-last-name">Fecha Inicio</label>
                                        <input type="text" id="input-last-name" class="form-control form-control-alternative" placeholder="Last name" value="{$reserva["fechaInicio"]}">
                                    </div>
                                    </div>
                                    <div class="col">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-last-name">Fecha Fin</label>
                                        <input type="text" id="input-last-name" class="form-control form-control-alternative" placeholder="Last name" value="{$reserva["fechaFin"]}">
                                    </div>
                                    </div>
                                    <div class="col">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-last-name">PrecioTotal</label>
                                        <input type="text" id="input-last-name" class="form-control form-control-alternative" placeholder="Last name" value="{$reserva["precioTotal"]}">
                                    </div>
                                    </div>
                                   <div class="btn btn-primary" onclick="getReserva($reserva)">Mas     
                                    </div>
                                   
                 </div>

                HTML; 
            }
            return $codHTML;
        }
                public function getReserva($datos_in){
                
                    $query = DatabaseConnection::query('select rh.id from reservaHist rh, reserva r where r.Codigo = rh.CodReserva AND rh.CodReserva ="'.$datos_in.'"');
                    $codHTML = "";
                    while($row = mysqli_fetch_array($query)) 
                            {
                                $hotels[] = $row;
                            }
                                    
                        $codHTML .= <<< HTML
                         <div class="row">
                            foreach($$hotels as $reserva){
                                
                                <div class="form-group focused">
                                        <label class="form-control-label" for="input-last-name">Fecha Inicio</label>
                                        <input type="text" id="input-last-name" class="form-control form-control-alternative" value="{$reserva["fechaInicio"]}">
                                    </div>
                                    </div>

                            endforeach
                            </div>
                        HTML; 
                    
                    return $codHTML;
            }
    }
?>