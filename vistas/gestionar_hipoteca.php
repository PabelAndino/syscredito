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
    if ($_SESSION['compras'] == 1)

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


                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="box-header with-border">
                        <h1 class="box-title badge">Prestamos   <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>

                    </div>
                    <br>


                    <div role="tabpanel">

                        <ul class="nav nav-tabs " role="tablist">
                            <li role="presentation" class="active"><a href="#seccion1"  class="badge" aria-controls="seccion1" data-toggle="tab" role="tab"> Nueva Cuenta</a> </li>
                            <li role="presentation"><a href="#seccion2" class="badge" aria-controls="seccion2"  data-toggle="tab" role="tab"> Abonos</a> </li>
                            <li role="presentation"><a href="#seccion3" class="badge" aria-controls="seccion3"   data-toggle="tab" role="tab"> Detalles de cuentas </a></li>
                        </ul>

                        <div class="tab-content">
                            <!-- Seccion 1 Nuevo Cuenta -->    <div role="tabpanel" class="tab-pane active" id="seccion1">
                                <!--<h3>Contenido 1</h3>-->
                                <div class="panel-body">
                                <br>
                                <label class="label label-primary">Nueva Cuenta</label>
                                <br>
                                <br>
                                <form name="formularioHipoteca" id="formularioHipoteca" method="POST">
                                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label>Solicitud(*):</label>

                                        <input type="hidden" class="form-control" name="idhipoteca" id="idhipoteca" maxlength="7">
                                        <select id="idsolicitud_picker"  title="Buscar Cuenta" name="idsolicitud_picker" class="form-control selectpicker" data-size="4" data-live-search="true" required>

                                        </select>
                                    </div>

                                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-6">

                                        <label>Fiador(*):</label>
                                        <select   id="idfiador_picker"  title="Busca al Fiador" name="idfiador_picker" class="form-control selectpicker" data-size="4" data-live-search="true" required>
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                        <label>Garantía(*):</label>
                                        <select  title="Busca al Garantia" name="idgarantia" id="idgarantia" class="form-control selectpicker" data-size="4" data-live-search="true" required>

                                        </select>
                                    </div>

                                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                        <label>Banco(*):</label>
                                        <select  title="Buscar cuentas de banco" name="idbancos" id="idbancos" class="form-control selectpicker" data-size="4" data-live-search="true" required>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Fecha Desembolso(*):</label>
                                        <input type="date" class="form-control" name="fechaHipoteca" id="fechaHipoteca">
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <label>Fecha Pago(*):</label>
                                        <input type="date" class="form-control" name="fechaPago" id="fechaPago">
                                    </div>

                                    <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                        <label>Moneda(*):</label>
                                        <select name="monedaHipoteca" id="monedaHipoteca" class="form-control selectpicker" required>

                                            <option value="Cordobas">Córdobas</option>
                                            <option value="Dolares">Dólares</option>

                                        </select>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                        <label>Monto(*):</label>
                                        <input type="text" class="form-control" name="monto_ncuenta" id="monto_ncuenta"  onkeypress="mascara(this,cpf)" maxlength="10" step=".01" min="0" required>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                        <label>Interés(*):</label>
                                        <input type="number" class="form-control" name="interes" id="interes" maxlength="7" placeholder="Serie" step=".01" min="0" required>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                        <label>Interés Moratorio(*):</label>
                                        <input type="number" class="form-control" name="interes_moratorio" id="interes_moratorio" maxlength="7" placeholder="Serie" step=".01" min="0" required>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                        <label>Mantenimiento de valor:</label>
                                        <input type="number" class="form-control" name="mantenimiento" id="mantenimiento"  step=".01" min="0">
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                        <label>Comision(*):</label>
                                        <input type="number" class="form-control" name="comision" id="comision" maxlength="7" placeholder="Serie" step=".01" min="0" required>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                        <label>Plazo(*):</label>
                                        <select name="plazo_month" id="plazo_month" title="Meses" class="form-control selectpicker" required>

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
                                    </div>

                                    <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                        <label>Tipo(*):</label>
                                        <select class="form-control selectpicker" name="tipo" id="tipo" required>

                                            <option value="Empeño">Empeño</option>
                                            <option value="Prestamo">Prestamo</option>

                                        </select>

                                    </div>





                                    <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                        <label>Saldo del Banco:</label>
                                        <input  class="form-control"  type="number" name="saldo_banco" id="saldo_banco"  step=".01" min="0" >
                                        <label id="banco_moneda">MONEDA</label>
                                    </div>


                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                        <div class="well well-sm">
                                            <button type="button" onclick="" class="btn btn-adn"><i class="fa fa-amazon"></i></button>

                                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">

                                                <label>Cambio dólar:</label>
                                                <input  class="form-control" name="saldo_banco" id="saldo_banco"  >
                                            </div>
                                            <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                <label>C$:</label>
                                                <input  class="form-control" name="saldo_banco" id="saldo_banco"  >
                                            </div>
                                            <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                                <label>$:</label>
                                                <input  class="form-control" name="saldo_banco" id="saldo_banco"  >
                                            </div>

                                        </div>


                                    </div>



                                    <div class="form-group col-lg-12 col-md-12 col-sm-6 col-xs-12">

                                        <label>Nota:</label>
                                        <textarea class="form-control" rows="5" id="comment" name="comment"></textarea>

                                    </div>

                                   <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                       <div class="well well-sm">
                                       <a data-toggle="modal" href="#modalCliente">
                                            <button id="btnAgregarArt" type="button" class="btn btn-primary"> <span class="fa fa-user"></span> Agregar Cliente</button>
                                        </a>


                                        <a data-toggle="modal" href="#modalFiador">
                                            <button id="btnAgregarArt" type="button" class="btn bg-light-blue-gradient"> <span class="fa fa-archive"></span> Agregar Fiador</button>
                                        </a>
                                           <a data-toggle="modal" href="#modal_nueva_cuenta">
                                               <button id="btnAgregarArt" type="button" class="btn bg-light-blue-gradient"> <span class="fa fa-archive"></span> Solicitud</button>
                                           </a>

                                        <a data-toggle="modal"  href="#modalGarantia">
                                            <button id="fiado" type="button" class="btn btn-warning" onclick="cargarCliente() + cargarCategoria()"> <span class="fa fa-bank"></span>Garantía</button>
                                        </a>

                                           <a data-toggle="modal" href="#modalEstado">
                                               <button id="btnestado" onclick="muestraEstadoCuenta()" type="button" class="btn btn-primary"> <span class="fa fa-user"></span> Plan de Pagos</button>
                                           </a>
                                       </div>
                                   </div>



                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="well well-sm">
                                        <button class="btn btn-success" type="submit" id="btGuardar" ><i class="fa fa-save"></i> Guardar</button>
                                        <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                        <button type="button" onclick="evaluar()" class="btn btn-bitbucket">Evaluar</button>
                                        </div>
                                    </div>


                                   <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                       <h4 class="badge badge-dark">Detalles de Cuenta</h4>
                                       <table id="detallesNuevaCuenta"  class="table table-striped table-bordered table-condensed table-hover">
                                           <thead style="background-color: #8fff87">

                                            <th>Opciones</th>
                                            <th>Cuenta</th>
                                            <th>Cliente</th>
                                            <th>Cedula</th>
                                            <th>Monto</th>
                                            <th>Interes</th>
                                            <th>Interes Moratorio</th>
                                            <th>Moneda</th>
                                            <th>Estado</th>
                                            <th>Condicion</th>

                                           <th style="white-space: nowrap;min-width: 200px;max-width: 200px;overflow: scroll">Nota</th>

                                           </thead>

                                           <tbody>

                                           </tbody>
                                       </table>
                                   </div>

                            </form>

                                </div>
                            </div><!--FIn de seccion 1-->
                            <!--Seccion 2 Abonos -->           <div role="tabpanel" class="tab-pane" id="seccion2">
                                           
                                                
                                                <div class="panel-body">
                                                   
                                                    <h3>Abonos</h3>
                                                    <form name="formularioAbono" id="formularioAbono" method="POST" style="height: 100%">
                                                        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label>Buscar Cuenta-Cliente(*):</label>

                                                          <select title="Busca al Cuenta del cliente" id="buscarClientesAbono" name="buscarClientesAbono" class="form-control selectpicker" data-size="4" data-live-search="true" required>

                                                        </select>
                                                        </div>

                                                    <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label>Fecha(*):</label>
                                                        <input type="date" class="form-control" name="fecha_horaAbono" id="fecha_horaAbono">
                                                    </div>



                                                    <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                                        <label>Interes:</label>
                                                        <input type="number" class="form-control" maxlength="10" step=".01" min="0" name="abonointeres" id="abonointeres" maxlength="7" placeholder="Abono Interes">
                                                        <input type="hidden" class="form-control" name="idabonodetalles" id="idabonodetalles" maxlength="7" placeholder="Abono Interes"><!--Este es el id de abono que se genera cuando se va a editar un abono-->
                                                        <input type="hidden" class="form-control" name="idhipotecaAbonar" id="idhipotecaAbonar" maxlength="7" placeholder="Abono Interes">  <!--es el mismo idhipoteca que se necesita para guardar un abono-->
                                                        <!-- <input type="hidden" class="form-control" name="idfinanciamientoAbonar" id="idfinanciamientoAbonar" maxlength="7" placeholder="Abono Interes">-->

                                                        <input type="hidden" class="form-control" name="ultimoidabono" id="ultimoidabono" maxlength="7" placeholder="test">
                                                    </div>

                                                        

                                                        <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                            <label>Interes moratorio:</label>
                                                            <input type="text" class="form-control" maxlength="10" step=".01" min="0" name="interes_moratorio_abono" id="interes_moratorio_abono" maxlength="7" placeholder="Cuota" VALUE="0.00">
                                                        </div>
                                                        <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                                            <label>Amortizacion:</label>
                                                            <input type="number" class="form-control" maxlength="10" step=".01" min="0" name="abono_capital" id="abono_capital" maxlength="7" placeholder="Cuota" VALUE="0.00">
                                                        </div>
                                                        <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-6" style="border: 5px ;border-color: #0c0c0c">
                                                            <div class="well well-sm">
                                                                <a data-toggle="modal" href="#modalCuentas">
                                                                    <button id="btnBuscarCuenta" type="button" onclick="muestraCuentasPendientesAbono()" class="btn btn-primary"> <span class="fa fa-plus"></span> Cuentas</button>
                                                                </a>
                                                            </div>
                                                        </div>

                                                    <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                                        <label>Mant Valor:</label>
                                                        <input type="number" class="form-control" maxlength="10" step=".01" min="0" name="mantValortotal" id="mantValortotal" maxlength="7" placeholder="Abono Interes" VALUE="0.00">
                                                    </div>


                                                      <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                            <label>Intereses(sumado):</label>
                                                            <input type="number" class="form-control" maxlength="10"  step=".01" min="0"  name="intereses" id="intereses" maxlength="7" placeholder="0" >
                                                        </div>


                                                        <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                            <label>Cuota:</label>
                                                            <input type="number" class="form-control" maxlength="10"  step=".01" min="0" name="cuota" id="cuota" maxlength="7" placeholder="0" >
                                                        </div>

                                                        


                                                        <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                            <label>Monto a Pagar:</label>
                                                            <input type="text"  class="form-control" name="monto_pago" id="monto_pago" maxlength="10" placeholder="$0">
                                                        </div>

                                                        <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                            <h4 style="color: #0074ff">Primer Interés:</h4>
                                                            <input type="text" readonly class="form-control" name="primerInteresAbono" id="primerInteresAbono" maxlength="7" placeholder="$0">
                                                        </div>

                                                        <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                            <h4 style="color: #6f42c1">Monto Restante:</h4>
                                                            <input type="text" class="form-control" name="siguienteMonto" id="siguienteMonto" maxlength="10" placeholder="$0">
                                                        </div>


                                                        

                                                    

                                                        <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <h5 style="color: #eb6d00">Pendiente:  <span class="badge badge-info" id="label_pendiente">0</span>  </h5>   
                                                        </div>

                                                        <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">

                                                        <h5 style="color: #eb6d00">A Capital:  <span class="badge badge-info" id="label_a_capital">0</span>  </h5>   

                                                        <h5 style="color: #eb6d00">A Interes:  <span class="badge badge-info" id="label_a_interes">0</span>  </h5>   
                                                        </div>
                                                        
                                                        <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">

                                                        <h5 style="color: #eb6d00">A Interes M:  <span class="badge badge-info" id="label_a_interes_m">0</span>  </h5>   

                                                        <h5 style="color: #eb6d00">A Mant V:  <span class="badge badge-info" id="label_a_mant_v">0</span>  </h5>   
                                                        </div>
                                                        <!-- <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <h3 style="color: #eb6d00">A Capital:  <span class="badge badge-info" id="label_a_capital">0</span>  </h3>   
                                                        </div>

                                                        <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <h3 style="color: #eb6d00">A Capital:  <span class="badge badge-info" id="label_a_capital">0</span>  </h3>   
                                                        </div> -->
                                                        
                                                    

                                                        


                                                        <!--<div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                            <h4 style="color: #6f42c1">Siguiente Interés:</h4>
                                                            <input type="text" class="form-control" name="siguienteInteres" id="siguienteInteres" maxlength="7" placeholder="$0">
                                                        </div>-->

                                                        

                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <label>Concepto:</label>
                                                        <textarea class="form-control" rows="5" id="commentAbono" name="commentAbono" ></textarea>
                                                    </div>



                                                     <!--Tabla Abonos-->   <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                                        <h4 class="bg-green-gradient">Detalles de Abonos</h4>
                                                        <table id="detallesAbonos"  class="table table-striped table-bordered table-condensed table-hover">

                                                            <thead style=" background-color: #6ce393">

                                                            <th>Opciones</th>
                                                            <th>Fecha</th>
                                                            <th>Concepto</th>
                                                            <th>Interes</th>
                                                            <th>Capital</th>
                                                            <th>Saldo Pendiente</th>
                                                            <th>Moneda</th>

                                                            </thead>


                                                            <tfoot>

                                                            <th></th>
                                                            <th></th>
                                                            <th><h4>$/ 0.00</h4></th>
                                                            <th><h4>$/ 0.00</h4></th>
                                                            <th></th>
                                                            </tfoot>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                        <!--Tabla MORA-->   <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                                            <h4 class="bg-red-gradient">Detalles de Mora</h4>
                                                            <table id="detalles_mora"  class="table table-striped table-bordered table-condensed table-hover">
                                                                   
                                                                <thead style=" background-color: #ff4e00">

                                                                <th>Meses</th>
                                                                <th>Fechas</th>
                                                                <th>Interes Diario</th>
                                                                <th>Interes Moratorio</th>
                                                                <th>Mant Valor</th>
                                                                <th>Total Interes</th>
                                                                <th>Moneda</th>
                                                                </thead>
                                                                <tfoot>
                                                                <th>Opciones</th>
                                                                <th>Año</th>
                                                                <th>Interes diario</th>
                                                                <th>Interes Moratorio</th>
                                                                <th>Mant Valor</th>
                                                                <th>Total Interes</th>

                                                                <th>Moneda</th>

                                                                </tfoot>
                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!--Detalles Cuenta--><div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                                            <h4 class="bg-yellow-gradient">Detalles de Cuenta</h4>

                                                            <table id="detallesCuenta"  class="table table-striped table-bordered table-condensed table-hover">
                                                                <thead style="background-color: #ffd82b">

                                                                <th>Fecha</th>
                                                                <th>Fiador</th>
                                                                <th>Garantia</th>
                                                                <th>Monto</th>
                                                                <th>Interés</th>
                                                                <th>Moneda</th>
                                                                <th style="white-space: nowrap;min-width: 200px;max-width: 200px;overflow: scroll">Nota</th>

                                                                </thead>
                                                                <tfoot>
                                                                <th>TOTAL</th>
                                                                <th></th>
                                                                <th></th>
                                                                <th><h4>$/ 0.00</h4></th>
                                                                <th><h4>$/ 0.00</h4></th>
                                                                <th></th>
                                                                <th></th>

                                                                </tfoot>
                                                                <tbody>

                                                                </tbody>
                                                            </table>


                                                        </div>

                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <button class="btn btn-primary" type="submit"  id="btnGuardarAbono"><i class="fa fa-save"></i> Guardar</button>

                                                            <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                                        </div>

                                                
                                                </div>
                            </div><!--Fin de Seccion 2 ///-->
                            <!--Seccion 3 Detalles de abono --><div role="tabpanel" class="tab-pane" id="seccion3">
                                <h3 class="h3"><span class="">Abonos del Dia</span></h3>

                                <div class="panel-body" style="height: 400px;" id="formularioregistros">

                                    <form name="formulario" id="formulario" method="POST">


                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                            <table id="tbllistadoHipotecas" class="table table-striped table-bordered table-condensed table-hover">


                                                <thead>
                                                <th>Opciones</th>
                                                <th>Fecha</th>
                                                <th>Cliente</th>
                                                <th>Abono Capital</th>
                                                <th>Abono Interes</th>
                                                <th>Total de abonos</th>
                                                <th>Moneda</th>
                                                </thead>
                                                <tbody>
                                                <!----  La loquera de aqui quien lo llena es el dataTable-->
                                                </tbody>

                                                <tfoot>
                                                <th>Opciones</th>
                                                <th>Fecha</th>
                                                <th>Cliente</th>
                                                <th>Abono Capital</th>
                                                <th>Abono Interes</th>
                                                <th>Total de abonos</th>
                                                <th>Moneda</th>
                                                </tfoot>
                                            </table>

                                        </div>


                                    </form>
                                </div>

                            </div><!--Fin de Seccion 3-->

                            </div><!--Fin Del content-->

                        </div><!-- Fin TabPanel -->

                </div><!-- /.row -->
    </section><!-- /.content -->

