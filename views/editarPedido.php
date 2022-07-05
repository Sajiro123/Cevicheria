<script type="text/javascript" src="./js/page_js/EditarPedido.js"></script>
 <link href="css/page_css/editarPedido.css" rel="stylesheet">


 
<style>
  
</style>
<?php 
if(isset($_GET['mesa'])){
   $mesaid = $_GET['mesa'];  
}
if(isset($_GET['idpedido'])){
    $idpedido = $_GET['idpedido'];  
 }
?>
<input type="hidden" id="idmesas" name="" value="<?php echo $mesaid?>">
<input type="hidden" id="idpedido" name="" value="<?php echo $idpedido?>">

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
                                             <th class="text-left" style="width: 1080px;">Producto</th>
                                             <th >Para Llevar</th>  
                                             <th style="text-align: center">Cantidad</th>
                                             <th style="text-align: center">Precio</th>
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
                     <!-- /.col -->
                  </div>
               </div>
      </section> 
      <section class="col-md-12 col-xl-3 col-sm-12 col-lg-3 modal-body"> 
         <div class="col-md-12" style="margin-left: -30px;">

               <div class="card"> 
                  <div class="row">
                        <div data-v-b991a720="" class="input-group mt-4">
                              <input data-v-b991a720="" type="text" placeholder="Buscar producto" class="form-control"> 
                              
                        </div>
                     
                        <div class="col-md-12"> 
                        
                           <form  id="myForm" onsubmit="return false">
                           <br/>
                           <i class="fas fa-arrow-alt-circle-left" onclick="RegresarProducto()" style="font-size: 38px;cursor: pointer;margin-top: -15px;display:none" id="idregresar"></i>
                           <br/> 
                              <div class="row" id="idimagenes"></div>
                           </form>
                        </div>
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
                     <a type="submit" onclick="EditarPedido()" id="Guardar_tabla" class="btn btn-lg btn-primary summary-btn-process-pay col-md-12">
                     Actualizar Pedido
                     </a>
                     <br/><br/><br/>
                     <hr/>
                  </ul>
               </div>
               </div>
         </div>   
      </section>
</div> 
<link href="./library/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
<script src='./library/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'  ></script>
<script>
   $(document).ready(function(){
      debugger
     $('#kt_content_container').css('margin-top','-42px')
   // $('#fechapedido').datepicker({
   // 		format: "dd/mm/yyyy",
   // 		todayHighlight: true,
   // 		autoclose: true
   // 	}); 
   
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