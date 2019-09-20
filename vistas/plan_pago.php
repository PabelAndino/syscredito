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
            <button class="btn-dark" id="printbtn" onclick="muestraEstadoCuenta()"><i class="fa fa-adjust"></i></button>
            <button class="btn-adn" id="printbtn" onclick="imprimirArea()"><i class="fa fa-print"></i></button>

            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h5 class="p-3 mb-2 ">Plan de pago </h5>
                                <div class="box-tools pull-right">

                                </div>



                            </div>

                            <div class="text-center">
                                <img src="../public/img/Credipage.png" alt="image description" class="rounded float-right">

                            </div>


                            <!-- /.box-header -->
                            <!-- centro panel body -->

                            <div id="imprimirArea">
                                <div class="panel-body">



                                    <br>
                                    <form name="formularioHipoteca" id="formularioHipoteca" method="POST">



                                        <table style="width:100%">
                                            <tr>
                                                <th>Fecha desembolso</th>
                                                <th>Fecha Pago</th>

                                                <th>Interes Mora</th>
                                                <th>Monto</th>
                                            </tr>
                                            <tr>
                                                <td><input type="date"  name="fechaHipoteca" id="fechaHipoteca"></td>

                                                <td><input type="date"  name="fechaPago" id="fechaPago"></td>


                                                <td><input type="number"  name="interes_moratorio" id="interes_moratorio" maxlength="7" placeholder="Interes Mora" step=".01" min="0" required></td>
                                                <td><input type="number" placeholder="Monto" name="monto_ncuenta" id="monto_ncuenta" maxlength="10" step=".01" min="0" required></td>
                                            </tr>

                                            <tr>
                                                <th>Moneda</th>
                                                <th>Plazo</th>

                                                <th>Mantenimiento valor</th>
                                                <th><label id="interes_lab">Interes</label></th>
                                            </tr>

                                            <tr>
                                                <td><select name="monedaHipoteca" id="monedaHipoteca" required>

                                                        <option value="Cordobas">Córdobas</option>
                                                        <option value="Dolares">Dólares</option>

                                                    </select>
                                                </td>
                                                <td><select name="plazo_month" id="plazo_month" title="Meses"  required>

                                                        <option value="1">1 mes</option>
                                                        <option value="2">2 meses</option>
                                                        <option value="3">3 meses</option>
                                                        <option value="4">4 meses</option>
                                                        <option value="5">5 meses</option>
                                                        <option value="6">6 meses</option>
                                                        <option value="7">7 meses</option>
                                                        <option value="8">8 meses</option>
                                                        <option value="9">9 meses</option>
                                                        <option value="10">10 meses</option>
                                                        <option value="11">11 meses</option>
                                                        <option value="12">1 año</option>
                                                        <option value="24">2 años</option>
                                                        <option value="36">3 años</option>
                                                        <option value="48">4 años</option>
                                                        <option value="60">5 años</option>
                                                        <option value="72">6 años</option>
                                                        <option value="84">7 años</option>
                                                        <option value="96">8 años</option>

                                                    </select>
                                                </td>

                                                <td><input type="number"  name="mantenimiento" id="mantenimiento" placeholder="Mant Valor" step=".01" min="0"></td>

                                                <td><input type="number" name="interes" id="interes" maxlength="7" placeholder="Interes" step=".01" min="0" required></td>
                                            </tr>

                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th>Comision Total</th>
                                                <th>Comision</th>
                                            </tr>
                                            <tr>
                                                 <td ></td>
                                                <td></td>
                                                 <td><input type="number"  id="comision_total" name="comision_total" maxlength="7" placeholder="Comision Total" step=".01" min="0" required>
                                                 <td><input type="number"  name="comision" id="comision" maxlength="7" placeholder="Comision" step=".01" min="0" required></td>
                                            </tr>


                                        </table>

<table>
    <tr><th>Cliente</th></tr>
    <tr>
      <td> <input type="text" size="50"  placeholder="Nombres y Apellidos del Cliente"></td>
    </tr>
</table>





                                        <table id="detallesEstado"  class="display compact">

                                            <thead>

                                            <th>Plazo</th>
                                            <th>Fecha</th>
                                            <th>Capital</th>
                                            <th>Interes</th>
                                            <th>Mant de Valor</th>
                                            <th>Saldo Capital</th>
                                            <th>Total a abonar</th>
                                            <th>Moneda</th>

                                            </thead>
                                            <tfoot>


                                            </tfoot>
                                            <tbody>

                                            </tbody>
                                        </table>

                                    </form>

                                </div>

                              </div>
                            <!--Fin centro PRint area -->
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
    <script type="text/javascript" src="scripts/plan_pago.js"></script>

    <?php

}//Else End

//libera el espacio del BUFFER
ob_end_flush();
?>