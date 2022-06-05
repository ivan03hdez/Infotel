<?php
    require_once "plantillas/PlantillaHtmlVista.php";
    require_once "plantillas/MenuPrincipalVista.php";
    require_once "plantillas/AdminNavBar.php";
    require_once "plantillas/Footer.php";

    class AdminHotelesVista extends PlantillaHtmlVista {
        public function render($datos_in){
            if(!isAdminUser()){
                return header("Location: login");
            }
        
            $datos = [
                'tituloPagina' => 'Administrador'
            ];

            $tableHeadersHTML='';
            $tableRows = '';
            
            $mainMenu = MenuPrincipalVista::getMainMenu(null);

            $adminNavBar = <<< HTML
                <div class="col-md-12" style="text-align:center">
                    <div class="btn-toolbar" style="width:100%">
                        <div class="btn-group">
                            <a type="button" class="btn btn-primary" href="AdminHoteles"> Hoteles </a>
                            <a type="button" class="btn btn-primary" href="AdminServicios"> Servicios </a>
                            <a type="button" class="btn btn-primary" href="AdminReservas"> Reserva </a>
                            <a type="button" class="btn btn-primary" href="AdminHabitaciones"> Habitación </a>
                            <a type="button" class="btn btn-primary" href="AdminTipos"> Tipo </a>
                            <a type="button" class="btn btn-primary" href="AdminOfertas"> Ofertas </a>
                        </div>
                    </div>
                </div> 
            HTML;

            $footer = Footer::getFooter(null);

            #Definimos los headers de la tabla
            $tableHeaders= array("ID","Nombre","Direccion","Ciudad","Nº de estrellas");
            
            // Crea el HTML de los headers
            $tableHeadersHTML .= '<tr>';
            foreach($tableHeaders as $header){
                $tableHeadersHTML .= '<th>'.$header.'</th>';
            }
            $tableHeadersHTML .= '</tr>';

            //Crea las filas de la tabla a partir de la consulta del Modelo
            foreach ($datos_in as $row) {
                $tableRows .= '<tr>';
                for($i=0;$i < count($row); $i++){
                    $tableRows .= '<td>'.$row[$i].'</td>';
                }
                $tableRows .= <<< HTML
                    <td>
                        <form method="post" action="HotelesForm">
                            <input type="hidden" name="edit" value={$row[0]}>
                            <button type="submit" class="btn btn-warning"> Editar </button>
                        </form>
                    </td>
                    <td>
                        <form method="post" action="AdminHoteles">
                            <input type="hidden" name="id" value={$row[0]}>
                            <button type="submit" class="btn btn-danger"> Borrar </button>
                        </form>
                    <td>
                HTML;
                $tableRows .= '</tr>';
            }
            

            #Construye el BODY de la página HTML
            $this->bodyPagina = <<<HTML
                $mainMenu
                <br>
                $adminNavBar
                <br>
                <form action="AdminHoteles" method="post">
                    <p> Busqueda de hotel
                        <input type="search" id="nombre" name="nombre" placeholder="Nombre del hotel">
                        <input type="submit" value="Buscar">
                    </p>
                </form>

                <table style="width:100%">
                    $tableHeadersHTML
                    $tableRows
                </table>

                
                <form action="HotelesForm" method="post">
                        <button type="submit" clas ="btn btn-success"> Crear un nuevo hotel </button>
                </form>

                <br>
                <br>

                $footer
            HTML;
            $this->tituloPagina = "Tablas Administrador";

            /*  TRASH ICON:
            <svg id="trash"  version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
            width="25px" height="35px" viewBox="0 0 485 485" style="enable-background:new 0 0 485 485;" xml:space="preserve">
            <g class="icon-trash">
              <rect x="67.224" width="350.535" height="71.81"/>
              <path d="M417.776,92.829H67.237V485h350.537V92.829H417.776z M165.402,431.447h-28.362V146.383h28.362V431.447z M256.689,431.447
                h-28.363V146.383h28.363V431.447z M347.97,431.447h-28.361V146.383h28.361V431.447z"/>
            </g>
          </svg>
          PENCIL ICON:
          <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="30px" height="40x" viewBox="0 0 100 100">
            <path d="M77.926,94.924H8.217C6.441,94.924,5,93.484,5,91.706V21.997c0-1.777,1.441-3.217,3.217-3.217h34.854 c1.777,0,3.217,1.441,3.217,3.217s-1.441,3.217-3.217,3.217H11.435v63.275h63.274V56.851c0-1.777,1.441-3.217,3.217-3.217 c1.777,0,3.217,1.441,3.217,3.217v34.855C81.144,93.484,79.703,94.924,77.926,94.924z"/>
            <path d="M94.059,16.034L84.032,6.017c-1.255-1.255-3.292-1.255-4.547,0l-9.062,9.073L35.396,50.116 c-0.29,0.29-0.525,0.633-0.686,1.008l-7.496,17.513c-0.526,1.212-0.247,2.617,0.676,3.539c0.622,0.622,1.437,0.944,2.274,0.944 c0.429,0,0.858-0.086,1.276-0.257l17.513-7.496c0.375-0.161,0.719-0.397,1.008-0.686l35.026-35.026l9.073-9.062 C95.314,19.326,95.314,17.289,94.059,16.034z M36.286,63.79l2.928-6.821l3.893,3.893L36.286,63.79z M46.925,58.621l-5.469-5.469 L73.007,21.6l5.47,5.469L46.925,58.621z M81.511,24.034l-5.469-5.469l5.716-5.716l5.469,5.459L81.511,24.034z"/>
           </svg>
          */
            echo parent::render(NULL);
        }
    }
?>