<script type="text/javascript" src="./js/page_js/NuevoPedido.js"></script>
<link href="css/page_css/editarPedido.css" rel="stylesheet">
<script src="https://unpkg.com/ionicons@latest/dist/ionicons.js"></script>

<style>
 .colorDashboar{    
    height: 115px;
    border: 2px solid #DDD;
    border-radius: 10px;
    cursor: pointer;
}

.numbersDashboard{
  background-color: #FFF;
  height: 115px;
  border: 2px solid #DDD;
  border-radius: 8px;
  font-size: 2em;
  cursor: pointer;
}
</style>
<?php
if (isset($_GET['mesa'])) {
    $mesaid = $_GET['mesa'];
} else {
    $mesaid = 0;
}
?>
<input type="hidden" id="idmesas" name="" value="<?php echo $mesaid ?>">
<div class="row">

    <section class="col-md-12 col-xl-4 col-sm-12 col-lg-4 modal-body">

        <div class="col-md-12">
            <div class="card">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="tbDetalleProducto" class="">
                            <thead>
                                <tr>
                                    <th style="display:none"></th>
                                    <th style="display:none"></th>
                                    <th class="text-left" style="width: 370px;">Producto</th>
                                    <th>Llevar</th>
                                    <th style="text-align: center">Cantidad</th>
                                    <th style="text-align: center">Precio</th>
                                    <th style="text-align: center">Total</th>
                                    <th style="text-align: center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="8" style="text-align: center;"> Presionar el boton Agregar Productos
                                        para obtener la informacion.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="container" style="margin-top: 50px;">
                    <div class="mb-4 total-section ml-4" style="margin-right: 2rem!important;">
                        <div class="d-flex justify-content-end"><strong>
                                <span>Descuentos (-) </span> <span style="padding-left: 1em;">
                                    S/</span></strong>
                            <div class="text-right pl-3" style="width: 7rem;"><input type="number" value="0" min="0" step="0.01" id="iddescuento" placeholder="Desc." class="form-control form-control-sm text-right discount-input" style="background-position: left calc(0.2em) center;border-color: rgba(0, 0, 0, 0.08);margin-left: 13px;margin-top: -6px;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-2 col-md-6">
                        </div>


                        <div class="col-md-6 mb-2 ">
                            <div style="display: flex!important;">

                                <button type="button" class="btn btn-sm btn-success" onclick="RegistrarPedido()" id="Guardar_tabla" style="width: 100%;">
                                    <div data-v-b991a720="" class="tw-flex" style="line-height: 10px;">
                                        <span style="float: center;font-size: 18px;">Guardar</span>
                                        <span style="float: right;color:white;font-size: 20px;" id="subtotal">0.00
                                        </span>
                                        <p style="float: right;font-size: 20px;"> S/</p>

                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!---->
                    <div class="row mt-4">
                        <div class="col-12">
                            <!----> <textarea id="idcomentario" placeholder="Mensaje de impresión en Cocina." rows="2" wrap="soft" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <br />
            </div>
        </div>
    </section>
    
    <section class="col-md-12 col-xl-3 col-sm-12 col-lg-3 modal-body">
        <div class="col-md-12">

            <div class="card">
                <div class="row">
                    <div class="col-md-12">

                        <form id="myForm" onsubmit="return false">
                            <br />
                            <i class="fas fa-arrow-alt-circle-left" onclick="RegresarProducto()" style="font-size: 63px;cursor: pointer;margin-top: -15px;display:none" id="idregresar"></i>
                            <div class="row" id="idimagenes"></div>
                        </form>
                    </div>
                    <div class="input-group mt-4 modal-body">
                        <input type="text" id="idplatotext" onkeypress="return AddKeyPress(event);" placeholder="Buscar producto" class="form-control">

                    </div>
                    <div class="col-md-12 modal-body">
                        <div class="table-responsive" style="overflow: scroll;height:471px;margin-top: -36px;">
                            <table class="table table-hover table-sm" id="listarPlatos">
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>

    <div class="modal fade" id="ModalCambiarPrecio" tabindex="-1" role="dialog" aria-labelledby="ModalCambiarPrecioLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalCambiarPrecioLabel">Cambiar Precio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h2 class="text-center"> Ingresar Precio</h2>
                    <br />
                    <input type="number" id="idcambioprecio" autofocus class="form-control" placeholder="Precio" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="cambiarPrecio() ">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalCalculadora" tabindex="-1" role="dialog" aria-labelledby="ModalCambiarPrecioLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalCambiarPrecioLabel">N° PLATO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h2 class="text-center"> Ingresar Plato N°</h2>
                    <br />

                    <div class="row">
        <div class="col-sm-12">
            <div class="card-panel">
                <div class="row">
                    <section class="input-filts col-sm-5">
                        <input type="Number" name="NumberLote" id="NumberLote" placeholder="Número" class="form-control form-sm" style="font-size: 2.9rem;text-align:center">
                        <label for="NumberLote"></label>
                    </section>
                    <section class="row ">
                
                        <div class="col-sm-4 light-blue numbersDashboard center " onclick="setNumbersSelectDashboard(1)"><p>1</p></div>
                        <div class="col-sm-4 light-blue numbersDashboard center " onclick="setNumbersSelectDashboard(2)"><p>2</p></div>
                        <div class="col-sm-4 light-blue numbersDashboard center " onclick="setNumbersSelectDashboard(3)"><p>3</p></div>
                        <div class="col-sm-4 light-blue numbersDashboard center " onclick="setNumbersSelectDashboard(4)"><p>4</p></div>
                        <div class="col-sm-4 light-blue numbersDashboard center " onclick="setNumbersSelectDashboard(5)"><p>5</p></div>
                        <div class="col-sm-4 light-blue numbersDashboard center " onclick="setNumbersSelectDashboard(6)"><p>6</p></div>
                        <div class="col-sm-4 light-blue numbersDashboard center " onclick="setNumbersSelectDashboard(7)"><p>7</p></div>
                        <div class="col-sm-4 light-blue numbersDashboard center " onclick="setNumbersSelectDashboard(8)"><p>8</p></div>
                        <div class="col-sm-4 light-blue numbersDashboard center " onclick="setNumbersSelectDashboard(9)"><p>9</p></div>
                        <div class="col-sm-4 light-blue numbersDashboard center " onclick="ListarPedidoNumeroCalculadora()" style="font-size: 67px;color: green;text-align: center;"><p><ion-icon name="checkmark-circle" role="img" class="md hydrated"></ion-icon></p></div>
                        <div class="col-sm-4 light-blue numbersDashboard center " onclick="setNumbersSelectDashboard(0)"><p>0</p></div>
                        <div class="col-sm-4 light-blue numbersDashboard center " onclick="setNumbersSelectDashboard('clear')"><p>Limpiar</p></div>
                    </section>
                </div>
            </div>
        </div>
    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                 </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="ModalOpcionesPlato" tabindex="-1" role="dialog" aria-labelledby="ModalOpcionesPlatoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <input type="hidden" id="dataopcionplato" class="form-control" />
                    <input type="hidden" id="dataopcioncorrelativo" class="form-control" />

                    <h3 class="modal-title" id="ModalOpcionesPlatoLabel">Etiquetas Platos</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="id_opciones"></div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="GuardarOpcionPlato() ">Guardar</button>
                </div>
            </div>
        </div>
    </div>
 

    <link href="./library/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <script src='./library/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>
    <script>
        $(document).ready(function() {
            // $('#kt_content_container').css('margin-top', '-42px')
            // $('#fechapedido').datepicker({
            // 		format: "dd/mm/yyyy",
            // 		todayHighlight: true,
            // 		autoclose: true
            // 	}); 

        });

        function cacheInput(e) {
            localStorage.setItem(e.attributes["name"].value, e.value)
        }

        function setNumbersSelectDashboard(data){
            console.log('Se ha seleccionado el Numero '+ data);
            var inp = $('input[name=NumberLote]');
            if(data === "Clear") {
                console.log('Limpiar')
                inp.val('');
            } 
            if(data !== 'none') {
                var ant = inp.val();
                var newN = data;
                inp.val(`${ant}${newN}`);
             }
        }

        window.onload = function() {
            let form = document.getElementById("myForm");
            let inputs = form.children;
            for (let i = 0; i < inputs.length; i++) {
                let el = inputs[i];
                if (el.tagName.toLowerCase() != "input" || el.attributes["type"].value != "text") {
                    continue
                }
                let cachedVal = localStorage.getItem(el.attributes["name"].value)
                if (cachedVal != null) {
                    el.value = cachedVal;
                }
            }
        }
    </script>