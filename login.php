<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
      <title> MODULO DE SUB DOMINIOS </title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
      <link href="css/login-theme-6.css" rel="stylesheet" id="fordemo">
      <link href="css/animate-custom.css" rel="stylesheet">
	  <link href="css/page_css/login.css" rel="stylesheet">

      <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"></script>
      <script src="https://kit.fontawesome.com/06efcdf77e.js" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.b	undle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

   </head>
   <body> 
      <div class="padreback" id="loading"  style="display:none">
         <div class="hijoback text-center">
            <span class="spinner"></span>
            <br /><br />
            Procesando..
         </div>
      </div>
      <div class="container" id="login-block">
         <div class="row">
            <div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4"></div>
            <div class="col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-4">
               <div class="login-box clearfix animated flipInY">
                  <br/>
                  <h4 class="text-center mb-20 ng-scope">BIENVENIDO</h4>
                  <hr/>
                  <div style="text-align:center">
                     <img width='59%' class="img-responsive" src="images/logo.png" alt="ESDINAMICO Logo"  style="width:59%;height:100%;text-align:center;margin-top: -21px;"  />
                  </div>
                  <form id=form_login name=form_login action='#' method="post">
                     <div class="login-form">
                        <input type="email" placeholder="Mi Usuario" id="user" name="user"  value="930317648" class="form-control ng-not-empty ng-dirty ng-valid-parse ng-valid ng-valid-required ng-touched" />
                        <input onkeyup="if(validateEnter(event) == true) { $('#enviar').click(); }" type="password" value="123456" placeholder="Mi Contraseña" id="pass" name="pass" class="form-control ng-not-empty ng-dirty ng-valid-parse ng-valid ng-valid-required ng-touched" />
                        <div id="divinfo" style='display:none' class="alert alert-warning">
                           Alerta: Ingrese su usuario.
                        </div>
                        <div id="divinfo2" style='display:none' class="alert alert-warning">
                           Alerta: Ingrese su contraseña.
                        </div>
                        <div id="diverror" style="display:none" class="alert alert-danger">
                           <b>Error: </b>Datos Incorrectos.
                        </div>
                        <input type="button"  id="enviar" name="enviar" onclick="Enviar()" class="btn btn-login btn-reset" value="Iniciar Sesión">
                      </div>
                  </form>
               </div>
            </div>
         </div>    
      </div>
      <footer class="container">
         <p id="footer-text" style="font:15px 'Trebuchet MS'"><small> &copy; 2021 <a style="cursor:pointer" target="blank" href="#"> Alex Espinoza Developer </a></small></p>
      </footer>
   </body>
</html>

<script type="text/javascript" src="./js/page_js/login.js"></script>
<script>
   $(document).ready(function() {
     $('#enviar').click();
});

</script>