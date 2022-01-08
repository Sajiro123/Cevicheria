<?php session_start();
   if( !isset($_SESSION['id_user']))
   header('Location: ./login.php'); 
     require "cnSql.php";
     $total=0;
     date_default_timezone_set("America/Lima");
     $fechadia=date('Y-m-d');
     $manana = date('Y-m-d',strtotime ( '+1 day' , strtotime ( $fechadia ))); 
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

      <script type="text/javascript" src="js\jquery-3.1.1.js"></script>
      <script src="css\bootstrap\js\bootstrap.bundle.min.js" ></script>
      <script src="css\bootstrap\js\fontawesome.js" ></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script> 
      <script src="js\page_js\index.js"></script> 
      <script type="text/javascript" src="js\sweetalert2.js"></script>


      <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

      <script type="text/javascript" src="./js/page_js/nuevousuario.js"></script> 
   </head>

   <body class="skin-blue">
 <nav class="navbar navbar-expand-md navbar-dark bg-primary">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#">
    <img src="https://v4-alpha.getbootstrap.com/assets/brand/bootstrap-solid.svg" width="30" height="30" class="d-inline-block align-top" alt="">
    <span class="menu-collapsed">My Bar</span>
  </a>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
     
      
      <!-- This menu is hidden in bigger devices with d-sm-none. 
           The sidebar isn't proper for smaller screens imo, so this dropdown menu can keep all the useful sidebar itens exclusively for smaller screens  -->
      <li class="nav-item dropdown d-sm-block d-md-none">
        <a class="nav-link dropdown-toggle" href="#" id="smallerscreenmenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Menu
        </a>
        <div class="dropdown-menu" aria-labelledby="smallerscreenmenu">
            <a class="dropdown-item" href="#">Dashboard</a>
            <a class="dropdown-item" href="#">Profile</a>
            <a class="dropdown-item" href="#">Tasks</a>
            <a class="dropdown-item" href="#">Etc ...</a>
        </div>
      </li><!-- Smaller devices menu END -->
      
    </ul>
  </div>
</nav> 


<!-- Bootstrap row -->
<div class="row" id="body-row">
    <!-- Sidebar -->
    <div id="sidebar-container" class="sidebar-expanded d-none d-md-block"><!-- d-* hiddens the Sidebar in smaller devices. Its itens can be kept on the Navbar 'Menu' -->
        <!-- Bootstrap List Group -->
        <ul class="list-group">
            <!-- Separator with title -->
            <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
                <small>MAIN MENU</small>
            </li>
            <!-- /END Separator -->
            <!-- Menu with submenu -->
            <a href="#submenu1" data-toggle="collapse" aria-expanded="false" class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-dashboard fa-fw mr-3"></span> 
                    <span class="menu-collapsed">Mantenimiento</span>
                    <span class="submenu-icon ml-auto"></span>
                </div>
            </a>
            <!-- Submenu content -->
            <div id='submenu1' class="collapse sidebar-submenu">
                <a href="?page=usuario" class="list-group-item list-group-item-action  text-dark">
                    <span class="menu-collapsed">Usuarios</span>
                </a> 
            </div>
             
            <!-- Submenu content -->
             
        </ul><!-- List Group END-->
    </div><!-- sidebar-container END -->

    <!-- MAIN -->
    <div class="col">
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
                                  
                           }

                     ?>

          </div>
    
</div><!-- body-row END -->
   </body>
</html>
