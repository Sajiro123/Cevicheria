
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@1,300&display=swap" rel="stylesheet">
<?php
   if (!isset($_SESSION['idperfil'])) {
       header('Location: ./login.php');
   }
 ?>


<style>
    body{
        font-family: 'Open Sans', sans-serif;
    }
    .circulo {
     width: 27px;
     height: 27px;
     -moz-border-radius: 50%;
     -webkit-border-radius: 50%;
     border-radius: 50%;
     background: #5cb85c;
}
</style>
<div id="idmesas">
    <?php if ($_SESSION['idperfil']== 2) { ?> <!--MOZO --> 
        <div class="modal-body">
            <div class="row">
            <?php
            for ($i=1; $i < 17; $i++) {    ?> 

                <div class="col-sm-3 col-xs-3 col-md-3">
                <div class="card" style="text-align:center;cursor:pointer;" onclick="Opciones_Mesa('<?php echo $i    ?>')"> 
                <div class="circulo" style="margin-left: 5px;"> 
            </div>
                    <div class="card-body">
                        <i class="fas fa-utensils" style="font-size: 60px;"></i>
                        <h2>Mesa<?php echo ' '.$i    ?></h2>
                    </div>
                </div>
                <br/>
            </div> 
            <?php
            }
    }
            ?>  
    </div>
    </div> 
</div>


<div id="idopciones" style="display:none">
    <div class="modal-body">
        <div class="row" id="regresar">
            <div class="col-sm-1" style="margin-left: 36px;">
                <i class="fas fa-arrow-alt-circle-left" onclick="RegresarMesas()" style="font-size:60px;cursor:pointer;"></i>
            </div>
        </div>
        <div class="container-sm" id="opciones">
        
                
        </div>
    </div>
</div>

 <script>

     function Opciones_Mesa(id){
         $('#mesa').text('Mesa '+id);
         $('#idmesas').css('display','none');
         $('#idopciones').css('display','block');
         
        $('#opciones').append('<h2 class="text-center" id="mesa" style="font-family: cursive;color: red;"></h2>'+
        '<div class="row" style="margin-top:100px">'+ 
        '<div class="col-sm-4 col-xs-4 col-md-4">'+
        '  <div class="card" style="text-align:center;cursor:pointer;width: 108%;" >'+  
        '<a href="?page=NuevoPedido&mesa='+id+'" class="list-group-item list-group-item-action  text-dark">'+ 
        '<div class="card-body">'+
        '<i class="fas fa-plus" style="font-size: 60px;"></i>'+
        '<h3>Nuevo</h3>'+
        '       </div>'+
        '       </a>'+ 
        '      </div>'+
        '            <br/>'+
        '           </div>'+   
        '           <div class="col-sm-4 col-xs-4 col-md-4">'+
        '               <div class="card" style="text-align:center;cursor:pointer;width: 108%;" onclick="Opciones_Mesa( )">'+
        '                   <div class="card-body">'+
        '                       <i class="fas fa-pencil-alt" style="font-size: 60px;"></i>'+
        '                       <h3>Editar</h3>'+
        '                   </div>'+
        '               </div>'+
        '            <br/>'+
        '           </div>'+
        '           <div class="col-sm-4 col-xs-4 col-md-4">'+
        '               <div class="card" style="text-align:center;cursor:pointer;width: 108%;" onclick="Opciones_Mesa( )">'+  
        '                   <div class="card-body">'+
        '                       <i class="fas fa-trash-alt" style="font-size: 60px;"></i>'+
        '                       <h3>Cancelar</h3>'+
        '                   </div>'+
        '               </div>'+
        '            <br/>'+
        '           </div>'+
        '           <div class="col-sm-4 col-xs-4 col-md-4" style="margin-top: -17px;">'+
        '               <div class="card" style="text-align:center;cursor:pointer;width: 108%;" onclick="Opciones_Mesa( )">'+  
        '                   <div class="card-body">'+
        '                       <i class="fas fa-money-check-alt" style="font-size: 60px;"></i>'+
        '                       <h3>Cobrar</h3>'+
        '                   </div>'+
        '               </div>'+
        '            <br/>'+
        '           </div>'+
        '           <div class="col-sm-4 col-xs-4 col-md-4" style="margin-top: -17px;">'+
        '               <div class="card" style="text-align:center;cursor:pointer;width: 108%;" onclick="Opciones_Mesa( )">'+  
        '                   <div class="card-body">'+
        '                       <i class="fas fa-print" style="font-size: 60px;"></i>'+
        '                       <h3>Imprimir</h3>'+
        '                   </div>'+
        '               </div>'+
        '            <br/>'+
        '           </div> '+
        '       </div>');
     }

     function RegresarMesas(){
        $('#idopciones').css('display','none');
        $('#idmesas').css('display','block');

     }

   

     

 </script>
 