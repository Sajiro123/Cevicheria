<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="./dist/js/formValidation.js"></script>
<script type="text/javascript" src="./dist/js/framework/bootstrap.js"></script>
 <script type="text/javascript" src="./js/printArea.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>

<style>
   .modal-backdrop.in { 
   opacity: 0 !important;
   }
</style>
<script> 
   var ajax_load = "<div style='text-align:center;padding-top:300px'> <button class='btn btn-lg btn-primary'><span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Cargando...</button></div>";
   $(".ajaxmenu").click(function(){
   	
   	myUrl= $(this).attr('href');
   if (myUrl.match('#')) {
   	  var myAnchor = myUrl.split('#')[1];
   	  /*Ahora arreglamos el URL - para evitar problemas en ie6*/
   	  var loadUrl = myUrl.split('#')[0];
   }else{
   	var loadUrl = $(this).attr('href');
   }
   
   $("#container-ajax").html(ajax_load).load(loadUrl);
   return false;		
   });	
   
 
   
</script>
<section class="content-header">
   <h1>
      Mantenimiento
      <small>Pedidos</small>
   </h1>
   <ol class="breadcrumb">
      <!--<li><a href="#"><i class="fa fa-dashboard"></i> Archivo</a></li>
         <li><a href="#">Maestro</a></li>-->
      <li class="active">Pedidos</li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-primary">
            <div class="box-header">
               <div class="col-md-12">
                  <i class="fa fa-edit"></i>
                  <h1 class="box-title">Busqueda por fechas</h1>
                  <!--
                     <a><i class="fa fa-plus" data-toggle="modal" data-target="#modalSubdominio" onclick=load_mantSubdominios("A","") style="float:right;cursor:pointer;font-size: 20px" title="Agregar">
                     </i></a>-->
               </div>
               <div class="col-md-12">
                  <input type="text" class="form-control"value="<?php echo date("Y-m-d");?>" id="fechainicio" style="float:left;width:100px;text-align:center;" >
                  <input type="text"   class="form-control" value="<?php echo date("Y-m-d");?>" id="fechafin" style="float:left;width:100px;text-align:center;"  >
                  <input type="button" onclick="generar_tabla()" class="btn btn-success btn-sm" value="Buscar" style="float:left;margin-top:2px;" >
                  <!--<input type="button" onclick="exportar3()" class="btn btn-success btn-sm" value="Reporte 3" style="float:right;" >--> 
               </div>
            </div>
            <!--Visualizar Listado Carta Fianza -->
            <div class="box-body pad table-responsive">
               <div id="div_carta_fianza">
                  <!--div_user-->
                  <table id="tabla_guia" class="table table-bordered table-hover">
                     <thead>
                        <tr style="background-color:#ECF0F5;">
                           <th style="width: 20px;" >Item </th>
                           <th style="width: 40px;text-align:center;">Correlativo </th>
                           <th style="width: 40px;text-align:center;">Cliente </th>
                           <th style="width: 30px;text-align:center;">Fecha </th>
                           <th style="width: 30px;text-align:center;">Cantidad Productos</th>
                           <th style="width: 60px;text-align:center;">Total</th>
                           <th style="width: 60px;text-align:center;">Ver</th>
                        </tr>
                     </thead>
                  </table>
               </div>
               <!--  Modal para insertar un Nuevo Sub Dominio -->
               <!--  -------------------------------------- -->
               
               </div>
            </div>
         </div>
         <!-- /.box -->
      </div>
   </div>
   <!-- /.col -->
   </div><!-- ./row -->		  
</section>


<!-- Button trigger modal -->
 
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
                           <div class="modal-header" id="modal_reporte">
                              <h3 class="modal-title" id="exampleModalLabel">Pedido Detalle</h3>
                              <hr/>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true" style="cursor: pointer;">&times;</span>
                              </button>
                               <!-- <button onclick="javascript:demoFromHTML();" class="btn btn-sm btn-success">Imprimir</button> -->
                          
                              </div>
                           <div class="modal-body"> 
                              <!-- <div id="customers">
                              <h2 >Pedido Detalle </h2>
                              <br/> -->
                              <table class="table table-striped table-bordered" id="tbListarPedidoDetalle" >
                              <!-- <colgroup>
                                 <col width="10%">
                                    <col width="20%">
                                       <col width="30%">
                                             <col width="10%">
                                             <col width="30%">
                                             <col width="10%">
                                             <col width="10%">
                                 </colgroup> -->
                                 <thead>
                                    <tr class='warning'>
                                       <th class="text-center" >CATEGORIA</th>
                                       <th class="text-center" >PRODUCTO</th>
                                       <th class="text-center">CANT</th>
                                       <th class="text-center" >DESCRIP</th>
                                       <th class="text-center" >PRECIO</th>
                                       <th class="text-center" >TOTAL</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td colspan="13" class="text-center">Presionar el boton Consultar para obtener la información.</td>
                                    </tr>
                                 </tbody>
                              </table>
                              </div>
                           </div>
                     </div> 
    </div>
  </div>

   

 
   
<!--Add External Libraries - JQuery and jspdf 
check out url - https://scotch.io/@nagasaiaytha/generate-pdf-from-html-using-jquery-and-jspdf
-->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
 
<!-- /.content -->
<!-- DIv de impresion-->
<link href="./library/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
<script src='./library/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'  ></script>
<script type="text/javascript" src="./js/page_js/Reporte_Pedido.js"></script>