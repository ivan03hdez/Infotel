<?php
    class LogoutModelo {
        public function getDatos($datos_in){
            session_start();
            session_destroy();
            return true;
        }
    }
?>