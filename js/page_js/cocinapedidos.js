// Cargar();
function Cargar(){
    setTimeout(function() {
        ListarMesasPedidos()
        Cargar();
    }, 30000);
}
ListarMesasPedidos()


function ListarMesasPedidos() {
    $.ajax({
        url: "./controller/pedidoController.php",
        type: "POST",
        datatype: "json",
        data: {
            function: "ListarPedidosMesa"
        },
        success: function (data) {
            $('#idpedidos_cocina').empty();
            $('#idpedidos_total').empty(); 
            var data = JSON.parse(data);
            var cantidad_pedidos = 0;
            var data_2= _.filter(data, function(o) {
                return o.pedido_estado != 1 ;
            });

            data_producto = _.groupBy(data_2, function (b) { return b.acronimo });

            $.each(data_producto, function (nombre, data_row) {


                     var cantidad=0;
                    $.each(data_row, function (nombre, row) { 
                       cantidad+= parseInt(row.cantidad);
                   });
                       $('#idpedidos_total').append('<tr class="table-info" >'+
                      '<td style="font-size: 23px;">'+nombre+'</td>'+
                      '<td style="font-size: 23px;" class="text-center">'+cantidad+'</td>'+
                      '</tr> ');
               
            });     
 
            data = _.groupBy(data, function (b) { return b.idpedido })
            keys = Object.keys(data);
            var i;
            var len;
            i= keys.length; 
            len= keys.length; 
            var array_final={}
            keys.sort().reverse(); 
            for (i = 0; i < len; i++) {
                k = keys[i]; 
                array_final[k]=data[k];
            }
            // array_final.sort().reverse(); 

            const sorted = Object.keys(array_final)
            .sort().reverse()
            .reduce((accumulator, key) => {
                accumulator[key] = array_final[key];

                return accumulator;
            }, {});

            debugger
            $.each(array_final, function (id_pedido, data_row) {
                var status_pedido=false;

                cantidad_pedidos++; 
                if(data_row[0].comentario == "")
                    data_row[0].comentario = null
                
                   var string_html='<div class="col-lg-2 col-sm-2 col-xs-2 col-md-4 " style="height: 700px;width:358px;margin-top: -28px;">' +
                        '<h1 style="text-align: center"><span class="grey">' + cantidad_pedidos + '</span></h1>' +
                        '<div class="card" style="height: 115%;">' +
                        '<div class="card-header">' +
                        '<div style="text-align: center">'+
                        '<h1 style="font-size: 38px;">Mesa '+data_row[0].mesa+'</h1><br/>' +
                        '<h5 style="color: #d45300;margin-top: -20px;font-weight: bolder;">Mozo : '+data_row[0].usuario+'</h5></br>' + 
                        '<h4 style="margin-top: -20px">'+data_row[0].pedido_hora+'</h4><br/><hr/>' +
                        '</div>'+

                        // '<a  alt="cobrar" class="fa fa-pencil" href="?page=EditarPedido&mesa='+data_row[0].mesa+'&idpedido='+id_pedido+'"></a>' +
                        // '<i  alt="cobrar" class="fas fa-money-check-alt d-sm-none d-lg-block" onclick="CobrarPedido('+data_row[0].mesa+','+id_pedido+')" ></i>' +
                         '</div> '+ 
                        '<div class="card-body" >' +
                            '<div id="' + id_pedido + '" class="modal-body" > '+ 
                            '</div> '+  
                            '<hr style="position: relative;left: -15px;width: calc(100% + 30px);height: 2px;border: 2px solid #141417;"/>'+
                            (data_row[0].comentario != null  ? '<div class="modal-body" style="background-color: #89ff9c;"> '+ 
                            '<span style="font-size:22px">Comentario Cocina</span>'+
                            '<h4 style="font-family:arial">'+data_row[0].comentario+'<h4/>'+
                            '</div> ': "")+ 
                        '</div> ' +
                        '    </div>' +
                        '</div>';
                        $.each(data_row, function (row, col) {
                            if(col.pedido_estado == "" || col.pedido_estado == null){ 
                                status_pedido=true;
                            }
                        });

                    if(status_pedido==true){

                        $('#idpedidos_cocina').append(string_html);
    
                        $.each(data_row, function (row, col) {
                            var lugarpedido=(col.lugarpedido == 1 ? 'Mesa' : 'LLevar');
                            var color=(col.lugarpedido == 1 ? 'black' : 'red');
                            var pedido_estado=(col.pedido_estado == 1 ? '#ffb9b9;text-decoration:line-through;':'');
                            $('#' + id_pedido).append('<p class="pedido_cocina" style="width: 115%;color:black;margin-top: -17px;font-weight: 600;background-color: '+pedido_estado+';">' + col.cantidad + ' ' + col.acronimo +''+ '<span class="grey" style="background: '+color+';width: 4.1em;font-size: 20px;margin-left: 3px;margin-top: -17px;">'+lugarpedido+'</span></p><br/>');
                        }); 
                    } 
            }); 
        }
    }, JSON).done(function() {
        $("#overlay").fadeOut(); 
    });


}

function ImprimirBoton($idpedido){

    $('#pdf_div').empty();
                $('#pdf_div').append('<iframe  width="470px" height="640px" src="controller/pedidoController.php?function=TicketPdf&idpedido='+$idpedido+'"></iframe>')
                $('#exampleModalLong').modal('show'); 
 
 }

 function CobrarPedido($mesa,$idpedido){

    Swal.fire({
        title: "Desea Cobrar el Pedido?",
        text: "Desea Cobrar el pedido de la mesa "+$mesa,
        icon: "info",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Cobrar",
     }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: "./controller/pedidoController.php",
                type: "POST",
                datatype: "json",
                data: { 
                    mesa: $mesa,
                    idpedido:$idpedido,
                    function: "CobrarPedido"
                },
                success: function (data) {  
                    ListarMesasPedidos();
                    Swal.fire(
                        "Se Cobro Correctamente!",
                        "Se cobro el pedido seleccionado.",
                        "success"
                    ); 
                    
                }
     
            }).done(function() {
                $("#overlay").fadeOut(); 
            }); 
 
        }
            
    });
}

 
$(document).ajaxSend(function() {
    $("#overlay").fadeIn(100);　
   }); 