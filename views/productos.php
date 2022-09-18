<style>
table,
th,
td {
    border: 0.1px solid black !important;
}

.results tr[visible='false'],
.no-result {
    display: none;
}

.results tr[visible='true'] {
    display: table-row;
}

.counter {
    padding: 8px;
    color: #ccc;
}
</style>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/css/jasny-bootstrap.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/js/jasny-bootstrap.min.js"></script>
<script src="js\page_js\productos.js"></script>

<div class="loader" id="idloader" style="display:none;"></div>

<div class="card"  id="idcard" style="display:none">
    <div class="card-body">
        <div class="form-group pull-right">
            <input type="text" class="search form-control" style="width: 304px;"
                placeholder="Ingrese la palabra de busqueda">
        </div>
        <br />
        <div style="height:406px;overflow: scroll; ">
            <div class="container">
                <table class="table table-bordered table-hover  results table-sm " id="idProductoTable">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" style="font-size: 15px">#</th>
                            <th class="text-center" style="font-size: 15px">Producto</th>
                            <th class="text-center" style="font-size: 15px">Precio</th>
                            <th class="text-center" style="font-size: 15px">Codigo</th>
                            <th class="text-center" style="font-size: 15px">Categoria</th>

                        </tr>
                        <tr class="warning no-result">
                            <td colspan="4"><i class="fa fa-warning"></i> No result</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form" action="./controller/productoController.php?function=AgregarProductos" method="post"
                    enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-8 row">


                            <label class="col-sm-4 col-xs-6 control-label text-theme">Nombre</label>
                            <div class="col-sm-8 col-xs-6">
                                <input type="text" class="form-control vacios" id="nombre" name="nombre" value=""
                                    required />
                            </div>

                            <label class="col-sm-4 col-xs-6 control-label text-theme mt-2">Codigo</label>
                            <div class="col-sm-8 col-xs-6 mt-2">
                                <input type="text" class="form-control vacios" id="codigo" name="codigo" value=""
                                    required />
                            </div>

                            <label class="col-sm-4 col-xs-6 control-label text-theme mt-2">Categoria</label>
                            <div class="col-sm-8 col-xs-6 mt-2">
                                <select id="idcategoria" class="form-control" required name="idcategoria">
                                </select>
                            </div>

                            <label class="col-sm-4 col-xs-6 control-label text-theme mt-2">Precio</label>
                            <div class="col-sm-8 col-xs-6 mt-2">
                                <input type="number" class="form-control vacios" id="precio" name="preciounitario"
                                    value="" required />
                            </div>

                            <label class="col-sm-4 col-xs-6 control-label text-theme mt-2">Acronimo</label>
                            <div class="col-sm-8 col-xs-6 mt-2">
                                <input type="text" class="form-control vacios" id="acronimo" name="acronimo" value=""
                                    required />
                            </div>

                            <label class="col-sm-4 col-xs-6 control-label text-theme mt-2" style=""
                                id="labelcoditotipoprod">Codigo Tipo Producto</label>
                            <div class="col-sm-8 col-xs-6 mt-2" id="idcoditotipoprod" style="">
                                <input type="text" class="form-control vacios" id="idtipoproducto" name="idtipoproducto"
                                    value="" />
                            </div>

                            <label class="col-sm-2 col-xs-6 control-label text-theme mt-2">Nivel 2</label>
                            <input class="col-sm-7 col-xs-6 mt-3" type="checkbox" name="idarbol" class="form-control"
                                id="checknivel2" value="true" onchange="AgregarTipoProducto()">
                        </div>

                        <div class="col-sm-4 ">
                            <div class="col-sm-12">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview img-thumbnail" data-trigger="fileinput"
                                        style="width: 200px; height: 150px;"></div>
                                    <div>
                                        <span class="btn btn-outline-secondary btn-file">
                                            <span class="fileinput-new">Seleccionar Imagen</span>
                                            <span class="fileinput-exists">Cambiar</span>
                                            <input type="file" id="imageUploadForm" accept=".jpg,.gif,.png"
                                                name="imgproducto" required>

                                        </span>
                                        <a href="#" class="btn btn-outline-secondary fileinput-exists"
                                            data-dismiss="fileinput">Eliminar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Save changes</button>
            </div>
            </form>

        </div>
    </div>
</div>