<?php
    require_once "plantillas/PlantillaHtmlVista.php";
    require_once "plantillas/MenuPrincipalVista.php";

    class MiCuentaVista extends PlantillaHtmlVista {
        public function render($datos_in){
            session_start();
            if (!isSet($_SESSION['user'])) {
                return header("Location: login");
            }

            // if (!isSet($_SESSION['direccion'])) {
            //     return header("Location: Micuenta");
            // }

            $user = $_SESSION['user'];
            $direccion = $_SESSION['direccion'];
            $datos = [
                'tituloPagina' => 'Mi Cuenta'
            ];
            $mainMenu = MenuPrincipalVista::getMainMenu($datos);
            $this->bodyPagina = <<<HTML
                $mainMenu

                <body>
                <div class="main-content">
                    <div class="container mt-7">
                    <!-- Table -->
                    <h2 class="mb-5">Datos Personales</h2>
                    <div class="row">
                        <div class="col-xl-8 m-auto order-xl-1">
                            <div class="card-body">
                            <form>
                                <h6 class="heading-small text-muted mb-4">Información del usuario</h6>
                                <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-username">Nombre</label>
                                        <input type="text" id="input-username" class="form-control form-control-alternative" placeholder="Username" value="Ivan">
                                    </div>
                                    </div>
                                    <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-first-name">Apellidos</label>
                                        <input type="text" id="input-first-name" class="form-control form-control-alternative" placeholder="First name" value="Hernández">
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-DNI">DNI</label>
                                        <input type="text" id="input-DNI" class="form-control form-control-alternative" placeholder="DNI" value="{$user["nif"]}">
                                    </div>
                                    </div>
                                    <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-last-name">Fecha de nacimiento</label>
                                        <input type="text" id="input-last-name" class="form-control form-control-alternative" placeholder="Last name" value="{$user["fechaNac"]}">
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Correo Electrónico</label>
                                        <input type="email" id="input-email" class="form-control form-control-alternative" placeholder="{$user["email"]}">
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <hr class="my-4">
                                <!-- Address -->
                                <h6 class="heading-small text-muted mb-4">Información de contacto</h6>
                                <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-md-12">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-address">Dirección</label>
                                        <input id="input-address" class="form-control form-control-alternative" placeholder="Home Address" value="Calle Alicante" type="text">
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-city">Ciudad</label>
                                        <input type="text" id="input-city" class="form-control form-control-alternative" placeholder="City" value="Alicante">
                                    </div>
                                    </div>
                                    <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-country">País</label>
                                        <input type="text" id="input-country" class="form-control form-control-alternative" placeholder="Country" value="{$user["nacionalidad"]}">
                                    </div>
                                    </div>
                                    <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-country">Código Postal</label>
                                        <input type="number" id="input-postal-code" class="form-control form-control-alternative" placeholder="{$direccion["cp"]}">
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <hr class="my-4">
                            </form>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </body>
            HTML;
            $this->tituloPagina = "Mi Cuenta";

            echo parent::render(NULL);
        }
    }
?>