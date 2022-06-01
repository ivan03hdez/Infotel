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
            if(isset($_SESSION['user'])){
                $this->bodyPagina = <<<HTML
                    $mainMenu
                    <div class="alert alert-success" role="alert">
                        <strong>Bienvenido!</strong>
                    </div>
                    <a href="index.php?accion=logout" class="btn btn-primary">Logout</a>
                HTML;
            }else{
                $this->bodyPagina = <<<HTML
                    $mainMenu
                        <div class="login-box">
                            <form method="post">
                                <div class="user-box">
                                    <span></span>
                                    <span></span>
                                    <input id="usuario" type="text" name="" required="">
                                    <label>Usuario</label>
                                </div>
                                <div class="user-box">
                                    <input id="contraseña" type="password" name="" required="">
                                    <label>Contraseña</label>
                                </div>
                                <table>
                                    <td>
                                        <a id="iniciarSesion" href="http://localhost/infotel/mvc/login">
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
                        $datos_in
                HTML; 
            }
            echo parent::render(NULL);
        }
    }
?>