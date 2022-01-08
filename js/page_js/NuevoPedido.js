var i = 0;
var correlativo = 0;
var table_status = false;
var total=0;

function CargarDataCategoria() {
  $.ajax(
    {
      url: "./controller/pedidoController.php",
      type: "POST",
      datatype: "json",
      data: "function=CargarDataCategoria",
      success: function (data) {
        var data_ = JSON.parse(data);

        $("#categoria").empty();
        if (data_.length == 0) {
          // si la lista esta vacia
          $("#categoria").append(
            '<option value="0">' + "--No hay información--" + "</option>"
          );
        } else {
          $.each(data_, function () {
            $("#categoria").append(
              '<option value="' + this.ID + '">' + this.NAME + "</option>"
            );
          });
          CargarDataProducto();
        }
      },
    },
    JSON
  );
}
function OnchangeProducto() {
   var precio =  $("#producto option:selected").attr('data-precio');
  $("#precio").val(precio);
}

function CargarDataProducto() {
  var categoria_select = $("#categoria option:selected").val();
  $("#producto").empty();

  $.ajax(
    {
      url: "./controller/pedidoController.php",
      type: "POST",
      datatype: "json",
      data: { function: "CargarDataProducto", categoria: categoria_select },
      success: function (data) {
        var data_ = JSON.parse(data);
  
        if (data_.data.length == 0) {
          // si la lista esta vacia
          $("#producto").append(
            '<option value="0">' + "--No hay información--" + "</option>"
          );
        } else {
          $(data_.data).filter(function (i, n) {
            return n.CATEGORY == categoria_select;
          });
          $.each(data_.data, function () {
            $("#producto").append(
              '<option value="' +this.ID +
                '" data-precio="' +
                this.PRICEBUY +
                '">' +
                this.NAME +
                "</option>"
            );
          });

          OnchangeProducto();
        }
      },
    });
}

CargarDataCategoria();
function agregarProducto() {
   if ($("#tbDetalleProducto tbody tr").length == 1 && table_status == false) {
    $("#tbDetalleProducto tbody").empty();
    total=0;
  }
 

  if ($("#tbDetalleProducto tbody tr").length == 0) 
      i = 0;

  //obtener valores del pedido
  var categoria = $("#categoria option:selected").text();
  var producto = $("#producto option:selected").text();

  var idproducto = $("#producto option:selected").val();
  var idcategoria = $("#categoria option:selected").val();

  var cantidad = $("#cantidad").val();
  var precio = $("#precio").val();
  var descripcion = $("#descripcion").val();

   
  correlativo++;
  total_multiplicado=precio*cantidad;
  $("#tbDetalleProducto tbody").append(
    "<tr data-cantidad='"+cantidad+"' data-idproducto='"+idproducto+"' data-idcategoria='"+idcategoria+
        "' data-precio='"+precio+"' data-subtotal='"+total_multiplicado+"' data-descripcion='"+descripcion+"'><td>" +
        correlativo +
      "</td>" +
      "<td>" +
      categoria +
      "</td>" +
      "<td>" +
      producto +
      "</td>" +
      '<td style="text-align: center">'+
      cantidad +
      "</td>" +
      '<td style="text-align: right">S/'+
      precio +
      "</td>" +
      '<td style="text-align: center">' +
      total_multiplicado +
      "</td>" +
      "<td>" +
      descripcion +
      "</td>" +
      "<td>" +
      '<span class="fa fa-trash" aria-hidden="true" style="cursor:pointer;font-size:19px" onclick="confirmarAnulacionPedido($(this).parent().parent());" ></span>' +
      "</td>" +
      "</tr>"
  );

  table_status = true;

  $.each($('#tbDetalleProducto tbody > tr'), function () { 
    var td=$(this);
    var total_td=0;
    var cantidad_td=0;
    $.each($(td).children(), function (j,x) {
      if(j==3){//cantidad
        cantidad_td=parseFloat(x.innerText);
       }

      if(j==4){//precio    
         total_td=parseFloat((x.innerText).replace('S/','')); 
      }
    });
    total=total+(total_td *cantidad_td);
    $('#subtotal').text(total);

});


}

