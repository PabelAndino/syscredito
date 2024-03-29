<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
    header("Location: login.html");
}
else
{
    require 'header.php';

    if ($_SESSION['Administrador']==1)
    {
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
                                <h1 class="p-3 mb-2 bg-black-gradient text-white">Pedido </h1>
                                <div class="box-tools pull-right">
                                </div>
                            </div>

                            <div class="panel-body"><button class="btn btn-success" id="btnagregar" onclick="mostrarForm2(true)"><i class="fa fa-plus-circle"></i> Agregar</button></div>

                            <!-- /.box-header -->
                            <!-- centro -->
                            <div class="panel-body table-responsive" id="listadoregistros">
                                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                                    <thead>
                                    <th>Opciones</th>

                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Proveedor</th>
                                    <th>Usuario</th>
                                    <th>Descripcion</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <th>Opciones</th>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Proveedor</th>
                                    <th>Usuario</th>
                                    <th>Descripcion</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="panel-body" style="height: 600px;" id="formularioregistros">
                                <form name="formulario" id="formulario" method="POST">
                                    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                        <label>Cliente(*):</label>
                                        <input type="hidden" name="idpedido" id="idpedido" >
                                        <select id="idcliente" name="idcliente" class="form-control selectpicker" data-live-search="true" required>

                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <label>Fecha(*):</label>
                                        <input type="date" class="form-control" name="fecha_hora" id="fecha_hora" required="">
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">

                                        <label>Proveedor(*):</label>
                                        <select name="idproveedor" id="idproveedor" class="form-control selectpicker" data-live-search="true" required="">

                                        </select>
                                    </div>


                                    <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                        <label>Producto:</label>
                                        <input type="text" class="form-control" name="articulo" id="articulo"  placeholder="Producto">
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                        <label>Cantidad:</label>
                                        <input type="text" class="form-control" name="cantidad" id="cantidad" maxlength="10" >
                                    </div>


                                    <div class="form-group col-lg-12 col-md-12 col-sm-4 col-xs-12">

                                    <div class="form-group">
                                        <label for="comment">Comentario o Descripción:</label>
                                        <textarea class="form-control" rows="5" id="comment" name="comment"></textarea>
                                    </div>

                                    </div>


                                    <div class="panel-body ">

                                        <button id="btnAgregarDetalles" type="button" class="btn btn-primary" onclick="sacarDetalles()"> <span class="fa fa-plus"></span> Agregar Pedidos</button>
                                        <button id="btnLimpiar" type="button" class="btn btn-warning" onclick="limpiarF()"> <span class="fa fa-close"></span> Limpiar</button>

                                    </div>


                                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                        <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                            <thead style="background-color:#d2ccff">

                                            <th>Opciones</th>

                                            <th>Artículo</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unitario</th>
                                            <th>Precio Venta</th>
                                            <th>Subtotal</th>
                                            </thead>
                                            <tfoot>
                                            <th>TOTAL</th>

                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th><h4 id="total">C$/. 0.00</h4><input type="hidden" name="total_Pedido" id="total_Pedido"></th>
                                            </tfoot>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                                        <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                    </div>




                                </form>
                            </div>
                            <!--Fin centro -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->

        </div><!-- /.content-wrapper -->
        <!--Fin-Contenido-->

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
            <div class="modal-dialog" style="width: 65% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Seleccione un Artículo</h4>
                    </div>
                    <div class="modal-body">
                        <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">

                            <thead>

                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Código</th>
                            <th>Stock</th>
                            <th>Precio Pedido</th>
                            <th>Imagen</th>
                            </thead>
                            <tbody>
                            <tr>







                            </tbody>
                            <tfoot>

                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Código</th>
                            <th>Stock</th>
                            <th>Precio Pedido</th>
                            <th>Imagen</th>
                            </tfoot>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin modal -->
        <?php
    }
    else
    {
        require 'noacceso.php';
    }

    require 'footer.php';
    ?>
    <script type="text/javascript" src="scripts/pedido.js"></script>
    <?php
}
ob_end_flush();
?>