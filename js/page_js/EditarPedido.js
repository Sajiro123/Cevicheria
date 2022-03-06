var i = 0;
var correlativo = 0;
var table_status = false;
var total=0;
var array_img='images/platos_pedido/';
var array_productos=[];
var Array_categoria=[];


var date = new Date()

var day = date.getDate()
var month = date.getMonth() + 1
var year = date.getFullYear()
var fecha="";


var IDCATEGORIA_GLOBAL;
var CODIGO_GLOBAL;
var IDARBOL_GLOBAL;
var STATUS_PEDIDO=0;

fecha = `${year}-${checkTime(month)}-${checkTime(day)}`
 

$.ajax({
    url: "./controller/pedidoController.php",
    type: "POST",
    datatype: "json",
    data: { function: "CargarDataProducto"},
    success: function (data) {
      var data_ = JSON.parse(data);
      array_productos=data_;
      ListarPedido();
    },
  });



function CargarDataCategoria() {
  $('#idregresar').css('display', 'none')
  STATUS_PEDIDO=0;
  if(Array_categoria.length >0){
    
    $('#idimagenes').empty();
  
    $.each(Array_categoria, function () {
        $('#idimagenes').prepend(            
          '<div class="col-md-4 col-xl-2 col-sm-2 col-lg-2 ">'+
          '<img src="'+array_img+this.url_imagen+'" class="img-thumbnail img-fluid" alt="Responsive image" width="300px" onclick="CargarDataProducto('+this.idcategoria+')" >'+
          '<h5 class="text-center">'+this.nombre+'</h5>'+
          '</div">'  
          ); 
    });

  }else{
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
            $('#idimagenes').empty();
  
            $.each(data_, function () {
                $('#idimagenes').prepend(            
                  '<div class="col-md-4 col-xl-2 col-sm-2 col-lg-2 ">'+
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
  
}
function OnchangeProducto() {
   var precio =  $("#producto option:selected").attr('data-precio');
  $("#precio").val(precio);
}

function RegresarProducto(){ 
  if(STATUS_PEDIDO==1){
    CargarDataCategoria();
    return;
  }else if(STATUS_PEDIDO>0){
    STATUS_PEDIDO--;
  }
  
  debugger; 
 var idcategoria=IDCATEGORIA_GLOBAL
 var codigo =CODIGO_GLOBAL
 var idarbol =IDARBOL_GLOBAL;

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
          '<div class="col-md-4 col-xl-2 col-sm-2 col-lg-2 ">'+
          '<span style="display: none">'+data+'</span>'+
          '<img src="'+array_img+this.imagen+'" class="img-thumbnail img-fluid" alt="Responsive image" width="300px" onclick="agregarProducto($(this))" >'+
          '<h5 class="text-center">'+this.nombre+'</h5>'+
          '</div">'  
          ); 
      }else{
        $('#idimagenes').prepend(            
          '<div class="col-md-4 col-xl-2 col-sm-2 col-lg-2 ">'+
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
      '<div class="col-md-4 col-xl-2 col-sm-2 col-lg-2 ">'+
      '<span style="display: none">'+data+'</span>'+
      '<img src="'+array_img+this.imagen+'" class="img-thumbnail img-fluid" alt="Responsive image" width="300px" onclick="agregarProducto($(this))" >'+
      '<h5 class="text-center">'+this.nombre+'</h5>'+
      '</div">'  
      ); 

  });
  
}

}

