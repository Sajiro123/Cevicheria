var ARRAY_PEDIDO=[];
var MESAS=[];

function mesapiso(valorpiso){ 
      $('#mesascantidad').empty();
    $(MESAS).each(function() {
         if(this.piso ==valorpiso ){   
             var clase= (this.estado ==  0 ?"circuloverde" :"circulorojo" );
             
             $('#mesascantidad').append('<div class="col-sm-2 col-xs-2 col-md-2">'+
             '<div class="card" style="text-align:center;cursor:pointer;border-color: rgb(255 90 0 / 90%)!important;background-color: rgb(232 227 221)!important;width: 123px;height: 142px;" onclick="Opciones_Mesa('+this.numero+','+this.estado+')">'+ 
             '       <div class="'+clase+'" style="margin-left: 5px;"></div>'+
             '         <div class="card-body">'+
             '           <h2 style="margin-left: -14px;">Mesa Nº'+this.numero+'</h2>'+
             '        </div>'+
             '     </div>'+
             '     <br/>'+
             '</div>');
        }
    }); 

    if(valorpiso == 0){
        
        data = _.groupBy(ARRAY_PEDIDO, function (b) { return b.idpedido })

        // data.forEach( function(valor, indice) {
        //     console.log(elemento);
        // });
        $.each(data, function (id_pedido, data_row) {
            debugger
            var status =true;
             $.each(this,function() {
                    if(this.mesa == 0 && status == true){
                        var clase= (this.estado ==  0 ?"circuloverde" :"circulorojo" );
                        var platos_text="";
                        $.each(data_row,function() {
                            platos_text+='<span>'+this.acronimo+"</span><br/>";
                        }); 

                        debugger;
                        $('#mesascantidad').append('<div class="col-sm-4 col-xs-4 col-md-4">'+
                        '<div class="card" style="text-align:center;cursor:pointer;border-color: rgb(255 90 0 / 90%)!important;background-color: rgb(232 227 221)!important;width: 203px;height: 262px;" onclick="Opciones_Mesa(0,1,'+this.idpedido+')">'+ 
                        '       <div class="'+clase+'" style="margin-left: 5px;"></div>'+
                        '         <div class="card-body">'+
                        '           <h2 style="margin-left: -14px;">Pedido</h2><br/>'+platos_text+
                        '        </div>'+
                        '     </div>'+
                        '     <br/>'+
                        '</div>');
                        status = false;
                     }
                }); 
        }); 

        // $(data).each(function(row,column) {
        //     var data=column
        //     $(this).each(function() {
        //         if(this.mesa == 0){

        //         }
        //     }); 
        // }); 
    }
    
}

