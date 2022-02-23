
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@1,300&display=swap" rel="stylesheet">
<?php
   if (!isset($_SESSION['idperfil'])) {
       header('Location: ./login.php');
   }
 ?>


<style>
    body{
        font-family: 'Open Sans', sans-serif;
    }
    .circuloverde {
        width: 27px;
        height: 27px;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        border-radius: 50%;
        background: #5cb85c;
    }
    .circulorojo {
        width: 27px;
        height: 27px;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        border-radius: 50%;
        background: red;
    }
</style>
<div id="idmesas">
    <?php if ($_SESSION['idperfil']== 2) { ?> <!--MOZO --> 
        <div class="modal-body">
            <div class="row" id="mesascantidad"> 
            <?php 
    }
            ?>  
    </div>
    </div> 
</div>


<!--  -->


<div id="idopciones" style="display:none">
    <div class="modal-body">
        <div class="row" id="regresar">
            <div class="col-sm-1" style="margin-left: 36px;">
                <i class="fas fa-arrow-alt-circle-left" onclick="RegresarMesas()" style="font-size:60px;cursor:pointer;"></i>
            </div>
            <div class="col-sm-10" >
            <h2 class="text-center" id="mesa" style="font-family: cursive;color: red;"></h2> 
            </div>

        </div>
        <div class="" id="opciones">
        
                
        </div>
    </div>
</div>