function CargarDataProducto(idcategoria,codigo=0,idarbol=0) { 
  STATUS_PEDIDO++;

  if(STATUS_PEDIDO==1){
    IDCATEGORIA_GLOBAL=idcategoria;
    CODIGO_GLOBAL=codigo;
    IDARBOL_GLOBAL=idarbol;
  }


    if(codigo == 0){ 
        var each_imagenes = array_productos.filter(function (row) {
            return row.idcategoria == idcategoria && row.idarbol == 1;
        });
        if(each_imagenes.length >0){
          $('#idimagenes').empty();
          $('#idregresar').css('display', 'block')
        }

        $(each_imagenes).each(function() {    
          if(this.preciounitario){
            var data =JSON.stringify(this);  
            $('#idimagenes').prepend(            
              '<div class="col-md-4 col-xl-2 col-sm-2 col-lg-2 ">'+
              '<span style="display: none">'+data+'</span>'+
              '<img src="'+array_img+this.imagen+'" class="img-thumbnail img-fluid" alt="Responsive image" width="300px" onclick="agregarProducto($(this))" >'+
              '<h5 class="text-center">'+this.nombre+'</h5>'+
              '</div">'  
              ); 
          }else{
            $('#idimagenes').prepend(            
              '<div class="col-md-4 col-xl-2 col-sm-2 col-lg-2 ">'+
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
          '<div class="col-md-4 col-xl-2 col-sm-2 col-lg-2 ">'+
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
      '<td style="text-align: center;" width="5%">'+
      '<div class="number-input">'+
      "<button  onclick='sumarinput(this)'><i class='fa fa-plus'></i></button>"+
      '<input  min="0" name="quantity"  type="number" value="1" style="text-align: center;height: 28px;" class="quantity"  />'+ 
      "<button  onclick='restarinput(this)'.stepUp()\"><i class='fa fa-minus'></i></button>"+
      '  </div>'+      '<td style="text-align: center">S/'+data.preciounitario +"</td>" +
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
    icon: "error",
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
  debugger;
  var idproducto=$($($(row).parent().parent().parent('tr'))[0]).attr('data-idproducto'); 
  var preciounitario=$($($(row).parent().parent().parent('tr'))[0]).attr('data-precio'); 
  var correlativo=$($($(row).parent().parent().parent('tr'))[0]).attr('data-correlativo');  
  
  var cantidad=parseInt(row.value); 
  actualizarCantidad(idproducto,correlativo,preciounitario,cantidad);   
  actualizarPedido();
}

function EditarPedido(){
 
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
  var mesas= $('#idmesas').val();
  var idpedido= $('#idpedido').val();

  total_pedidos_count=$("#tbDetalleProducto tbody tr").length;
     $.ajax({
        url: "./controller/pedidoController.php",
        type: "POST",
        datatype: "json",
        data: { 
          function: "EditarProducto",
           idpedido:idpedido,
           total:total_,
           total_pedidos:total_pedidos_count,
           fechapedido:fecha,
           mesa:mesas
          },
        success: function (data) {
          
          var prod_detall=[];

          $.each($('#tbDetalleProducto tbody > tr'), function () { 
            var tr=$(this); 
            $.each($(tr), function (j,x) {
              debugger;
              var cantidadtd=$(x).children()[3];
              var cantidadval=($(cantidadtd).children().children('input')).val();

              var totaltd=$(x).children()[5];
              totaltd=totaltd.innerText;

              
              var detalle={
                idpedido:idpedido,
                categoria: x.dataset.idcategoria,
                producto: x.dataset.idproducto ,
                cantidad:cantidadval,
                precioU: x.dataset.precio,
                total: totaltd,
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
                function: "EditarProductoDetalle",
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
        debugger;
        cantidad_td = $(this).children().children('input');      
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

function ListarPedido(){
  $('#tbDetalleProducto tbody').empty();  

  var idpedido= $('#idpedido').val();
  table_status=true;
    $.ajax({
    url: "./controller/pedidoController.php",
    type: "POST",
    datatype: "json",
    data: { 
      function: "ReporteProductoDetalle",
      idpedido:idpedido, 
      },
    success: function (data) {  
      var result = JSON.parse(data); 
      var i=0;
       var strHTML=''
      if (result.length <= 0) {
        strHTML += '<tr><td colspan="100" class="text-left" style="padding-left: 15%">No hay información para mostrar</td></tr>';

      } else {

        $.each(result, function () { 
                  correlativo++
          strHTML += 
          "<tr data-correlativo='"+correlativo+"' data-cantidad='1' data-idproducto='"+this.idproducto+"' data-idcategoria='"+this.idcategoria+"'"+
          "data-precio='"+this.precioU+"' data-subtotal='"+this.total+"'>"+

          '<td class="text-center" >'+correlativo+'</td>' +  
          '<td class="text-center" >' + (this.categoria == null ? "" : this.categoria) + '</td>' + 
            '<td class="text-center" >' + (this.nombre == null ? "" : this.nombre) + '</td>' +
            '<td style="text-align: center;" width="5%">'+
            '<div class="number-input">'+
            "<button  onclick='sumarinput(this)'><i class='fa fa-plus'></i></button>"+
            '<input  min="0" name="quantity"  type="number" value="'+this.cantidad+'" style="text-align: center;height: 28px;" class="quantity"  />'+ 
            "<button  onclick='restarinput(this)'.stepUp()\"><i class='fa fa-minus'></i></button>"+
            '  </div>'+
            '  </td>' +  
            '<td class="text-center" >' + (this.precioU == null ? "" : this.precioU) + '</td>' +
            '<td class="text-center" >' + (this.total == null ? "" : this.total) + '</td>' +  
            "<td>" +'<span class="fa fa-trash" aria-hidden="true" style="cursor:pointer;font-size:19px;color:red" onclick="confirmarAnulacionPedido($(this).parent().parent());" ></span>' +"</td>" +
            '</tr>';

        });

      }
      $('#tbDetalleProducto tbody').append(strHTML);
      actualizarPedido();

     },
    },
    JSON
  ); 

}

function sumarinput(row){
   var status=parseInt($(row).parent().children('input')[0].value) + 1;
  $(row).parent().children('input')[0].value=status;
  cantidadPlatos($(row).parent().children('input')[0]);
}
function restarinput(row){
  var status=parseInt($(row).parent().children('input')[0].value) - 1;
  $(row).parent().children('input')[0].value=status;
  cantidadPlatos($(row).parent().children('input')[0]);

}

function actualizarCantidad(idproducto,correlativo,preciounitario,cantidad){
  var status=true;
  var total_multiplicado=0;
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
}

function checkTime(i) {
  if (i < 10) {
      i = "0" + i;
  }
  return i;
}