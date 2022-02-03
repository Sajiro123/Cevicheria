var i = 0;
var correlativo = 0;
var table_status = false;
var total=0;
var array_img='http://localhost:8079/cevicheria/images/platos_pedido/';
var array_productos=[];
var Array_categoria=[];


var date = new Date()

var day = date.getDate()
var month = date.getMonth() + 1
var year = date.getFullYear()
var fecha="";

fecha = `${year}-${checkTime(month)}-${checkTime(day)}`
 

$.ajax({
    url: "./controller/pedidoController.php",
    type: "POST",
    datatype: "json",
    data: { function: "CargarDataProducto"},
    success: function (data) {
      var data_ = JSON.parse(data);
      array_productos=data_;
    },
  });



function CargarDataCategoria() {
  $.ajax(
    {
      url: "./controller/pedidoController.php",
      type: "POST",
      datatype: "json",
      data: "function=CargarDataCategoria",
      success: function (data) {
         var data_ = JSON.parse(data);
         Array_categoria=data_;
        $("#categoria").empty();
        if (data_.length == 0) {
          $("#categoria").append(
            '<option value="0">' + "--No hay información--" + "</option>"
          );
        } else {
          $.each(data_, function () {
              $('#idimagenes').prepend(            
                '<div class="col-md-2 col-xl-2 col-sm-2 col-lg-2 ">'+
                '<img src="'+array_img+this.url_imagen+'" class="img-thumbnail img-fluid" alt="Responsive image" width="300px" onclick="CargarDataProducto('+this.idcategoria+')" >'+
                '<h5 class="text-center">'+this.nombre+'</h5>'+
                '</div">'  
                ); 
          });
          // CargarDataProducto();
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

function CargarDataProducto(idcategoria,codigo=0,idarbol=0) { 

    if(codigo == 0){ 
        var each_imagenes = array_productos.filter(function (row) {
            return row.idcategoria == idcategoria && row.idarbol == 1;
        });
        if(each_imagenes.length >0){
          $('#idimagenes').empty();
        }

        $(each_imagenes).each(function() {    
          if(this.preciounitario){
            var data =JSON.stringify(this);  
            $('#idimagenes').prepend(            
              '<div class="col-md-2 col-xl-2 col-sm-2 col-lg-2 ">'+
              '<span style="display: none">'+data+'</span>'+
              '<img src="'+array_img+this.imagen+'" class="img-thumbnail img-fluid" alt="Responsive image" width="300px" onclick="agregarProducto($(this))" >'+
              '<h5 class="text-center">'+this.nombre+'</h5>'+
              '</div">'  
              ); 
          }else{
            $('#idimagenes').prepend(            
              '<div class="col-md-2 col-xl-2 col-sm-2 col-lg-2 ">'+
              '<img src="'+array_img+this.imagen+'" class="img-thumbnail img-fluid" alt="Responsive image" width="300px" onclick="CargarDataProducto('+this.idcategoria+','+this.codigo+','+this.idarbol+')" >'+
              '<h5 class="text-center">'+this.nombre+'</h5>'+
              '</div">'  
              ); 
          }
        

        });
    }else if(idarbol == 2 || idarbol == 1 ) {

      var each_imagenes = array_productos.filter(function (row) {
        return row.idtipoproducto == codigo;
      });
      if(each_imagenes.length >0){
        $('#idimagenes').empty();
      }

      $(each_imagenes).each(function() {    
        var data =JSON.stringify(this);        
        $('#idimagenes').prepend(            
          '<div class="col-md-2 col-xl-2 col-sm-2 col-lg-2 ">'+
          '<span style="display: none">'+data+'</span>'+
          '<img src="'+array_img+this.imagen+'" class="img-thumbnail img-fluid" alt="Responsive image" width="300px" onclick="agregarProducto($(this))" >'+
          '<h5 class="text-center">'+this.nombre+'</h5>'+
          '</div">'  
          ); 

      });
      
    }
}

CargarDataCategoria();
function agregarProducto(row) {
  var data= JSON.parse(($(row).parent().children('span'))[0].innerText);   

  var categoria_object = Array_categoria.filter(function (row) {
    return row.idcategoria == data.idcategoria;
  })[0];

   if ($("#tbDetalleProducto tbody tr").length == 1 && table_status == false) {
    $("#tbDetalleProducto tbody").empty();
    total=0;
  }
 
  if ($("#tbDetalleProducto tbody tr").length == 0) 
      i = 0;

   
  correlativo++;
  total_multiplicado=data.preciounitario*1;
  $("#tbDetalleProducto tbody").append(
    "<tr data-correlativo='"+correlativo+"' data-cantidad='1' data-idproducto='"+data.idproducto+"' data-idcategoria='"+categoria_object.idcategoria+"'"+
     "data-precio='"+data.preciounitario+"' data-subtotal='"+total_multiplicado+"'>"+
      "<td>" +correlativo +"</td>" +
      "<td>" + categoria_object.nombre + "</td>" +
      "<td>" + data.nombre +"</td>" +
      '<td style="text-align: center;" width="5%"><input type="number" style="text-align: center;height: 28px;" class="form form-control" value="1" onclick="cantidadPlatos(this)"/></td>' +
      '<td style="text-align: center">S/'+data.preciounitario +"</td>" +
      '<td style="text-align: center">' +total_multiplicado +"</td>" +      
      "<td>" +'<span class="fa fa-trash" aria-hidden="true" style="cursor:pointer;font-size:19px;color:red" onclick="confirmarAnulacionPedido($(this).parent().parent());" ></span>' +"</td>" +
      "</tr>"
  );

  table_status = true;
  total=0;

  actualizarPedido();


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
      actualizarPedido();

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

function cantidadPlatos(row){
  var idproducto=$($(row).parent().parent()).attr('data-idproducto'); 
  var preciounitario=$($(row).parent().parent()).attr('data-precio'); 
  var correlativo=$($(row).parent().parent()).attr('data-correlativo'); 

  
  var cantidad=parseInt(row.value);
  var total_multiplicado=0;
  var status=true;

  $.each($('#tbDetalleProducto tbody > tr'), function () { 
    if(status){
      if($(this).attr('data-idproducto') == idproducto  &&  $(this).attr('data-correlativo') == correlativo   ){
        total_multiplicado=preciounitario*cantidad;
  
        $.each($(this).children(), function (j,x) { 
          if(j==5){//total                
             this.innerText=parseFloat(total_multiplicado); 
             status=false;
          }
        }); 
  
      }
    }
       
});
   
   actualizarPedido();
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
  var total_=$('#subtotal').text();

  total_pedidos_count=$("#tbDetalleProducto tbody tr").length;
     $.ajax({
        url: "./controller/pedidoController.php",
        type: "POST",
        datatype: "json",
        data: { 
          function: "InsertarProducto",
           total:total_,
           total_pedidos:total_pedidos_count,
           fechapedido:fecha   
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
                  CargarDataCategoria();
              },},JSON);  
           
         },
      },
      JSON
    ); 
}

function actualizarPedido(){
  var total=0;

  
  $.each($('#tbDetalleProducto tbody > tr'), function () { 
    var td=$(this);
    var total_td=0;
    var cantidad_td=0;
    $.each($(td).children(), function (j,x) {
      if(j==3){//cantidad
        cantidad_td = $(this).children();      
        cantidad_td = parseInt($(cantidad_td).val());
       }

      if(j==4){//precio    
         total_td=parseFloat((x.innerText).replace('S/','')); 
      }
    }); 
    total=total+(total_td *cantidad_td);
    $('#subtotal').text(total);

});
}


function checkTime(i) {
  if (i < 10) {
      i = "0" + i;
  }
  return i;
}