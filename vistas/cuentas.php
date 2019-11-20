<?php

//se activa el almacenamiento el Buffer para iniciar sesion
ob_start();
session_start();

if(!isset($_SESSION["nombre"]))
{
    header("Location: login.html");
}
else
{

    if ($_SESSION['Administrador'] == 1)

    {

require 'header.php';
?>
<!--Contenido-->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">Cuentas
                            
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoCuentas">
                        <label>Cuentas</label>
                        <table id="detallesCuentas" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                            <th>Opciones</th>
                            <th>Cuenta</th>
                            <th>Cliente</th>
                            <th>Cedula</th>
                            <th>Monto</th>
                            <th>Interes</th>
                            <th>Interes Moratorio</th>
                            <th>Moneda</th>
                            <th>Estado</th>
                            <th>Condicion</th>
                            </thead>
                            <tbody>
                            <!----  La loquera de aqui quien lo llena es el dataTable-->
                            </tbody>

                            <tfoot>

                            </tfoot>
                        </table>


                    </div>


                    <div class="panel-body" style="height: 400px;" id="formularioregistros">

                        

                    </div>
                    <!--Fin centro -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->

</div><!-- /.content-wrapper -->
<!--Fin-Contenido-->
<?php
    }//fin deel if de inicio de session que da los permisos

    else {
        require 'noacceso.php';
    }
require 'footer.php';
?>
<script type="text/javascript" src="../public/js/JsBarcode.all.min.js"></script>
<script type="text/javascript" src="../public/js/jquery.PrintArea.js"></script>
<script type="text/javascript" src="scripts/cuentas.js"></script>
    <?php
}

//libera el espacio del BUFFER
ob_end_flush();
?>