function Opciones_Mesa(id,estado,idpedido=0){   
    debugger
   if(idpedido == 0){
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
    }else{
        if(estado == 0){//agregar nuevo pedido
            // Create anchor element.
            var a = document.createElement('a'); 
            var link = document.createTextNode("This is link");           
            a.appendChild(link);  
            a.href = '?page=NuevoPedido'; 
            a.click();
            return;
        }

        $('#mesa').text('Pedido');
        var pedido_mesa = ARRAY_PEDIDO.filter(function (row) {
            return row.idpedido == idpedido;
        });        
    }
   var editar_div=""; 
   var pedido_mesa_lenght="";
   var table_listar_pedidos="";
   var id_pedido=0;
   var html_pedido="";
   var html_footer="";
   var int_responsive="";
   var total= 0;
   var descuento=0;
   $(pedido_mesa).each(function() {
        $('#idpedido_cobrar').val(this.idpedido);
       var checked='';
       if(this.pedido_estado == 1){
          checked='checked';
       }
       total+= parseInt(this.cantidad)*this.precioU ;
       descuento = (this.descuento != null ? this.descuento:0 )
       html_pedido+="<tr>"+
       "<td class='text-center' style='font-size: 20px;'>"+this.categoria+"</td>"+
       "<td class='text-center' style='font-size: 20px;' >"+this.cantidad+"</td>"+
       "<td class='text-center' style='font-size: 20px;'>"+this.nombre+"</td>"+
       "<td class='text-center' style='font-size: 20px;'>"+'<input onchange="estadoPedido(this)" style="width: 77%;height: 1.5em;margin-left: -2%;margin-top: -4px;"'+checked+' class="form-check-input" type="checkbox" id="'+this.idpedidodetalle+'" >'+"</td>"+
       "<td class='text-center' style='font-size: 20px;'>"+(this.lugarpedido == 1 ? "Mesa":"Llevar")+"</td>"+
       "<td class='text-center' style='font-size: 20px;'>"+this.precioU+"</td>"+
       "<td class='text-center' style='font-size: 20px;'>"+this.total+"</td>"+
       "</tr>";  
      
       id_pedido=this.idpedido

   });
   if(descuento != 0){
        total=total- descuento ;
        html_footer+=(descuento != null ?"<tr>"+
        "<td colspan='6' class='text-center' style='font-weight:bold;font-size: 26px;' >Descuento</td>"+          
        "<td class='text-center' style='font-weight:bold;font-size: 26px;'>"+descuento+"</td>"+
        "</tr>":"");
    }    
    html_footer+=
        "<tr>"+
        "<td colspan='6' class='text-center' style='font-weight:bold;font-size: 26px;' >Total</td>"+          
        "<td class='text-center' style='font-weight:bold;font-size: 26px;'>"+total+"</td>"+
        "</tr>"; 

    $('#idtotal').val(total);
   
   if(pedido_mesa.length==0){
       int_responsive=12;
       pedido_mesa_lenght='<div class="c">'+
       '  <div class="card" style="text-align:center;cursor:pointer;width: 108%;">'+  
       '<a href="?page=NuevoPedido&mesa='+id+'" class="list-group-item list-group-item-action  text-dark">'+ 
       '<div class="card-body">'+
       '<i class="fas fa-plus" style="font-size: 55px;"></i>'+ 
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

   editar_div='<div class="" >'+
       '               <div class="card" style="text-align:center;cursor:pointer;width: 108%;">'+
       '<a href="?page=EditarPedido&mesa='+id+'&idpedido='+id_pedido+'" class="list-group-item list-group-item-action  text-dark">'+  
       '                   <div class="card-body">'+
       '                       <i class="fas fa-pencil-alt" style="font-size: 55px;"></i>'+
       '                   </div>'+
       '       </a>'+ 
       '<h3>Editar</h3>'+ 
       '               </div>'+
       '            <br/>'+
       '           </div>';
   } 
   
    $('#opciones').empty();
    $('#mesa').text('Mesa '+id);
    $('#idopciones').css('display','block');
    $('#opciones_botones').empty();
    $('#opciones').append('<div class="row" style="margin-top: 10px;">'+table_listar_pedidos+'</div>');
    $('#opciones_botones').append('<div style="margin-top: -29px;" class="col-sm-'+int_responsive+' row">'+ pedido_mesa_lenght+editar_div+ 
    '           <div class="" style="">'+
    '               <div class="card" style="text-align:center;cursor:pointer;width: 108%;margin-top: -12px;" onclick="ImprimirBoton('+id+','+id_pedido+')">'+  
                            '<a href="#"  class="list-group-item list-group-item-action  text-dark">'+ 
                '                   <div class="card-body">'+
                '                       <i class="fas fa-file-alt" style="font-size: 55px;"></i>'+
                '                   </div>'+
                    '       </a>'+  
    '                       <h3>Ticket</h3>'+ 
    '               </div>'+
    '            <br/>'+
    '           </div>'+ 

                ' <div class="c" style="">'+
                '               <div class="card" style="text-align:center;cursor:pointer;width: 108%;margin-top: -12px;" onclick="ImprimirCocinaBoton('+id+','+id_pedido+')">'+  
                                        '<a href="#"  class="list-group-item list-group-item-action  text-dark">'+ 
                            '                   <div class="card-body">'+
                            '                       <i class="fas fas fa-utensils" style="font-size: 55px;"></i>'+
                            '                   </div>'+
                                '       </a>'+  
                '                       <h3>Cocina</h3>'+ 
                '               </div>'+
                '            <br/>'+
                '           </div>'+ 

                '<div class="c" style="">'+
                '               <div class="card" style="text-align:center;cursor:pointer;width: 108%;margin-top: -12px;" onclick="ModalCobrar('+id+','+id_pedido+')">'+  
                                    '<a href="#"  class="list-group-item list-group-item-action  text-dark">'+ 
                        '                   <div class="card-body">'+
                        '                       <i class="fas fa-money-check-alt" style="font-size: 55px;margin-left: -10px"></i>'+'                   </div>'+
                            '       </a>'+  
                '                       <h3>Cobrar</h3>'+ 
                '               </div>'+
                
                '            <br/>'+
                '           <div class="">'+
                '               <div class="card" style="text-align:center;cursor:pointer;width: 108%;margin-top: -12px;" onclick="CancelarPedido('+id+','+id_pedido+')">'+  
                                    '<a href="#"  class="list-group-item list-group-item-action  text-dark">'+   
                                    '                   <div class="card-body">'+
                                    '                       <i class="fas fa-trash-alt" style="font-size: 55px;"></i>'+
                                    '                   </div>'+
                                    '       </a>'+  
                '                       <h3>Cancelar</h3>'+
                '               </div>'+
                '            <br/>'+
                '           </div>'+ 
                '               </div>');
}

