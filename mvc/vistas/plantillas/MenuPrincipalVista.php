<?php
    class MenuPrincipalVista {
        public static function getMainMenu($datos_in){
            $tituloPagina= isset($datos_in['tituloPagina']) ? $datos_in['tituloPagina'] : 'Inicio';
            $cssModifier = isset($datos_in['imagenMenu']) ? $datos_in['imagenMenu'] : "mainMenuContainer";
            $menuPrincipal = <<<HTML
                <div class="$cssModifier">
                    <div class="infotelContainer">
                        <div class="infotelRectangulo">
                            <div class="infotelTexto">
                                <h1>INFOTEL</h1>
                                <h6>HOTELES</h6>
                            </div>
                        </div>
                    </div>
                    <div class="mainMenuList">
                            <div><span>Hoteles</span><div class="underlined"></div></div>
                            <div><span>Servicios</span><div class="underlined"></div></div>
                            <div><span>Reservas</span><div class="underlined"></div></div>
                            <div><span>Mis Viajes</span><div class="underlined"></div></div>
                            <div><span>Login</span><div class="underlined"></div></div>
                            <div><span>Mi Cuenta</span><div class="underlined"></div></div>
                            <div><span>Administrador</span><div class="underlined"></div></div>
                    </div>
                    <div class="tituloPagina"><h1>$tituloPagina</h1></div>
                </div>
            HTML;

            return $menuPrincipal;
        }
    }
?>