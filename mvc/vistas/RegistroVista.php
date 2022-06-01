<?php
    require_once "plantillas/PlantillaHtmlVista.php";
	require_once "MenuPrincipalVista.php";

    class RegistroVista extends PlantillaHtmlVista {
        public function render($datos_in){
            $datos = [
                'tituloPagina' => 'Crear Cuenta'
            ];

            $this->tituloPagina = "Crear Cuenta";
            
            $mainMenu = MenuPrincipalVista::getMainMenu($datos);

            $this->bodyPagina = <<<HTML
                $mainMenu
                    <div class="login-box">
                        <form> 
                            <div class="user-box">
                                <span></span>
                                <span></span>
                                <input type="text" name="" required="">
                                <label>Nombre:</label>
                            </div>
                            <div class="user-box">
                                <span></span>
                                <span></span>
                                <input type="text" name="" required="">
                                <label>Apellidos:</label>
                            </div>
                            <div class="user-box">
                                <span></span>
                                <span></span>
                                <input type="text" name="" required="">
                                <label>DNI:</label>
                            </div>
                            <div class="user-box">
                                <span></span>
                                <span></span>
                                <input type="text" name="" required="">
                                <label>Teléfono:</label>
                            </div>
                            <div class="user-box">
                                <span></span>
                                <span></span>
                                <input type="text" name="" required="">
                                <label>Fecha Nacimiento:</label>
                            </div>
                            <div class="user-box">
                                <span></span>
                                <span></span>
                                <input type="text" name="" required="">
                                <label>Nacionalidad:</label>
                            </div>
                            <div class="user-box">
                                <span></span>
                                <span></span>
                                <input type="text" name="" required="">
                                <label>Vacunado:</label>
                            </div>
                            <div class="user-box">
                                <span></span>
                                <span></span>
                                <input type="text" name="" required="">
                                <label>Usuario:</label>
                            </div>
                            <div class="user-box">
                                <input type="password" name="" required="">
                                <label>Contraseña:</label>
                            </div>
                                <a href="#">
                                <span></span>
                                <span></span>
                                Crea tu cuenta de Infotel
                                </a>
                        </form>
                    </div>
            HTML; 

            echo parent::render(NULL);
        }
    }
?>