 

<style>
    .nav-pills .nav-link.active,
    .nav-pills .show > .nav-link {
        background-color: #0c3968;
    }
    .table > tbody > tr > td,
    .table > tbody > tr > th,
    .table > tfoot > tr > td,
    .table > tfoot > tr > th,
    .table > thead > tr > td,
    .table > thead > tr > th {
        padding: 8px;
        line-height: 1.42858;

        color: #616f77;
        font-size: 14px;
        font-weight: 600;
    }
    .reqError{
        color: red;
    font-weight: 700;
    }
</style>
<div class="modal-body">
    <blockquote class="blockquote">
        <p class="mb-0" style="font-weight: 600;">Nuevo Usuario</p>
    </blockquote>
    <hr />
    <ul class="nav nav-pills mt-3 border" id="pills-tab" role="tablist" style="background-color: #00488f; font-size: 16px;">
        <li class="nav-item">
            <a style="color: white;" class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Información General</a>
        </li>
        <li class="nav-item">
            <a style="color: white;" class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Usuario / Acceso</a>
        </li>
    </ul>
    <form id="form" action="./controller/nuevoPersonaController.php?function=AgregarPersona" method="post"  >
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active border modal-body" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">


                <!-- INFORMACION GENERAL -->
                <div class="row mt-1">
                    <label class="col-sm-2 col-xs-6 text-primary">Apellido Paterno: <span class="asterisk">*</span></label>
                    <div class="col-sm-4 col-xs-6">
                        <input type="text" name="apellidopat" id="apellidopat" class="form-control form-control-sm" aria-invalid="false"  />
                        <span id="reqapellidopat" class="reqError"></span><br />

                    </div>
                    <label class="col-sm-2 col-xs-6 text-primary ng-scope">Apellido Materno: <span class="asterisk">*</span></label>
                    <div class="col-sm-4 col-xs-6">
                        <input type="text" name="apellidomat" id="apellidomat" class="form-control form-control-sm" aria-invalid="false" />
                        <span id="reqapellidomat" class="reqError"></span><br />

                    </div>
                </div>
                <div class="row mt-1">
                    <label class="col-sm-2 col-xs-6 text-primary">Nombres: <span class="asterisk">*</span></label>
                    <div class="col-sm-4 col-xs-6">
                        <input type="text" name="nombres"   id="nombres" class="form-control form-control-sm" aria-invalid="false" />
                        <span id="reqnombres" class="reqError"></span><br />

                    </div>
                    <label class="col-sm-2 col-xs-6 text-primary">Tipo documento: <span class="asterisk">*</span></label>
                    <div class="col-sm-4 col-xs-6">
                        <select  name="idtipodoc" class="form-control form-control-sm"  aria-invalid="false" style="">
                            <option label="DNI" value="1" selected="selected" >DNI</option>
                            <option label="RUC" value="2" >RUC</option>
                            <option label="CARNET EXT." value="3">CARNET EXT.</option>
                            <option label="PASAPORTE" value="4">PASAPORTE</option>
                        </select>   
                    </div>
                </div>
                <div class="row mt-1"> 
                    <label class="col-sm-2 col-xs-6 text-primary">Número Documento: <span class="asterisk">*</span></label>
                    <div class="col-sm-4 col-xs-6">
                        <input type="number" name="numerodoc"  id="numerodoc" class="form-control form-control-sm"  maxlength="15" ng-minlength="8" aria-invalid="false" style="" />
                        <span id="reqnumerodoc" class="reqError"></span><br />

                    </div>
                    <label class="col-sm-2 col-xs-6 text-primary">Correo electrónico:</label>
                    <div class="col-sm-4 col-xs-6">
                        <input type="text" name="email" class="form-control form-control-sm" maxlength="50" aria-invalid="false" />
                    </div>
                </div>
                <div class="row mt-1"> 
                    <label class="col-sm-2 col-xs-6 text-primary ng-scope">Celular:</label>
                    <div class="col-sm-4 col-xs-6 ng-scope">
                        <input type="number" name="numerocel" class="form-control form-control-sm"  maxlength="9" ng-minlength="9" aria-invalid="false" style="" />
                    </div>
                    <label class="col-sm-2 col-xs-6 text-primary">Fecha nacimiento: <span class="asterisk">*</span></label>
                    <div class="col-sm-4 col-xs-6">
                        <input type="text" name="fechanacimiento" id="datepicker" class="form-control form-control-sm"  aria-invalid="false" value="<?php echo date('d/m/Y') ?>" />
                    </div>
                </div>
                <div class="row mt-2">
                   
                    <label class="col-sm-2 col-xs-6 text-primary">Fecha Ingreso:</label>
                    <div class="col-sm-4 col-xs-6">
                        <input type="text" name="fechaingreso" id="datepickerfechaini" class="form-control form-control-sm"  aria-invalid="false" value="<?php echo date('d/m/Y') ?>" />
                    </div>
                    <div class="col-sm-12 col-xs-6">
                        <button type="button" class="btn btn-secondary float-right mt-5" onclick="checkReqFields()">Siguiente <i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>


            <!-- USUARIO -->
            <div class="tab-pane fade border modal-body" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <div class="row ">
            <div class="col-sm-12 col-xs-6"> 
            <div class="btn-group btn-group-rounded-20 float-left">
                <button class="btn btn-info btn-sm" type="button" onclick="$('#pills-tab li:nth-child(1) a').tab('show')">
                <i class="fas fa-chevron-left"></i> Regresar
                </button>
                </div>
                <div class="btn-group btn-group-rounded-20 float-right">
                <button class="btn btn-info btn-sm" type="submit">
                <i class="fa fa-floppy-o"></i> Grabar
                </button>
                </div>
            </div> 
            </div> 
                <div class="row mt-3">
                    <label class="col-sm-2 col-xs-6 text-primary">Usuario:</label>
                    <div class="col-sm-4 col-xs-6">
                        <input type="text" id="usuario" name="usuario" class="form-control form-control-sm" aria-invalid="false" disabled />
                    </div>
                    <label class="col-sm-2 col-xs-6 text-primary ng-scope">Contraseña:</label>
                    <div class="col-sm-4 col-xs-6">
                        <input type="password" name="password" id="password" placeholder="*********" class="form-control form-control-sm" aria-invalid="false" />
                        <span id="reqpassword" class="reqError"></span><br />

                    </div>
                </div>
                <div class="row mt-2    ">
                    <label class="col-sm-2 col-xs-6 text-primary">Perfil: <span class="asterisk">*</span></label>
                    <div class="col-sm-4 col-xs-6">
                        <select name="idperfil" class="form-control form-control-sm"  aria-invalid="false" style="">
                            <option value="1">Cocinero</option>
                            <option value="2">Caja</option>

                        </select>
                    </div>
                    <!-- <label class="col-sm-2 col-xs-6 text-primary ng-scope"></label>
                    <div class="col-sm-4 col-xs-6">
                        <button type="button" class="btn btn-info btn-sm float-right" data-toggle="modal" data-target="#staticBackdrop">Cambiar contraseña</button>
                    </div> -->
                </div>
                <div class="row mt-2">
                    <label class="col-sm-2 col-xs-12 text-primary">Sede: <span class="asterisk">*</span></label> 
                    <div class="col-sm-4 col-xs-6">
                        <select  name="idsede" class="form-control form-control-sm"  aria-invalid="false" style="">
                            <option  value="1" selected="selected" >La Molina</option>
                            <option  value="2" >Manchay</option> 
                        </select>   
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>


<!-- MODAL CAMBIAR CONTRASEÑA -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Cambiar Contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mt-2">
                    <label class="col-sm-4 col-xs-6 text-primary">Usuario:</label>
                    <div class="col-sm-8 col-xs-6">
                        <input type="text" name="usuario" class="form-control form-control-sm" aria-invalid="false" disabled />
                    </div>
                </div>
                <div class="row mt-3">
                    <label class="col-sm-4 col-xs-6 text-primary ng-scope">Contraseña:</label>
                    <div class="col-sm-8 col-xs-6">
                        <input type="password" name="password" placeholder="*********" class="form-control form-control-sm" aria-invalid="false" />
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
 <script>
        $("#datepicker").datepicker({
        uiLibrary: "bootstrap4",
    });
    $("#datepickerfechaini").datepicker({
        uiLibrary: "bootstrap4",
    });

    </script>