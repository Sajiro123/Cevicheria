var array_productos = [];
var array_productos_opciones = [];
var OPCIONES_PRODUCTO = [];
var OPCIONES_PRODUCTO_temp= [];

  
$(function() {
    Opciones_Producto();
    //hang on event of form with id=myform
    $("#form").submit(function(e) { 
        $('#id_button_productos').attr('disabled', 'disabled');
        //prevent Default functionality
        e.preventDefault();

        var array_opciones=[];
        //get the action-url of the form
        var actionurl = e.currentTarget.action;
        var form = $(e.target);
        var json = convertFormToJSON(form);
        
        if ($('#checknivel2').is(':checked')) {
            json.idarbol = 1;
        }


        $.each($('#html_opciones div'), function () { 
            $aqui= $($(this).children().children('input')[0]).val();
            if($aqui)
                array_opciones.push($aqui);
        });
        json.array_opciones=array_opciones;
 
        setTimeout(function(){
            location.reload(); 
        }, 1000);

        
        //do your own request an handle the results
        $.ajax({
                url: actionurl,
                type: 'post',
                dataType: 'application/json',
                data: {
                    data: json
                },
                success: function(data) {
                 }
        });

    });

});



function Opciones_Producto() {
    $.ajax({
      url: "./controller/productoController.php",
      type: "POST",
      datatype: "json",
      data: { function: "Opciones_Producto" },
      success: function (data) {
        var data_ = JSON.parse(data);
        OPCIONES_PRODUCTO = data_;
      },
    });
  }


function CrearOpciones(){ 
    var status = $('#modaltexto').text();

    if(status != "Editar Producto"){
        $('#html_opciones').append('<div class="row">'+
        '<label class="col-sm-4 col-xs-6 control-label text-theme" style="text-align: center;margin-top: 12px;">Nombre</label>'+
        '<div class="col-sm-8 col-xs-6">'+
        '<input type="text" class="form-control vacios"  value=""'+
        'required />'+
        '</div>'+
        '</div><br/>');
    }else{

        $('#html_opciones').append('<br/><div class="row">'+
        '<label class="col-sm-3 col-xs-6 control-label text-theme" style="text-align: center;margin-top: 12px;">Nombre</label>'+
        '<div class="col-sm-7  col-xs-6">'+
        '<input type="text" class="form-control vacios"  value="" required/>'+
         '</div><div class="col-sm-2">'+
        '<span class="fa fa-trash custom-cursor-on-hover" aria-hidden="true" style="cursor:pointer;font-size:30px;color:red" onclick="EliminarOpciones($(this).parent().parent());"></span> </div>'+
        '</div><br/>');  
    }
    

}

function EliminarOpciones(row){
 row.remove();
}

function CargarProducto(valor = '', tipo = '') {

    $.ajax({
        url: "./controller/pedidoController.php",
        type: "POST",
        datatype: "json",
        data: {
            function: "CargarDataProducto",
            valor: valor,
            tipo: tipo
        },
        success: function(data) {

            var data_ = JSON.parse(data);
            array_productos = data_;
            var strHTML = "";
            var i = 0;
            if (tipo == '' || tipo == "p.idcategoria") {
                if (data_.length <= 0) {
                    strHTML += '<tr><td colspan="100" class="text-left" style="padding-left: 15%">No hay información para mostrar</td></tr>';

                } else {
                    $('#idProductoTable tbody').empty();

                    $.each(data_, function() {
                        if (this.preciounitario == null)
                            return;
                        i++;
                        strHTML += '<tr onclick="seleccionaFila($(this))">' +
                            '<td class="text-center" style="font-size: 15px">' + i + '</td>' +
                            '<td class="text-center" style="font-size: 15px" >' + this.nombre + '</td>' +
                            '<td class="text-center" style="font-size: 15px">' + this.preciounitario + '</td>' +
                            '<td class="text-center" style="font-size: 15px">' + this.codigo + '</td>' +
                            '<td class="text-center" style="font-size: 15px">' + this.categoria + '</td>' +
                            '<td><i onclick="Editarproducto(' + this.idproducto + ')" class="fas fa-pencil-alt" style="font-size: 18px;" aria-hidden="true"></i></td>'+
                            '<td><i onclick="Eliminar_Producto(' + this.idproducto + ')" class="fas fa-trash-alt" style="font-size: 18px;" aria-hidden="true"></i></td>' 
                        '</tr>';

                    });

                }
                $('#idProductoTable tbody').append(strHTML);
            } else {
                $('#nombre').val(array_productos[0].nombre);
                $('#codigo').val(array_productos[0].codigo);
                $('#idcategoria').val(array_productos[0].idcategoria);
                $('#precio').val(array_productos[0].preciounitario);
                $('#acronimo').val(array_productos[0].acronimo);
                $('#idtipoproducto').val(array_productos[0].idtipoproducto);
                $('#idproductoeditar').val(array_productos[0].idproducto);
                if (array_productos[0].idarbol == 2)
                    $('#checknivel2').prop('checked', true);
            }
        },

    });
}

