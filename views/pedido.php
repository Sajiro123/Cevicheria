<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@1,300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"
    integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w=="
    crossorigin="anonymous" />

<script src="js\page_js\cocinapedidos.js"></script>

<style>
body {
    font-family: 'Open Sans', sans-serif;
}

.pedido_cocina {
    font-size: 19px;
}

.circuloverde {
    width: 27px;
    height: 27px;
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    border-radius: 50%;
    background: #5cb85c;
}

.circulorojo {
    width: 27px;
    height: 27px;
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    border-radius: 50%;
    background: red;
}

span.grey {
    background: black;
    border-radius: 0.8em;
    -moz-border-radius: 0.8em;
    -webkit-border-radius: 0.8em;
    color: #fff;
    display: inline-block;
    font-weight: bold;
    line-height: 1.4em;
    margin-right: 15px;
    text-align: center;
    width: 1.4em;
}

html {
    zoom: 68%;
}

.modal-backdrop.show {
    opacity: .0 !important;
}

.row {
    --bs-gutter-x: 1.5rem;
    --bs-gutter-y: 0;
    display: flex;
    margin-top: calc(-1 * var(--bs-gutter-y));
    margin-right: calc(-.5 * var(--bs-gutter-x));
    margin-left: calc(-.5 * var(--bs-gutter-x)); 
    flex-wrap: nowrap;
}

/* @media (max-width: 1199.98px) {

        .col-sm-2 {
        flex: 0 0 23.5%;
        max-width: 20.0%;
        position: relative;
        width: 100%;
        padding-right: 15px;
        padding-left: 15px; */
/* } */
/* } */
</style>

<div>
    <div class="modal-body">
        <div class="row">
            <div id="idpedidos_cocina" class="col-sm-10 row"></div>
            <!-- <div  class="col-sm-2">
          <table class="table table-sm table-info">
          <thead>
            <tr>
              <th scope="col">NOMBRE</th>
              <th scope="col" class="text-center">CANTIDAD</th> 
            </tr>
          </thead>
          <tbody id="idpedidos_total"> 
          </tbody>
        </table>
         </div>  -->
        </div>
    </div>
    <script>
    $(document).ready(function() {
        ListarMesasPedidos();
    });
    </script>
</div>
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="pdf_div">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>