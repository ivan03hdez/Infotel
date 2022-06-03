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

            //check if we get the user session to display a success message or the login
            session_start();
            //echo implode($_SESSION['user']);
            if(array_key_exists('user', $_SESSION)){
                $userName = $_SESSION['user']['nombre'];
                $this->bodyPagina = <<<HTML
                    $mainMenu
                    <div style="text-align:center" class="alert alert-success" role="alert">
                        <strong >Bienvenido $userName!</strong>
                    </div>
                    <div class="container">
                        <div style="justify-content:space-around;" class="row">
                            <div style="width:auto;" class="col-md-12">
                                <a href="?controller=Login&action=logout" class="btn btn-primary">Cambiar Cuenta</a>
                            </div>
                            <div style="width:auto;" class="col-md-12">
                                <a href="http://localhost/infotel/mvc/logout" class="btn btn-primary">Cerrar Sesion</a>
                            </div>
                        </div>
                    </div>
                HTML;
            }else{
                $loginErorMessage = json_encode($datos_in) == 'false' ? <<<HTML
                    <div class="row">
                        <div class="col-md-12">
                            <div style="margin-top:1vh;" class="alert alert-danger" role="alert">
                                <strong>Error!</strong> Correo o contraseña incorrectos.
                            </div>
                        </div>
                    </div>
                HTML : ''; 
                $this->bodyPagina = <<<HTML
                    <div class="RegisterContainer">
                        $mainMenu
                        $loginErorMessage
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
                                            Iniciar Sesion
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
                    </div>
                HTML; 
            }
            echo parent::render(NULL);
        }
    }
?>