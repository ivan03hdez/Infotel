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

            $registerMessage = '';
            if ($datos_in) {
               $registerMessage = <<<HTML
                    <div class="alert alert-success" role="alert">
                        <strong>¡Registro exitoso!</strong>
                    </div>
                    <a href="home" class="btn btn-primary">Volver a inicio</a>
                HTML;
            }
 
            if (json_encode($datos_in) == 'false' ) {
                $registerMessage = <<<HTML
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger" role="alert">
                                <strong>Error!</strong> No se ha podido registrar. Por favor, introduce los datos correctamente.
                            </div>
                        </div>
                    </div>
                HTML; 
            }

            $registerForm = <<<HTML
                <form id="registerForm" method="POST"> 
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
                        <label>Fecha Nacimiento (YY-MM-DD):</label>
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
                        <input type="email" name="correo" required="">
                        <label>Correo:</label>
                    </div>
                    <div class="user-box">
                        <input type="text" name="contrasenya" required="">
                        <label>Contraseña:</label>
                    </div>
                    <div class="user-box">
                        <a style="left:8%;width: 90%;text-align: center;cursor:pointer;" id="crearCuenta">
                            <span></span>
                            <span></span>
                            Crea tu cuenta de Infotel
                        </a>
                    </div>
                </form>
            HTML; 

            $this->bodyPagina = <<<HTML
                <div class="RegisterContainer">
                    $mainMenu
                    $registerMessage
                    <div class="login-box">
                        $registerForm
                    </div>
                </div>
            HTML; 

            echo parent::render(NULL);
        }
    }
?>