function confirmarAnulacionPedido(row) {
  Swal.fire({
    title: "Desea Eliminar la Fila?",
    text: "Eliminar la fila de la tabla",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Eliminar",
  }).then((result) => {
    if (result.isConfirmed) {
      correlativo--;
      $(row[0]).remove();
      total=0;
      $.each($('#tbDetalleProducto tbody > tr'), function () { 
        var td=$(this);
        var total_td=0;
        var cantidad_td=0;
        $.each($(td).children(), function (j,x) {
          if(j==3){//cantidad
            cantidad_td=parseFloat(x.innerText);
           }
    
          if(j==4){//precio        
             total_td=parseFloat((x.innerText).replace('S/','')); 
          }
        });
        total=total+(total_td *cantidad_td);
        $('#subtotal').text(total);
    
    });

    if($('#tbDetalleProducto tbody > tr').length==0){
      $('#subtotal').text(0);
      table_status = false;
      $("#tbDetalleProducto tbody").append(
        "<tr>" +'<td colspan="8" style="text-align: center;"> Presionar el boton Agregar Productos para obtener la informacion.</td>'+"</tr>"
      );
    } 
      Swal.fire(
        "Se elimino Correctamente!",
        "Se elimino el producto seleccionado.",
        "success"
      );
 
    }
  });
}



function RegistrarPedido(){
 
  $('#Guardar_tabla').prop('disabled', true).html('<span>Cargando...</span></div>');

  $('#Guardar_tabla').attr('disabled', 'disabled');

  if ($("#tbDetalleProducto tbody tr").length == 1 && table_status == false) {
    Swal.fire({
      icon: 'info',
      title: 'Ingresar un nuevo pedido'
     })
     return false;
  }
  var fechapedido=$('#fechapedido').val();
  total_pedidos_count=$("#tbDetalleProducto tbody tr").length;
     $.ajax({
        url: "./controller/pedidoController.php",
        type: "POST",
        datatype: "json",
        data: { 
          function: "InsertarProducto",
           total:total,
           total_pedidos:total_pedidos_count,
           fechapedido:fechapedido   
          },
        success: function (data) {
          var data_ = JSON.parse(data); 
          var prod_detall=[];
          $.each($('#tbDetalleProducto tbody > tr'), function () { 
            var tr=$(this); 
            $.each($(tr), function (j,x) {
              var detalle={
                idpedidodetalle:data_.data[0].idpedido,
                categoria: x.dataset.idcategoria,
                producto: x.dataset.idproducto ,
                cantidad:x.dataset.cantidad,
                precioU: x.dataset.precio,
                total: x.dataset.subtotal,
                descripcion:x.dataset.descripcion
              };

              prod_detall.push(detalle);
            }); 
          }); 
         
             $.ajax({
              url: "./controller/pedidoController.php",
              type: "POST",
              datatype: "json",
              data: { 
                function: "InsertarProductoDetalle",
                detalle_total:prod_detall
                },
              success: function (data) {  
                  $('#Guardar_tabla').prop('disabled', false).html('Procesar Compras');
                  $('#Guardar_tabla').removeAttr('disabled');
                  Swal.fire(
                    "Se Registro correctamente su pedido",
                    "se registro correctamente.",
                    "success"
                  );         
                  $("#tbDetalleProducto tbody").empty(); 
                  $("#tbDetalleProducto tbody ").append(
                    "<tr>" +'<td colspan="8" style="text-align: center;"> Presionar el boton Agregar Productos para obtener la informacion.</td>'+"</tr>"
                  );         
                  $('#subtotal').text(0);
                  table_status = false;

                  $('#descripcion').val('');
                  $('#cantidad').val(''); 
   
              },},JSON);  
           
         },
      },
      JSON
    ); 
}