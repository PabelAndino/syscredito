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
                                <h4 class="p-3 mb-2 ">Print Test (Plan de pago) </h4>
                                <div class="box-tools pull-right">
                                    <button class="btn-adn" id="printbtn" onclick="imprimirArea()">Imprimir</button>
                                </div>



                            </div>

                            <div class="text-center">
                                <img src="../public/img/Credipage.png" alt="image description" class="rounded float-right">

                            </div>
                            <div class="panel-body">
<!--                                <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button>-->
                            </div>
                            <!-- /.box-header -->
                            <!-- centro -->

                            <div id="imprimirArea">
                            <div class="panel-body"  id="formularioregistros">

                                    <form name="formularioSocios" id="formularioSocios" method="POST">

                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
                                            <label>Nombre(*):</label>

                                            <!--                                    <input type="hidden" name="tipo_personaCliente" id="tipo_personaCliente" value="Cliente" >-->

                                            <input type="text"     class="" name="nombres" id="nombres" maxlength="100" placeholder="Nombres y Apellidos" required>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
                                            <label>Tipo de documento(*):</label>
                                            <input type="text" value="CEDULA">

                                        </div>

                                        <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-3">
                                            <label>Genero(*):</label>

                                                <input type="text" value="Hombre">

                                        </div>

                                        <div class=" col-lg-2 col-md-2 col-sm-2 col-xs-4">
                                            <label>Numero de Documento(*):</label>
                                            <input type="text" class="" name="cedula_ruc" id="cedula_ruc" maxlength="256" placeholder="Documento" required>
                                        </div>

                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
                                            <label>Dirección(*):</label>
                                            <input type="text" class="" name="direccion" id="direccion" maxlength="256" placeholder="Direccion" required>
                                        </div>

                                        <div class=" col-lg-2 col-md-2 col-sm-2 col-xs-3">
                                            <label>Teléfono(*):</label>
                                            <input type="text" class="" name="telefono" id="telefono" maxlength="256" placeholder="telefono" required>
                                        </div>

                                        <div class=" col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                            <label>Correo:</label>
                                            <input type="text" class="" name="correo" id="correo" maxlength="50" placeholder="email">
                                        </div>



                                    </form>
                                <br>


                                    <table id="listadoSocios" name="listadoSocios">
                                        <thead>

                                        <th>Nombres</th>
                                        <th>Documento</th>
                                        <th>N.Doc</th>
                                        <th>Genero</th>
                                        <th>Dirección</th>

                                        <th>Teléfono</th>
                                        <th>Correo</th>
                                        <th>Estado</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>

                                        <th>Nombres</th>
                                        <th>Documento</th>
                                        <th>N.Doc</th>
                                        <th>Genero</th>
                                        <th>Dirección</th>

                                        <th>Teléfono</th>
                                        <th>Correo</th>
                                        <th>Estado</th>
                                        </tfoot>

                                    </table>




                            </div>

                                <div class="form-control pt-2"> Segun la puntualidad del pago de las cuotas dependeran sus futuros creditos. Gracias!!!</div>

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
    <script type="text/javascript" src="scripts/printTest.js"></script>

    <?php

}//Else End

//libera el espacio del BUFFER
ob_end_flush();
?>