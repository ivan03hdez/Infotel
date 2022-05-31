<?php
    require_once "plantillas/PlantillaHtmlVista.php";
    require_once "MenuPrincipalVista.php";

    class AdminTablasVista extends PlantillaHtmlVista {
        public function render($datos_in){
            $datos = [
                'tituloPagina' => 'Administrador'
            ];
            $mainMenu = MenuPrincipalVista::getMainMenu($datos);
            $this->bodyPagina = <<<HTML
                $mainMenu
                <nav class="navbar navbar-expand-lg navbar-light bg-dark">
                  <div class = "container">
                    
                        <a href = "/" class="text-white bg-dark" > Clientes   </a>
                        <a href = "/" class="text-white bg-dark" > Reservas </a>
                        <a href = "/" class="text-white bg-dark" > Servicios </a>
                        <a href = "/" class="text-white bg-dark" > Hoteles </a>
                        <a href = "/" class="text-white bg-dark" > Habitaciones </a>
                        <a href = "/" class="text-white bg-dark" > Tipo </a>
                        <a href = "/" class="text-white bg-dark" > Empleados </a>
                    </div>
                  </nav>
                <table>
                <tr><td>Nombre</td><td>Apellidos</td><td>Email</td><td>NIF</td><td>Codigo Postal</td><td>Eliminar</td><td>Editar</td></tr>
                </table>
                <table>
                <tr><td>Codigo</td><td>Identificador</td><td>Fecha de inicio</td><td>Fecha de fin</td><td>Precio Total</td><td>Eliminar</td><td>Editar</td></tr>
                </table>
                <table>
                <tr><td>ID</td><td>Id del Hotel</td><td>Nombre</td><td>Descripcion</td><td>Precio</td><td>Eliminar</td><td>Editar</td></tr>
                </table>
                <table>
                <tr><td>ID</td><td>Id direccion</td><td>Nombre</td><td>Estrellas</td><td>Imagen</td><td>Eliminar</td><td>Editar</td></tr>
                </table>
                <table>
                <tr><td>ID</td><td>Id Hotel</td><td>Id Tipo</td><td>Numero</td><td>Vistas</td><td>Esta Limpia</td><td>Esta Ocupada</td><td>Es Adaptada</td><td>Eliminar</td><td>Editar</td></tr>
                </table>
                <table>
                <tr><td>ID</td><td>Tipo</td><td>Imagen</td><td>Precio Base</td><td>Tamanyo</td><td>Personas</td><td>Eliminar</td><td>Editar</td></tr>
                </table>
                <table>
                <tr><td>ID</td><td>Id hotel</td><td>Id direccion</td><td>Nombre</td><td>Apellidos</td><td>NIF</td><td>Email</td><td>Telefono</td><td>Fecha Nacimiento</td><td>Puesto</td><td>Sueldo</td><td>IRPF</td><td>Cuota Patronal</td><td>Eliminar</td><td>Editar</td></tr>
                </table>

            HTML;
            $this->tituloPagina = "Tablas Administrador";

            echo parent::render(NULL);
        }
    }
?>