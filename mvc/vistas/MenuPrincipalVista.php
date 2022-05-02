<?php
    class MenuPrincipalVista {
        public static function getMainMenu($datos_in){
            $menuPrincipal = <<<HTML
                <div class="mainMenuContainer">
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
                </div>
            HTML;

            return $menuPrincipal;
        }
    }
?>