</div><!-- /.content-wrapper -->
<!--Fin-Contenido-->

        <!-- Modal Cliente -->
        <div class="modal fade" id="modalCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
            <div class="modal-dialog" style="width: 75% !important;">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Agregar Datos del Cliente</h4>
                    </div>
                    <div class="modal-body">

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

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Correo:</label>
                                    <input type="text" class="form-control" name="emailCliente" id="emailCliente" maxlength="50" placeholder="email">
                                </div>

                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <button class="btn btn-primary" type="button" onclick="guardaryeditarCliente()" id="btnGuardarCliente"><i class="fa fa-save"></i> Guardar</button>

                                    <button class="btn btn-warning" onclick="limpiarCliente()" type="button"><i class="fa fa-arrow-circle-left"></i> Limpiar</button>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="limpiarCliente()" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin modal -->

        <!-- Modal Nueva Solicitud -->
        <div class="modal fade" id="modal_nueva_cuenta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
            <div class="modal-dialog" style="width: 75% !important;">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Solicitud de prestamo</h4>
                    </div>
                    <div class="modal-body">

                        <div class="panel-body" style="height: 400px;" id="formularioregistros">

                            <form  id="formulario_nueva_solicitud" method="POST">


                                <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <label>Cliente(*)</label>
                                    <select title="Clientes" data-size="7" name="idcliente_solicitud" id="idcliente_solicitud" class="form-control selectpicker" data-live-search="true" required></select><!--data live searchj nos permitira hacer filtros aqui -->

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
                                    <button type="submit" class="btn btn-success"  >Guardar</button>
                                </div>

                            </form>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="limpiarCliente()" data-dismiss="modal">Cerrar</button>

                    </div>


                </div>
            </div>
        </div>
        <!-- Fin modal -->

        <!-- Modal Fiador -->
        <div class="modal fade" id="modalFiador" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
            <div class="modal-dialog" style="width: 65% !important;">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Agregar Datos del Fiador</h4>
                    </div>
                    <div class="modal-body">

                        <div class="panel-body" style="height: 400px;" id="formularioregistroFiador">
                            <form name="formularioFiador" id="formularioFiador" method="POST">
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Nombre(*):</label>
                                    <input type="hidden" name="id_fiador" id="id_fiador">
                                    <input type="hidden" name="tipo_persona" id="tipo_persona" value="Fiador" >

                                    <input type="text"     class="form-control" name="nombreFiador" id="nombreFiador" maxlength="100" placeholder="Nombres y Apellidos" required>
                                </div>



                                <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <label>Tipo de documento(*):</label>
                                    <select class="form-control selectpicker" name="tipo_documentoFiador" id="tipo_documentoFiador" required>

                                        <option value="CEDULA">Cedula</option>
                                        <option value="RUC">RUC</option>

                                    </select>

                                </div>

                                <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                    <label>Genero(*):</label>
                                    <select class="form-control selectpicker" name="genero_fiador" id="genero_fiador" required>

                                        <option value="Hombre">Hombre</option>
                                        <option value="Mujer">Mujer</option>

                                    </select>

                                </div>
                                <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <label>Estado Civil(*):</label>
                                    <select class="form-control selectpicker" name="estado_civilFiador" id="estado_civilFiador" required>

                                        <option value="Casado">Casado</option>
                                        <option value="Soltero">Soltero</option>
                                        <option value="Acompanado">Acompanado</option>

                                    </select>

                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Numero de Documento(*):</label>
                                    <input type="text" class="form-control" name="num_documentoFiador" id="num_documentoFiador" maxlength="256" placeholder="Documento" required>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Dirección(*):</label>
                                    <input type="text" class="form-control" name="direccionFiador" id="direccionFiador" maxlength="256" placeholder="Direccion" required>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Teléfono(*):</label>
                                    <input type="text" class="form-control" name="telefonoFiador" id="telefonoFiador" maxlength="256" placeholder="telefono" required>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Correo:</label>
                                    <input type="text" class="form-control" name="emailFiador" id="emailFiador" maxlength="50" placeholder="email">
                                </div>


                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Ingresos:</label>
                                    <input type="text" class="form-control" name="ingresos" id="ingresos" maxlength="50" placeholder="Ingreso">
                                </div>



                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <button class="btn btn-primary" type="button" onclick="guardaryeditarFiador()" id="btnGuardarFiador"><i class="fa fa-save"></i> Guardar</button>

                                    <button class="btn btn-warning" onclick="limpiarFiador()" type="button"><i class="fa fa-arrow-circle-left"></i> Limpiar</button>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="limpiarFiador()" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin modal -->

        <!-- Modal Garantia -->
        <div class="modal fade" id="modalGarantia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
            <div class="modal-dialog" style="width: 65% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Agregue una Garantia </h4>
                    </div>
                    <div class="modal-body">

                        <div class="panel-body" style="height: 700px;" id="formularioregistroGarantia">

                            <form name="formularioGarantia" id="formularioGarantia" method="POST">
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Nombre</label>
                                    <input type="hidden"  name="idgarantia" id="idgarantia">
                                    <input type="text" class="form-control form-rounded " name="nombreGarantia" id="nombreGarantia" maxlength="100" placeholder="Nombre" required>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Cliente(*):</label>


                                    <select id="idcliente2"  title="Busca al Cliente" name="idcliente2" class="form-control selectpicker" data-size="4" data-live-search="true" required>

                                    </select>
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

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <label>Precio:</label>
                                    <input type="number" class="form-control" name="precioGarantia" id="precioGarantia" maxlength="7" placeholder="Ingrese la cantidad">
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <label>Codigo</label>

                                    <input type="text" class="form-control" name="codigoGarantia" id="codigoGarantia" placeholder="Codigo de barras" />
                                    <button class="btn btn-success" type="button" onclick="generarbarcode()">Generar</button>
                                    <button class="btn btn-info" type="button" onclick="imprimir()">Imprimir</button>
                                <!--    <div size="" id="print" >
                                        <svg id="barcode"></svg>
                                    </div>-->

                                </div>

                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>Descripción detallada</label>

                                    <textarea class="form-control" rows="5"  name="descripcionGarantia"  id="descripcionGarantia" placeholder="Descripcion" ></textarea>
                                </div>

                                <div class="form-group col-lg-12 col-md-12 col-sm-6 col-xs-12" >
                                    <button class="btn btn-primary" type="button" id="btnAgregarDetalles" onclick="sacarDetalles()" ><i class="fa fa-plus"></i> Agregar</button>
                                    <!--                               <button class="btn btn-warning"  id="btnLimpiar"  onclick="limpiar()"><i class="fa fa-close"></i>Limpiar</button>-->
                                    <button class="btn btn-warning" onclick="cancelarform()" type="button" ><i class="fa fa-minus"></i> Limpiar</button>
                                </div>


                                <div class="panel-body table-responsive" id="listadoArticulos">

                                    <table id="tablaGarantia" class="table table-striped table-bordered table-condensed table-hover">
                                        <thead>

                                        <th>Quitar</th>
                                        <th>Descripcion</th>
                                        <th>Categoria</th>
                                        <th>Código</th>
                                        <th>Valor Aprox</th>
                                        <th>Moneda</th>


                                        </thead>
                                        <tbody>
                                        <!----  La loquera de aqui quien lo llena es el dataTable-->
                                        </tbody>

                                        <tfoot>

                                        </tfoot>
                                    </table>


                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <button type="submit" class="btn btn-success"  >Guardar</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="limpiarGarantia()">Cerrar</button>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-6 col-xs-12" >
