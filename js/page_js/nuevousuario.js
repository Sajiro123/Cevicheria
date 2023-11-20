$(document).ready(function() {
    CargarPersona();
    // $('#data-table').on('click', 'tbody tr', function(event) {
    //     $(this).addClass('highlight').siblings().removeClass('highlight');
    // });
});

//table 


//Cargar datos al cargar el Modal de modificar
function CargarPersona() {
    $('#data-table tbody ').empty();
    $.ajax({
            url: "./controller/nuevoPersonaController.php",
            type: "POST",
            datatype: "json",
            data: {
                function: "CargarPersona"
            },
            success: function(data) {
                var result = JSON.parse(data);
                var i = 0;
                var strHTML = ''
                if (result.length <= 0) {
                    strHTML += '<tr><td colspan="10" class="text-left" style="padding-left: 15%">No hay información para mostrar</td></tr>';

                } else {

                    $.each(result, function() {
                        switch (this.idtipodoc) {
                            case "1":
                                this.idtipodoc = "DNI"
                                break;
                            case "2":
                                this.idtipodoc = "CARNET EXTRA."
                                break;
                        }
                        switch (this.idperfil) {
                            case "1":
                                this.idperfil = "Cocinero"
                                break;
                            case "2":
                                this.idperfil = "Mozo"
                                break;
                            case "3":
                                this.idperfil = "caja"
                                break;
                        }
 

                        i++;
                        strHTML += '<tr onclick="seleccionaFila($(this))" data-idpersona="'+this.idpersona+'">' +
                            '<td class="text-center" >' + i + '</td>' +
                            '<td class="text-center" >' + (this.apellidomat == null ? "" : this.apellidomat) + '</td>' +
                            '<td class="text-center" >' + (this.apellidopat == null ? "" : this.apellidopat) + '</td>' +
                            '<td class="text-center" >' + (this.nombres == null ? "" : this.nombres) + '</td>' +
                            '<td class="text-center" >' + (this.idperfil == null ? "" : this.idperfil) + '</td>' + 
                            '<td class="text-center" >' + (this.idtipodoc == null ? "" : this.idtipodoc) + '</td>' +
                            '<td class="text-center" >' + (this.numerodoc == null ? "" : this.numerodoc) + '</td>' +
                            '<td class="text-center" >' + (this.email == null ? "" : this.email) + '</td>' +
                            '<td class="text-center" >' + (this.numerocel == null ? "" : this.numerocel) + '</td>' +
                            '<td class="text-center" >' + (this.fechanacimiento == null ? "" : this.fechanacimiento) + '</td>' +
                            '<td class="text-center" >' + (this.completo == null ? "" : this.completo) + '</td>' +
                            '</tr>';
                    });

                }
                $('#data-table tbody').append(strHTML);
                var s = document.createElement("script");
                s.type = "text/javascript";
                s.src = "js/jquery/auto-tables.js";
                $("head").append(s);

                var headers = $('#data-table thead th');
                $(headers[5]).attr('data-tablesort-type', 'date');
                $('table').not(".tablesort").addClass('tablesort');

            },
        },
        JSON
    );
}

    function checkReqFields() { 
        $('#reqapellidopat').text('');
        $('#reqapellidomat').text('');
        $('#reqnombres').text('');
        $('#reqnumerodoc').text('');
        $('#reqpassword').text('');

    
        if ($('#apellidopat').val().trim() == "") {document.getElementById("reqapellidopat").innerHTML = "* Apellido paterno es obligatorio.";$('#apellidopat').focus();return false;} 
        if ($('#apellidomat').val().trim() == "") {document.getElementById("reqapellidomat").innerHTML = "* Apellido materno es obligatorio.";$('#apellidomat').focus();return false;} 
        if ($('#nombres').val().trim() == "") {document.getElementById("reqnombres").innerHTML = "* nombres es obligatorio.";$('#nombres').focus();return false;} 
        if ($('#numerodoc').val().trim() == "") {document.getElementById("reqnumerodoc").innerHTML = "* numero documento es obligatorio.";$('#numerodoc').focus();return false;} 

        $('#pills-tab li:nth-child(2) a').tab('show')
        
        $('#usuario').val($('#numerodoc').val());
    }



 

$("#form").on('submit', function(e) {

     if ($('#password').val().trim() == "") {document.getElementById("reqpassword").innerHTML = "* La contraseña es obligatorio.";$('#password').focus();return false;} 

    var form=$(this);

    e.preventDefault();
    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize()
      }).done(function(data) {
        var result = JSON.parse(data);

       
        $.each(result, function() { 
            if(this.status){
             Swal.fire({
                icon: 'error',
                title: this.status,
                showConfirmButton: false,
                timer: 1500
            });

            return false;
            }

            Swal.fire({
                icon: 'success',
                title: "Se registro correctamente el usuario",
                showConfirmButton: false,
                timer: 2000
            });

            setTimeout(function(){
                window.location.href="?page=usuario";
            },1500);

        });

         
          console.log('data');
        // Optionally alert the user of success here...
      }).fail(function(data) {
        // Optionally alert the user of an error here...
      });
});
 

