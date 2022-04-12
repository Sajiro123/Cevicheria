var ARRAY_PEDIDO=[];
var MESAS=[];

function mesapiso(valorpiso){ 
      $('#mesascantidad').empty();
    $(MESAS).each(function() {
         if(this.piso ==valorpiso ){   
             var clase= (this.estado ==  0 ?"circuloverde" :"circulorojo" );
             
             $('#mesascantidad').append('<div class="col-sm-3 col-xs-3 col-md-3">'+
             '<div class="card" style="text-align:center;cursor:pointer;" onclick="Opciones_Mesa('+this.numero+','+this.estado+')">'+ 
             '       <div class="'+clase+'" style="margin-left: 5px;"></div>'+
             '         <div class="card-body">'+
             '              <i class="fas fa-utensils" style="font-size: 60px;"></i>'+
             '           <h2>Mesa '+this.numero+'</h2>'+
             '        </div>'+
             '     </div>'+
             '     <br/>'+
             '</div>');
        }
    }); 
}

function Opciones_Mesa(id,estado){   
   
    if(estado == 0){//agregar nuevo pedido
        // Create anchor element.
        var a = document.createElement('a'); 
        var link = document.createTextNode("This is link");           
        a.appendChild(link);  
        a.href = '?page=NuevoPedido&mesa='+id; 
        a.click();
        return;
   }

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
       var checked='';
       if(this.pedido_estado == 1){
          checked='checked';
       }
    
       html_pedido+="<tr>"+
       "<td class='text-center' style='font-size: 20px;'>"+this.categoria+"</td>"+
       "<td class='text-center' style='font-size: 20px;' >"+this.cantidad+"</td>"+
       "<td class='text-center' style='font-size: 20px;'>"+this.nombre+"</td>"+
       "<td class='text-center' style='font-size: 20px;'>"+'<input onchange="estadoPedido(this)" style="width: 4%;height: 1.9em;margin-left: -2%;margin-top: -4px;"'+checked+' class="form-check-input" type="checkbox" id="'+this.idpedidodetalle+'" >'+"</td>"+
       "<td class='text-center' style='font-size: 20px;'>"+(this.lugarpedido == 1 ? "Mesa":"Para Llevar")+"</td>"+
       "<td class='text-center' style='font-size: 20px;'>"+this.precioU+"</td>"+
       "<td class='text-center' style='font-size: 20px;'>"+this.total+"</td>"+
       "</tr>"; 

       html_footer="<tr>"+
       "<td colspan='6' class='text-center' style='font-weight:bold;font-size: 26px;' >Total</td>"+          
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
    '           <th scope="col" class="text-center"width="3%">Estado</th>'+ 
    '           <th scope="col" class="text-center" width="3%">Lugar</th>'+ 
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
//        '           <div class="col-sm-4 col-xs-4 col-md-4" style="">'+
//        '               <div class="card" style="text-align:center;cursor:pointer;width: 108%;" onclick="ImprimirBoton('+id+','+id_pedido+')">'+  
//        '<a href="#"  class="list-group-item list-group-item-action  text-dark">'+   

//        '                   <div class="card-body">'+
//        '                       <i class="fas fa-money-check-alt" style="font-size: 60px;"></i>'+
//        '                   </div>'+
//        '       </a>'+  
//        '                       <h3>Cobrar</h3>'+ 
//        '               </div>'+
//        '            <br/>'+
//        '           </div>'+ 
//    '   </div>' +
   '  </div> ');
}

function RegresarMesas(){
   $('#idopciones').css('display','none');
   $('#idmesas').css('display','block');
   ListarMesas('#mesascantidad');
}

function ListarMesas(id){
   $.ajax({
                   url: "./controller/pedidoController.php",
                   type: "POST",
                   datatype: "json",
                   data: {
                       function: "ListarMesas"
                   },                        
                   success: function (data) {  
                       var result = JSON.parse(data);
                       MESAS=result;
                       var i = 0;
                       var strHTML = ''
                       if (result.length <= 0) {
                           alert('falta configuracion de mesas')
                       } else {
                           $(id).empty(); 
                             var valorpiso = $('input[name="piso"]:checked').val();
                           $(result).each(function() {
                            
                                if(this.piso == valorpiso){   
                                    var clase= (this.estado ==  0 ?"circuloverde" :"circulorojo" );
                                    
                                    $(id).append('<div class="col-sm-3 col-xs-3 col-md-3">'+
                                    '<div class="card" style="text-align:center;cursor:pointer;" onclick="Opciones_Mesa('+this.numero+','+this.estado+')">'+ 
                                    '       <div class="'+clase+'" style="margin-left: 5px;"></div>'+
                                    '         <div class="card-body">'+
                                    '              <i class="fas fa-utensils" style="font-size: 60px;"></i>'+
                                    '           <h2>Mesa '+this.numero+'</h2>'+
                                    '        </div>'+
                                    '     </div>'+
                                    '     <br/>'+
                                    '</div>');
                                 }
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
                           }, JSON).done(function() {
                            $("#overlay").fadeOut(); 
                        });
                       }

                    }
               }, JSON).done(function() {
                $("#overlay").fadeOut(); 
            });
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

function ImprimirBoton($mesa,$idpedido){

   $('#pdf_div').empty();
               $('#pdf_div').append('<iframe  width="470px" height="640px" src="http://192.168.1.12:8079/cevicheria/controller/pedidoController.php?function=TicketPdf&idpedido='+$idpedido+'"></iframe>')
               $('#exampleModalLong').modal('show'); 
}

function estadoPedido(row){
    if(row.checked){
        $.ajax({
           url: "./controller/pedidoController.php",
           type: "POST",
           datatype: "json",
           data: { 
               value: 1,
               idpedidodetalle:row.id,
               function: "ActualizarEstado"
         } 
        }).done(function() {
            $("#overlay").fadeOut(); 
        });
    }else{
        $.ajax({
            url: "./controller/pedidoController.php",
            type: "POST",
            datatype: "json",
            data: { 
                value: null,
                idpedidodetalle:row.id,
                function: "ActualizarEstado"
          } 
         }).done(function() {
            $("#overlay").fadeOut(); 
        });

    }

}

$(document).ajaxSend(function() {
    $("#overlay").fadeIn(10);　
});   