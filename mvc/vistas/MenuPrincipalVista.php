<?php
    class MenuPrincipalVista {
        function createMainMenu() {
        }


        public static function getMainMenu($datos_in){
            $tituloPagina= isset($datos_in['tituloPagina']) ? $datos_in['tituloPagina'] : 'Inicio';
            $imagenMenu= isset($datos_in['imagenMenu']) ? $datos_in['imagenMenu'] : '';
            $cssModifier = isset($datos_in['imagenMenu']) ? $datos_in['imagenMenu'] : "mainMenuContainer";
            $menuPrincipal = <<<HTML
                <div class="$cssModifier">
                    <div class="infotelRectangulo">
                        <div class="infotelTexto">
                            <h1>INFOTEL</h1>
                            <h6>HOTELES</h6>
                        </div>
                    </div>
                    <div class="mainMenuList">
                        <div>
                            <span>Hoteles<div class="underlined"></div></span>
                        </div>
                        <div>
                            <span>Servicios<div class="underlined"></div></span>
                        </div>
                        <div>
                            <span>Reservas<div class="underlined"></div></span>
                        </div>
                        <div>
                            <span>Mis Viajes<div class="underlined"></div></span>
                        </div>
                        <div>
                            <span>Login<div class="underlined"></div></span>
                        </div>
                        <div>
                            <span>Mi Cuenta<div class="underlined"></div></span>
                        </div>
                        <div>
                            <span>Logout<div class="underlined"></div></span>
                        </div>
                    </div>
                    <div class="tituloPagina"><h1>$tituloPagina</h1></div>
                </div>
            HTML;

            return $menuPrincipal;
        }
    }
?>