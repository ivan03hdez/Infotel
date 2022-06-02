<?php
    require_once "plantillas/PlantillaHtmlVista.php";
	require_once "plantillas/MenuPrincipalVista.php";

    class RegistroVista extends PlantillaHtmlVista {
        public function render($datos_in){
            $datos = [
                'tituloPagina' => 'Crear Cuenta'
            ];

            $this->tituloPagina = "Crear Cuenta";
            
            $mainMenu = MenuPrincipalVista::getMainMenu($datos);

            $this->bodyPagina = <<<HTML
                <div class="RegisterContainer">
                    $mainMenu
                    <div class="login-box">
                        <form> 
                            <div class="user-box">
                                <span></span>
                                <span></span>
                                <input type="text" name="nombre" required="">
                                <label>Nombre:</label>
                            </div>
                            <div class="user-box">
                                <span></span>
                                <span></span>
                                <input type="text" name="apellidos" required="">
                                <label>Apellidos:</label>
                            </div>
                            <div class="user-box">
                                <span></span>
                                <span></span>
                                <input type="text" name="dni" required="">
                                <label>DNI:</label>
                            </div>
                            <div class="user-box">
                                <span></span>
                                <span></span>
                                <input type="text" name="telefono" required="">
                                <label>Teléfono:</label>
                            </div>
                            <div class="user-box">
                                <span></span>
                                <span></span>
                                <input type="text" name="fechaNac" required="">
                                <label>Fecha Nacimiento:</label>
                            </div>
                            <div class="user-box">
                                <span></span>
                                <span></span>
                                <input type="text" name="nacionalidad" required="">
                                <label>Nacionalidad:</label>
                            </div>
                            <div class="user-box">
                                <span></span>
                                <span></span>
                                <input type="text" name="vacunado" required="">
                                <label>Vacunado:</label>
                            </div>
                            <div class="user-box">
                                <span></span>
                                <span></span>
                                <input type="email" name="correo" required="">
                                <label>Correo:</label>
                            </div>
                            <div class="user-box">
                                <input type="text" name="contrasenya" required="">
                                <label>Contraseña:</label>
                            </div>
                            <div class="user-box">
                                <a style="left:8%;width: 90%;text-align: center;" id="crearCuenta" href="#">
                                    <span></span>
                                    <span></span>
                                    Crea tu cuenta de Infotel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            HTML; 

            echo parent::render(NULL);
        }
    }
?>