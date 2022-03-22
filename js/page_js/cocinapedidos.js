// Cargar();
// function Cargar(){
//     setTimeout(function() {
//         ListarMesasPedidos()
//         Cargar();
//     }, 30000);
// }
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
            data_producto = _.groupBy(data, function (b) { return b.acronimo })

            $.each(data_producto, function (nombre, data_row) {
                var cantidad=0;
                 $.each(data_row, function (nombre, row) {
                     debugger;
                    cantidad+= parseInt(row.cantidad);
                });
                    $('#idpedidos_total').append('<tr class="table-info" >'+
                   '<td style="font-size: 18px;">'+nombre+'</td>'+
                   '<td style="font-size: 18px;" class="text-center">'+cantidad+'</td>'+
                   '</tr> ');
            });           

            data = _.groupBy(data, function (b) { return b.idpedido })
            $.each(data, function (id_pedido, data_row) {
                cantidad_pedidos++;
                if (cantidad_pedidos > 6) {
                    $('#idpedidos_cocina').append('<div class="col-lg-2 col-sm-2 col-xs-2 col-md-4 " style="height: 400px;margin-top: 120px;">' +
                        '<h1 style="text-align: center"><span class="grey">' + cantidad_pedidos + '</span></h1>' +
                        '<div class="card" style="height: 115%;">' +
                        '<div class="card-header" style="height: 50px;">' +
                        '<h4>Mesa '+data_row[0].mesa+'</h4>' +
                        '</div> ' +
                        '<div class="card-body" >' +
                        '<h5 style="color: #d45300;margin-top: -20px;font-weight: bolder;">Mozo : '+data_row[0].usuario+'</h5>' +
                        '<div id=' + id_pedido + ' style="margin-left: -8%;"> '+ 
                        '</div> '+  
                    '</div> ' +
                    '    </div>' +
                    '</div>');
                } else {
                    $('#idpedidos_cocina').append('<div class="col-lg-2 col-sm-2 col-xs-2 col-md-4 " style="height: 400px;    margin-top: -28px;">' +
                        '<h1 style="text-align: center"><span class="grey">' + cantidad_pedidos + '</span></h1>' +
                        '<div class="card" style="height: 115%;">' +
                        '<div class="card-header" style="height: 50px;">' +
                        '<h4>Mesa '+data_row[0].mesa+
                        '<i  alt="cobrar" class="fas fa-money-check-alt d-sm-none d-lg-block" onclick="CobrarPedido('+data_row[0].mesa+','+id_pedido+')" style="font-size: 31px;margin-left: 60%;cursor: pointer;margin-top: -15%;"></i>' +
                        '<i alt="generar pdf" class="fas fa-file-pdf d-sm-none d-lg-block" onclick="ImprimirBoton('+id_pedido+')" style="font-size: 31px;margin-left: 92%;cursor: pointer;margin-top: -19%;"></i></h4>'+ 
                        '</div> '+ 
                        '<div class="card-body" >' +
                        '<h5 style="color: #d45300;margin-top: -20px;font-weight: bolder;">Mozo : '+data_row[0].usuario+'</h5>' + 
                            '<div id="' + id_pedido + '" style="margin-left: -8%;"> '+ 
                            '</div> '+  
                        '</div> ' +
                        '    </div>' +
                        '</div>');
                }

                $.each(data_row, function (row, col) {
                    var lugarpedido=(col.lugarpedido == 1 ? 'Mesa' : 'LLevar');
                    var color=(col.lugarpedido == 1 ? 'black' : 'red');
                    $('#' + id_pedido).append('<span class="pedido_cocina col-form-label-sm">' + col.cantidad + ' ' + col.acronimo +'</span>'+ '<br/><span class="grey " style="background: '+color+';width: 4.1em;font-size: 13px;margin-left: 3px;">'+lugarpedido+'</span></br>');
                });

            }); 
        }
    }, JSON).done(function() {
        $("#overlay").fadeOut(); 
    });


}

function ImprimirBoton($idpedido){

    $('#pdf_div').empty();
                $('#pdf_div').append('<iframe  width="470px" height="640px" src="http://192.168.1.12:8079/cevicheria/controller/pedidoController.php?function=TicketPdf&idpedido='+$idpedido+'"></iframe>')
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
                    debugger;
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