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
                                <h1 class="p-3 mb-2 bg-aqua-gradient text-white">Garantias </h1>
                                <div class="box-tools pull-right">
                                    <button class="btn-adn" onclick="imprimirArea()">Imprimir</button>
                                </div>
                            </div>

                            <div class="panel-body">
<!--                                <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button>-->
                            </div>
                            <!-- /.box-header -->
                            <!-- centro -->

                              <!-- centro -->
                              <div class="panel-body table-responsive" id="listado_garantia">
                                <table id="tbllistado_garantia" class="table table-striped table-bordered table-condensed table-hover">
                                    <thead>
                                    <th>Opciones</th>
                                    <th>Dueño</th>
                                    <th>Garantia</th>
                                    <th>Opciones</th>
                                   
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <th>Opciones</th>
                                    <th>Dueño</th>
                                    <th>Garantia</th>
                                    <th>Opciones</th>
                                    </tfoot>
                                </table>
                            </div>    
                            <!--Fin centro -->
                            <!-- centro -->
                            <div class="panel-body table-responsive" id="listado_detalles">
                                <table id="tbllistado_detalles" class="table table-striped table-bordered table-condensed table-hover">
                                    <thead>
                                    <th>Opciones</th>
                                    <th>Descripcion</th>
                                    <th>Categoria</th>
                                    <th>Codigo</th>
                                    <th>Valor</th>
                                    <th>Moneda</th>
                                    <th>Estado</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <th>Opciones</th>
                                    <th>Descripcion</th>
                                    <th>Categoria</th>
                                    <th>Codigo</th>
                                    <th>Valor</th>
                                    <th>Moneda</th>
                                    <th>Estado</th>
                                    </tfoot>
                                </table>
                            </div>    
                            <!--Fin centro -->
                                        
                                        
                        <!--Inicio de form -->
                         <div class="panel-body" style="height: 400px;" id="formularioregistroCliente">
                                                <form name="formularioCliente" id="formularioCliente" method="POST">
                                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <label>Valor(*):</label>
                                                        <input type="hidden" name="id_cliente" id="id_cliente">
                                                        <input type="hidden" name="tipo_personaCliente" id="tipo_personaCliente" value="Cliente" >

                                                        <input type="text"     class="form-control" name="nombreCliente" id="nombreCliente" maxlength="100" placeholder="Nombres y Apellidos" required>
                                                    </div>

                                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <label>Categoria</label>
                                                        <select name="idcategoriaGarantia" id="idcategoriaGarantia" class="form-control selectpicker" data-live-search="true" required></select><!--data live searchj nos permitira hacer filtros aqui -->
                                                        </select>
                                                    </div>
                                                    

                                                    
                                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <label>Moneda</label>
                                                        <select name="monedaGarantia" id="monedaGarantia" class="form-control selectpicker" required><!--data live searchj nos permitira hacer filtros aqui -->
                                                        <option value="Cordobas">Córdobas</option>
                                                        <option value="Dolares">Dólares</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <label>Codigo(*):</label>
                                                        <input type="text" class="form-control" name="num_documentoCliente" id="num_documentoCliente" maxlength="256" placeholder="Documento" required>
                                                    </div>

                                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <label>Descripcion(*):</label>
                                                        <input type="text" class="form-control" name="direccionCliente" id="direccionCliente" maxlength="256" placeholder="Direccion" required>
                                                    </div>

                          

                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <button class="btn btn-primary" type="button" onclick="guardaryeditarCliente()" id="btnGuardarCliente"><i class="fa fa-save"></i> Guardar</button>

                                                        <button class="btn btn-warning" onclick="limpiarCliente()" type="button"><i class="fa fa-arrow-circle-left"></i> Limpiar</button>
                                                    </div>
                                                </form>
                                            </div>



                            
                        </div><!-- /.box -->
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
    <script type="text/javascript" src="scripts/garantias.js"></script>

    <?php

}//Else End

//libera el espacio del BUFFER
ob_end_flush();
?>