function RegresarMesas(){
//    $('#idopciones').css('display','none');
//    $('#idmesas').css('display','block');
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
                                    
                                    $(id).append('<div class="col-sm-2 col-xs-2 col-md-2">'+
                                    '<div class="card" style="text-align:center;cursor:pointer;border-color: rgb(255 90 0 / 90%)!important;background-color: rgb(232 227 221)!important;width: 123px;height: 142px;" onclick="Opciones_Mesa('+this.numero+','+this.estado+')">'+ 
                                    '       <div class="'+clase+'" style="margin-left: 5px;"></div>'+
                                    '         <div class="card-body">'+
                                    // '              <i class="fas fa-utensils" style="font-size: 55px;"></i>'+
                                    '           <h2 style="margin-left: -14px;">Mesa Nº'+this.numero+'</h2>'+
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
               $('#pdf_div').append('<iframe  width="470px" height="700px" src="controller/pedidoController.php?function=TicketPdf&idpedido='+$idpedido+'"></iframe>')
               $('#exampleModalLong').modal('show'); 
}

function ImprimirCocinaBoton($mesa,$idpedido){

    $('#pdf_div').empty();
                $('#pdf_div').append('<iframe  width="470px" height="700px" src="controller/pedidoController.php?function=TicketCocinaPdf&idpedido='+$idpedido+'"></iframe>')
                $('#exampleModalLong').modal('show'); 
 }

 function ModalCobrar($mesa,$idpedido){
   $('#idModalCobrar').modal('show'); 
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
            window.location.reload(1);

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
            window.location.reload(1);

        });

    }

}

function CobrarSumar(){
  var idefectivo= $('#idefectivo').val() == "" ? 0 : parseInt($('#idefectivo').val());
  var idvisa= $('#idvisa').val() == "" ? 0 : parseInt($('#idvisa').val());
  var idyape= $('#idyape').val() == "" ? 0 : parseInt($('#idyape').val());
  var idplin= $('#idplin').val() == "" ? 0 : parseInt($('#idplin').val());

  var total=idefectivo + idplin + idyape + idvisa;
  var idtotal= $('#idtotal').val();

  if(total == idtotal){
    //se guarda
    var $mesa= $('#mesa').text();
    var $idpedido= $('#idpedido_cobrar').val();
     Swal.fire({
        title: "Desea Cobrar el Pedidoe la mesa "+$mesa,
        // text: "Desea Cobrar el pedido de la mesa "+$mesa,
        icon: "info",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Cobrar",
     }).then((result) => {
        if (result.isConfirmed) {
            var $mesa= $('#mesa').text();
            $mesa= $mesa.split(" ");

            $.ajax({
                url: "./controller/pedidoController.php",
                type: "POST",
                datatype: "json",
                data: { 
                    idpedido:$idpedido,
                    mesa:$mesa[1], 
                    function: "CobrarPedido",
                    data: {
                        efectivo:idefectivo,
                        visa:idvisa,
                        yape:idyape,
                        plin:idplin, 
                    }
                },
                success: function (data) {  
                     Swal.fire(
                        "Se Cobro Correctamente!",
                        "Se cobro el pedido seleccionado.",
                        "success"
                    ); 
                    setTimeout(function(){
                        window.location.reload(1);
                        }, 1500);
                }
     
            }).done(function() {
                $("#overlay").fadeOut(); 
            }); 
 
        }
            
    });

  }else if(total < idtotal){
    alert("el total es menor")

  }else if(total > idtotal){
    alert("el total es mayor")
  }
}

$(document).ajaxSend(function() {
    $("#overlay").fadeIn(10);　
});   