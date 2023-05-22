<style>
   table,
   th,
   td {
   border: 0.1px solid black !important;
   }
   .results tr[visible='false'],
   .no-result {
   display: none;
   }
   .results tr[visible='true'] {
   display: table-row;
   }
   .counter {
   padding: 8px;
   color: #ccc;
   }
</style>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/css/jasny-bootstrap.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/js/jasny-bootstrap.min.js"></script>
<script src="js\page_js\productos.js"></script>
<div class="loader" id="idloader" style="display:none;"></div>
<div class="card"  id="idcard" style="display:none">
   <div class="card-body">
      <div class="row">
         <div class="col-sm-3"> 
            <input type="text" class="search form-control" style="width: 304px;"
               placeholder="Ingrese la palabra de busqueda">
         </div>
         <div class="col-sm-3">
            <select class="form-select " id="seltected_categoria" onchange="FiltrarDataCategoria()"> 
            </select>
         </div>
      </div>
      <br />
      <div style="height:406px;overflow: scroll; ">
         <div class="container">
            <table class="table table-bordered  results table-sm " id="idProductoTable">
               <thead class="table-dark">
                  <tr>
                     <th class="text-center" style="font-size: 15px">#</th>
                     <th class="text-center" style="font-size: 15px">Producto</th>
                     <th class="text-center" style="font-size: 15px">Precio</th>
                     <th class="text-center" style="font-size: 15px">Codigo</th>
                     <th class="text-center" style="font-size: 15px">Categoria</th>
                     <th class="text-center"></th>
                     <th class="text-center"></th>
                  </tr>
                  <tr class="warning no-result">
                     <td colspan="4"><i class="fa fa-warning"></i> No result</td>
                  </tr>
               </thead>
               <tbody>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="modaltexto"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="form" action="" method="post"
               enctype="multipart/form-data">
               <div class="row">
                  <div class="col-sm-8 row">
                     <label class="col-sm-4 col-xs-6 control-label text-theme">Nombre</label>
                     <div class="col-sm-8 col-xs-6">
                        <input type="text" class="form-control vacios" id="nombre" name="nombre" value=""
                           required />
                     </div>
                     <label class="col-sm-4 col-xs-6 control-label text-theme mt-2">Codigo</label>
                     <div class="col-sm-8 col-xs-6 mt-2">
                        <input type="text" class="form-control vacios" id="codigo" name="codigo" value=""
                           required />
                     </div>
                     <label class="col-sm-4 col-xs-6 control-label text-theme mt-2">Categoria</label>
                     <div class="col-sm-8 col-xs-6 mt-2">
                        <select id="idcategoria" class="form-control" required name="idcategoria">
                        </select>
                     </div>
                     <label class="col-sm-4 col-xs-6 control-label text-theme mt-2">Precio</label>
                     <div class="col-sm-8 col-xs-6 mt-2">
                        <input type="number" class="form-control vacios" id="precio" name="preciounitario"
                           value="" required />
                     </div>
                     <label class="col-sm-4 col-xs-6 control-label text-theme mt-2">Acronimo</label>
                     <div class="col-sm-8 col-xs-6 mt-2">
                        <input type="text" class="form-control vacios" id="acronimo" name="acronimo" value=""
                           required />
                     </div>
                     <label class="col-sm-4 col-xs-6 control-label text-theme mt-2" style=""
                        id="labelcoditotipoprod">Codigo Tipo Producto</label>
                     <div class="col-sm-8 col-xs-6 mt-2" id="idcoditotipoprod" style="">
                        <input type="text" class="form-control vacios" id="idtipoproducto" name="idtipoproducto"
                           value="" />
                     </div>
                     <label class="col-sm-2 col-xs-6 control-label text-theme mt-2">Nivel 2</label>
                     <input class="col-sm-7 col-xs-6 mt-3" type="checkbox" name="idarbol" class="form-control" id="checknivel2" value="true">
                  </div>
                  <div class="col-sm-4 ">
                     <img name="" id="img_producto" />
                     <div class="col-sm-12">
                        <!-- <div class="fileinput fileinput-new" data-provides="fileinput">
                           <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" id="id_img"
                              style="width: 200px; height: 150px;"></div>
                           <div>
                              <span class="btn btn-outline-secondary btn-file">
                              <span class="fileinput-new">Seleccionar Imagen</span>
                              <span class="fileinput-exists">Cambiar</span>
                              <input type="file" id="imageUploadForm" accept=".jpg,.gif,.png"
                                 name="imgproducto" required>
                              </span>
                              <a href="#" class="btn btn-outline-secondary fileinput-exists"
                                 data-dismiss="fileinput">Eliminar</a>
                           </div>-->
                        </div> 
                     </div>
                     <br/>  
                  <br/>
                  <button  type="button" Onclick='($("#opcion_show").css("display")=="none"? $("#opcion_show").css("display","block") : $("#opcion_show").css("display","none"))' style="border: #bb0000;padding: 2px;margin;margin-top: 42px"  class="btn btn-info">Ver más</button>
                  <div class="row" id="opcion_show" style="display:none">
                  <br/>
                  <div class="row">
                     <h4 class="col-sm-3">Opciones Producto</h4>  
                     <div class="col-sm-1">
                         <button onclick="CrearOpciones()" type="button" class="btn btn-success" style="margin-top: -5px;margin-left: -10px;">
                           <svg style="width: 14px;height:16px;"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>
                        </button> 
                     </div> 
                  </div> 
                  <div id="html_opciones">

                  </div>
                  
                     
 
               </div>
               <input type="hidden" name="idproductoeditar" id="idproductoeditar"/>
         </div>
         </div>

         <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         <button type="submit" class="btn btn-success" id="id_button_productos">Guardar</button>
         </div>
         </form>
      </div>
   </div>
</div>