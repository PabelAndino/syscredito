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
                                <h1 class="p-3 mb-2 bg-maroon-gradient text-white">Fiador </h1>
                                <div class="box-tools pull-right">
                                </div>
                            </div>

                            <div class="panel-body">
                                
                            </div>
                            <!-- /.box-header -->

                            <div class="panel-body" style="height: 400px;" id="formularioregistroCliente">
                                <form name="formularioCliente" id="formularioCliente" method="POST">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Nombre(*):</label>
                                        <input type="hidden" name="id_cliente" id="id_cliente">
                                        <input type="hidden" name="tipo_personaCliente" id="tipo_personaCliente" value="Cliente" >

                                        <input type="text"     class="form-control" name="nombreCliente" id="nombreCliente" maxlength="100" placeholder="Nombres y Apellidos" required>
                                    </div>

                                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label>Tipo de documento(*):</label>
                                        <select class="form-control selectpicker" name="tipo_documentoCliente" id="tipo_documentoCliente" required>

                                            <option value="CEDULA">Cedula</option>
                                            <option value="RUC">RUC</option>

                                        </select>

                                    </div>

                                    <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                        <label>Genero(*):</label>
                                        <select class="form-control selectpicker" name="genero_cliente" id="genero_cliente" required>

                                            <option value="Hombre">Hombre</option>
                                            <option value="Mujer">Mujer</option>

                                        </select>

                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Estado Civil(*):</label>
                                        <select class="form-control selectpicker" name="estado_civil" id="estado_civil" required>

                                            <option value="Casado">Casado</option>
                                            <option value="Soltero">Soltero</option>
                                            <option value="Acompanado">Acompanado</option>

                                        </select>

                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Numero de Documento(*):</label>
                                        <input type="text" class="form-control" name="num_documentoCliente" id="num_documentoCliente" maxlength="256" placeholder="Documento" required>
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Dirección(*):</label>
                                        <input type="text" class="form-control" name="direccionCliente" id="direccionCliente" maxlength="256" placeholder="Direccion" required>
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Teléfono(*):</label>
                                        <input type="text" class="form-control" name="telefonoCliente" id="telefonoCliente" maxlength="256" placeholder="telefono" required>
                                    </div>

                                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label>Correo:</label>
                                        <input type="text" class="form-control" name="emailCliente" id="emailCliente" maxlength="50" placeholder="email">
                                    </div>
                                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label>Ingresos:</label>
                                        <input type="text" class="form-control" name="ingresosCliente" id="ingresosCliente" maxlength="50" placeholder="Ingresos">
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button class="btn btn-primary" type="button" onclick="guardaryeditarFiador()" id="btnGuardarCliente"><i class="fa fa-save"></i> Guardar</button>

                                        <button class="btn btn-warning" onclick="limpiarCliente()" type="button"><i class="fa fa-arrow-circle-left"></i> Limpiar</button>
                                    </div>
                                </form>
                            </div>
                                
                            <!-- centro -->
                            <div class="panel-body table-responsive" id="listadoregistros">
                                <table id="tbllistadoFiador" class="table table-striped table-bordered table-condensed table-hover">
                                    <thead>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Documento</th>
                                    <th>Número</th>
                                    <th>Género</th>
                                    <th>Est Civil</th>
                                    <th>Dirección</th>
                                    <th>Telefóno</th>
                                    <th>Correo</th>
                                    <th>Ingresos</th>
                                    <th>Estado</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Documento</th>
                                    <th>Número</th>
                                    <th>Género</th>
                                    <th>Est Civil</th>
                                    <th>Dirección</th>
                                    <th>Telefóno</th>
                                    <th>Correo</th>
                                    <th>Ingresos</th>
                                    <th>Estado</th>
                                    </tfoot>
                                </table>
                            </div>    
                            <!--Fin centro -->
                            <!-- centro -->




                            
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
    <script type="text/javascript" src="scripts/cliente.js"></script>

    <?php

}//Else End

//libera el espacio del BUFFER
ob_end_flush();
?>