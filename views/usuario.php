<script type="text/javascript" src="./js/page_js/nuevousuario.js"></script> 
 

<style>
    .table tbody tr.highlight td {
  background-color: #ddd;
}
</style> 
 <div class="modal-body float-right">
                    <div class="btn-group btn-group-rounded-20"> 
                        <a   class="btn btn-sm btn-secondary ng-scope"    onclick="editarUsuario()" ><i class="fa fa-pencil"></i>
                            Editar</a>
                       <a   class="btn btn-sm btn-secondary ng-scope" href="?page=nuevousuario"><i class="fa fa-plus"></i> Nuevo</a><!-- end ngIf: tokenPayload.myperfilnuevo === '1' -->
                       <a href="javascript:;" class="btn btn-sm btn-secondary ng-scope"  onclick="EliminarUsuario()" style=""><i class="fa fa-trash-o"></i>
                            Eliminar </a>
                    </div>
                </div>
 <div class="container" style="max-width: 1370px;"> 

<br/>
        <h4 class="text-center ml-5 mb-1 ">Personas</h4>
        <br/>
         <input type="text" class="form-control mb-3 tablesearch-input" data-tablesearch-table="#data-table" placeholder="Buscar Persona">

        <div class="table-responsive" style="height:500px">

            <table id="data-table" class="table table-bordered  tablesearch-table table-sm  ">
                <thead class="thead-dark">
                    <tr>
                        <th>N°</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Nombres</th>
                        <th>Perfil</th> 
                        <th>Tipo Documento</th>
                        <th>N° Documento</th>
                        <th>Email</th>
                        <th>N° Celular</th>
                        <th>Nacimiento</th>
                        <th>Nombres </th> 
                    </tr>
                </thead>
                <tbody> 
                    <tr>
                        <td colspan="10" > No existe información</td>
                    </tr>
                </tbody>
            </table>
        </div>

 <script>
     function seleccionaFila(elementFila) {
        $.each($('#data-table tbody > tr'), function () {
            $(this).css('background-color', '');    
        });
        elementFila.css('background-color', '#17a2b838');
    }

    function editarUsuario(){
        var status=false;
         $.each($('#data-table tbody > tr'), function () {
            if(this.style.backgroundColor){ 
                 var idusuario=parseInt($(this).attr('data-idpersona'));
                status=true;

                var link=document.createElement("a");
                link.href="?page=editarusuario&idusuario="+idusuario;
                link.click();
            }
              
        });
        if(status==false){
            Swal.fire({
                icon: 'info',
                title: "Seleccionar usuario para editar",
                showConfirmButton: false,
                timer: 2000
            });
        } 
    }

    function EliminarUsuario(){
        var status=false;
         $.each($('#data-table tbody > tr'), function () {
            if(this.style.backgroundColor){ 
                 var idusuario=parseInt($(this).attr('data-idpersona'));
                status=true; 


                Swal.fire({
                text: "Estas seguro que deseas elimnar el registro ?",
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "./controller/nuevoPersonaController.php",
                        type: "POST",
                        datatype: "json",
                        data: {
                            function: "EliminarPersona",
                            idpersona:idusuario
                        },                        
                        success: function (result) { 
                            Swal.fire({
                                icon: 'success',
                                title: 'Se elimino correctamente usuario',
                                showConfirmButton: false,
                                timer: 2500
                            });

                            setTimeout(function(){
                            window.location.reload(1);
                            }, 1500);
                        }
                    }, JSON);
               }
    });
                 
            }
              
        });
        if(status==false){
            Swal.fire({
                icon: 'info',
                title: "Seleccionar usuario para editar",
                showConfirmButton: false,
                timer: 2000
            });
        } 
    }
    

    </script>