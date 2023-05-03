 var array_productos=[];

function AbrirModal() {
    $("#exampleModal").modal("show");
}

function CargarProducto(valor='',tipo=''){

  $('#idProductoTable tbody').empty();
  $.ajax({
    url: "./controller/pedidoController.php",
    type: "POST",
    datatype: "json",
    data: { 
      function: "CargarDataProducto",
      valor:valor,
      tipo:tipo
  },
    success: function (data) {
     
      var data_ = JSON.parse(data);
      array_productos=data_;
      var strHTML="";
      var i= 0;
      if (data_.length <= 0) {
              strHTML += '<tr><td colspan="100" class="text-left" style="padding-left: 15%">No hay información para mostrar</td></tr>';

          } else {

              $.each(data_, function () { 
                if(this.preciounitario == null)
                    return;
                i++;
                  strHTML += '<tr  onclick="seleccionaFila($(this))">'+
                      '<td class="text-center" style="font-size: 15px">' + i + '</td>' + 
                      '<td class="text-center" style="font-size: 15px" >' + this.nombre + '</td>' + 
                      '<td class="text-center" style="font-size: 15px">' + this.preciounitario + '</td>' + 
                      '<td class="text-center" style="font-size: 15px">' + this.codigo + '</td>' + 
                      '<td class="text-center" style="font-size: 15px">' + this.categoria + '</td>' + 

                      '</tr>';

              });

          }
           $('#idProductoTable tbody').append(strHTML);

    },
  });
}

function CargarDataCategoria() {
  $('#idregresar').css('display', 'none')
  $('#idloader').css('display', 'block') 
  
    $.ajax(
      {
        url: "./controller/pedidoController.php",
        type: "POST",
        datatype: "json",
        data: "function=CargarDataCategoria",
        success: function (data) {
          CargarProducto();
           var data_ = JSON.parse(data);
           Array_categoria=data_;
          $("#categoria").empty();
          if (data_.length == 0) {
            $("#categoria").append(
              '<option value="0">' + "--No hay información--" + "</option>"
            );
          } else {
            $('#idcategoria').empty();
  
            $.each(data_, function () {
                $('#idcategoria').prepend('<option value="'+this.idcategoria+'">'+this.nombre+'</option>'); 
                $('#seltected_categoria').prepend('<option value="'+this.idcategoria+'">'+this.nombre+'</option>'); 

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

function FiltrarDataCategoria(){
 var valor= $('#seltected_categoria').val(); 
 CargarProducto(valor,'p.idcategoria');
}


function seleccionaFila(elementFila) {
  $.each($('#idProductoTable tbody > tr'), function () {
      $(this).css('background-color', '');    
  });
  elementFila.css('background-color', '#17a2b838');
}


$(document).ready(function() {
  CargarDataCategoria()



  $('#idcreate').append(
      '<button type="submit" class="btn btn-sm btn-danger" data-toggle="modal" onclick="AbrirModal()"> Nuevo producto</button>'
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
 