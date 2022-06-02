<?php
    require_once "plantillas/PlantillaHtmlVista.php";
	require_once "plantillas/MenuPrincipalVista.php";

    class LoginVista extends PlantillaHtmlVista {
        public function render($datos_in){
            $datos = [
                'tituloPagina' => 'Login'
            ];

            $this->tituloPagina = "Login";
            $loginOrChangeAccount = isSet($_SESSION['id']) ? 'Cambiar de Cuenta' : 'Iniciar Sesion';

            $mainMenu = MenuPrincipalVista::getMainMenu($datos);

            //check if we get the user session to display a success message or the login
            if(isset($_SESSION['user'])){
                $userName = $_SESSION['user']['nombre'];
                $this->bodyPagina = <<<HTML
                    $mainMenu
                    <div style="text-align:center" class="alert alert-success" role="alert">
                        <strong >Bienvenido $userName!</strong>
                    </div>
                HTML;
            }else{
                $s = isSet($datos_in) ? implode($datos_in) : '';
                $this->bodyPagina = <<<HTML
                    <div class="RegisterContainer">
                        $mainMenu
                        <div style="width:35%;margin-top:4%;margin-left:1%" class="login-box">
                            <form id="loginForm" method="POST">
                                <div class="user-box">
                                    <span></span>
                                    <span></span>
                                    <input id="usuario" type="text" name="usuario" required="">
                                    <label>Correo</label>
                                </div>
                                <div class="user-box">
                                    <input id="contrasenya" type="password" name="contrasenya" required="">
                                    <label>Contraseña</label>
                                </div>
                                <table>
                                    <td>
                                        <a id="iniciarSesion">
                                            <span></span>
                                            <span></span>
                                            $loginOrChangeAccount
                                        </a>
                                    </td>
                                    <td style="margin-left:3%;">
                                        <a href="http://localhost/infotel/mvc/Registro">
                                        <span></span>
                                        <span></span>
                                        Crea tu cuenta
                                        </a>
                                    </td>
                                </table>
                            </form>
                        </div>
                        $s
                    </div>
                HTML; 
            }
            echo parent::render(NULL);
        }
    }
?>