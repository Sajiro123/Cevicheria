<script type="text/javascript" src="./js/page_js/NuevoPedido.js"></script>
<link href="css/page_css/editarPedido.css" rel="stylesheet"> 
<style type="text/css">
   


</style>
<?php 
if(isset($_GET['mesa'])){
   $mesaid = $_GET['mesa'];  
}
?>
<input type="hidden" id="idmesas" name="" value="<?php echo $mesaid?>">
<div class="row">

<section class="content col-md-12 col-xl-9 col-sm-12 col-lg-9 modal-body">
   <div class="col-md-12">
      <div class="card">
            <div class="card-header">
            <h5 >NUEVO PEDIDO</h5> 
            </div>
         <div class="card-body">
                           <i class="fas fa-arrow-alt-circle-left" onclick="RegresarProducto()" style="font-size: 77px;cursor: pointer;margin-top: -15px;display:none" id="idregresar"></i>
             <div class="row">
               <div class="modal-body"> 
          

                  <section class="content col-md-12">
                     <div class="row">
                        <div class="col-md-12">
                  

                           <form  id="myForm" onsubmit="return false">
                              <h4>Categoria:</h4>
                              <div class="row" id="idimagenes"> 
                              </div>
                        </div>
                        </form>
                     </div>
                     <hr/>
                     <h4>Detalle Productos:</h4>
                            <div class="table-responsive" style="WIDTH: 106%;MARGIN-LEFT: -3%;">
                              <table id="tbDetalleProducto" class="table table-striped table-bordered">
                                 <thead>
                                    <tr>
                                       <th width="5%">Fila</th>
                                       <th>Categoria</th>
                                       <th>Producto</th>
                                       <th>Para Llevar</th> 
                                       <th style="text-align: center">Cantidad</th>
                                       <th style="text-align: center">Precio U.</th>
                                       <th style="text-align: center">Total</th>
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
               <!-- /.col -->
            </div>
         </div>
      </div>
</section>


<section class="content col-md-12 col-xl-3 col-sm-12 col-lg-3 modal-body"> 
      <div class="card">
         <div class="card-header">
         <h4 style="text-align:center">RESUMEN DE TU PEDIDO</h4>
         </div>
        <div class="card-body">
        <ul class="summary">
            <hr/>
            <div class="col-md-6">
               <h4>Total Pedido: </h4>
               <br/><br/>
               <h4 class="float-sm-left" >
               S/</p> 
               <h4 class="float-sm-right"  style="color:red" id="subtotal">0.00 </h4>
            </div>
            <div class="col-md-6">
            </div>
            <br/><br/><br/>
            <hr/>
            <a type="submit" onclick="RegistrarPedido()" id="Guardar_tabla" class="btn btn-lg btn-primary summary-btn-process-pay col-md-12">
            Generar Pedido
            </a>
            <br/><br/><br/>
            <hr/>
         </ul>
        </div>
      </div>  
</section>
</div> 
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