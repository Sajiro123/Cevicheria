   
<script type="text/javascript" src="./js/page_js/NuevoPedido.js"></script>
<style>
   hr{
      border-bottom: 1px solid #ccc; 
   }

</style>
<section class="content-header">
   <h1>
      Nuevo Pedido            
   </h1>
</section>
<!-- Main content -->
<section class="content col-md-9">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-primary">
         <form  id="myForm" onsubmit="return false">

            <div class="box-header">
               <h4>Productos:</h4>

               <div class="row modal-body" >
                  <label class="col-sm-1 col-xs-2 text-primary">Categoria</label>
                  <div class="col-sm-3 col-xs-4">
                     <select class="form-control form-control-sm"onchange="CargarDataProducto()" id="categoria"></select>
                  </div>
                  <label class="col-sm-1 col-xs-2 text-primary">Producto</label>
                  <div class="col-sm-3 col-xs-4">
                     <select class="form-control form-control-sm" id="producto" onchange="OnchangeProducto()"  ></select> 
                  </div>
                  <label class="col-sm-1 col-xs-2 text-primary"  aria-hidden="false">Cantidad<span class="asterisk">*</span></label>
                  <div class="col-sm-2 col-xs-4"aria-hidden="false">
                     <input type="number" name="cantidad" id="cantidad" value="1" class="form-control input-sm mb-5 ng-pristine ng-untouched ng-valid-maxlength ng-not-empty ng-valid ng-valid-required"  aria-invalid="false">                           
                  </div>
                </div>
                  <div class="row modal-body">
                  <label class="col-sm-1 col-xs-2 text-primary ng-hide"  aria-hidden="true">Precio</label>
                  <div class="col-sm-2 col-xs-4 ng-hide" aria-hidden="true">
                     <input type="text" name="precio"  id="precio" class="form-control input-sm mb-5 ng-pristine ng-untouched ng-empty ng-valid-maxlength ng-valid ng-valid-required"   aria-invalid="false">
                  </div>
                  <label class="col-sm-1 col-xs-2 text-primary"  aria-hidden="false">Descripcion</label>
                  <div class="col-sm-4 col-xs-4"aria-hidden="false">
                     <input type="text" class="form-control"style="height: 120px;"  id="descripcion" name="descripcion">
                  </div>

                  <label class="col-sm-1 col-xs-2 text-primary"  aria-hidden="false">Fecha</label>
                  <div class="col-sm-3 col-xs-4"aria-hidden="false">
                  <input type="text" class="form-control" rows="5" value="<?php echo date("d-m-Y");?>" id="fechapedido" style="float:left;width:100px;text-align:center;" >
                  </div>


               </div>
               <div class=" pull-right col-sm-3 col-xs-6" style="margin-top:2px;">
                  <button type="submit" style="font-size:17px" class="btn btn-success" onclick="agregarProducto()"><i class="fa fa-plus" style="font-size: 15px"> </i>&nbsp;&nbsp Agregar Producto</button>
               </div>

            </div>
            </form>

         </div>
      </div>
      <!-- /.box -->
   </div>
   <div class="row">
   <div class="box box-primary">
      <div class="box-header">
         <h4>Detalle Productos:</h4>
         <div class="modal-body">
         <div class="col-md-12">
<div class="table-responsive">
            <table id="tbDetalleProducto" class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th>Fila</th>
                     <th>Categoria</th>
                     <th>Producto</th>
                     <th style="text-align: center">Cantidad</th>
                     <th style="text-align: center">Precio U.</th>
                     <th style="text-align: center">Total</th>
                     <th>Descripcion</th>
                     <th style="text-align: center"  ></th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td colspan="8" style="text-align: center;"> Presionar el boton Agregar Productos para obtener la informacion.</td>
                  </tr>
               </tbody>
            </table>
            </div>

         </div>
         </div> 
         </div> 
      </div>
   </div>
   </div>
   <!-- /.col -->
   </div><!-- ./row -->		  
</section>
<section class="content col-md-3">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-primary">
            <div class="box-header">
               <h4 style="text-align:center">RESUMEN DE TU PEDIDO</h4>
               <ul class="summary">
               <hr/>
               <div class="col-md-6">
                  <h4>Subtotal </h4>
               </div>
               <div class="col-md-6">
                <p class="pull-left" style="margin-top: 10px;"> S/</p> <h4 style="color:red" id="subtotal">0.00 </h4>
               </div>
               <br/><br/><br/>
               <hr/> 
               <a type="submit" onclick="RegistrarPedido()" id="Guardar_tabla" class="btn btn-lg btn-primary summary-btn-process-pay col-md-12">
                    Procesar Compra
               </a>
               <br/><br/><br/>

               <hr/>

            </ul>
            </div>            
         </div>
      </div>
   </div>
</section>
<!-- /.content -->

<link href="./library/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
	<script src='./library/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'  ></script>
<script>
	$(document).ready(function(){
$('#fechapedido').datepicker({
			format: "dd/mm/yyyy",
			todayHighlight: true,
			autoclose: true
		});


   });
   function cacheInput(e) {
    localStorage.setItem(e.attributes["name"].value, e.value)
}

window.onload = function () {
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
