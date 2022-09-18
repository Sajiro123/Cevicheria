<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@1,300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"
    integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w=="
    crossorigin="anonymous" />

<script src="js\page_js\mesas.js"></script>
<!-- <script src="js\page_js\cocinapedidos.js"></script>  -->


<?php
if (!isset($_SESSION['idperfil'])) {
    header('Location: ./login.php');
}
?>


<style>
body {
    font-family: 'Open Sans', sans-serif;
}
 

.pedido_cocina {
    font-size: 17px;
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

.col-sm-2 {
    flex: 0 0 23.5%;
    max-width: 20.0%;
    position: relative;
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
}

input[type="radio"] {
    margin: .4rem;

}
</style>
<div class="loader" id="idloader" style="display:none;"></div>
<div class="row" id="idcard" style="display:none;">
    <div class="col-sm-12 col-lg-4">
        <div id="idmesas">
            <div style="height: 69px;margin-top: -18px;">
                <input type="radio" id="pisouno" name="piso" value="1" style="width: 4%;height: 2em;"
                    onchange="mesapiso($('#pisouno').val())" checked>
                <label for="uno" style="font-size: 22px">Primer Piso</label>
                <input type="radio" id="pisodos" name="piso" value="2" style="width: 4%;height: 2em;"
                    onchange="mesapiso($('#pisodos').val())">
                <label for="dos" style="font-size: 22px">Segundo Piso</label>
                <input type="radio" id="pedidosinmesa" name="piso" value="0" style="width: 4%;height: 2em;"
                    onchange="mesapiso($('#pedidosinmesa').val())">
                <label for="dos" style="font-size: 22px">Pedido sin Mesa</label>
            </div>
            <div class="row" id="mesascantidad">
            </div>
        </div>
    </div>

    <div class="col-sm-9 col-lg-5" >

        <div id="idopciones" style="margin-top: -28px;">
            <div class="modal-body">
                <div class="row" id="regresar">
                    <!-- <div class="col-sm-1" style="margin-left: 46px;">
                        <i class="fas fa-arrow-alt-circle-left" onclick="RegresarMesas()" style="font-size:60px;cursor:pointer;"></i>
                    </div> -->
                    <div class="col-sm-10">
                        <h2 class="text-center" id="mesa" style="font-family: cursive;color: red;font-size: 31px;"></h2>
                    </div>

                </div>
                <div class="" id="opciones">
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-2 col-lg-1"  id="opciones_botones">
    </div> 
    
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Pedido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> -->
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

    <div class="modal fade" id="idModalCobrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cobrar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-3">
                        <h4 class="text-center">EFECTIVO</h4>
                        <input type="number" class="form-control" placeholder="Efectivo" id="idefectivo"
                            name="idefectivo" />
                    </div>
                    <div class="col-md-2">
                        <h4 class="text-center">VISA</h4>
                        <input type="number" class="form-control" placeholder="Visa" id="idvisa" name="idvisa" />
                    </div>
                    <div class="col-md-2">
                        <h4 class="text-center">YAPE</h4>
                        <input type="number" class="form-control" placeholder="Yape" id="idyape" name="idyape" />
                    </div>
                    <div class="col-md-2">
                        <h4 class="text-center">PLIN</h4>
                        <input type="number" class="form-control" placeholder="Plin" id="idplin" name="idplin" />
                    </div>

                    <div class="col-md-3">
                        <h4 class="text-center">Total</h4>
                        <input type="number" class="form-control" placeholder="Total" name="totalid" id="idtotal" disabled
                            name="idplin" />
                        <input type="number" class="form-control" placeholder="Total" name="totalid" id="idpedido_cobrar" style="display: none"
                            disabled name="idplin" />

                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                    <button type="button" class="btn btn-primary" onclick="CobrarSumar()">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script runat="server">
  public void Page_Load(Object sender, EventArgs e)
  {
    // Define the name and type of the client scripts on the page.
    String csname1 = "PopupScript";
    Type cstype = this.GetType();
        
    // Get a ClientScriptManager reference from the Page class.
    ClientScriptManager cs = Page.ClientScript;

    // Check to see if the startup script is already registered.
    if (!cs.IsStartupScriptRegistered(cstype, csname1))
    {
        StringBuilder cstext1 = new StringBuilder();
        cstext1.Append("<script type=text/javascript> alert('Hello World!') </");
        cstext1.Append("script>");

        cs.RegisterStartupScript(cstype, csname1, cstext1.ToString());
    }
  }
</script>

<script>
$(document).ready(function() {
    ListarMesas('#mesascantidad');
});
</script>


<?php if ($_SESSION['idperfil'] == 1) { ?>
<!--COCINA -->
<div class="modal-body">
    <div class="row" id="idpedidos_cocina">
    </div>
</div>
<script>
$(document).ready(function() {
    ListarMesasPedidos();
});
</script>
<?php
    }
    ?>
</div>