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
    if ($_SESSION['ventas'] == 1)

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
                                <h1 class="p-3 mb-2 bg-aqua-gradient text-white">Socios </h1>
                                <div class="box-tools pull-right">
                                    <button class="btn-adn" onclick="imprimirArea()">Imprimir</button>
                                </div>
                            </div>

                            <div class="panel-body">
<!--                                <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button>-->
                            </div>
                            <!-- /.box-header -->
                            <!-- centro -->

                            <div id="imprimirArea">
                            <div class="panel-body"  id="formularioregistros">

                                    <form name="formularioSocios" id="formularioSocios" method="POST">
                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>Nombre(*):</label>
                                            <input type="hidden" name="idsocio" id="idsocio">
                                            <!--                                    <input type="hidden" name="tipo_personaCliente" id="tipo_personaCliente" value="Cliente" >-->

                                            <input type="text"     class="form-control" name="nombres" id="nombres" maxlength="100" placeholder="Nombres y Apellidos" required>
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                            <label>Tipo de documento(*):</label>
                                            <select class="form-control selectpicker" name="tipo_documento" id="tipo_documento" required>

                                                <option value="CEDULA">Cedula</option>
                                                <option value="RUC">RUC</option>

                                            </select>

                                        </div>

                                        <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <label>Genero(*):</label>
                                            <select class="form-control selectpicker" name="genero" id="genero" required>

                                                <option value="Hombre">Hombre</option>
                                                <option value="Mujer">Mujer</option>

                                            </select>

                                        </div>


                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>Numero de Documento(*):</label>
                                            <input type="text" class="form-control" name="cedula_ruc" id="cedula_ruc" maxlength="256" placeholder="Documento" required>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>Dirección(*):</label>
                                            <input type="text" class="form-control" name="direccion" id="direccion" maxlength="256" placeholder="Direccion" required>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>Teléfono(*):</label>
                                            <input type="text" class="form-control" name="telefono" id="telefono" maxlength="256" placeholder="telefono" required>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>Correo:</label>
                                            <input type="text" class="form-control" name="correo" id="correo" maxlength="50" placeholder="email">
                                        </div>

                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <button class="btn btn-primary" type="submit"  id="btnGuardarSocio"><i class="fa fa-save"></i> Guardar</button>

                                            <button class="btn btn-warning" onclick="limpiarCampos()" type="button"><i class="fa fa-arrow-circle-left"></i> Limpiar</button>
                                        </div>
                                    </form>


                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="listadoregistros">
                                    <table id="listadoSocios" name="listadoSocios"class="table table-striped table-bordered table-condensed table-hover">
                                        <thead>
                                        <th>Opciones</th>
                                        <th>Nombres</th>
                                        <th>Documento</th>
                                        <th>No Documento</th>
                                        <th>Genero</th>
                                        <th>Dirección</th>

                                        <th>Teléfono</th>
                                        <th>Correo</th>
                                        <th>Estado</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                        <th>Opciones</th>
                                        <th>Nombres</th>
                                        <th>Documento</th>
                                        <th>No Documento</th>
                                        <th>Genero</th>
                                        <th>Dirección</th>

                                        <th>Teléfono</th>
                                        <th>Correo</th>
                                        <th>Estado</th>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>

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
    <script type="text/javascript" src="scripts/socios.js"></script>

    <?php

}//Else End

//libera el espacio del BUFFER
ob_end_flush();
?>