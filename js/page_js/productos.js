function CargarDataCategoria() {
    $('#idregresar').css('display', 'none')

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
              $('#idcategoria').empty();
    
              $.each(data_, function () {
                  $('#idcategoria').prepend('<option value="'+this.idcategoria+'">'+this.nombre+'</option>'); 
              });
            }
          },
        },
        JSON
      ); 
  }

CargarDataCategoria()


function AgregarTipoProducto(){
 
  //  if ($('#checknivel2').is(':checked')) { 
  //   $('#labelcoditotipoprod').removeAttr('style');
  //   $('#idcoditotipoprod').removeAttr('style');
    
  // }else{
  //   $('#labelcoditotipoprod').css('display','none');
  //   $('#idcoditotipoprod').css('display','none');
  // } 
}
 