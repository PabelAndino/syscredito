<?php
if (strlen(session_id()) < 1)
    session_start();

require_once "../modelos/Gestionar_Hipoteca.php";


$hipoteca=new Gestionar_Hipoteca();
$idusuario=$_SESSION["idusuario"];
$fecha_horacreditos=isset($_POST["fecha_horacreditos"])? limpiarCadena($_POST["fecha_horacreditos"]):"";




switch ($_GET["op"]){
     //Save methods
    case 'guardarCliente':
            $idcliente=$_GET['idcliente'];
            $nombre=$_GET['nombres'];
            $direccion=$_GET['direccion'];
           // $sector=$_GET['sector'];
            $genero=$_GET['genero'];
            $estado_civil=$_GET['estado_civil'];
            $tipo_documento=$_GET['tipo_documento'];
            $num_documento=$_GET['num_documento'];



            if(empty($idcliente)){
               $repuesta=$hipoteca->guardarCliente($nombre,$direccion,$genero,$estado_civil,$tipo_documento,$num_documento);
               echo $repuesta ? "Cliente Ingresado" : "Cliente no se pudo ingresar correctamente";
            }else{

            }

        break;
    case 'guardarFiador':

        $idcliente=$_GET['idfiador'];
        $nombre=$_GET['nombres'];
        $direccion=$_GET['direccion'];
        // $sector=$_GET['sector'];
        $genero=$_GET['genero'];
        $estado_civil=$_GET['estado_civil'];
        $tipo_documento=$_GET['tipo_documento'];
        $num_documento=$_GET['num_documento'];
        $ingresos=$_GET['ingresos'];

        if(empty($idcliente)){
            $repuesta=$hipoteca->guardarFiador($nombre,$direccion,$genero,$estado_civil,$tipo_documento,$num_documento,$ingresos);
            echo $repuesta ? "Fiador Ingresado" : "Fiador no se pudo ingresar correctamente";
        }else{

        }
        break;
    case 'guardaryeditarGarantia':
        $idcliente=$_POST['idcliente2'];
        $nombreGarantia=$_POST['nombreGarantia'];


        if (empty($idgarantia)){

            $rspta=$hipoteca->insertarGarantia($idcliente,$nombreGarantia,$_POST["categoria"],$_POST["codigo"],$_POST["descripcion"],$_POST["precio"], $_POST["moneda"]);

            echo $rspta ? "Garantia Ingresada" : "No se pudo registrar la Garantia";
        }
        else {
        }
        break;
    case 'guardaryeditarHipoteca':
        $monto = ($_GET['montos']);//cantidad que se debitara de la cuenta socios
        $monto_prestamo = ($_GET['monto_ncuenta']); //cantidad que se guardara en la cuenta  prestamo del cliente
        $idhipoteca=$_GET['idhipoteca'];
        $saldo_banco =$_GET['saldo_banco'];
        $solicitud =$_GET['solicitud'];
        $fiador=$_GET['fiador'];
        $garantia=$_GET['garantia'];
        $cuenta_desenbolso=$_GET['banco'];
        $fecha_desembolso=$_GET['desembolso'];
        $fecha_pago=$_GET['pago'];
        $moneda=$_GET['moneda'];
        $interes=$_GET['interes'];
        $interes_moratorio=$_GET['interes_moratorio'];
        $comision=$_GET['comision'];
        $manteminiento_valor=$_GET['mantenimiento'];
        $plazo=$_GET['plazo'];
        $tipo=$_GET['tipo'];
        $nota=$_GET['nota'];
        
        $numero_cuenta = 0;
        $monto_a_actualizar = round((round($saldo_banco) - round($monto) ),2 );//como quedara el monto de la cuenta despues del prestamo que va para el socio

        //verifica si no hay una cuenta nueva, si no hay asignara uno para que se sepa que es la primera cuenta, si no consultara si esta para sumarle 1
        $obtiene_ncuenta = $hipoteca->getnoCuenta($solicitud);

        if(($obtiene_ncuenta->num_rows) == 0){ //si devuelve cero significa que no se a creado ninguna cuenta, significa que sera la primera 

            $numero_cuenta = 1;
           // echo $numero_cuenta;

        }else{
            while($ncuenta = $obtiene_ncuenta->fetch_object()){
                $numero = $ncuenta->no_credito;
                $numero_cuenta = $numero + 1;
               
         }
        }
        
       // echo $numero_cuenta;
        if (empty($idhipoteca)){

           $rspta=$hipoteca->guardarHipoteca($idusuario,$fiador,$garantia,$fecha_desembolso,$fecha_pago,$tipo,
                                             $monto,$interes,$plazo,$interes_moratorio,$moneda,$nota,$comision,$manteminiento_valor,$cuenta_desenbolso,$solicitud,$numero_cuenta,$monto_a_actualizar,$monto_prestamo);
            echo $rspta ? "Cuenta guardada correctamente":"No se pudo guardar la cuenta";
          
        }else {
            
        }
        break;

    case 'guardarAbono':

        $idhipotecaAbonar = $_GET['idhipoteca'];
        $abonocapital = $_GET['capital'];     
        $abonointeres = $_GET['interes'];
        $interes_pendiente =$_GET['pendiente'];
        $interes_moratorio = $_GET['interes_moratorio'];
        $mantenimiento = $_GET['mant_valor'];
        $idabono = $_GET['idabono'];
       
       
        $fechaAbono = $_GET['fecha'];
        $nota = $_GET['nota'];
        if(empty($interes_pendiente)){
            $interes_pendiente = 0 ;
        }
        if (empty($idabono)){

           $rspta=$hipoteca->insertarAbono($idusuario,$idhipotecaAbonar,$fechaAbono,$abonocapital,$abonointeres,$interes_pendiente,$interes_moratorio,$mantenimiento,$nota);
           echo $rspta ? "Abono Registrado" : "No se pudo registrar el abono";
          
        }
        else {
           // $rspta=$hipoteca->editarAbono($idabono,$fechaAbono,$abonocapital,$abonointeres,$nota);
           // echo $rspta ? "Abono editado correcatamente" : "No se pudo editar el Abono";
        }
        break;
   
    case 'editarAbono':

        break;    
    case 'guardaryeditarDetallesAbono':
       
        if (empty($idabono)){

            $rspta=$hipoteca->insertarDetalleAbono($idabono,$fecha,$abonocapital,$abonointeres);

            echo $rspta ? "Hipoteca Registrada" : "No se pudo registrar la Hipoteca";
        }
        else {
        }
        break;
    case 'guardarSolicitud':
        $idsolicitud=$_GET['idsolicitud'];
        $idcliente=$_GET['idcliente'];
        $sabeleer=$_GET['sabeleer'];
        $tipo_local=$_GET['tipo_local'];
        $ultimo_anio=$_GET['ultimo_anio'];
        $num_dependientes=$_GET['num_dependientes'];
        $ingresos=$_GET['ingresos'];
        $ingresos_seraliced=serialize($ingresos);//se tiene que serializar porque recibe un array
        $total_ingresos=$_GET['total_ingresos'];
        $sector=$_GET['sector'];
        $objetivo_prestamo=$_GET['objetivo_prestamo'];
        $conyugue=$_GET['conyugue'];

     //   echo $idcliente,$conyugue,$sabeleer,$tipo_local,$ultimo_anio,$num_dependientes,$ingresos_seraliced,$total_ingresos,
     //   $sector,$objetivo_prestamo;
        if(empty($idsolicitud)){
            $repuesta=$hipoteca->insertarNuevaSolicitur($idcliente,$conyugue,$tipo_local,$sabeleer,$ultimo_anio,$num_dependientes,
            $ingresos_seraliced,$total_ingresos,$sector,$objetivo_prestamo);
            echo ($repuesta)? "Solicitud ingresada correctamente":"No se pudo ingresar la solicitud";
        }else{
            $repuesta=$hipoteca->actualizarSolicitud($idsolicitud,$idcliente,$conyugue,$tipo_local,$sabeleer,$ultimo_anio,$num_dependientes,
            $ingresos_seraliced,$total_ingresos,$sector,$objetivo_prestamo);
            echo ($repuesta)? "Solicitud Actualizada correctamente":"No se pudo actualizar la solicitud";
        }
        
        break;
        //Delete
    case 'anular':
        $rspta=$venta->anular($idventa);
        echo $rspta ? "Venta anulada" : "Venta no se puede anular";
        break;
    case 'anularDetalle':
        $rspta=$venta->anularDetalle($idventa);
        echo $rspta ? "Venta anulada" : "Venta no se puede anular";
        break;
        //Mostrar

    case 'muestraHipotecas':
        $date = date('Y-m-d');
        $rspta=$hipoteca->muestraAbonosDiarios($date);

        //Codificar el resultado utilizando json
        echo '<thead style="background-color:#ff6851">

                                            <th>Opciones</th>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>Abono Capital</th>
                                            <th>Abono Interes</th>
                                            <th>Total Abonado</th>
                                            <th>Moneda</th>
                                    

                                    <!-- 
                                    <th style="white-space: nowrap;min-width: 200px;max-width: 200px;overflow: scroll">Nota</th>
                                    -->
                                </thead>';

        while ($reg = $rspta->fetch_object())
        {
            $urlTICKET='../reportes/TicketRepH.php?id='.$reg->detalle.'&idhipo= '.$reg->idhipoteca.' ';
              
            echo '<tr>
                   <td><a target="_blank" href="'.$urlTICKET.'">   <button class="btn btn-info" type="button"><i class="fa fa-print"></i></button></a>
                   <a data-toggle="modal" href="#modalCuentasAbonos"><button class="btn btn-bitbucket" type="button" onclick="mostrarAbonoInfo('.$reg->idhipoteca.','.$reg->monto.')"><i class="fa fa-info"></i></button></a>
                   </td>
                   <td>'.$reg->fecha.'</td>
                   <td>'.$reg->cliente.'</td>
                   <td>'.$reg->abono_capital.'</td>
                   <td>'.$reg->abono_interes.'</td>
                   <td>'.$reg->total_abonado.'</td>
                   <td>'.$reg->moneda.'</td>
                   </tr>';
        }
        break;
   
    case 'muestraHipotecasLista':
        $idcl=$_GET['idcliente'];
        $rspta=$hipoteca->muestraHipotecasLista($idcl);
        //Codificar el resultado utilizando json
        echo '<thead style="background-color:#ff6851">

                                            <th>Opciones</th>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>Abono Capital</th>
                                            <th>Abono Interes</th>
                                            <th>Total Abonado</th>
                                            <th>Moneda</th>
                                    

                                    <!-- 
                                    <th style="white-space: nowrap;min-width: 200px;max-width: 200px;overflow: scroll">Nota</th>
                                    -->
                                </thead>';
        while ($reg = $rspta->fetch_object())
        {
            $urlTICKET='../reportes/TicketRepH.php?id=';
            echo '<tr>
                   <td><a target="_blank" href="'.$urlTICKET.$reg->detalle.'">   <button class="btn btn-info" type="button"><i class="fa fa-print"></i></button></a></td> 
                   <td>'.$reg->fecha.'</td>
                   <td>'.$reg->cliente.'</td>
                   <td>'.$reg->abono_capital.'</td>
                   <td>'.$reg->abono_interes.'</td>
                   <td>'.$reg->total_abonado.'</td>
                   <td>'.$reg->moneda.'</td>
                  
                   
                   </tr>';
        }
        break;
    
    case 'muestraTodosAbonos':
         $rspta=$hipoteca->muestratodosAbonos();

        //Codificar el resultado utilizando json
        echo '<thead style="background-color:#ff6851">

                                            <th>Opciones</th>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>Abono Capital</th>
                                            <th>Abono Interes</th>
                                            <th>Total Abonado</th>
                                            <th>Moneda</th>
                                    

                                    <!-- 
                                    <th style="white-space: nowrap;min-width: 200px;max-width: 200px;overflow: scroll">Nota</th>
                                    -->
                                </thead>';

        while ($reg = $rspta->fetch_object())
        {
            $urlTICKET='../reportes/TicketRepH.php?id=';

            echo '<tr>
                   <td><a target="_blank" href="'.$urlTICKET.$reg->detalle.'">   <button class="btn btn-info" type="button"><i class="fa fa-print"></i></button></a>
                   <a data-toggle="modal" href="#modalCuentasAbonos"><button class="btn btn-bitbucket" type="button" onclick="mostrarAbonoInfo('.$reg->idhipoteca.','.$reg->monto.')"><i class="fa fa-info"></i></button></a>
                   </td>
                   <td>'.$reg->fecha.'</td>
                   <td>'.$reg->cliente.'</td>
                   <td>'.$reg->abono_capital.'</td>
                   <td>'.$reg->abono_interes.'</td>
                   <td>'.$reg->total_abonado.'</td>
                   <td>'.$reg->moneda.'</td>
                   </tr>';
        }
     break;  
    case 'mostrar':
        $rspta=$venta->mostrar($idventa);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;
    case 'muestraSumaCapital':
        $id=$_GET['idhipoteca'];
        $rspta = $hipoteca->muestraSumaCapital($id);
        while ($reg = $rspta->fetch_object()) {
            echo $reg->total_abonado;
        }
        break;
    
    case 'mostrarUltimoAbono':
            $id=$_GET['id'];

             $rspta = $hipoteca->mostrarUltimoAbono($id);
             while ($reg = $rspta->fetch_object()) {
            echo $reg->id;
            }
     break;
    case 'muestraAbonoeInteres':
        $id=$_GET['ultimoabono'];
        $rspta=$hipoteca->muestraAbonoeInteres($id);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;
    case 'mostrarNumero': //MUSTRA EL NUMERO DE SERIE AUTOINCREMENTADO

        $rspta=$venta->sumarNumeroFactura();
        //Codificar el resultado utilizando json

        while ($reg = $rspta->fetch_array())
        {
            echo $reg[0];
        }

        break;
    case 'obtenerMonto':

        $monto=$_GET['monto'];
        $interes=$_GET['interes'];

        echo  $monto."  datos  ".$interes;
        break;
    case 'mostrarCuentasAbono'://muestra el numero de creditos al cual desea abonar
    
            $id=$_GET['idcliente'];
            $rspta=$hipoteca->mostrarCuentasAbono($id);
            $augment = 0 ;//variable que aumentara en 1 para poder saber el id del campo que restara un dia
            //Vamos a declarar un array
            $data= Array();
            while ($reg=$rspta->fetch_object()){

                echo ' <thead>
                        <th>Opciones</th>
                            <th>No Creditos</th>
                            <th>Fecha Desembolso</th>
                            <th>Fecha Pago</th>
                            <th>Monto</th>
                            <th>Interes</th>
                            <th>Moneda</th>
                        </thead>';
                echo '<tr>
                        <th><button class="btn btn-success" onclick="mostrarCuentas('.$reg->idhipoteca.',\''.$reg->monto.'\',\''.$reg->interes.'\',\''.$reg->plazo.'\',\''.$augment.'\')"><i class="fa fa-plus"></i></button><label>&nbsp &nbspRestar dia&nbsp &nbsp</label><input id="dia_menos'.$augment.'" type="number" value="0"></th> 
                        <th>'.$reg->no_credito.'</th>
                        <th>'.$reg->fecha_desembolso.'</th>
                        <th>'.$reg->fecha_pago.'</th>
                        <th>'.$reg->monto.'</th>
                        <th>'.$reg->interes.'</th>
                        <th>'.$reg->moneda.'</th>
                        </tr>';
                        //&nbsp es para espacios HTML

                        $augment ++;

            }
            break;

    case 'mostrarPrimerInteres':
        $idHipoteca = $_GET['idHipoteca'];
        $rspta = $hipoteca->calcula_mora($idHipoteca);
        while ($reg = $rspta->fetch_object()){
            $fecha_desembolso = date('Y-m-d',strtotime($reg->fecha_desembolso));
            $fecha_pago = date('Y-m-d',strtotime($reg->fecha_pago));
            $monto = $reg->monto;
            $interes = $reg->interes;
            $intereses_primerodias = array();


            while (strtotime($fecha_desembolso) < strtotime($fecha_pago)){


                $recorrido_fecha_desembolso = $fecha_desembolso;


                $totalInteres = round( ( ($monto * $interes)/100),2);//calcula el interes a pagar
                $primerosdias = cal_days_in_month(CAL_GREGORIAN, date('m',strtotime($recorrido_fecha_desembolso)), date('Y',strtotime($recorrido_fecha_desembolso)));//cuandos dias hay en el mes, puede que llegue un mes que cambie entonces dira cuantos dias hay en ese mes
                $totalInteres = round(($totalInteres / $primerosdias),2);//cuanto seria el interes diario, divide el interes entre los dias del mes en que se encuentre, ya sea el mismo mes o el mes vaya aumentando

                array_push($intereses_primerodias,$totalInteres);//agrega los interes calculados diarios al array

                $fecha_desembolso = date('Y-m-d',strtotime("+1 day",strtotime($recorrido_fecha_desembolso)));//aumenta 1 dia hasta llegar al mes y dia de pago

            }

            echo array_sum($intereses_primerodias);


        }



        break;
    case 'muestraEstado'://PLAN DE PAGOS
        $fecha_actual = date('Y-m-d');
        $fechaPago = $_GET['fechaPago'];
        $plazo = $_GET['plazos'];
        $interes = $_GET['interes'];

        $monto = $_GET['monto']; //el monto para calcular mensaualidades del capital
        $monto2 = $_GET['monto']; //el monto para calcular el interes
        $moneda = $_GET['moneda'];
        $mantenimiento_valor = $_GET['mValor'];
        $mantValor = 0;
        $fechapagoo_dia = date('d',strtotime($fechaPago));
        $valorTest = $_GET['monto'];
        $abonos_mensuales = (round((($monto)/$plazo),2));
        //El primer abono
        $fechaDesembolso = $_GET['desembolso'];
      //  $fechaPago = $_GET['pago'];
       // $dayplus = date('Y-m-d',strtotime("+1 day",strtotime($date)));
        $date = date('Y-m-d',strtotime( "+1 day" ,strtotime($fechaDesembolso))); //le suma un dia porque el dia de desembolso no puede comenzar a sumar intereses
        //si no hasta el dia siguiente
        $end_date = date('Y-m-d',strtotime($fechaPago));

        $mes_aniodesembolso = date('Y-m',strtotime($date));
        $mes_aniopago = date('Y-m',strtotime($end_date));
        $mes_desembolso = date('m',strtotime($date));
        $mes_pago = date('m',strtotime($end_date));
        $diadesembolso  = date('d',strtotime($fechaDesembolso));
        $diapago = date('d',strtotime($fechaPago));
        $aniodesembolso = date('Y',strtotime($date));
        $aniopago =date('Y',strtotime($end_date));
        $dias=array();
        $diascaculados = array();
        $diastotales = array();
        $contador=1;
        $manteminiento_valor_primeros_dias = 0;

        echo '<thead class="display compact" style="width:100%">

                                <th>Plazo</th>
                                <th>Fecha</th>
                                <th>Capital</th>
                                <th>Interes</th>
                                <th>M Valor</th>
                                <th>Cuota</th>
                                <th>Saldo</th>
                                <th>Moneda</th>
                              
                                </thead>';

        for ($i=1 ;$i <= $plazo; $i++){

            $restante = round(($monto-$abonos_mensuales),2);  
            $monto = $restante;
           
            $date2 = date('Y-m-d',strtotime("+1 day",strtotime($end_date)));//despues de resolver los primeros meses ahora el mes de inicio sera el mes que continua comienza al siguiente dia porque 
            //en los primeros meses ya se cobro el dia correspondiente entonce somienza al siguiente dia, por es el +1
            $end_date2 = date('Y-m-d',strtotime("+1 month",strtotime($end_date)));//ahora hira sumando un mes a la fecha tambien
           // $interes_calculado = round((($monto2 * $interes)/100),2);
          //  $mantValor = round((($monto2  * $mantenimiento_valor)/100),2);
            

            $intereses_primerodias = array();
            $mantenimientoArray = array();
            while(date('Y-m-d',strtotime($date2))   <=  date('Y-m-d',strtotime($end_date2) ) ){//recorrera el siguiente dia de desembolso hasta el dia que contemplo pagar

                $totalInteres = round( ( ($monto2 * $interes)/100),2);//calcula el interes a pagar
                $primerosdias = cal_days_in_month(CAL_GREGORIAN, date('m',strtotime($date2)), date('Y',strtotime($date2)));//cuantos dias hay en el mes, puede que llegue un mes que cambie entonces dira cuantos dias hay en ese mes
                $totalInteres = round(($totalInteres / $primerosdias),2);//cuanto seria el interes diario, divide el interes entre los dias del mes en que se encuentre, ya sea el mismo mes o el mes vaya aumentando
     
                array_push($intereses_primerodias,$totalInteres);//agrega los interes calculados diarios al array

                //saca el mantenimiento de valor
                $manteminiento_valor_primeros_dias = round( (($mantenimiento_valor * $monto2 )/100),2);
                $manteminiento_valor_primeros_dias = round( ($manteminiento_valor_primeros_dias / $primerosdias ),2);

                array_push($mantenimientoArray,$manteminiento_valor_primeros_dias);

                $date2 = date('Y-m-d',strtotime("+1 day",strtotime($date2)));//aumenta 1 dia hasta llegar al mes y dia de pago
            }

            $primerosdias_totales = array_sum($intereses_primerodias);//suma el total de dias
            $totalInteres = round(($primerosdias_totales),2);

            $manteminiento_valor_primeros_dias_total = array_sum($mantenimientoArray);
            $totalMantenimiento = round(($manteminiento_valor_primeros_dias_total),2);


            $interes_calculado = $totalInteres;
            $mantValor = $totalMantenimiento;
           

            if($i==$plazo){ //cuando llega al ultimo plazo 
                $abonos_mensuales= $abonos_mensuales + $restante;
                $interes_moneda=round((($monto2 * $interes)/100),2); //
              
                $restante=0; //para que muestre el ultimo plazoa cero el restante a cero
            }

            if($i==1){//El primer estado

                if($mes_aniodesembolso < $mes_aniopago){ //verifica que no este en el mismo mes

                    
                    $intereses_primerodias = array();
                    $mantenimientoArray = array();
                    while(date('Y-m-d',strtotime($date))   <=  date('Y-m-d',strtotime($end_date) ) ){//recorrera el siguiente dia de desembolso hasta el dia que contemplo pagar

                        $totalInteres = round( ( ($monto2 * $interes)/100),2);//calcula el interes a pagar
                        $primerosdias = cal_days_in_month(CAL_GREGORIAN, date('m',strtotime($date)), date('Y',strtotime($date)));//cuandos dias hay en el mes, puede que llegue un mes que cambie entonces dira cuantos dias hay en ese mes
                        $totalInteres = round(($totalInteres / $primerosdias),2);//cuanto seria el interes diario, divide el interes entre los dias del mes en que se encuentre, ya sea el mismo mes o el mes vaya aumentando
             
                        array_push($intereses_primerodias,$totalInteres);//agrega los interes calculados diarios al array

                        //saca el mantenimiento de valor
                        $manteminiento_valor_primeros_dias = round( (($mantenimiento_valor * $monto2 )/100),2);
                        $manteminiento_valor_primeros_dias = round( ($manteminiento_valor_primeros_dias / $primerosdias ),2);

                        array_push($mantenimientoArray,$manteminiento_valor_primeros_dias);

                        $date = date('Y-m-d',strtotime("+1 day",strtotime($date)));//aumenta 1 dia hasta llegar al mes y dia de pago
                    }


                   // echo ' *** Ultimo mes y dias: ' ;

                    // array_push($diascaculados,$dias[0]); //procesa en un array los primeros y ultimos datos de dias
                    //  array_push($diascaculados,end($dias));//los ultimos datos del array
                    $primerosdias_totales = array_sum($intereses_primerodias);//suma el total de dias
                    $totalInteres = round(($primerosdias_totales),2);

                    $manteminiento_valor_primeros_dias_total = array_sum($mantenimientoArray);
                    $totalMantenimiento = round(($manteminiento_valor_primeros_dias_total),2);


                    $interes_calculado = $totalInteres;
                    $mantValor = $totalMantenimiento;


                    // echo $r;

                }
                else if($mes_aniodesembolso == $mes_aniopago){ //meses iguales en el mismo anio
                 
                 
                  $intereses_primerodias = array();
                  $mantenimientoArray = array();
                  
                  while(date('Y-m-d',strtotime($date))   <  date('Y-m-d',strtotime($end_date) ) ){//no se usa el <= porque cuenta un dia de mas, si han pasado 3 dias,cuenta 4, solo con < los cuanta bien

                      $totalInteres = round( ( ($monto2 * $interes)/100),2);//calcula el interes a pagar
                      $primerosdias = cal_days_in_month(CAL_GREGORIAN, date('m',strtotime($date)), date('Y',strtotime($date)));//cuandos dias hay en el mes, puede que llegue un mes que cambie entonces dira cuantos dias hay en ese mes
                      $totalInteres = round(($totalInteres / $primerosdias),2);//cuanto seria el interes diario, divide el interes entre los dias del mes en que se encuentre, ya sea el mismo mes o el mes vaya aumentando
           
                      array_push($intereses_primerodias,$totalInteres);//agrega los interes calculados diarios al array

                      //saca el mantenimiento de valor
                      $manteminiento_valor_primeros_dias = round( (($mantenimiento_valor * $monto2 )/100),2);
                      $manteminiento_valor_primeros_dias = round( ($manteminiento_valor_primeros_dias / $primerosdias ),2);

                      array_push($mantenimientoArray,$manteminiento_valor_primeros_dias);

                      $date = date('Y-m-d',strtotime("+1 day",strtotime($date)));//aumenta 1 dia hasta llegar al mes y dia de pago
                  }

                    $primerosdias_totales = array_sum($intereses_primerodias);//suma el total de dias
                    $totalInteres = round(($primerosdias_totales),2);

                    $manteminiento_valor_primeros_dias_total = array_sum($mantenimientoArray);
                    $totalMantenimiento = round(($manteminiento_valor_primeros_dias_total),2);


                    $interes_calculado = $totalInteres;
                    $mantValor = $totalMantenimiento;


                }

            }
            // else{
            //     $intereses_porfecha = $interes_calculado;

            // }
           
            

            if($restante>=0){
                $pMesDiario = date('m',strtotime($fechaPago));
                $pAnioDiario = date('Y',strtotime($fechaPago));
              //  $interesDiario = cal_days_in_month(CAL_GREGORIAN,  $pMesDiario, $pAnioDiario);


                echo '  <tr>
                    <td>'.$i.'</td>
                    <td> '.date('Y-m-d',strtotime($fechaPago)).' </td>
                    <td>'.$abonos_mensuales.'</td> <!--Abonos mensuales al capital--> 
                    <td>'.round(($interes_calculado),2).'</td> <!--Interes ya calculado-->
                    <td>'.$mantValor.'</td> <!--Mantenimiento de Valor--> 
                    <td>'.round((($abonos_mensuales + $interes_calculado) + $mantValor ),2).'</span></td><!--Cutora-->
                    <td>'.$restante.'</td><!--Saldo-->
                    <td>'.$moneda.'</td>
                   
                    </tr>';

                    $monto2=$monto; //Si no se iguala mostrara la ultima cantidad a cero, y asi comienza a calcular
                //desde el monto principal, luego sigue el monto restante, hasta llegar a la menor cantidad
                    $fechaPago = date("Y-m-d",strtotime($fechaPago."+ 1 month"));


            }

        }
       

        break;
   
    case 'calcula_moras':
        $idhipoteca = $_GET['idhipoteca'];
        $dia_menos = $_GET['dia_menos'];
        $dia_menos_formato = "-".$dia_menos." day";
        $fechaactual = $_GET['fecha_horacreditos'];//date("Y-m-d")
        $fechaactual = date("Y-m-d",strtotime($dia_menos_formato,strtotime($fechaactual)));
        $conteo = 1;
        $conteo2 = 0; //para contar despues de los abonos
        $conteo_moratorio = 1;
        $test = "";
        $test2 = "";
        $totalInteres = 0;
        $totalInteresMoratorio = 0;
        $mes_anioactual = date("Y-m");
        //$anioactual = date("Y");
        //$mesactual = date("m");
        $diaactual = date("d",strtotime($fechaactual));
        //$moneda = 0;

        $rspta = $hipoteca->calcula_mora($idhipoteca);
        $data = Array();

        while ($reg = $rspta->fetch_object()){

            $estado = $reg->estado;
            $monto = $reg->monto;
            $moneda = $reg->moneda;
            $mantenimiento = $reg->mantenimiento_valor;
            $fecha_desembolso = date('Y-m-d',strtotime($reg->fecha_desembolso));
            $aniomes_desembolso =  date('Y-m',strtotime($reg->fecha_desembolso));
            $dia_desembolso = date('d',strtotime($reg->fecha_desembolso));
            $mes_desembolso = date('m',strtotime($reg->fecha_desembolso));
            $anio_desembolso = date('Y',strtotime($reg->fecha_desembolso));

            $fecha_pago = date("Y-m-d",strtotime($reg->fecha_pago));
            $mes_pago = date('m',strtotime($reg->fecha_pago));
            $fecha_pago_mesanio = date('Y-m',strtotime($reg->fecha_pago));
            $dia_pago = date('d',strtotime($reg->fecha_pago));
            $interes = $reg->interes;
            $interes_moratorio = $reg->interes_moratorio;
             //se inicializa a cero porque despues se asignara con los valores del interes moratorio
            if($estado=='sin_abono'){//si no se a realizado ningun abono

                $fechaInicio = date('Y-m-d',strtotime("+1 day",strtotime($fecha_desembolso)));
                $fechaFin = $fechaactual;
                $diaInicio = date('d',strtotime($fechaInicio));
                $interesM = 0;

                $intereses_primerodias = array();//guardara los intereses dividios por el mes
                $moratorio_primerosdias = array();
                $mantenimientoArray = array();
                while(date('Y-m-d',strtotime($fechaInicio))   <=  date('Y-m-d',strtotime($fechaFin) ) ){//recorrera el siguiente dia del desembolso hasta el dia que contemplo pagar

                        $totalInteres = round( ( ($monto * $interes)/100),2);//calcula el interes a pagar
                        $primerosdias = cal_days_in_month(CAL_GREGORIAN, date('m',strtotime($fechaInicio)), date('Y',strtotime($fechaInicio)));//cuandos dias hay en el mes, puede que llegue un mes que cambie entonces dira cuantos dias hay en ese mes
                        $totalInteres = round(($totalInteres / $primerosdias),2);//cuanto seria el interes diario, divide el interes entre los dias del mes en que se encuentre, ya sea el mismo mes o el mes vaya aumentando
             
                        array_push($intereses_primerodias,$totalInteres);//agrega los interes calculados diarios al array $intereses_primerodias asi permitira sumar el contenido del array

                        //saca el mantenimiento de valor
                        $manteminiento_valor_primeros_dias = round( (($mantenimiento * $monto )/100),2);
                        $manteminiento_valor_primeros_dias = round( ($manteminiento_valor_primeros_dias / $primerosdias ),2);

                        array_push($mantenimientoArray,$manteminiento_valor_primeros_dias);


                        if(date('Y-m-d',strtotime($fechaInicio)) > date('Y-m-d',strtotime($fecha_pago)) ){//la ficha inicio va aumentando un dia, luego cuando sea mayor que la fecha de pago cobrara el moratorio
                            $interesM = round((($interes_moratorio * $monto)/100),2);
                            $interesM = round(($interesM / $primerosdias),2);
                            array_push($moratorio_primerosdias,$interesM);

                         }
                       $data[]=array(
                        "0"=>$conteo,//$conteo2,//meses
                        "1"=>$fechaInicio,//$fechaInicio,//fechas
                        "2"=>$totalInteres,//$totalInteres,
                        "3"=>$interesM,//$totalInteresMoratorio,//interes Moratorio
                        "4"=>$manteminiento_valor_primeros_dias,//$totalMantenimiento /* round((($mantenimiento * $capital)/100 ),2 ) */,
                        "5"=>round(($totalInteres + $interesM + $manteminiento_valor_primeros_dias),2),//round(($totalInteres + $totalInteresMoratorio + $totalMantenimiento ),2),
                        "6"=>$moneda,//$moneda.$dia_menos
        
                       );

                        $fechaInicio = date('Y-m-d',strtotime("+1 day",strtotime($fechaInicio)));//aumenta 1 dia hasta llegar al mes y dia de pago
                        $conteo ++;//para enumerar los dias
                    }

                    // $primerosdias_totales = array_sum($intereses_primerodias);//suma el total de dias
                    // $totalInteres = round(($primerosdias_totales),2);
                    // $interes_calculado = $totalInteres;

            }
            else{
                //Si ya se hicieron abonos
                //Debe de calcular el siguiente abono para eso debo de tener la ultima fecha, y el interes que le toca
                ////basado en el siguiente capital
                $capital = 0;
                $ultima_fecha = date('Y-m-d');//se inicializan para asignar despues
                $fechaInicio = date('Y-m-d');//se inicializan para asignar despues
                $suma_capital = $hipoteca->muestraSumaCapital($idhipoteca);//obtiene cuanto a abonado
                $ultimos_datos_abono = $hipoteca->muestraUltimoAbono($idhipoteca);
                while ($reg = $ultimos_datos_abono->fetch_object()){

                    $ultima_fecha = date('Y-m-d',strtotime($reg->fecha));
                    $fechaInicio =  $ultima_fecha;
                    

                }

                while ($reg = $suma_capital->fetch_object()) {
                    $capital = $monto - ($reg->total_abonado) ;//el Restante seria el monto total menos lo que a abonado
                   
                    $fechaInicio = date('Y-m-d',strtotime("+1 day",strtotime($fechaInicio)));
                    $fechaFin = $fechaactual;
                   
                    $interesM = 0;
    
                    $intereses_primerodias = array();//guardara los intereses dividios por el mes
                    $moratorio_primerosdias = array();
                    $mantenimientoArray = array();

                    //el año que ya abono, -- el mas que ya abono mas 1 y el dia que le toca pagar mas 1
                    $date_mora_anio = date('Y',strtotime($fechaInicio));
                    $date_mora_mes = date('m',strtotime("+1 month",strtotime($fechaInicio)));// date('m',strtotime($fechaInicio));//
                    $date_mora_dia = date('d',strtotime("+1 day",strtotime($fecha_pago)));
                    $date_mora = ($date_mora_anio) ."-". ( $date_mora_mes)."-".($date_mora_dia) ;
                   // echo  $date_mora;
                    while(date('Y-m-d',strtotime($fechaInicio))   <=  date('Y-m-d',strtotime($fechaFin) ) ){//recorrera el siguiente dia del desembolso hasta el dia que contemplo pagar

                        $totalInteres = round( ( ($capital * $interes)/100),2);//calcula el interes a pagar
                        $primerosdias = cal_days_in_month(CAL_GREGORIAN, date('m',strtotime($fechaInicio)), date('Y',strtotime($fechaInicio)));//cuandos dias hay en el mes, puede que llegue un mes que cambie entonces dira cuantos dias hay en ese mes
                        $totalInteres = round(($totalInteres / $primerosdias),2);//cuanto seria el interes diario, divide el interes entre los dias del mes en que se encuentre, ya sea el mismo mes o el mes vaya aumentando
             
                        array_push($intereses_primerodias,$totalInteres);//agrega los interes calculados diarios al array $intereses_primerodias asi permitira sumar el contenido del array

                        //saca el mantenimiento de valor
                        $manteminiento_valor_primeros_dias = round( (($mantenimiento * $capital )/100),2);
                        $manteminiento_valor_primeros_dias = round( ($manteminiento_valor_primeros_dias / $primerosdias ),2);

                        array_push($mantenimientoArray,$manteminiento_valor_primeros_dias);

                        
                        
                        if(strtotime($fechaInicio) >=  strtotime($date_mora)){//la ficha inicio va aumentando un dia, luego cuando sea mayor que la fecha de pago cobrara el moratorio
                            
                            $interesM = round((($interes_moratorio * $capital)/100),2);
                            $interesM = round(($interesM / $primerosdias),2);
                            array_push($moratorio_primerosdias,$interesM);

                         }
                       $data[]=array(
                        "0"=>$conteo,//$conteo2,//meses
                        "1"=>$fechaInicio,//$fechaInicio,//fechas
                        "2"=>$totalInteres,//$totalInteres,
                        "3"=>$interesM,//$totalInteresMoratorio,//interes Moratorio
                        "4"=>$manteminiento_valor_primeros_dias,//$totalMantenimiento /* round((($mantenimiento * $capital)/100 ),2 ) */,
                        "5"=>round(($totalInteres + $interesM + $manteminiento_valor_primeros_dias),2),//round(($totalInteres + $totalInteresMoratorio + $totalMantenimiento ),2),
                        "6"=>$moneda,//$moneda.$dia_menos
        
                       );

                        $fechaInicio = date('Y-m-d',strtotime("+1 day",strtotime($fechaInicio)));//aumenta 1 dia hasta llegar al mes y dia de pago
                        $conteo ++;//para enumerar los dias
                    }

                
                
              

            }
        }
        

        }

           $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
     break;
    case 'planPago'://Case de prueba****
        //     $fecha_actual = date('Y-m-d');
        //     $fechaPago = $_GET['fechaPago'];
        //     $plazo = $_GET['plazos'];
        //     $interes = $_GET['interes'];

        //     $monto = $_GET['monto']; //el monto para calcular mensaualidades del capital
        //     $monto2 = $_GET['monto']; //el monto para calcular el interes
        //     $moneda = $_GET['moneda'];
        //     $mantenimiento_valor = $_GET['mValor'];
        //     $mantValor = 0;
        //     $fechapagoo_dia = date('d',strtotime($fechaPago));
        //     $valorTest = $_GET['monto'];
        //     $abonos_mensuales = (round((($monto)/$plazo),2));
        //     //El primer abono
        //     $fechaDesembolso = $_GET['desembolso'];
        //   //  $fechaPago = $_GET['pago'];

        //     $date = date('Y-m-d',strtotime($fechaDesembolso));
        //     $end_date = date('Y-m-d',strtotime($fechaPago));

        //     $mes_aniodesembolso = date('Y-m',strtotime($date));
        //     $mes_aniopago = date('Y-m',strtotime($end_date));
        //     $mes_desembolso = date('m',strtotime($date));
        //     $mes_pago = date('m',strtotime($end_date));
        //     $diadesembolso  = date('d',strtotime($fechaDesembolso));
        //     $diapago = date('d',strtotime($fechaPago));
        //     $aniodesembolso = date('Y',strtotime($date));
        //     $aniopago =date('Y',strtotime($end_date));
        //     $dias=array();
        //     $diascaculados = array();
        //     $diastotales = array();
        //     $contador=1;
        //     $manteminiento_valor_primeros_dias = 0;

        //     echo '<thead class="display compact" style="width:100%">

        //                             <th>Plazo</th>
        //                             <th>Fecha</th>
        //                             <th>Capital</th>
        //                             <th>Interes</th>
        //                             <th>M Valor</th>
        //                             <th>Cuota</th>
        //                             <th>Saldo</th>
        //                             <th>Moneda</th>
        //                             </thead>';

        //     for ($i=1 ;$i <= $plazo; $i++){
        //        $restante = round(($monto-$abonos_mensuales),2);

        //        $interes_moneda=round((($monto*$interes)/100),2);
            
        //        $monto = $restante;

        //         // if($i==$plazo){
        //         //     $abonos_mensuales= $abonos_mensuales + $restante;
        //         //     $interes_moneda=round((($monto2 * $interes)/100),2); //
        //         //   //  $interes_calculado = $interes_moneda;
        //         //     $restante=0; //para que muestre el ultimo plazo
        //         // }

        //         $interes_calculado = round((($monto2 * $interes)/100),2);
        //         $mantValor = round((($monto2  * $mantenimiento_valor)/100),2);
        //        // $dias_mesdeDesembolso = cal_days_in_month(CAL_GREGORIAN, date('m',strtotime($fechaPago)), date('Y',strtotime($fechaPago)));
                    

        //         if($i==1){//El primer estado

        //             if($mes_aniodesembolso < $mes_aniopago){ //verifica que no este en el mismo mes

                        
        //                 $intereses_primerodias = array();
        //                 $mantenimientoArray = array();
        //                 while(date('Y-m-d',strtotime($date))   <  date('Y-m-d',strtotime($end_date) ) ){//no se usa el <= porque cuenta un dia de mas, si han pasado 3 dias,cuenta 4, solo con < los cuanta bien

        //                     $totalInteres = round( ( ($monto2 * $interes)/100),2);//calcula el interes a pagar
        //                     $primerosdias = cal_days_in_month(CAL_GREGORIAN, date('m',strtotime($date)), date('Y',strtotime($date)));//cuandos dias hay en el mes, puede que llegue un mes que cambie entonces dira cuantos dias hay en ese mes
        //                     $totalInteres = round(($totalInteres / $primerosdias),2);//cuanto seria el interes diario, divide el interes entre los dias del mes en que se encuentre, ya sea el mismo mes o el mes vaya aumentando
                
        //                     array_push($intereses_primerodias,$totalInteres);//agrega los interes calculados diarios al array

        //                     //saca el mantenimiento de valor
        //                     $manteminiento_valor_primeros_dias = round( (($mantenimiento_valor * $monto2 )/100),2);
        //                     $manteminiento_valor_primeros_dias = round( ($manteminiento_valor_primeros_dias / $primerosdias ),2);

        //                     array_push($mantenimientoArray,$manteminiento_valor_primeros_dias);

        //                     $date = date('Y-m-d',strtotime("+1 day",strtotime($date)));//aumenta 1 dia hasta llegar al mes y dia de pago
        //                 }


        //                // echo ' *** Ultimo mes y dias: ' ;

        //                 // array_push($diascaculados,$dias[0]); //procesa en un array los primeros y ultimos datos de dias
        //                 //  array_push($diascaculados,end($dias));//los ultimos datos del array
        //                 $primerosdias_totales = array_sum($intereses_primerodias);//suma el total de dias
        //                 $totalInteres = round(($primerosdias_totales),2);

        //                 $manteminiento_valor_primeros_dias_total = array_sum($mantenimientoArray);
        //                 $totalMantenimiento = round(($manteminiento_valor_primeros_dias_total),2);


        //                 $interes_calculado = $totalInteres;
        //                 $mantValor = $totalMantenimiento;


        //                 // echo $r;

        //             }
                    
                    
        //         }else{
        //             $intereses_porfecha = $interes_calculado;

        //         }

        //         if($restante>=0){
        //             $pMesDiario = date('m',strtotime($fechaPago));
        //             $pAnioDiario = date('Y',strtotime($fechaPago));
        //           //  $interesDiario = cal_days_in_month(CAL_GREGORIAN,  $pMesDiario, $pAnioDiario);


        //             echo '  <tr>
        //                 <td>'.$i.'</td>
        //                 <td> '.date('Y-m-d',strtotime($fechaPago)).' </td>
        //                 <td>'.$abonos_mensuales.'</td> <!--Abonos mensuales al capital--> 
        //                 <td>'.round(($interes_calculado),2).'</td> <!--Interes ya calculado-->
        //                 <td>'.$mantValor.'</td> <!--Mantenimiento de Valor--> 
        //                 <td>'.round((($abonos_mensuales + $interes_calculado) + $mantValor ),2).'</span></td><!--Cutora-->
        //                 <td>'.$restante.'</td><!--Saldo-->
        //                 <td>'.$moneda.'</td>
        //                 </tr>';

        //                 $monto2=$monto; //Si no se iguala mostrara la ultima cantidad a cero, y asi comienza a calcular
        //             //desde el monto principal, luego sigue el monto restante, hasta llegar a la menor cantidad
        //                 $fechaPago = date("Y-m-d",strtotime($fechaPago."+ 1 month"));


        //         }

        //     }

     break;
        //LIST METHODS

    case 'listarDetallesCuenta':
        $id=$_GET['id'];
        $rspta = $hipoteca->listarDetalleCuenta($id);
        $total=0;
        echo '<thead style="background-color:#ffb211">
                                    <th>Fecha Desembolso</th>
                                    <th>Fecha Pago</th>
                                    <th>Fiador</th>
                                    <th>Garantia</th>
                                    <th>Monto</th>
                                    <th>Interés%</th>
                                    <th>Interés Mor%</th>
                                    <th>Plazo</th>
                                    <th>Moneda</th>
                                    <th style="white-space: nowrap;min-width: 200px;max-width: 200px;overflow: scroll">Nota</th>
                                </thead>';
        while ($reg = $rspta->fetch_object())
        {
            echo '<tr>
                   <td>'.$reg->fecha_desembolso.'</td>
                    <td>'.$reg->fecha_pago.'</td>
                   <td>'.$reg->fiador.'</td>
                   <td>'.$reg->garantia.'</td>
                   <td>'.$reg->monto.'</td>
                   <td>'.$reg->interes.'</td>
                   <td>'.$reg->interes_moratorio.'</td>
                   <td>'.$reg->plazo.'</td>
                   <td>'.$reg->moneda.'</td>
                   <td>'.$reg->nota.'</td>
                   </tr>';
        }

        break;
    case 'mostrarUltimoPendiente':
        $id=$_GET['idhipoteca'];
        $saldo = 0;
        $rspta = $hipoteca->mostrarUltimoPendiente($id);
        while ($reg = $rspta->fetch_object()) {
            
                 $saldo = $reg->saldo;
                 if(empty($saldo)){
                     $saldo = 0;
                     echo $saldo;
                 }

                 echo $saldo;

            }
     break;
    case 'listarDetallesAbono':
        $id=$_GET['idhipoteca'];
        $rspta = $hipoteca->listarDetallesAbono($id);
        $total=0;
        $total=0;
        $opciones="Opciones";

        echo '<thead style="background-color:#6ce393">
                                    <th>Opciones</th>
                                    <th>Fecha</th>
                                    <th style="white-space: nowrap;min-width: 200px;max-width: 200px;overflow: scroll">Concepto</th>
                                    <th>Interes</th>
                                    <th>Interes Mor</th>
                                    <th>Capital</th>
                                    <th>Pendiente Capital</th>
                                    <th>Saldo Pendiente</th>
                                    <th>Moneda</th>    
                                </thead>';


       $montoS=$_GET['monto'];

        while ($reg = $rspta->fetch_object())
        {
            $nota=(string) $reg->nota;

            $total =   $montoS - $reg->abono_capital;
            $montoS=   $total;



            echo '<tr>
                       <td><button class="btn btn-warning" type="button" onclick="editarAbono('.$reg->iddetalle.',\''.$reg->nota.'\', \''.$reg->abono_interes.'\',  \''.$reg->abono_capital.'\',\''.$reg->moneda.'\')"><i class="fa fa-edit"></i></button>
                       <button class="btn btn-danger" type="button" onclick="eliminarAbonoH('.$reg->iddetalle.')"><i class="fa fa-trash"></i></button>
                       </td>
                       <td><input type="hidden" id="fechaA" value="'.$reg->fecha.'">'.$reg->fecha.'</td>
                       <td><input type="hidden" id="notaA" value="'.$reg->nota.'">'.$reg->nota.'</td>
                       <td><input type="hidden" id="interesA" value="'.$reg->abono_interes.'">'.$reg->abono_interes.'</td>
                       <td><input type="hidden" id="interesA" value="'.$reg->abono_interes_moratorio.'">'.$reg->abono_interes_moratorio.'</td>
                       
                       <td><input type="hidden" id="capitalA" value="'.$reg->abono_capital.'">'.$reg->abono_capital.'</td>
                       <td><input type="hidden" id="totalA" value="'.$total.'"> '.$total.'</td>
                       <td><input type="hidden" id="saldoA" value="'.$total.'"> '.$reg->saldo.'</td>
                       <td><input type="hidden" id="monedaA" value="'.$reg->moneda.'">'.$reg->moneda.'</td>   
                   </tr>';


        }
        break;
    case 'listarDetallesAbonoModal':
        $id=$_GET['id'];
        $rspta = $hipoteca->listarDetallesAbono($id);
        $total=0;
        $total=0;
        $opciones="Opciones";

        echo '<thead style="background-color:#6ce393">
                                    <th>Opciones</th>
                                    <th>Fecha</th>
                                    <th style="white-space: nowrap;min-width: 200px;max-width: 200px;overflow: scroll">Concepto</th>
                                    <th>Interes</th>
                                    <th>Capital</th>
                                    <th>Pendiente Capital</th>
                                    <th>Moneda</th>    
                                </thead>';


        $montoS=$_GET['monto'];

        while ($reg = $rspta->fetch_object())
        {
            $nota=(string) $reg->nota;

            $total =   $montoS - $reg->abono_capital;
            $montoS=$total;

            echo '<tr>
                       <td>
                       </td>
                       <td><input type="hidden" id="fechaA" value="'.$reg->fecha.'">'.$reg->fecha.'</td>
                       <td><input type="hidden" id="notaA" value="'.$reg->nota.'">'.$reg->nota.'</td>
                       <td><input type="hidden" id="interesA" value="'.$reg->abono_interes.'">'.$reg->abono_interes.'</td>
                       <td><input type="hidden" id="capitalA" value="'.$reg->abono_capital.'">'.$reg->abono_capital.'</td>
                       <td><input type="hidden" id="totalA" value="'.$total.'"> '.$total.'</td>
                       <td><input type="hidden" id="monedaA" value="'.$reg->moneda.'">'.$reg->moneda.'</td>   
                   </tr>';

        }
        break;
    case 'listarDetallesAbonoMontos':
        $id=$_GET['id'];
        $rspta=$hipoteca->listarDetallesAbonoMonto($id);
        //Vamos a declarar un array
        $data= Array();
        while ($reg=$rspta->fetch_object()){
            $data[]=array(

                "0"=>$reg->fecha,
                "1"=>$reg->nota,
                "2"=>$reg->interes,
                "3"=>$reg->capital,
                "4"=>$reg->moneda,
            );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

        break;
    case 'listarNuevaCuenta':
       $rspta = $hipoteca->listarNuevaCuena();


        echo '<thead style="background-color:#6ce393">
                                           <th>Opciones</th>
                                           <th>Fecha</th>
                                           <th>Id C</th>
                                           <th>Cliente</th>
                                           <th>Garantia</th>
                                           <th>Tipo</th>
                                           <th>Monto</th>
                                           <th>Interés</th>
                                           <th>Moneda</th>
                                           <th style="white-space: nowrap;min-width: 200px;max-width: 200px;overflow: scroll">Nota</th>  
                                </thead>';




        while ($reg = $rspta->fetch_object())
        {
            $urlTICKET='../reportes/TicketRepHLista.php?id=';

            echo '<tr>
                       <td><a target="_blank" href="'.$urlTICKET.$reg->idhipoteca.'"><button class="btn btn-warning" type="button" ><i class="fa fa-print"></i></button> </a>
                       <button class="btn btn-danger" type="button" onclick="eliminarH('.$reg->idhipoteca.')"><i class="fa fa-trash"></i></button> 
                       </td>
                       <td> '.$reg->fecha.'</td>
                       <td> '.$reg->idcliente.'</td>
                       <td> '.$reg->nombre.'</td>
                       <td> '.$reg->garantia.'</td>
                       <td> '.$reg->tipo.'</td>
                       <td> '.$reg->monto.'</td>
                       <td> '.$reg->interes.'</td>
                       <td> '.$reg->moneda.'</td>  
                       <td> '.$reg->nota.'</td>  
                        
                   </tr>';

        }
        break;
    case 'listar':
        $rspta=$venta->listar();
        //Vamos a declarar un array

        $data= Array();


        while ($reg=$rspta->fetch_object()){


            $urlTICKET='../reportes/TicketRep.php?id=';


            $urlFACT='../reportes/FacturaRep.php?id=';


            $data[]=array(
                "0"=>(($reg->estado=='Aceptado')?'<button class="btn btn-warning" onclick="mostrar('.$reg->idventa.')"><i class="fa fa-eye"></i></button>'.
                        ' <button class="btn btn-danger" onclick="anular('.$reg->idventa.')"><i class="fa fa-close"></i></button>':
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idventa.')"><i class="fa fa-eye"></i></button>').

                    // '<a target="_blank" href="'.$urlFACT.$reg->idventa.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>',
                    '<a target="_blank" href="'.$urlTICKET.$reg->idventa.'"> <button class="btn btn-flickr"><i class="fa fa-file-text"></i></button></a>'.
                    '<a target="_blank" href="'.$urlFACT.$reg->idventa.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>',
                "1"=>$reg->fecha,
                "2"=>$reg->cliente,
                "3"=>$reg->usuario,
                "4"=>$reg->tipo_comprobante,
                "5"=>$reg->num_comprobante,
                "6"=>$reg->total_venta,
                "7"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
                    '<span class="label bg-red">Anulado</span>'
            );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

        break;


    case 'listarNuevasCuentas':

        require_once "../modelos/Cuentas.php"; 

        $cuentas = new Cuentas();

        $rspta=$cuentas->listarCuentaDia();
       
        echo '
                <thead>
                <th>Opciones</th>
                <th>Solicitud</th>
                <th>Cuenta</th>
                <th>No Credito</th>
                <th>Cliente</th>
                <th>Cedula</th>
                <th>Monto</th>
                <th>Interes</th>
                <th>Mantenimiento</th>
                <th>Interes Moratorio</th>
                <th>Moneda</th>
                <th>Estado</th>
                <th>Condicion</th>
                </thead>
        ';
        while ($reg=$rspta->fetch_object()) //recorrere todos los registros almacenare en la variable reg y almacenare en el indices cada dato y recorrera todos los registros
        {
           $condition = '';
           $state = '';
           $color = '';
           $urlTICKET='../reportes/TicketRepHLista.php?id=';
           
           if (($reg->estado) == 'Aceptado'){
            $state = '<button class="btn btn-danger" type="button" onclick="eliminarHipoteca('.$reg->idhipoteca.',\''.$reg->cuenta_desembolso.'\',\''.$reg->no_credito.'\',\''.$reg->cantidad_debitada.'\',\''.$reg->solicitud.'\')"><i class="fa fa-trash"></i>Eliminar</button> ';
           }else if(($reg->estado) == 'Cancelado'){
            $state = '<button class="btn btn-twitter" type="button" onclick="restaurar('.$reg->idhipoteca.')" ><i class="fa fa-truck"></i>Regresar</button>';
           }

            

           echo '
                <tr>
                <td>'. $state.' <a target="_blank" href="'.$urlTICKET.$reg->idhipoteca.'"> <button class="btn btn-flickr" type="button"><i class="fa fa-file-text"></i></button></a> </td>
                <td>'.$reg->solicitud.'</td>
                <td>'.$reg->idhipoteca.'</td>
                <td>'.$reg->no_credito.'</td>
                <td>'.$reg->nombres.'</td>
                <td>'.$reg->num_documento.'</td>
                <td>'.$reg->monto.'</td>
                <td>'.$reg->interes.'</td>
                <td>'.$reg->mantenimiento_valor.'</td>
                <td>'.$reg->interes_moratorio.'</td>
                <td>'.$reg->moneda.'</td>
                <td>'.$reg->estado.'</td>
                <td>'.$reg->condicion.'</td>
                </tr>
           
           ';
        }



        break;
        //SELECTS
    case 'selectCliente':

        $rspta=$hipoteca->selectCliente();
        while ($reg = $rspta->fetch_object())
        {
            echo '<option value=' . $reg->idcliente . '>' . $reg->nombres . ' - '.$reg->num_documento.'</option>';
        }
        break;
    case 'selectFiador':
      $rspta = $hipoteca->selectFiador();

        while ($reg = $rspta->fetch_object())
        {
            echo '<option value=' . $reg->idcliente . '>' . $reg->nombres . ' - '.$reg->num_documento.'</option>';
        }
        break;
    case 'selectGarantia':
       $rspta = $hipoteca->selectGarantia();

        while ($reg = $rspta->fetch_object())
        {
            echo '<option value=' . $reg->idgarantia . '>' . $reg->nombre . '</option>';
        }
        break;
    case 'selectCategoria':

        $resp = $hipoteca->selectCategoria();
        while ($reg = $resp->fetch_object())//reg hara el recorrido
        {
            echo '<option value = ' . $reg->idcategoria. '>'. $reg->nombre . '</option>';
        }
        break;
    case 'selectSector':

        $resp = $hipoteca->selectSector();
        while ($reg = $resp->fetch_object())//reg hara el recorrido
        {
            echo '<option value = ' . $reg->idsector. '>'. $reg->sector . '</option>';
        }
        break;
    case 'selectSolicitud':

        $resp = $hipoteca->selectSolicitud();
        while ($reg = $resp->fetch_object())//reg hara el recorrido
        {
            echo '<option value = ' . $reg->idsolicitud. '>'. $reg->idsolicitud . '-'.$reg->cliente. '</option>';
        }
        break;
        //*****
    case 'listarArticulosVenta':

        require_once "../modelos/Articulo.php";
        $articulo=new Articulo();

        $rspta=$articulo->listarActivosVenta();
        //Vamos a declarar un array
        $data= Array();

        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" id="botonon" onclick="agregarDetalle('.$reg->stock.',\''.$reg->idarticulo.'\', \''.$reg->nombre.'\',  \''.$reg->precio_compra.'\',\''.$reg->precio_venta.'\')" ><span class="fa fa-plus"></span></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->categoria,
                "3"=>$reg->codigo,
                "4"=>$reg->stock,
                "5"=>$reg->precio_compra,
                "6"=>$reg->precio_venta,
                "7"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >"
            );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
        break;
    case 'buscarClientesAbono':
        $rspta = $hipoteca->buscarClientesAbono();
        while ($reg=$rspta->fetch_object()){
            echo '<option value='.$reg->idcliente.'>'.$reg->nombre.' - '.$reg->num_documento.'</option>';
        }
        break;
    case 'calcula_moras--':
        $idhipoteca = $_GET['idhipoteca'];
        $dia_menos = $_GET['dia_menos'];
        $dia_menos_formato = "-".$dia_menos." day";
        $fechaactual = date("Y-m-d");
        $fechaactual = date("Y-m-d",strtotime($dia_menos_formato,strtotime($fechaactual)));
        $conteo = 1;
        $conteo2 = 0; //para contar despues de los abonos
        $conteo_moratorio = 1;
        $test = "";
        $test2 = "";
        $totalInteres = 0;
        $totalInteresMoratorio = 0;
        $mes_anioactual = date("Y-m");
        //$anioactual = date("Y");
        //$mesactual = date("m");
        $diaactual = date("d",strtotime($fechaactual));
        //$moneda = 0;

        $rspta = $hipoteca->calcula_mora($idhipoteca);
        $data = Array();

        while ($reg = $rspta->fetch_object()){

            $estado = $reg->estado;
            $monto = $reg->monto;
            $moneda = $reg->moneda;
            $mantenimiento = $reg->mantenimiento_valor;
            $fecha_desembolso = date('Y-m-d',strtotime($reg->fecha_desembolso));
            $aniomes_desembolso =  date('Y-m',strtotime($reg->fecha_desembolso));
            $dia_desembolso = date('d',strtotime($reg->fecha_desembolso));
            $mes_desembolso = date('m',strtotime($reg->fecha_desembolso));
            $anio_desembolso = date('Y',strtotime($reg->fecha_desembolso));

            $fecha_pago = date("Y-m-d",strtotime($reg->fecha_pago));
            $mes_pago = date('m',strtotime($reg->fecha_pago));
            $fecha_pago_mesanio = date('Y-m',strtotime($reg->fecha_pago));
            $dia_pago = date('d',strtotime($reg->fecha_pago));
            $interes = $reg->interes;
            $interes_moratorio = $reg->interes_moratorio;

            if($estado=='sin_abono'){//si no se a realizado ningun abono

                $fechaInicio = $fecha_pago;
                $fechaFin = $fechaactual;
                $diaInicio = date('d',strtotime($fechaInicio));


                while (strtotime($fechaInicio) <= strtotime($fechaFin)){


                    $totalInteres = round( ( ($monto * $interes)/100),2);

                    $dias_mesdeDesembolso = cal_days_in_month(CAL_GREGORIAN, date('m',strtotime($fechaInicio)), date('Y',strtotime($fechaInicio)));
                    $totalInteres = round(($totalInteres / $dias_mesdeDesembolso),2);
                    //El interes moratorio
                    $totalInteresMoratorio = round( ( ($monto * $interes_moratorio)/100),2);
                    $totalInteresMoratorio = round(($totalInteresMoratorio / $dias_mesdeDesembolso),2);

                    $totalMantenimiento = round( (($mantenimiento * $monto )/100),2);
                    $totalMantenimiento = round( ($totalMantenimiento / $dias_mesdeDesembolso ),2);

                    if(date('Y-m',strtotime($fechaInicio)) == date('Y-m',strtotime($fechaFin)) ){
                    ///""""""La ultima fecha con la fecha actual
                        $ultimodia = date('d',strtotime($fechaInicio));
                        $diaactual = date('d',strtotime($fechaactual));
                        $dias_del_ultimomes = $diaactual - $ultimodia;



                        if($diaactual>$ultimodia){
                            $test = $ultimodia." ".$diaactual." ".$dias_del_ultimomes;

                        }elseif ($diaactual==$ultimodia){
                            //si el ultimo dia del mes es el mismo que el mes actual
                            $test = $ultimodia." ".$diaactual." Ultimo Dia ".$dias_del_ultimomes;

                        }
                    }
                        //'''''''''''''La primera Fecha
                        if($conteo == 1){
                                //'''''''''''''La primera Fecha o la primera fecha o la fecha mas pequena
                                //Tiene que recorrer la fecha de pago y fecha desembolso  **********~~~~~~~~~~~~~~~~~ y verificar si es el mismo mes o no
                                if($mes_desembolso == $mes_pago){//Si el mes de pago es el mismo del desembolso

                                    $totalInteresMoratorio = 0;//estamos en la primera fecha, no se cobra interes moratorio
                                    $recorrido_fecha_desembolso = $fecha_desembolso;
                                    $intereses_primerodias = array();
                                    $mantenimientoArray = array();
                                    //Recorrera los dias desde la fecha de desembolso
                                    while(date('Y-m-d',strtotime($recorrido_fecha_desembolso)) < date('Y-m-d',strtotime($fecha_pago)) ){ //no se usa el <= porque cuenta un dia de mas, si han pasado 3 dias,cuenta 4, solo con < los cuanta bien

                                        $totalInteres = round( ( ($monto * $interes)/100),2);//calcula el interes a pagar
                                        $primerosdias = cal_days_in_month(CAL_GREGORIAN, date('m',strtotime($recorrido_fecha_desembolso)), date('Y',strtotime($recorrido_fecha_desembolso)));//cuandos dias hay en el mes, puede que llegue un mes que cambie entonces dira cuantos dias hay en ese mes
                                        $totalInteres = round(($totalInteres / $primerosdias),2);//cuanto seria el interes diario, divide el interes entre los dias del mes en que se encuentre, ya sea el mismo mes o el mes vaya aumentando



                                        array_push($intereses_primerodias,$totalInteres);//agrega los interes calculados diarios al array
                                      
                                        //saca el mantenimiento de valor
                                        $manteminiento_valor_primeros_dias = round( (($mantenimiento * $monto )/100),2);
                                        $manteminiento_valor_primeros_dias = round( ($manteminiento_valor_primeros_dias / $primerosdias ),2);
                                        array_push($mantenimientoArray,$manteminiento_valor_primeros_dias);
                                        
                                      
                                        $recorrido_fecha_desembolso = date('Y-m-d',strtotime("+1 day",strtotime($recorrido_fecha_desembolso)));//aumenta 1 dia hasta llegar al mes y dia de pago`

                                    }

                                    $primerosdias_totales = array_sum($intereses_primerodias);//suma el total de dias
                                    $totalInteres = $primerosdias_totales;

                                    $manteminiento_valor_primeros_dias_total = array_sum($mantenimientoArray);
                                    $totalMantenimiento = $manteminiento_valor_primeros_dias_total;


                                }elseif ($mes_desembolso < $mes_pago){//si el mes de pago es diferente al desembolso

                                    $totalInteresMoratorio = 0; //estamos en la primera fecha, no se cobra interes moratorio
                                    $recorrido_fecha_desembolso = $fecha_desembolso;
                                    $intereses_primerodias = array();
                                    $mantenimientoArray = array();
                                    //Recorrera los dias desde la fecha de desembolso
                                    while(date('Y-m-d',strtotime($recorrido_fecha_desembolso)) < date('Y-m-d',strtotime($fecha_pago)) ){ //no se usa el <= porque cuenta un dia de mas, si han pasado 3 dias,cuenta 4, solo con < los cuanta bien

                                        $totalInteres = round( ( ($monto * $interes)/100),2);//calcula el interes a pagar
                                        $primerosdias = cal_days_in_month(CAL_GREGORIAN, date('m',strtotime($recorrido_fecha_desembolso)), date('Y',strtotime($recorrido_fecha_desembolso)));//cuandos dias hay en el mes, puede que llegue un mes que cambie entonces dira cuantos dias hay en ese mes
                                        $totalInteres = round(($totalInteres / $primerosdias),2);//cuanto seria el interes diario, divide el interes entre los dias del mes en que se encuentre, ya sea el mismo mes o el mes vaya aumentando

                                        array_push($intereses_primerodias,$totalInteres);//agrega los interes calculados diarios al array

                                        //saca el mantenimiento de valor
                                        $manteminiento_valor_primeros_dias = round( (($mantenimiento * $monto )/100),2);
                                        $manteminiento_valor_primeros_dias = round( ($manteminiento_valor_primeros_dias / $primerosdias ),2);
                                        
                                       
                                        
                                       // echo "<script>console.log('Debug Objects: " . $manteminiento_valor_primeros_dias. " ". $contadorEnllave .  "  ' );</script>";
                                        
                                        array_push($mantenimientoArray,$manteminiento_valor_primeros_dias);


                                        $recorrido_fecha_desembolso = date('Y-m-d',strtotime("+1 day",strtotime($recorrido_fecha_desembolso)));//aumenta 1 dia hasta llegar al mes y dia de pago


                                    }

                                    $primerosdias_totales = array_sum($intereses_primerodias);//suma el total de dias
                                    $totalInteres = round(($primerosdias_totales),2);

                                    $manteminiento_valor_primeros_dias_total = array_sum($mantenimientoArray);
                                    $totalMantenimiento = round(($manteminiento_valor_primeros_dias_total),2);
                                }

                              //  $primerosDias = array();


                        }else{
                            $totalDias =  $diaactual;
                          //  $interesDiario = $totalInteres / 30;
                         //   $totalInteres = "Lo que continua";

                        }

                    $data[]=array(
                        "0"=>$conteo,//meses
                        "1"=>$fechaInicio,//fechas
                        "2"=>$totalInteres,//interes diario
                        "3"=>$totalInteresMoratorio, //interes moratorio
                        "4"=>$totalMantenimiento,//totalIntereses /// mantenimiento de valor
                        "5"=>round(($totalInteres + $totalInteresMoratorio + $totalMantenimiento),2), //Moneda
                        "6"=>$moneda.$dia_menos
                       

                    );

                  $fechaInicio = date('Y-m-d',strtotime("+1 day",strtotime($fechaInicio)));
                  $conteo ++;
                }



            }
            else{
                 //Si ya se hicieron abonos
                 //Debe de calcular el siguiente abono para eso debo de tener la ultima fecha, y el interes que le toca
                ////basado en el siguiente capital
                $capital = 0;
                $ultima_fecha = date('Y-m-d');//se inicializan para asignar despues
                $fechaInicio = date('Y-m-d');//se inicializan para asignar despues
                $suma_capital = $hipoteca->muestraSumaCapital($idhipoteca);
                
                while ($reg = $suma_capital->fetch_object()) {
                    $capital = $monto - ($reg->total_abonado) ;//Restante

                }

                $ultimos_datos_abono = $hipoteca->muestraUltimoAbono($idhipoteca);
                while ($reg = $ultimos_datos_abono->fetch_object()){

                    $ultima_fecha = date('Y-m-d',strtotime($reg->fecha));
                    $fechaInicio =  $ultima_fecha;
                    

                } 

                
                //A la variable varFetch la actualizo con el dia de pago pero le paso el ultimo mes que se pago
                //para posteriormente poder hacer el calculo del interes moratorioe
                $varFech = date('Y',strtotime($fechaInicio)). '-'. date('m',strtotime($fechaInicio)) . '-'. date('d',strtotime($fecha_pago));
                $fechaMora = date('Y-m-d',strtotime($varFech));//guarda la fecha con el dia al le toca la mora
              
                while (strtotime($fechaInicio) <= strtotime($fechaactual)){

                    $totalInteres = round( ( ($capital * $interes)/100),2);
                    $totalMantenimiento =  round((($mantenimiento * $capital)/100 ),2 );   
                    $dias_mesdeDesembolso = cal_days_in_month(CAL_GREGORIAN, date('m',strtotime($fechaInicio)), date('Y',strtotime($fechaInicio)));
                   
                    $totalInteres = round(($totalInteres / $dias_mesdeDesembolso),2);
                    $totalMantenimiento = round(($totalMantenimiento / $dias_mesdeDesembolso),2);
                  
                    if(date('Y-m',strtotime($fechaMora)) < date('Y-m',strtotime($fechaInicio))   ){ //verifica que si esta en diferente mes, para que no cobre el mes actual
                        
                        if(date('d',strtotime($fechaMora)) < date('d',strtotime($fechaInicio))   ){ //Una vez dentro comienza a cobrar el dia siguente el moratorio

                             $totalInteresMoratorio = round( ( ($monto * $interes_moratorio)/100),2);
                             $totalInteresMoratorio = round(($totalInteresMoratorio / $dias_mesdeDesembolso),2);

                        }
                        
                    
                    }else{
                        $totalInteresMoratorio = 0;
                    
                    }
                  
                    


                    // $valor = 2345.21;
                   // number_format($valor, 2, '.',',' ) EL formato para separadore de miles y decimales PHP , $valor contiene la cantidad
                  
                    if($conteo2 > 0){//Si no es asi suma la ultima fecha de pago, y tiene que mostrar hasta la fecha siguiente de pago
                      
                        $data[]=array(
                        "0"=>$conteo2,//meses
                        "1"=>$fechaInicio,//fechas
                        "2"=>$totalInteres,
                        "3"=>$totalInteresMoratorio,//interes Moratorio
                        "4"=>$totalMantenimiento /* round((($mantenimiento * $capital)/100 ),2 ) */,
                        "5"=>round(($totalInteres + $totalInteresMoratorio + $totalMantenimiento ),2),
                        "6"=>$moneda.$dia_menos

                        

                    );  
                    

                    }
                   
                    
                    $fechaInicio = date('Y-m-d',strtotime("+1 day",strtotime($fechaInicio)));
                    $conteo2 ++;

                }


            }

        }

           $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);

       

        break;
    case 'eliminarAbono':
        $iddetalleF=$_GET['id'];
        $rpsta=$hipoteca->eliminarDetalleAbono($iddetalleF);
        echo $rpsta ? " Abono Eliminado Correctamente " : " No se pudo eliminar ";
        break;



        break;
    case 'eliminarH':
        $idhipoteca=$_POST['idhipoteca'];
        $cuenta_desembolso =$_POST['cuenta_desembolso'];//la cuenta del socio
        $no_credito = $_POST['no_credito'];
        $solicitud = $_POST['solicitud'];
        $cantidad_debitada = $_POST['cantidad_debitada'];//la cantidad que se habia prestado
        $monto_actulizar = "";//el monto que se actualizara a los socios por estar eliminado la cuenta
        $garantia = "";//la garantia pasara a no_asignado
        $cuenta_socio = "";
       
        $credito = 1;
        //number_format(($saldo_socio - $cantidad_debitada ),2,'.',',');//
        
      


        $rspta =$hipoteca->eliminarHipoteca($idhipoteca);//primero lo elimina, para que reasgine los no_creditos a los que no estan eliminados
        $consulta_saldo =$hipoteca->getSaldoSocio($cuenta_desembolso);
        $get_socio = $consulta_saldo->fetch_object();
        $saldo_socio = $get_socio->monto;
        $saldo_final = ($saldo_socio + $cantidad_debitada);//obtiene cuanto monto tiene el socio y le sumara lo que se habia debitado
        $rpsta=$hipoteca->pruebaReasignarNoCredito($solicitud);//recibe el idhipotecas con la solicitud enviada, cada solicitud ouede tener varias prestamos
        while($creditos = $rpsta->fetch_object()){
            
            $idhipotecaCredit =  $creditos->idhipoteca;
            
            
           $hipoteca->actualizarNoCreditos($idhipotecaCredit,$credito);//reacomadara el orden de los numero de no_creditos
           $credito ++;
           
         }

         $hipoteca->actualizarMontoSocio($cuenta_desembolso,$saldo_final);
         
         echo $rspta ? "Eliminado Correctamente" : "No se pudo eliminar";
       // $rpsta=$hipoteca->eliminarHipoteca( $idhipoteca,$cuenta_desembolso,$no_credito,$cantidad_debitada);
       // echo $rpsta ? " Cuenta Eliminada Correctamente " : " No se pudo eliminar la cuenta!!! ";
        break;
    case 'fechaActual':
            $fechaActual = date('Y-m-d');
             echo $fechaActual;
     break;

        


     }







     
?>