<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div id="pdf_div">

          </div>
       </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

 <script>
    var ARRAY_PEDIDO=[];

     function Opciones_Mesa(id){   
        
        $('#mesa').text('Mesa '+id);
        var pedido_mesa = ARRAY_PEDIDO.filter(function (row) {
            return row.mesa == id;
        });          

        var editar_div=""; 
        var pedido_mesa_lenght="";
        var table_listar_pedidos="";
        var id_pedido=0;
        var html_pedido="";
        var html_footer="";
        var int_responsive="";

        $(pedido_mesa).each(function() {
            html_pedido+="<tr>"+
            "<td class='text-center' style='font-size: 20px;'>"+this.categoria+"</td>"+
            "<td class='text-center' style='font-size: 20px;' >"+this.cantidad+"</td>"+
            "<td class='text-center' style='font-size: 20px;'>"+this.nombre+"</td>"+
            "<td class='text-center' style='font-size: 20px;'>"+this.precioU+"</td>"+
            "<td class='text-center' style='font-size: 20px;'>"+this.total+"</td>"+
            "</tr>"; 

            html_footer="<tr>"+
            "<td colspan='4' class='text-center' style='font-weight:bold;font-size: 26px;' >Total</td>"+          
            "<td class='text-center' style='font-weight:bold;font-size: 26px;'>"+this.totalidad+"</td>"+
            "</tr>"; 
            id_pedido=this.idpedido

        });

        if(pedido_mesa.length==0){
            int_responsive=12;
            pedido_mesa_lenght='<div class="col-sm-4 col-xs-4 col-md-4">'+
            '  <div class="card" style="text-align:center;cursor:pointer;width: 108%;">'+  
            '<a href="?page=NuevoPedido&mesa='+id+'" class="list-group-item list-group-item-action  text-dark">'+ 
            '<div class="card-body">'+
            '<i class="fas fa-plus" style="font-size: 60px;"></i>'+ 
            '       </div>'+
            '       </a>'+ 
            '<h3>Nuevo</h3>'+
            '      </div>'+
            '            <br/>'+
            '           </div>';
            editar_div='';
        }else{
            int_responsive=12;
            table_listar_pedidos='<div class="col-sm-12 card">'+  
         '   <table class="table table-bordered">'+
         '       <thead class="thead-dark">'+
         '           <tr>'+
         '           <th scope="col" class="text-center">Categoria</th>'+
         '           <th scope="col" class="text-center" width="3%">Cantidad</th>'+
         '           <th scope="col" class="text-center">Pedido</th>'+
         '           <th scope="col" class="text-center" width="3%">Precio U.</th>'+
         '           <th scope="col" class="text-center" width="3%">Total</th>'+
         '           </tr>'+
         '       </thead>'+
         '           <tbody> '+html_pedido+ 
         '           </tbody>'+
         '           <tfoot>'+html_footer+
         '           </tfoot>'+ 
          '   </table>'+ 
        '</div>'; 

        editar_div='<div class="col-sm-4 col-xs-4 col-md-4" >'+
            '               <div class="card" style="text-align:center;cursor:pointer;width: 108%;">'+
            '<a href="?page=EditarPedido&mesa='+id+'&idpedido='+id_pedido+'" class="list-group-item list-group-item-action  text-dark">'+  
            '                   <div class="card-body">'+
            '                       <i class="fas fa-pencil-alt" style="font-size: 60px;"></i>'+
            '                   </div>'+
            '       </a>'+ 
            '<h3>Editar</h3>'+ 
            '               </div>'+
            '            <br/>'+
            '           </div>';
        } 
        
        $('#opciones').empty();

         $('#mesa').text('Mesa '+id);
         $('#idmesas').css('display','none');
         $('#idopciones').css('display','block');
         
        $('#opciones').append('<div class="row" style="margin-top: 10px;">'+table_listar_pedidos+        
        '<div style="margin-top: 29px;" class="col-sm-'+int_responsive+' row">'+ pedido_mesa_lenght+editar_div+
            '           <div class="col-sm-4 col-xs-4 col-md-4">'+
            '               <div class="card" style="text-align:center;cursor:pointer;width: 108%;" onclick="CancelarPedido('+id+','+id_pedido+')">'+  
            '<a href="#"  class="list-group-item list-group-item-action  text-dark">'+   
            '                   <div class="card-body">'+
            '                       <i class="fas fa-trash-alt" style="font-size: 60px;"></i>'+
            '                   </div>'+
            '       </a>'+  
            '                       <h3>Cancelar</h3>'+
            '               </div>'+
            '            <br/>'+
            '           </div>'+
            '           <div class="col-sm-4 col-xs-4 col-md-4" style="">'+
            '               <div class="card" style="text-align:center;cursor:pointer;width: 108%;" onclick="Opciones_Mesa( )">'+  
            '                   <div class="card-body">'+
            '                       <i class="fas fa-money-check-alt" style="font-size: 60px;"></i>'+
            '                       <h3>Cobrar</h3>'+
            '                   </div>'+
            '               </div>'+
            '            <br/>'+
            '           </div>'+
            '           <div class="col-sm-4 col-xs-4 col-md-4" style="">'+
            '               <div class="card" style="text-align:center;cursor:pointer;width: 108%;" onclick="ImprimirBoton()">'+  
            '<a href="#"  class="list-group-item list-group-item-action  text-dark">'+    
            '                   <div class="card-body">'+
            '                       <i class="fas fa-print" style="font-size: 60px;"></i>'+
             '                   </div>'+
            '       </a>'+  
            '                       <h3>Imprimir</h3>'+

            '               </div>'+
            '            <br/>'+
            '           </div> '+

        '   </div>' +
        '  </div> ');
     }

     function RegresarMesas(){
        $('#idopciones').css('display','none');
        $('#idmesas').css('display','block');

     }

     function ListarMesas(){
        $.ajax({
                        url: "./controller/pedidoController.php",
                        type: "POST",
                        datatype: "json",
                        data: {
                            function: "ListarMesas"
                        },                        
                        success: function (data) {  
                            var result = JSON.parse(data);
                            var i = 0;
                            var strHTML = ''
                            if (result.length <= 0) {
                                alert('falta configuracion de mesas')
                            } else {
                                $('#mesascantidad').empty();

                                $(result).each(function() {
                                var clase= (this.estado ==  0 ?"circuloverde" :"circulorojo" );
                                
                                $('#mesascantidad').append('<div class="col-sm-3 col-xs-3 col-md-3">'+
                                '<div class="card" style="text-align:center;cursor:pointer;" onclick="Opciones_Mesa('+this.numero+')">'+ 
                                '       <div class="'+clase+'" style="margin-left: 5px;"></div>'+
                                '         <div class="card-body">'+
                                '              <i class="fas fa-utensils" style="font-size: 60px;"></i>'+
                                '           <h2>Mesa '+this.numero+'</h2>'+
                                '        </div>'+
                                '     </div>'+
                                '     <br/>'+
                                '</div>');
                                }); 


                                $.ajax({
                                    url: "./controller/pedidoController.php",
                                    type: "POST",
                                    datatype: "json",
                                    data: {
                                        function: "ListarPedidosMesa"
                                    },                        
                                    success: function (data) {  
                                            var result = JSON.parse(data);
                                            var i = 0;
                                            var strHTML = ''
                                            if (result.length <= 0) {

                                            } else {  
                                            ARRAY_PEDIDO=result;
                                            }

                                        }
                                }, JSON); 
                            }

                         }
                    }, JSON);
     }
     
     function CancelarPedido($mesa,$idpedido){
         Swal.fire({
            title: "Desea Eliminar Pedido?",
            text: "Eliminar el pedido de la mesa "+$mesa,
            icon: "error",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Eliminar",
         }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                url: "./controller/pedidoController.php",
                type: "POST",
                datatype: "json",
                data: { 
                    mesa: $mesa,
                    idpedido:$idpedido,
                    function: "DeletePedidoMesa"
                },
                success: function (data) { 
                    Swal.fire(
                        "Se elimino Correctamente!",
                        "Se elimino el pedido seleccionado.",
                        "success"
                    ); 
                    
                    setTimeout(location.reload(), 2000);


                }
            });  
            }
            
         
         
        }); 
     }

    function ImprimirBoton(){
        debugger;
        $('#exampleModalLong').modal('show');
        $('#pdf_div').append('<iframe  width="1200px" height="1000px" src="https://sistemas.centromedicoosi.com/apiosi/public/content/uploads?us=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC93d3d3LmxhZ3JhbmVzY3VlbGEuY29tIiwibXkiOjU5MjA0LCJteXVzZXJuYW1lIjoiNzU0ODYyNzMiLCJteXNlZGUiOltdLCJteXRpbWUiOiIyMDIyLTAyLTIzIDA4OjM3OjIzIiwibXlhZG1hc2lzdGVuY2lhIjoxLCJpYXQiOjE2NDU2MjM0NDMsImV4cCI6MTY0NTcwOTg0MywiaXAiOiI1MS44MS4yMy4xMSIsIm15ZW50ZXJwcmlzZSI6MSwibXlwZXJmaWxpZHBhcmVudCI6MSwibXlwZXJmaWxpZCI6MSwibXlwZXJmaWxudWV2byI6IjEiLCJteXBlcmZpbGVkaXRhciI6IjEiLCJteXBlcmZpbGVsaW1pbmFyIjoiMSIsIm9wdGluZm9ybWUiOiIxIn0.l79AQxd7m-79QWHhvzjNEBSPLLnbg_0JxzA0YE7mRvA&tipFolder=informes_medicos-firmados&archivo=Historia_141541_2022-02-22_18-19-39.pdf"></iframe>')
 
    }

    function ImprimirTicket(){

        $.ajax({
                url: "./controller/pedidoController.php",
                type: "POST",
                datatype: "json",
                data: {  
                    function: "TicketPdf"
                },
                success: function (data) { 
                    debugger;


                }
            });      
        
    }

   
     $(document).ready(function(){
        ListarMesas();
     });

 </script>
 