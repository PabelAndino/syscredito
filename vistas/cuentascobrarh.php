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
                        <h1 class="label-default">Cuentas Cobro de Prestamos
                           </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <!-- LISTADO ABONOS -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                    <h2 class="label-primary">Muestra los clientes con mora de un Año o menos </h2>
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>

                            <th>Opciones</th>
                            <th>Cliente</th>
                            <th>Monto</th>
                            <th>Interes</th>
                            <th>Moneda</th>
                            <th>Meses Pendientes</th>
                            <th>Ultimo Pago</th>
                            <th>Dia a pagar</th>
                            <th>Estado</th>

                            </thead>
                            <tbody>
                            <!----  La loquera de aqui quien lo llena es el dataTable-->
                            </tbody>

                            <tfoot>

                            </tfoot>
                        </table>


                    </div>
                    <!-- FIN LISTADO ABONOS -->

                    <!-- LISTADO NUEVA CUENTA -->
                    <div class="panel-body table-responsive" id="listadonuevacuenta ">
                        <h3 class="label-info">Cuentas que no han hecho abonos aun</h3>
                        <table id="tbllistado_ncuenta" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>

                            <th>Opciones</th>
                            <th>Cliente</th>
                            <th>Monto</th>
                            <th>Interes</th>
                            <th>Moneda</th>
                            <th>Tipo</th>
                            <th>Fecha Prestamo</th>
                            <th>Fecha a pagar</th>
                            <th>Estado</th>

                            </thead>
                            <tbody>
                            <!----  La loquera de aqui quien lo llena es el dataTable-->
                            </tbody>

                            <tfoot>

                            </tfoot>
                        </table>


                    </div>
                    <!-- FIN LISTADO NUEVA CUENTA -->
                    <!--Fin centro -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->

</div><!-- /.content-wrapper -->
<!--Fin-Contenido-->


        <!-- Modal Cliente -->
        <div class="modal fade" id="modalClienteh" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
            <div class="modal-dialog" style="width: 75% !important;">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Agregar Datos del Cliente</h4>
                    </div>
                    <div class="modal-body">

                        <div class="panel-body" style="height: 400px;" id="formulariodatosCliente">
                            <form name="formularioCliente" id="formularioCliente" method="POST">
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Nombre(*):</label>
                                    <input type="text"     class="form-control" name="nombreh" id="nombreh" maxlength="100" placeholder="Nombres y Apellidos" required>
                                </div>

                                <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label>Documento(*):</label>
                                    <input type="text"  class="form-control" VALUE="" name="cedulah" id="cedulah" maxlength="100" placeholder="Nombres y Apellidos" required>



                                </div>



                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Dirección(*):</label>
                                    <input type="text" class="form-control" name="direccionh" id="direccionh" maxlength="256" placeholder="Direccion" required>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Teléfono(*):</label>
                                    <input type="text" class="form-control" name="telefonoh" id="telefonoh" maxlength="256" placeholder="telefono" required>
                                </div>


                            </form>

                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                <h4 class="badge badge-dark">Detalles de Abonos</h4>
                                <table id="detallesAbonosh"  class="table table-striped table-bordered table-condensed table-hover">

                                    <thead style=" background-color: #6ce393">


                                    <th>Fecha</th>
                                    <th>Concepto</th>
                                    <th>Interes</th>
                                    <th>Capital</th>
                                    <th>Pendiente Capital</th>
                                    <th>Moneda</th>

                                    </thead>
                                    <tfoot>


                                    </tfoot>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>



                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="limpiarCliente()" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin modal -->


<?php
    }//fin deel if de inicio de session que da los permisos

    else {
        require 'noacceso.php';
    }
require 'footer.php';
?>
    <script type="text/javascript" src="scripts/cuentascobrar.js"></script>

<!--<script type="text/javascript" src="../../public/js/JsBarcode.all.min.js"></script>
<script type="text/javascript" src="../../public/js/jquery.PrintArea.js"></script>
<script type="text/javascript" src="../scripts/cuentascobrar.js"></script>-->
    <?php
}

//libera el espacio del BUFFER
ob_end_flush();
?>