function ListarMesasPedidos() {
    $.ajax({
        url: "./controller/pedidoController.php",
        type: "POST",
        datatype: "json",
        data: {
            function: "ListarPedidosMesa"
        },
        success: function (data) {
            var data = JSON.parse(data);
            var cantidad_pedidos = 0;

            data = _.groupBy(data, function (b) { return b.idpedido })
            $.each(data, function (id_pedido, data_row) {
                cantidad_pedidos++;
                if (cantidad_pedidos > 5) {
                    $('#idpedidos_cocina').append('<div class="col-sm-2" style="height: 350px;margin-top: 120px;">' +
                        '<h1 style="text-align: center"><span class="grey">' + cantidad_pedidos + '</span></h1>' +
                        '<div class="card" style="height: 115%;">' +
                        '<div class="card-header" style="height: 50px;">' +
                        '<h4>Mesa '+data_row[0].mesa+'</h4>' +
                        '</div> ' +
                        '<div class="card-body" >' +
                        '<div id=' + id_pedido + ' style="margin-top: -20px;"> '+ 
                        '</div> '+  
                    '</div> ' +
                    '    </div>' +
                    '</div>');
                } else {
                    $('#idpedidos_cocina').append('<div class="col-sm-2" style="height: 350px;    margin-top: -28px;">' +
                        '<h1 style="text-align: center"><span class="grey">' + cantidad_pedidos + '</span></h1>' +
                        '<div class="card" style="height: 115%;">' +
                        '<div class="card-header" style="height: 50px;">' +
                        '<h4>Mesa '+data_row[0].mesa+'</h4>' +
                        '</div> '+ 
                        '<div class="card-body" >' +
                            '<div id=' + id_pedido + ' style="margin-top: -20px;"> '+ 
                            '</div> '+  
                        '</div> ' +
                        '    </div>' +
                        '</div>');
                }

                $.each(data_row, function (row, col) {
                    $('#' + id_pedido).append('<span class="pedido_cocina">' + col.cantidad + ' ' + col.acronimo + '</span></br>');
                });

            }); 
        }
    }, JSON).done(function() {
        $("#overlay").fadeOut(); 
    });


}

$(document).ajaxSend(function() {
    $("#overlay").fadeIn(100);　
   }); 