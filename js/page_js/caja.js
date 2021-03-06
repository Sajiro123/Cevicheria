
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
            $.each(data, function (id_pedido, data_row) {
                cantidad_pedidos++;
                    $('#idpedidos_cocina').append('<div class="col-lg-2 col-sm-2 col-xs-2 col-md-4 " style="height: 400px;margin-top: 0px;">' +
                        '<h1 style="text-align: center"><span class="grey">' + cantidad_pedidos + '</span></h1>' +
                        '<div class="card" style="height: 115%;">' +
                        '<div class="card-header" style="height: 50px;">' +
                        '<input type="radio" id="huey" name="drone" value="huey" checked style="float: right!important;height: 35px;width: 42px;"> <label for="huey"></label>'+
                        '<h4 style="margin-top: -19px;">Mesa '+data_row[0].mesa+'</h4>' +
                        // '<i  alt="cobrar" class="fa fa-pencil" href="?page=EditarPedido&mesa='+data_row[0].mesa+'&idpedido='+id_pedido+'" style="font-size: 31px;margin-left: 47%;cursor: pointer;margin-top: -8%;"></i>' +
                        // '<i  alt="cobrar" class="fas fa-money-check-alt d-sm-none d-lg-block" onclick="CobrarPedido('+data_row[0].mesa+','+id_pedido+')" style="font-size: 31px;margin-left: 60%;cursor: pointer;margin-top: -9%;"></i>' +
                        // '<i alt="generar pdf" class="fas fa-file-pdf d-sm-none d-lg-block" onclick="ImprimirBoton('+id_pedido+')" style="font-size: 31px;margin-left: 92%;cursor: pointer;margin-top: -14%;"></i></h4>'+                    
                        '</div> ' +
                        '<div class="card-body" >' +
                        '<h5 style="color: #d45300;margin-top: -20px;font-weight: bolder;">Mozo : '+data_row[0].usuario+'</h5></br>' +
                        '<div id=' + id_pedido + ' style="margin-left: -4%;margin-top: -22px;"> '+ 
                        '</div> '+  
                    '</div> ' +
                    '    </div>' +
                    '</div>');                

                $.each(data_row, function (row, col) {
                    var lugarpedido=(col.lugarpedido == 1 ? 'Mesa' : 'LLevar');
                    var color=(col.lugarpedido == 1 ? 'black' : 'red');
                    var pedido_estado=(col.pedido_estado == 1 ? '#ffb9b9':'');
                    $('#' + id_pedido).append('<p class="pedido_cocina" style="width: 106%;color:black;margin-top: -17px;font-weight: 600;background-color: '+pedido_estado+';">' + col.cantidad + ' ' + col.acronimo +''+ '<span class="grey" style="background: '+color+';width: 4.1em;font-size: 20px;margin-left: 3px;margin-top: -17px;">'+lugarpedido+'</span></p>');
                });

            }); 
        }
    }, JSON).done(function() {
        $("#overlay").fadeOut(); 
    });


}

function ImprimirBoton($idpedido){

    $('#pdf_div').empty();
                $('#pdf_div').append('<iframe  width="470px" height="440px" src="http://192.168.1.12:8079/cevicheria/controller/pedidoController.php?function=TicketPdf&idpedido='+$idpedido+'"></iframe>')
                $('#exampleModalLong').modal('show'); 
 
 }
