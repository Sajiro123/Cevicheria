<?php  
   if( !isset($_SESSION['idperfil']))
   header('Location: ./login.php'); 
 ?>


<style>
    .circulo {
     width: 27px;
     height: 27px;
     -moz-border-radius: 50%;
     -webkit-border-radius: 50%;
     border-radius: 50%;
     background: #5cb85c;
}
</style>

<?php if ($_SESSION['idperfil']== 2){ ?> <!--MOZO -->
    <div class="modal-body">
        <div class="row">
        <?php
        for ($i=1; $i < 17; $i++) {    ?>
         

             <div class="col-sm-3 col-xs-3 col-md-3">
             <div class="card" style="text-align:center;cursor:pointer;" onclick="Escoger_Mesa('<?php echo $i    ?>')"> 
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

 <script>

     function Escoger_Mesa(id){
         alert(id);
     }

 </script>