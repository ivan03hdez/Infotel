<?php
    require_once "plantillas/PlantillaHtmlVista.php";
	require_once "plantillas/MenuPrincipalVista.php";

    class LoginVista extends PlantillaHtmlVista {
        public function render($datos_in){
            $datos = [
                'tituloPagina' => 'Login'
            ];

            $this->tituloPagina = "Login";

            $mainMenu = MenuPrincipalVista::getMainMenu($datos);

            $this->bodyPagina = <<<HTML
                $mainMenu
                    <div class="login-box">
                        <form>
                            <div class="user-box">
                                <span></span>
                                <span></span>
                                <input type="text" name="" required="">
                                <label>Usuario</label>
                            </div>
                            <div class="user-box">
                                <input type="password" name="" required="">
                                <label>Contraseña</label>
                            </div>
                            <table>
                                <td>
                                    <a href="#">
                                    <span></span>
                                    <span></span>
                                    Iniciar sesión
                                    </a>
                                </td>
                                <td>
                                    <a href="http://localhost/infotel/mvc/Registro">
                                    <span></span>
                                    <span></span>
                                    Crea tu cuenta
                                    </a>
                                </td>
                            </table>
                        </form>
                    </div>
            HTML; 

            echo parent::render(NULL);
        }
    }
?>