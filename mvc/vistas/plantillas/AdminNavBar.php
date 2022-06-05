<?php
    class AdminNavBar {
        public static function getNavBar($datos_in){
            $adminnavBar = <<<HTML
            <div class="mainMenuList">
                <div><span>Hoteles</span><div class="underlined"></div></div>
                <div><span>Servicios</span><div class="underlined"></div></div>
                <div><span>Reservas</span><div class="underlined"></div></div>
                <div><span>Mis Viajes</span><div class="underlined"></div></div>
                <div><span>Login</span><div class="underlined"></div></div>
                <div><span>Mi Cuenta</span><div class="underlined"></div></div>
                <div><span>Administrador</span><div class="underlined"></div></div>
                <div><span>Mantenimiento</span><div class="underlined"></div></div>
            </div>
            HTML;

            return $adminnavBar;
        }
    }
?>