<!--                                    <button type="submit" class="btn bg-green"  id="btnGuardar" >Guardar</button>-->
<!--                                     <button class="btn btn-warning"  id="btnLimpiar"  onclick="limpiar()"><i class="fa fa-close"></i>Limpiar</button>-->
                                    <!--  <button class="btn btn-danger" onclick="cancelarform()" type="button" ><i class="fa fa-arrow-circle-left"></i>Cancelar</button>-->



                                </div>
                            </form>

                        </div>

                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>
        <!-- Fin modal -->

        <!-- Modal Cuentas -->
        <div class="modal fade" id="modalCuentas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
            <div class="modal-dialog" style="width: 85% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Selecciona la cuenta que desea abonar</h4>
                    </div>
                    <div class="modal-body">

                        <table id="tblCuentasCliente" class="table table-striped table-bordered table-condensed table-hover" style="width: 100%">

                            <thead>
                            <th>Opciones</th>

                            <th>Fecha</th>

                            <th>Monto</th>
                            <th>Interes</th>
                            <th>Moneda</th>

                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <th>Opciones</th>
                            <th>Fecha</th>

                            <th>Monto</th>
                            <th>Interes</th>
                            <th>Moneda</th>

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

        <!-- Modal Cuentas Abonos -->
        <div class="modal fade" id="modalCuentasAbonos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
            <div class="modal-dialog" style="width: 85% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Abonos Realizados</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <h4 class="badge badge-dark">Detalles de Abonos</h4>
                            <table id="detallesAbonosmodal"  class="table table-striped table-bordered table-condensed table-hover">

                                <thead style=" background-color: #6ce393">

                                <th>Opciones</th>
                                <th>Fecha</th>
                                <th>Concepto</th>
                                <th>Interes</th>
                                <th>Capital</th>
                                <th>Pendiente Capital</th>
                                <th>Moneda</th>

                                </thead>
                                <tfoot>

                                <th></th>
                                <th></th>
                                <th><h4>$/ 0.00</h4></th>
                                <th><h4>$/ 0.00</h4></th>
                                <th></th>
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <h4 class="badge badge-dark">Detalles de Cuenta</h4>
                            <table id="detallesCuentamodal"  class="table table-striped table-bordered table-condensed table-hover">
                                <thead style="background-color: #ff6851">

                                <th>Fecha</th>
                                <th>Fiador</th>
                                <th>Garantia</th>
                                <th>Monto</th>
                                <th>Interés</th>
                                <th>Moneda</th>
                                <th style="white-space: nowrap;min-width: 200px;max-width: 200px;overflow: scroll">Nota</th>

                                </thead>
                                <tfoot>
                                <th>TOTAL</th>
                                <th></th>
                                <th></th>
                                <th><h4>$/ 0.00</h4></th>
                                <th><h4>$/ 0.00</h4></th>
                                <th></th>
                                <th></th>

                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin modal -->

        <!-- Modal Estado de Cuenta Plan de pagos -->
        <div class="modal fade" id="modalEstado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
            <div class="modal-dialog" style="width: 85% !important;">
                <div  class="modal-content"  >


                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Estado de cuenta</h4>

                    </div>

                    <div class="modal-body">
                        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">


                            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <label>Comisión %:</label>
                                <input type="number" class="form-control" name="comision_porcentaje" id="comision_porcentaje"  step=".01" min="0">


                            </div>
                            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12 pr-1">
                            <label>Comisión Total:</label>
                            <input type="number" class="form-control" name="comision_total" id="comision_total"  step=".01" min="0">
                            </div>
                            <table id="detallesEstado"  class="table table-striped table-bordered table-condensed table-hover">

                                <thead style=" background-color: #6ce393">

                                <th>Plazo</th>
                                <th>Fecha</th>
                                <th>Capital</th>
                                <th>Interes</th>
                                <th>Mantenimiento de Valor</th>
                                <th>Pendiente Capital</th>
                                <th>Total a abonar</th>
                                <th>Moneda</th>

                                </thead>
                                <tfoot>


                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                        </div>


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
<script type="text/javascript" src="scripts/gestionar_hipoteca.js"></script>

    <?php

}//Else End

//libera el espacio del BUFFER
ob_end_flush();
?>