function Editarproducto(idproducto) {
    $('#html_opciones').empty();

    
    OPCIONES_PRODUCTO_temp = OPCIONES_PRODUCTO.filter(function (row) {
             return (row.idproducto == idproducto);
    });
    var nombre ="alex"

        var i=0;
        $.each(OPCIONES_PRODUCTO_temp, function() { 
            var id_input='nombre_'+i;
            $('#html_opciones').append('<br/><div class="row">'+
            '<label class="col-sm-3 col-xs-6 control-label text-theme" style="text-align: center;margin-top: 12px;">Nombre</label>'+
            '<div class="col-sm-7  col-xs-6">'+
            '<input type="text" class="form-control vacios" id="'+id_input+'" data-text="'+this.nombre+'" />'+
             '</div><div class="col-sm-2">'+
            '<span class="fa fa-trash custom-cursor-on-hover" aria-hidden="true" style="cursor:pointer;font-size:30px;color:red" onclick="EliminarOpciones($(this).parent().parent());"></span> </div>'+
            '</div><br/>');  
            i++; 

         }); 
    
    $('#imageUploadForm').removeAttr('required');
    CargarProducto(idproducto, 'p.idproducto');
    $('#checknivel2').prop('checked', false);
    $('input').val('');
    $('#modaltexto').text('Editar Producto');
    $('#form').attr('action', './controller/productoController.php?function=EditarProducto')
    $("#exampleModal").modal("show");
    $.each($('#html_opciones div > div > input'), function() {
        $texto=$(this).attr('data-text');
        this.value = $texto
    });

}

 
function Eliminar_Producto(idproducto) {

  Swal.fire({
    title: 'Deseas Eliminar el producto?',
    showDenyButton: true,
    showCancelButton: true,
    confirmButtonText: 'Yes',
    denyButtonText: 'No',
    customClass: {
      actions: 'my-actions',
      cancelButton: 'order-1 right-gap',
      confirmButton: 'order-2',
      denyButton: 'order-3',
    }
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "./controller/productoController.php",
        type: "POST",
        datatype: "json",
        data: {
            function: "Eliminar_Producto",
            valor: idproducto
        },
        success: function(data) { 
          Swal.fire('Se elimino Correctamente!', '', 'success') 
          CargarProducto();
        }

    });

    } else if (result.isDenied) {
      Swal.fire('Ningun cambio se realizo', '', 'info')
    }
  })


   

}

function RegistrarProducto() {
    $('#html_opciones').empty();
    $("#opcion_show").css("display","none")
    $('#imageUploadForm').attr('required', 'required');
    $('#checknivel2').prop('checked', false);
    $('input').val('');
    $('#modaltexto').text('Nuevo Producto');
    $('#form').attr('action', './controller/productoController.php?function=AgregarProductos')
    $("#exampleModal").modal("show");
}

function CargarDataCategoria() {
    $('#idregresar').css('display', 'none')
    $('#idloader').css('display', 'block')

    $.ajax({
            url: "./controller/pedidoController.php",
            type: "POST",
            datatype: "json",
            data: "function=CargarDataCategoria",
            success: function(data) {
                CargarProducto();
                var data_ = JSON.parse(data);
                Array_categoria = data_;
                $("#categoria").empty();
                if (data_.length == 0) {
                    $("#categoria").append(
                        '<option value="0">' + "--No hay información--" + "</option>"
                    );
                } else {
                    $('#idcategoria').empty();

                    $.each(data_, function() {
                        $('#idcategoria').prepend('<option value="' + this.idcategoria + '">' + this.nombre + '</option>');
                        $('#seltected_categoria').prepend('<option value="' + this.idcategoria + '">' + this.nombre + '</option>');

                    });
                }
                $('#seltected_categoria').append('<option selected value="">--Seleccionar--</option>');

                $('#idloader').css('display', 'none')
                $('#idcard').css('display', 'block')

            },
        },
        JSON
    );
}

function FiltrarDataCategoria() {
    var valor = $('#seltected_categoria').val();
    CargarProducto(valor, 'p.idcategoria');
}


function seleccionaFila(elementFila) {
    $.each($('#idProductoTable tbody > tr'), function() {
        $(this).css('background-color', '');
    });
    elementFila.css('background-color', '#17a2b838');
}


$(document).ready(function() {
    CargarDataCategoria()



    $('#idcreate').append(
        '<button type="submit" class="btn btn-sm btn-danger" data-toggle="modal" onclick="RegistrarProducto()"> Nuevo producto</button>'
    )

    $(".search").keyup(function() {
        var searchTerm = $(".search").val();
        var listItem = $('.results tbody').children('tr');
        var searchSplit = searchTerm.replace(/ /g, "'):containsi('")

        $.extend($.expr[':'], {
            'containsi': function(elem, i, match, array) {
                return (elem.textContent || elem.innerText || '').toLowerCase().indexOf((
                    match[3] || "").toLowerCase()) >= 0;
            }
        });

        $(".results tbody tr").not(":containsi('" + searchSplit + "')").each(function(e) {
            $(this).attr('visible', 'false');
        });

        $(".results tbody tr:containsi('" + searchSplit + "')").each(function(e) {
            $(this).attr('visible', 'true');
        });

        var jobCount = $('.results tbody tr[visible="true"]').length;
        $('.counter').text(jobCount + ' item');

        if (jobCount == '0') {
            $('.no-result').show();
        } else {
            $('.no-result').hide();
        }
    });
});
function convertFormToJSON(form) {
    return $(form)
      .serializeArray()
      .reduce(function (json, { name, value }) {
        json[name] = value;
        return json;
      }, {});
  }