<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();

if (!isset($_SESSION["nombre"]))
{
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
}
else
{
if ($_SESSION['Administrador']==1)
{
?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link href="../public/css/ticket.css" rel="stylesheet" type="text/css">
    <style>
.titulo,.datos_prestamo {
  border-collapse: collapse;
 }

.titulo,.datos_prestamo {
  border: 1px solid black;
}
</style>

</head>
<body onload="window.print();"><!--IMPRIME DIRECTAMENTE AL LLAMARLO-->
<?php

//Incluímos la clase Venta
require_once "../modelos/Gestionar_Hipoteca.php";
//Instanaciamos a la clase con el objeto venta
$hipoteca = new Gestionar_Hipoteca();
//En el objeto $rspta Obtenemos los valores devueltos del método ventacabecera del modelo
$rspta = $hipoteca->ticketNuevaCuenta($_GET["id"]);
$reg = $rspta->fetch_object();

$restante = $hipoteca->restanteTicket($_GET["id"]);
$recorreres = $restante->fetch_object();
//Recorremos todos los valores obtenidos


//Establecemos los datos de la empresa

$empresa = "CrediEmpeño";
$documento = "";
$direccion = "Contiguo antena claro sector 3";
$telefono = "2737-2584";

?>
<div class="zona_impresion">
<!-- codigo imprimir -->
<br>
<table border="1"  width="300px" class="titulo">
    <tr>
        <td align="center">
        <!-- Mostramos los datos de la empresa en el documento HTML -->
        <img src="../public/img/logo.png" alt="Logo" style="width:170px; height:70px;"><br>
       
        <?php echo $direccion; ?><br>
        <?php echo $telefono; ?><br>
        </td>
    </tr>
    <!--<tr>
        <td align="center"><?php /*echo $reg->fecha; */?></td>
    </tr>-->
    <tr>
      <td align="center"></td>
    </tr>
    <tr>
        <!-- Mostramos los datos del cliente en el documento HTML -->
        <td>Cliente: <?php echo $reg->cliente; ?></td>
    </tr>
    <tr>
        <td><?php echo $reg->tipo_documento.": ".$reg->cedula; ?></td>
    </tr>
    <tr>
        <td>Nº de cuenta: <?php echo " - ".$reg->idhipoteca ; ?></td>
    </tr>
    <tr>
        <td>Fecha de desembolso: <?php echo " - ".date('d-m-Y',strtotime($reg->fecha_desembolso)); ?></td>
    </tr>
    <tr>
        <td>Primer Pago: <?php echo " - ".date('d-m-Y',strtotime($reg->fecha_pago)); ?></td>
    </tr>
</table>
<br>
<!-- Mostramos los detalles de la venta en el documento HTML -->
<table class="datos_prestamo" border="1"  width="300px" >


    <tr>
        <td >Interes.</td>
        <td>Monto</td>
        <td>Moneda</td>
    </tr>
  
    <?php

    $rsptad = $hipoteca->ticketNuevaCuenta($_GET["id"]);
    $cantidad=0;

    while ($regd = $rsptad->fetch_object()) {
        $interes= (($regd->interes));
        $fecha_desem = $reg->fecha_desembolso;
        $fecha_pago = $reg->fecha_pago;
        $mantenimiento_valor =$reg->mantenimiento_valor;
        $monto2 = $regd->monto;
        $date2 = date('Y-m-d',strtotime("+1 day",strtotime($fecha_desem)));//despues de resolver los primeros meses ahora el mes de inicio sera el mes que continua comienza al siguiente dia porque 
        //en los primeros meses ya se cobro el dia correspondiente entonce somienza al siguiente dia, por es el +1
        
        $intereses_primerodias = array();
        $mantenimientoArray = array();
        while(date('Y-m-d',strtotime($date2))   <=  date('Y-m-d',strtotime($fecha_pago) ) ){//recorrera el siguiente dia de desembolso hasta el dia que contemplo pagar

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
        //// $valor = 2345.21;
        // number_format($valor, 2, '.',',' )
        //$valor sera = 2,345.21

        echo "<tr>";
        echo "<td>".number_format((round(($interes_calculado + $mantValor),2)),2,'.',',')."</td>";
        echo "<td>".number_format(($regd->monto),2,'.',',');
        echo "<td > ".$regd->moneda."</td>";
        echo "</tr>";

    }

    ?>
  

    



    <!-- Mostramos los totales de la venta en el documento HTML -->
    


</table>




<br>
</div>
<p>&nbsp;</p>

</body>
</html>
<?php 
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>