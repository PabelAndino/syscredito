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
                                <h1 class="p-3 mb-2 bg-maroon-gradient text-white">Gestionar Egresos </h1>
                                <div class="box-tools pull-right">
                                </div>
                            </div>


                            <!-- /.box-header -->
                            <!-- centro -->


                            <div class="panel-body">
                                <form name="formulario_ncuenta" id="formulario_ncuenta" method="POST">

                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                       
                                        <input type="hidden" id="iddetalle_egreso" VALUE="">
                                    </div>


                                    
                                    
                                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label>Egreso:</label>
                                        <select class="form-control selectpicker" title="Tipo Egreso" data-size="5" name="idegreso_picker" id="idegreso_picker" required>
                                        </select>

                                    </div>

                                    <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Fecha(*):</label>
                                        <input type="date" class="form-control" name="fecha" id="fecha">
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Moneda(*):</label>
                                        <select class="form-control selectpicker" name="moneda" id="moneda" title="Moneda"required>

                                            
                                            <option value="Cordobas">Cordobas</option>
                                            <option value="Dolares">Dolares</option>
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
                                            
                                            <a data-toggle="modal" href="#modalBancos">
                                                <button class="btn btn-bitbucket" type="button" id="btn_bancos"><i class="fa fa-codepen"></i> Gestionar Egreso</button>
                                            </a>

                                        </div>
                                        
                                        

                                            </div>
                                              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <label>Detalles:</label>
                                                <textarea  class="form-control" name="descripcion_egreso" id="descripcion_egreso" placeholder="Destalles"  rows="3"></textarea>
                                            </div>

                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="listadoregistros">
                                        <table id="listadoDetallesEgreso" name="listadoDetallesEgreso"class="table table-striped table-bordered table-condensed table-hover">
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

                                        <button class="btn btn-danger"  onclick="limpiarDetalles()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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
        
        <!-- Fin Modal -->

        <!-- Modal Bancos-->
        <div class="modal fade" id="modalBancos" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true"  >
            <div class="modal-dialog" style="width: 75% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Ingrese Egresos</h4>
                    </div>

                            <form name="formulario_egresos" id="formulario_egresos" method="POST">

                                 <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Nombre del egreso:</label>
                                    <input type="text" class="form-control" name="egreso_input" id="egreso_input"  placeholder="Banco" required>
                                    <input type="number" name="idegreso" id="idegreso" hidden VALUE="">
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Detalles:</label>
                                    <input type="text" class="form-control" name="descripcion_input" id="descripcion_input" placeholder="Descripcion" >
                                </div>

                                <!-- <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Teléfono(*):</label>
                                    <input type="text" class="form-control" name="telefono" id="telefono" maxlength="256" placeholder="telefono" required>
                                </div> -->

                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <button class="btn btn-primary" type="submit"  id="btnGuardarSocio"><i class="fa fa-save"></i> Guardar</button>

                                    <button class="btn btn-warning" onclick="limpiarEgreso()" type="button"><i class="fa fa-arrow-circle-left"></i> Limpiar</button>
                                </div>

                            </form>

                      <div class="">
                        <table id="tbEgresos" class="table table-striped table-bordered table-condensed table-hover">

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
    <script type="text/javascript" src="scripts/egresos.js"></script>

    <?php

}//Else End

//libera el espacio del BUFFER
ob_end_flush();
?>