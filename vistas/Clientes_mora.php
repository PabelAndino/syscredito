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
                        <h1 class="box-title">Articulo
                            <button class="btn btn-success" onclick="mostrarform(true)" id="btnAgregar"><i class="fa fa-plus-circle"></i> Agregar </button><a target="_blank" href="../reportes/rptarticulos.php">  <button  class="btn btn-info" >Reporte</button></a></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">

                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Categoria</th>
                            <th>Código</th>
                            <th>Stock</th>
                            <th>Imagen</th>
                            <th>Estado</th>
                            </thead>
                            <tbody>
                            <!----  La loquera de aqui quien lo llena es el dataTable-->
                            </tbody>

                            <tfoot>

                            </tfoot>
                        </table>


                    </div>


                    <div class="panel-body" style="height: 400px;" id="formularioregistros">

                        <form action="formulario" id="formulario" method="POST">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Nombre</label>
                                <input type="hidden"  name="idarticulo" id="idarticulo">
                                <input type="text" class="form-control form-rounded " name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Categoria</label>
                                <select name="idcategoria" id="idcategoria" class="form-control selectpicker" data-live-search="true" required></select><!--data live searchj nos permitira hacer filtros aqui -->

                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Stock</label>

                                <input type="number" class="form-control" name="stock" id="stock" required readonly>
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Descripción</label>

                                <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Descripcion" maxlength="250">
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Imagen</label>

                                <input type="file" class="form-control" name="imagen" id="imagen" >
                                <input type="hidden" name="imagenactual" id="imagenactual">
                                <img src="" width="150px" height="120px" id="imagenmuestra">
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Codigo</label>

                                <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Codigo de barras" >
                                <button class="btn btn-success" type="button" onclick="generarbarcode()">Generar</button>
                                <button class="btn btn-info" type="button" onclick="imprimir()">Imprimir</button>
                                <div id="print">
                                    <svg id="barcode"></svg>
                                </div>



                            </div>



                            <div class="form-group col-lg-12 col-md-12 col-sm-6 col-xs-12" >
                                <button class="btn btn-primary" type="submit" id="btnGuardar" ><i class="fa fa-save"></i>Guardar</button>
                                <!--                               <button class="btn btn-warning"  id="btnLimpiar"  onclick="limpiar()"><i class="fa fa-close"></i>Limpiar</button>-->
                                <button class="btn btn-danger" onclick="cancelarform()" type="button" ><i class="fa fa-arrow-circle-left"></i>Cancelar</button>
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
<?php
    }//fin deel if de inicio de session que da los permisos

    else {
        require 'noacceso.php';
    }
require 'footer.php';
?>
<script type="text/javascript" src="../public/js/JsBarcode.all.min.js"></script>
<script type="text/javascript" src="../public/js/jquery.PrintArea.js"></script>
<script type="text/javascript" src="scripts/articulo.js"></script>
    <?php
}

//libera el espacio del BUFFER
ob_end_flush();
?>