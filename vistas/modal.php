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

    if ($_SESSION['almacen'] == 1)

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
                        <h1 >Abonos</h1>
                        <div class="panel-body" style="height: 400px;" id="formularioregistros">

<form name="formulario" id="formulario" method="POST">


    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <table id="tbllistadoHipotecas" class="table table-striped table-bordered table-condensed table-hover">


            <thead>
            <th>Opciones</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Abono Capital</th>
            <th>Abono Interes</th>
            <th>Total de abonos</th>
            <th>Moneda</th>
            </thead>
            <tbody>
            <!----  La loquera de aqui quien lo llena es el dataTable-->
            </tbody>

            <tfoot>
            <th>Opciones</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Abono Capital</th>
            <th>Abono Interes</th>
            <th>Total de abonos</th>
            <th>Moneda</th>
            </tfoot>
        </table>

    </div>


</form>
</div>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <!-- centro -->


<!--                    MODAL SOLICITUD DE PRESTAMO-->

<!--                    FIN DEL MODAL   -->




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
<script type="text/javascript" src="scripts/modal.js"></script>
    <?php
}

//libera el espacio del BUFFER
ob_end_flush();
?>