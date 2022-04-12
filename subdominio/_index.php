
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@1,300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />

<script src="js\page_js\mesas.js"></script> 
<!-- <script src="js\page_js\cocinapedidos.js"></script>  -->


<?php
   if (!isset($_SESSION['idperfil'])) {
       header('Location: ./login.php');
   }
 ?>


<style>
    body{
        font-family: 'Open Sans', sans-serif;
    }
    .pedido_cocina{
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
input[type="radio"]{
    margin: .4rem;

}
</style>

<div >
    
    <?php if ( isset($_SESSION['idperfil']) &&$_SESSION['idperfil']== 2) { ?> <!--MOZO --> 
        <div class="modal-body" id="idmesas">
            <div>
                <input type="radio" id="pisouno"  name="piso" value="1"  style="width: 4%;height: 2em;" onchange="mesapiso($('#pisouno').val())" checked>
                <label for="uno" style="font-size: 22px">Primer Piso</label>
                <input type="radio" id="pisodos" name="piso" value="2" style="width: 4%;height: 2em;" onchange="mesapiso($('#pisodos').val())">
                <label for="dos" style="font-size: 22px">Segundo Piso</label>
            </div>
            <div class="row" id="mesascantidad"> 
            </div>
        </div>  
            <div id="idopciones" style="display:none">
                <div class="modal-body">
                        <div class="row" id="regresar">
                            <div class="col-sm-1" style="margin-left: 46px;">
                                <i class="fas fa-arrow-alt-circle-left" onclick="RegresarMesas()" style="font-size:60px;cursor:pointer;"></i>
                            </div>
                            <div class="col-sm-10" >
                            <h2 class="text-center" id="mesa" style="font-family: cursive;color: red;"></h2> 
                            </div>

                        </div>
                        <div class="" id="opciones"> 
                        </div>
                 </div>
             </div>
             <script>
                 $(document).ready(function(){
                  ListarMesas('#mesascantidad'); 
                });
            </script>
     <?php 
    }
     ?>  

    <?php if ($_SESSION['idperfil']== 1) { ?> <!--COCINA --> 
            <div class="modal-body" >
                <div class="row" id="idpedidos_cocina"> 
               </div>
            </div>
            <script>
                 $(document).ready(function(){
                  ListarMesasPedidos();
                });
            </script>
        <?php 
        }
        ?>  
</div>
 




 
  