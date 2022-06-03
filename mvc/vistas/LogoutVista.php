<?php
    class LogoutVista {
        public function render($datos_in){
            if(!isAdminUser()){
                return header("Location: home");
            }
        }
    }
?>