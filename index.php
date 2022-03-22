<?php session_start();
   if( !isset($_SESSION['id_user']))
   header('Location: ./login.php'); 
     require "cnSql.php";
     $total=0;
     date_default_timezone_set("America/Lima");
     $fechadia=date('Y-m-d');
     $manana = date('Y-m-d',strtotime ( '+1 day' , strtotime ( $fechadia ))); 

     function CerrarSesionPhp(){
      session_destroy();
     }
   ?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <title>Cevicheria Willy Gourmet</title>
      <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
      <link rel="stylesheet" href="css\bootstrap\css\boostrap4.6.min.css">
      <link href="library/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />      
      <link href="css\page_css\layout.css" rel="stylesheet" type="text/css" />      
      <link href="css\sweetalert2.css" rel="stylesheet" type="text/css" />      
      <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
      <link href="css\page_css\side.css" rel="stylesheet" type="text/css" />       
      <link href="css/page_css/loading.css" rel="stylesheet">
      <link href="css\inputs\chekbox.css" rel="stylesheet">

      <script type="text/javascript" src="js\jquery-3.1.1.js"></script>
      <script src="css\bootstrap\js\bootstrap.bundle.min.js" ></script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script> 
      <script src="js\page_js\index.js"></script> 
      <script type="text/javascript" src="js\sweetalert2.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js" integrity="sha512-WFN04846sdKMIP5LKNphMaWzU7YpMyCU245etK3g/2ARYbPK9Ub18eG+ljU96qKRCWh+quCY7yefSmlkQw1ANQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

      <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
      <script src="https://kit.fontawesome.com/06efcdf77e.js" crossorigin="anonymous"></script>
   </head>
 
   <body class="skin-blue">

   <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>

<div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
            <img width='100%' class="img-responsive" src="images/logo.png" alt="ESDINAMICO Logo"  style="width:100%;height:100%;text-align:center;margin-top: -21px;"  />
            </div>

            <ul class="list-unstyled components">
                <p style="border-style: dashed;font-weight: bold;">Cevicheria Willy Gourmet</p>
                <li class="active">
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Mantenimiento</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="?page=usuario">
                            <span>Usuarios</span>
                            </a> 
                        </li> 
                    </ul>
                </li>
                <li>
                    <a href="#">About</a>
                </li>                
            </ul> 
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light" id="menu_arriba">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <!-- <span>Toggle Sidebar</span> -->
                    </button>

                    <div id="menu_inicio" style="margin-left: 10%;margin-top: -8px;font-size: 21px;" class="d-inline-block d-lg-none ml-auto">
                                     <a class="" href="index.php" style="color: #280909;">       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;              Mesas</a>
                                     <a class="" href="?page=Pedidos" style="color: #280909;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pedidos Cocina</a>
                                     <a class="" href="?page=NuevoPedido" style="color: #280909;">         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;        Nuevo Pedido</a>
                     </div>
                     <div id="menu_inicio" style="margin-left: 37%;margin-top: -8px;font-size: 21px;">
                                     <a class="" href="index.php" style="color: #280909;">      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;           Mesas</a>
                                     <a class="" href="?page=Pedidos" style="color: #280909;">   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                Pedidos Cocina</a>
                                     <a class="" href="?page=NuevoPedido" style="color: #280909;">    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;             Nuevo Pedido</a>
                     </div>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>
                    

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto"> 
                            <li>
                                <a  href="logout.php" onclick="CerrarSesion()" >
                                    <i class="fa fa-sign-out"></i> Cerrar sesión
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <?php
                           $page=null;
                           if(isset($_GET['page'])){
                              $page = $_GET['page'];  
                           }else if($page == null) {
                              $page = 'index';  
                           }

                           switch ($page) { 
                              case 'index':
                                 include('subdominio\_index.php');
                                 break; 
                              case 'usuario':  
                                 include('views\usuario.php');
                                 break; 
                              case 'nuevousuario': 
                                  include('views\nuevousuario.php');
                                  break; 
                              case 'editarusuario':  
                                  include('views\editarusuario.php');
                                    break; 
                              case 'NuevoPedido':  
                                  include('subdominio\nuevoPedido.php');
                                      break; 
                              case 'EditarPedido':  
                                  include('views\editarPedido.php');
                                      break;   
                              case 'Pedidos':  
                                  include('views\pedido.php');
                                      break;
                           }

                     ?>    
        </div>
    </div>

<?php if ($_SESSION['idperfil']== 2) { ?> <!--MOZO || COCINA-->
    
        <script>
                $('#sidebar').toggleClass('active');
         </script>
        <?php 
            }  
            ?>  

<?php if ($_SESSION['idperfil']== 1) { ?> <!-- COCINA-->
   
        <script>
                $('#sidebar').toggleClass('active');
                // $('#menu_arriba').css('display','none');
        </script>
        <?php 
            }  
            ?>  
            
   </body>
   <script> 
     
     $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
 

        function CerrarSesion(){ 
          location.reload();
      }
        </script>
</html>
