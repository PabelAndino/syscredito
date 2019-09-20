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
if ($_SESSION['ventas']==1)
{
?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link href="../public/css/ticket.css" rel="stylesheet" type="text/css">

</head>
<body onload="window.print();"><!--IMPRIME DIRECTAMENTE AL LLAMARLO-->
<?php

//Incluímos la clase Venta
require_once "../modelos/Gestionar_Hipoteca.php";
//Instanaciamos a la clase con el objeto venta
$hipoteca = new Gestionar_Hipoteca();
//En el objeto $rspta Obtenemos los valores devueltos del método ventacabecera del modelo
$rspta = $hipoteca->cabeceraTicket($_GET["id"]);
$reg = $rspta->fetch_object();

$restante = $hipoteca->restanteTicket($_GET["id"]);
$recorreres = $restante->fetch_object();
//Recorremos todos los valores obtenidos


//Establecemos los datos de la empresa

$empresa = "CrediEmpeño";
$documento = "2737-00000";
$direccion = "Sector 3";
$telefono = "2737-00000";
$email = "pabelwitt@gmail.com";
?>
<div class="zona_impresion">
<!-- codigo imprimir -->
<br>
<table border="1"  width="300px">
    <tr>
        <td align="center">
        <!-- Mostramos los datos de la empresa en el documento HTML -->
        .::<strong> <?php echo $empresa; ?></strong>::.<br>
        <?php echo $documento; ?><br>
        <?php echo $direccion .' - '.$telefono; ?><br>
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
        <td><?php echo $reg->tipo_documento.": ".$reg->num_documento; ?></td>
    </tr>
    <tr>
        <td>Nº de cuenta: <?php echo " - ".$reg->num_cuenta ; ?></td>
    </tr>
</table>
<br>
<!-- Mostramos los detalles de la venta en el documento HTML -->
<table border="0"  width="100px" >


    <tr>
        <td >Interes.</td>
        <td>Capital</td>
        <td>Total Abonado</td>
    </tr>
    <tr>
      <td colspan="3">=============================</td>
    </tr>
    <?php

    $rsptad = $hipoteca->abonoDetalle($_GET["id"]);
    $cantidad=0;

    while ($regd = $rsptad->fetch_object()) {
        echo "<tr>";
        echo "<td>".$regd->abono_interes."</td>";
        echo "<td>".$regd->abono_capital;
        echo "<td >$/ ".$regd->total_abonado."</td>";
        echo "</tr>";

    }

    ?>
    <!-- Mostramos los totales de la venta en el documento HTML -->
    <tr>

    <td align="left"><b>Restante:</b></td>


    <td><b> <?php echo $recorreres->restante;  ?></b></td>


    </tr>
    <tr>

        <td align="left"><b>Principal:</b></td>


        <td><b> <?php echo $recorreres->monto; ?></b></td>


    </tr>
    <tr>
      <td colspan="3">Nº de abono: <?php echo $reg->detalle; ?></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" align="center">¡Gracias por preferirnos!</td>
    </tr>
    <tr>
      <td colspan="3" align="center">ElsaSoft</td>
    </tr>
    <tr>
      <td colspan="3" align="center"> Nicaragua- Jalapa</td>
    </tr>

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