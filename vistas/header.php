

<?php

    if(strlen(session_id()) < 1)//si no existe una variable de session  y si esta iniciada no hay falla
    {
        session_start();
    }
//valida si la session esta iniciada
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ElsaSoft | </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
      <!--<link rel="stylesheet" href="../public/bootstrap/css/_variables.scss">-->
      <link rel="stylesheet" href="../public/css/toastr.css">
      <link rel="stylesheet" href="../public/js/toastr.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/css/font-awesome.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">
    <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
    <link rel="shortcut icon" href="../public/img/favicon.ico">

    <!-- DATATABLES -->
    <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">    
    <link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet"/>
    <link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet"/>

    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">

  </head>
  <body class="hold-transition skin-black-light sidebar-mini  ">  <!-- Colores o temas del sistema -->
    <div class="wrapper">

      <header class="main-header">

        <!-- Logo -->

          <a href="venta.php" class="logo">

              <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>E</b>S</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>ElsaSoft</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?php echo $_SESSION['nombre']; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
                    <p>
                      www.pabeldev.dx.am - Software Development
                      <small>www.youtube.com/pabelwitt</small>
                    </p>
                  </li>
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    
                    <div class="pull-right">
                      <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat">Cerrar</a>
                    </div>
                  </li>
                </ul>
              </li>
              
            </ul>
          </div>

        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar ">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar ">
          <!-- sidebar menu: : style can be found in sidebar.less -->


          <ul class="sidebar-menu ">
            <li class="header"></li>
            <?php

            if ($_SESSION['Administrador']==1)
            {
            //     echo '<li>
            //   <a href="dashboard.php">
            //     <i class="fa fa-columns"></i> <span>Dashboard</span>
            //   </a>
              
            // </li>    ';
            }
            ?>



              <?php
              if ($_SESSION['Administrador']==1)
              {
                  echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-th"></i>
                <span>Prestamos</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
               
                <li><a href="gestionar_hipoteca.php"><i class="fa fa-circle-o"></i>Prestamos</a></li>
                
                 
               
                
              </ul>
            </li>';
              }
              ?>
              <?php
            if ($_SESSION['Abono']==1)
              {
                  echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-sellsy "></i>
                <span>Abonos</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="gestionar_abono.php"><i class="fa fa-circle-o"></i> Abonos</a></li>
                
              </ul>
            </li>   ';
              }
              ?>

          <?php
              if ($_SESSION['Administrador']==1)
              {
                  echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-exchange"></i>
                <span>Cuentas</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
               
                <li><a href="cuentas.php"><i class="fa fa-circle-o"></i>Cuentas</a></li>
                <li><a href="bancos.php"><i class="fa fa-circle-o"></i>Bancos</a></li>
                 <li><a href="socios.php"><i class="fa fa-circle-o"></i>Socios</a></li>
                 <li><a href="solicitud.php"><i class="fa fa-circle-o"></i>Solicitudes</a></li>
                 <li><a href="categorias.php"><i class="fa fa-circle-o"></i>Categorias Garantia</a></li>
                <li><a href="cliente.php"><i class="fa fa-circle-o"></i>Cliente</a></li>
                <li><a href="fiador.php"><i class="fa fa-circle-o"></i>Fiador</a></li>
                 <li><a href="egresos.php"><i class="fa fa-circle-o"></i>Egresos</a></li>
                
              </ul>
            </li>';
              }
              ?>

         <?php
              if ($_SESSION['Administrador']==1)
              {
                  echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-bar-chart"></i> <span>Plan Pago</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
               <!-- <li><a href="tests.php"><i class="fa fa-circle-o"></i> TESTS</a></li>-->  
                <li><a href="plan_pago.php"><i class="fa fa-circle-o"></i> Plan Pago</a></li>  
                           
              </ul>
            </li>';
              }
              ?>
              <?php
              if ($_SESSION['Administrador']==1)
              {
                  echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-pie-chart"></i> <span>Reportes</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="cuentascobrarh.php"><i class="fa fa-circle-o"></i>Cartera-Cuentas Activas</a></li>  
                <li><a href="abonos.php"><i class="fa fa-circle-o"></i>Abonos</a></li> 
                
                           
              </ul>
            </li>';
              }
              ?>

            <?php
              if ($_SESSION['Administrador']==1)
              {
                  echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-cog"></i> <span> Configuracion</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="usuario.php"><i class="fa fa-circle-o"></i> Usuarios</a></li>
                <li><a href="permiso.php"><i class="fa fa-circle-o"></i> Permisos</a></li>
                
              </ul>
            </li>';
              }
              ?>
          <!--    <a href="#">
                <i class="fa fa-plus-square"></i> <span>Ayuda</span>
                <small class="label pull-right bg-red">PDF</small>
              </a>
            </li>
            <li>-->
              <li>
              <a href="#">
                <i class="fa fa-info-circle"></i> <span>Acerca De...</span>
                <small class="label pull-right bg-yellow">ES</small>
              </a>
            </li>
                        
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
