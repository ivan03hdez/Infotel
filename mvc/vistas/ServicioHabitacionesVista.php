<?php
    require_once "plantillas/PlantillaHtmlVista.php";
    require_once "plantillas/MenuPrincipalVista.php";

    class ServicioHabitacionesVista extends PlantillaHtmlVista {
        public function render($datos_in) {
            session_start();
            if (!isSet($_SESSION['user'])) {
                return header("Location: login");
            }
            $datos = [
                'tituloPagina' => 'Mis Viajes'
            ];
            $mainMenu = MenuPrincipalVista::getMainMenu($datos);
            $reshabitacion =  ServicioHabitacionesVista::reservaHabitacion($datos_in);
            $resservicio =  ServicioHabitacionesVista::reservaServicio($datos_in);
            $this->bodyPagina = <<<HTML
                $mainMenu
                <body>
                    <div class="main-content">
                    <div class="container mt-7">
                    <!-- Table -->
                    <h2 class="mb-5">Reserva Histórico Desglosado</h2>
                    $reshabitacion
                    $resservicio
                    </div>
                </body>
            HTML;
            $this->tituloPagina = "Mis Viajes";

            echo parent::render(NULL);
        }
        public function reservaHabitacion($datos_in){
            $codHTML = "";
            foreach($datos_in['hoteles'] as $reserva){
                $codHTML .= <<< HTML
                  <div class="row">
                                    <div class="col">
                                        <label class="form-control-label" for="input-prehab">Precio de la habitación número {$reserva["numero"]}</label>
                                        <input type="text" id="input-prehab" class="form-control form-control-alternative"  value="{$reserva["precio"]}">
                                    </div>               
                 </div>
                HTML; 
              
            }
            return $codHTML;
        }
        public function reservaServicio($datos_in){
            $codHTML = "";
            foreach($datos_in['servicios'] as $reserva){
                $codHTML .= <<< HTML
                  <div class="row">
                                    <div class="col">
                                        <label class="form-control-label" for="input-prehab">Precio de la {$reserva["nombre"]}</label>
                                        <input type="text" id="input-preser" class="form-control form-control-alternative"  value="{$reserva["precio"]}">
                                    </div>               
                 </div>
                HTML; 
              
            }
            return $codHTML;
        }
    }
?>