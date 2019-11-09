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
                                <h1 class="p-3 mb-2 bg-aqua-gradient text-white">Solicitudes </h1>
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

                                    <form name="formularioSocios" id="formularioSolicitud" method="POST">
                                        
                                                            <div class="modal-body">

                                                    <div class="panel-body" style="height: 400px;" id="formularioregistros">

                                                        <form  id="formulario_nueva_solicitud" method="POST">


                                                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Cliente(*)</label>
                                                                <select title="Clientes" data-size="7" name="idcliente_solicitud" id="idcliente_solicitud" class="form-control selectpicker" data-live-search="true" required></select><!--data live searchj nos permitira hacer filtros aqui -->
                                                                <input type="hidden" id="idsolicitud">
                                                            </div>
                                                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Nombre del Conyugue (*)</label>

                                                                <input type="text" class="form-control form-rounded " name="nombre_conyugue" id="nombre_conyugue" maxlength="100" placeholder="Nombre" required>
                                                            </div>

                                                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Tipo de local (*)</label>

                                                                <input  class="form-control" name="tipo_local" id="tipo_local" required>
                                                            </div>


                                                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <h4 >Sabe leer y escribir (*)</h4>

                                                                <div id ="optType" onchange="leerEscribir()">
                                                                    <input type="radio" id="leersi" name="customRadio" class="custom-control-input" >
                                                                    <label class="custom-control-label" for="leersi">Si</label>


                                                                    <input type="radio" id="leerno" name="customRadio" class="custom-control-input">
                                                                    <label class="custom-control-label" for="leerno">No </label>
                                                                </div>

                                                            </div>




                                                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Ultimo año aprobado</label>

                                                                <input type="text" class="form-control" name="ultimoaprov" id="ultimoaprov" placeholder="Descripcion" maxlength="250">
                                                            </div>

                                                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Numero dependientes</label>

                                                                <input type="text" class="form-control" name="num_dependientes" id="num_dependientes" placeholder="Dependientes" maxlength="50">
                                                            </div>


                                                            <div class="form-group  col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                                                <h4>Ingresos Mensuales</h4>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="defaultUnchecked" value="Negocio" name="check">
                                                                    <label class="custom-control-label" for="defaultUnchecked">Negocio .</label>
                                                                    <input type="checkbox" class="custom-control-input" id="defaultUnchecked2" value="Esposo" name="check">
                                                                    <label class="custom-control-label" for="defaultUnchecked2">Espos@ .</label>
                                                                    <input type="checkbox" class="custom-control-input" id="defaultUnchecked3" value="Companero" name="check">
                                                                    <label class="custom-control-label" for="defaultUnchecked3">Compañe@ .</label>
                                                                    <input type="checkbox" class="custom-control-input" id="defaultUnchecked4" value="otros" name="check">
                                                                    <label class="custom-control-label" for="defaultUnchecked4">Otros .</label>

                                                                </div>
                                                                <input type="number" class="input-sm" id="total_ingresos" placeholder="Total">

                                                            </div>


                                                            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Sector</label>
                                                                <select name="sector" id="idsector_picker" class="form-control selectpicker" required>


                                                                </select><!--data live searchj nos permitira hacer filtros aqui -->

                                                            </div>

                                                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <label>Objetivo del Prestamo</label>

                                                                <textarea  rows="5" class="form-control" name="objetico_prestamo" id="objetico_prestamo"></textarea>


                                                            </div>



                                                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <button type="button" onclick="guardarNuevaSolicitud()"  class="btn btn-success"  >Guardar</button>
                                                            </div>




                                                        </form>

                                                    </div>

                                                </div>
                                                
        

                                    </form>


                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="listadoregistros">
                                    <table id="listadoSocios" name="listadoSocios"class="table table-striped table-bordered table-condensed table-hover">
                                        <thead>
                                        <th>Opciones</th>
                                        <th>Cliente</th>
                                        <th>Documento</th>
                                        <th>No Documento</th>
                                        
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                        <th>Opciones</th>
                                        <th>Cliente</th>
                                        <th>Documento</th>
                                        <th>No Documento</th>
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
    <script type="text/javascript" src="scripts/solicitud.js"></script>

    <?php

}//Else End

//libera el espacio del BUFFER
ob_end_flush();
?>