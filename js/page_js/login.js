$(document).ready(function() {
    $('#botontext').html("Iniciar Sesión");
    $("#user").focus();
});


function Enviar() {
debugger;
    $('#diverror').slideUp("fast");
    $('#divinfo').slideUp("fast");
    $('#divinfo2').slideUp("fast");

    if ($('#user').val() == '') {
        $('#diverror').slideUp("fast");
        $('#divinfo').slideDown("fast");
        $('#divinfo2').slideUp("fast");
    } else if ($('#pass').val() == '') {
        $('#diverror').slideUp("fast");
        $('#divinfo').slideUp("fast");
        $('#divinfo2').slideDown("fast");
    } else {
        $('#loading').css('display', 'block')

        $.ajax({
            url: './access.php',
            type: 'POST',
            data: $('#form_login').serialize(),
            success: function(data) {
                $('#loading').css('display', 'none')

                //alert(data);
                //return false;
                if (data * 1 == '1') {
                    $('#diverror').slideUp("fast");
                    $('#divinfo').slideUp("fast");
                    $('#divinfo2').slideUp("fast");
                    location.href = "./";
                } else {

                    $('#diverror').slideDown("fast");
                    $('#divinfo').slideUp("fast");
                    $('#divinfo2').slideUp("fast");
                }
                //alert(data);
            }
        });
    }
};

function validateEnter(e) {
    var key = e.keyCode || e.which;
    if (key == 13) {
        return true;
    } else {
        return false;
    }
}