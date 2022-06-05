<?php
    require_once "plantillas/PlantillaHtmlVista.php";
    require_once "plantillas/MenuPrincipalVista.php";

    class PaginaPagoVista extends PlantillaHtmlVista {
        public function render($datos_in){
            /*session_start();
            $user = $_SESSION['user'];*/
            $datos = [
                'tituloPagina' => 'Pagina de Pago'
            ];

            $this->tituloPagina = "Pagina de Pago";

            $mainMenu = MenuPrincipalVista::getMainMenu($datos);
            $this->bodyPagina = <<<HTML
                $mainMenu
                    <div class="container">
                        <div class="row m-0">
                            <div class="col-md-7 col-12">
                                <div class="row">
                                    <div class="col-12 mb-4">
                                    <div class="row box-right">
                                        <div class="col-md-8 ps-0 ">
                                            <p class="ps-3 textmuted fw-bold h6 mb-0">Total de la Reserva</p>
                                            <p class="h1 fw-bold d-flex"> <span class=" fas fa-dollar-sign textmuted pe-1 h6 align-text-top mt-1"></span>524€ </p>
                                            <p class="ms-3 px-2 bg-green">-10% por la oferta</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="p-blue"> <span class="fas fa-circle pe-2"></span>Pendiente de pago </p>
                                            <p class="fw-bold mb-3"><span class="fas fa-dollar-sign pe-1"></span>524€ </p>
                                            <p class="p-org"><span class="fas fa-circle pe-2"></span>Sin Oferta</p>
                                            <p class="fw-bold"><span class="fas fa-dollar-sign pe-1"></span>576,4€</p>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-12 px-0 mb-4">
                                    <div class="box-right">
                                        <div class="d-flex pb-2">
                                            <p class="fw-bold h7"><span class="textmuted">Desglose de la estancia</span></p>
                                            <p class="ms-auto p-blue"><span class=" bg btn btn-primary fas fa-pencil-alt me-3"></span> <span class=" bg btn btn-primary far fa-clone"></span> </p>
                                        </div>
                                        <div class="bg-blue p-2">
                                            <p class="h8 textmuted">Entrada: 17/05/2022</p>
                                            <p class="h8 textmuted">Salida: 25/05/2022</p>
                                            <p class="h8 textmuted">Duración total de la estancia: 9 días</p>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-12 px-0">
                                    <div class="box-right">
                                    <div class="d-flex pb-2">
                                            <p class="fw-bold h7"><span class="textmuted">Cancelación</span></p>
                                            <p class="ms-auto p-blue"><span class=" bg btn btn-primary fas fa-pencil-alt me-3"></span> <span class=" bg btn btn-primary far fa-clone"></span> </p>
                                        </div>
                                        <div class="bg-blue p-2">
                                            <p class="h8 textmuted">Cancelación gratis</p>
                                            <p class="h8 textmuted">hasta las 23:59 del 10/05/2022.</p>
                                            <p class="h8 textmuted">A partir de las 00:00 del 16/05/2022 se le cargará un importe de 100€ por la cancelación.</p>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-12 ps-md-5 p-0 ">
                                <div class="box-left">
                                    <p class="textmuted h8">Información de la reserva</p>
                                    <p class="fw-bold h7">Juan Palomo</p>
                                    <p class="textmuted h8">{$datos_in["input-hotel"]}</p>
                                    <p class="textmuted h8 mb-2">San Vicente del Raspeig, Alicante 03690</p>
                                    <div class="h8">
                                    <div class="row m-0 border mb-3">
                                        <div class="col-6 h8 pe-0 ps-2">
                                            <p class="textmuted py-2">Items</p>
                                            <span class="d-block py-2 border-bottom">Habitación {$datos_in[0][0][0][2]}</span> 
                                            <span class="d-block py-2">Servicio {$datos_in[2][0]}</span> 
                                        </div>
                                        <div class="col-2 text-center p-0">
                                            <p class="textmuted p-2">Cant.</p>
                                            <span class="d-block p-2 border-bottom">2</span> <span class="d-block p-2">1</span> 
                                        </div>
                                        <div class="col-2 p-0 text-center h8 border-end">
                                            <p class="textmuted p-2">Precio</p>
                                            <span class="d-block border-bottom py-2">
                                                <span class="fas fa-dollar-sign"></span>200</span> 
                                                <span class="d-block py-2 ">
                                                    <span class="fas fa-dollar-sign">
                                                    </span>124</span> 
                                        </div>
                                        <div class="col-2 p-0 text-center">
                                            <p class="textmuted p-2">Total</p>
                                            <span class="d-block py-2 border-bottom"><span class="fas fa-dollar-sign">
                                            </span>400</span> <span class="d-block py-2">
                                                <span class="fas fa-dollar-sign">
                                                </span>124</span> 
                                        </div>
                                    </div>
                                    <div class="d-flex h7 mb-2">
                                        <p class="">Total por pagar</p>
                                        <p class="ms-auto"><span class="fas fa-dollar-sign"></span>524</p>
                                    </div>
                                    <div class="h8 mb-5">
                                        <p class="textmuted">Se podrán añadir cargos adicionales por destrozos. </p>
                                    </div>
                                    <div class="row m-0 border mb-3">
                                        <div class="col-6 h8 pe-0 ps-2">
                                            <span class="d-block py-2 border-bottom">Código promocional: </span>  
                                        </div>
                                        <div class="col-12 text-center p-0">
                                        <div class="col-12"> <input class="form-control my-6" type="text" placeholder="Ejemplo: OYGFHJ"> </div>
                                        </div>
                                    </div>
                                    <div class="">
                                    <p class="h7 fw-bold mb-1">Pagar la reserva</p>
                                    <p class="textmuted h8 mb-2">Hacer pago mediante tarjeta.</p>
                                    <div class="form">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card border-0"> <input class="form-control ps-5" type="text" placeholder="Número de la tarjeta"> <span class="far fa-credit-card"></span> </div>
                                            </div>
                                            <div class="col-6"> <input class="form-control my-3" type="text" placeholder="MM/YY"> </div>
                                            <div class="col-6"> <input class="form-control my-3" type="text" placeholder="CVV"> </div>
                                            <p class="p-blue h8 fw-bold mb-3">Más métodos de pago</p>
                                        </div>
                                        <div class="btn btn-primary d-block h8">Pagar reserva -> <span class="fas fa-dollar-sign ms-2"></span>524€<span class="ms-3 fas fa-arrow-right"></span></div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            HTML;


            echo parent::render(NULL);
        }
    }
?>