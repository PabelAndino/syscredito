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
                                <h1 class="p-3 mb-2 bg-maroon-gradient text-white">Gestionar cuentas de Socios </h1>
                                <div class="box-tools pull-right">
                                </div>
                            </div>


                            <!-- /.box-header -->
                            <!-- centro -->


                            <div class="panel-body">
                                <form name="formulario_ncuenta" id="formulario_ncuenta" method="POST">

                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <h2>Datos Socios</h2>
                                        <input type="hidden" id="idcuenta_banco" VALUE="">
                                    </div>

                                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label>Socio(*):</label>
                                        <select class="form-control selectpicker" title="Socios" data-size="5" name="socios_picker" id="socios_picker" required>



                                        </select>

                                    </div>

                                    
                                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label>Banco:</label>
                                        <select class="form-control selectpicker" title="Bancos" data-size="5" name="banco_nombre" id="banco_nombre" required>
                                        </select>

                                    </div>

                                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label>Numero de Cuenta:</label>
                                        <input type="text" class="form-control" name="num_cuenta" id="num_cuenta" maxlength="256" placeholder="Documento">
                                    </div>


                                    <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Fecha(*):</label>
                                        <input type="date" class="form-control" name="fecha" id="fecha">
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Moneda(*):</label>
                                        <select class="form-control selectpicker" name="moneda" id="moneda" required>

                                            <option value="Dolares">Dolares</option>
                                            <option value="Cordobas">Cordobas</option>

                                        </select>

                                    </div>

                                    <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Monto:</label>

                                        <input type="text" class="form-control" name="monto" id="monto" maxlength="100" placeholder="Monto" required>
                                    </div>

                                    <!--Montos para editar-->
                                    <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12" >
                                        <!-- <label>Montos:</label>
                                        <select class="form-control selectpicker" title="Montos" data-size="5" name="montos_picker" id="montos_picker"  ><!--CARGARA LOS MONTOS PARA EDITARLOS-->

                                        <!-- </select> -->

                                      </div>

                                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">

                                        <div class="well-sm">
                                            <a data-toggle="modal" href="#modalSocios">
                                                <button class="btn btn-warning" type="button" id="btn_socio"><i class="fa fa-user"></i> Socio</button>
                                            </a>
                                            <a data-toggle="modal" href="#modalBancos">
                                                <button class="btn btn-bitbucket" type="button" id="btn_bancos"><i class="fa fa-bank"></i> Bancos</button>
                                            </a>

                                        </div>

                                        <!-- <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">

                                        <div class="well-sm">
                                            
                                        </div> -->

<!--                                        <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>-->
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="listadoregistros">
                                        <table id="listadoCuentas" name="listadoCuentas"class="table table-striped table-bordered table-condensed table-hover">
                                            <thead>
                                            <th>Opciones</th>
                                            <th>Fecha</th>
                                            <th>No Cuenta</th>
                                            <th>Socio</th>
                                            <th>Documento</th>
                                            <th>Banco</th>
                                            <th>No Cuenta Banco</th>
                                            <th>Moneda</th>
                                            <th>Monto</th>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                            <th>Opciones</th>
                                            <th>Fecha</th>
                                            <th>No Cuenta</th>
                                            <th>Socio</th>
                                            <th>Documento</th>
                                            <th>Banco</th>
                                            <th>No Cuenta Banco</th>
                                            <th>Moneda</th>
                                            <th>Monto</th>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button class="btn btn-primary" type="submit"  id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                                        <button class="btn btn-danger"  type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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

        <div class="modal fade" id="modalSocios" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >

            <div class="modal-dialog" style="width: 75% !important;">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Agregar Datos de Socios</h4>
                    </div>
                    <div class="modal-body">

                        <div class="panel-body" style="height: 400px;" id="formularioregistroCliente">
                            <form name="formularioSocios" id="formularioSocios" method="POST">
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Nombre(*):</label>
                                    <input type="hidden" name="idsocio" id="idsocio">


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

                                    <button class="btn btn-warning"  type="button"><i class="fa fa-arrow-circle-left"></i> Limpiar</button>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger"  data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        
        <!-- Fin Modal -->

        <!-- Modal Bancos-->
        <div class="modal fade" id="modalBancos" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true"  >
            <div class="modal-dialog" style="width: 75% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Ingrese un Banco</h4>
                    </div>

                            <form name="formularioBancos" id="formularioBancos" method="POST">

                                 <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Nombre del Banco:</label>
                                    <input type="text" class="form-control" name="banco_input" id="banco_input"  placeholder="Banco" required>
                                    <input type="number" name="idbanco" id="idbanco" hidden VALUE="">
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Descripción:</label>
                                    <input type="text" class="form-control" name="descripcion_input" id="descripcion_input" placeholder="Descripcion" required>
                                </div>

                                <!-- <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Teléfono(*):</label>
                                    <input type="text" class="form-control" name="telefono" id="telefono" maxlength="256" placeholder="telefono" required>
                                </div> -->

                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <button class="btn btn-primary" type="submit"  id="btnGuardarSocio"><i class="fa fa-save"></i> Guardar</button>

                                    <button class="btn btn-warning"  type="button"><i class="fa fa-arrow-circle-left"></i> Limpiar</button>
                                </div>

                            </form>

                      <div class="">
                        <table id="tbBancos" class="table table-striped table-bordered table-condensed table-hover">

                            <thead>

                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <tbody>
                            <tr>

                            </tbody>
                            <tfoot>

                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            
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

    }//fin deel if de inicio de session que da los permisos

    else {
        require 'noacceso.php';
    }
    require 'footer.php';
    ?>
    <script type="text/javascript" src="scripts/bancos.js"></script>

    <?php

}//Else End

//libera el espacio del BUFFER
ob_end_flush();
?>