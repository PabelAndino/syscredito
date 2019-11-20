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
if ($_SESSION['Abono']==1)
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

<body onload="window.print();" style="style="width:100px;height:500px;"><!--IMPRIME DIRECTAMENTE AL LLAMARLO-->
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
    $documento = "";
    $direccion = "Contiguo antena claro sector 3";
    $telefono = "2737-2584";
  ?>
  
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
              <td><?php echo $reg->tipo_documento.": ".$reg->num_documento; ?></td>
          </tr>
          <tr>
              <td>Nº de cuenta: <?php echo " - ".$reg->num_cuenta ; ?></td>
          </tr>
          <tr>
            <td>
               Nº Solicitud: <?php echo " - ".$reg->num_cuenta ; ?>
            </td>
           
          </tr>
          <tr>
            <td>
               Nº Credito: <?php echo " - ".$reg->no_credito ; ?>
            </td>
           
          </tr>
      </table>
      <br>
      <!-- Mostramos los detalles de la venta en el documento HTML -->

      <table border="1" width="270px" class="titulo">
        <tr>
                <td>Intereses</td>
                <td>Capital</td>
                <td>Total</td>
                <td>Moneda</td>
            </tr>
            <tr>
              <!-- <td colspan="3">----------------------------</td> -->
            </tr>
            <?php

              $rsptad = $hipoteca->abonoDetalle($_GET["id"]);
              $cantidad=0;

              while ($regd = $rsptad->fetch_object()) {
                  echo "<tr>";
                  echo "<td>".$regd->intereses."</td>";
                  echo "<td>".$regd->abono_capital;
                  echo "<td > ".round((($regd->total_abonado)+($regd->abono_capital)),2)."</td>";
                  echo "<td > ".$regd->moneda."</td>";
                  echo "</tr>";

              }

            ?>
      </table>

      <table border="0.5">

           <tr>
              <td align="left"><b>Principal:</b></td>
              <td><b> <?php echo $recorreres->monto; ?></b></td>

          </tr>
          
          <!-- Mostramos los totales de la venta en el documento HTML -->
          <tr>

            <td align="left"><b>Saldo Actual:</b></td>
            <td><b> <?php
              $restant =$recorreres->restante;
              if (($recorreres->sumaTotal) == 0){
               
               $rst = $hipoteca->restanteTicketHipoteca($_GET["idhipo"]);
               $rr = $rst->fetch_object();
               $restant = $rr->restante;
              }
            
            echo $restant; ?></b></td>

          </tr>

        
          <tr>
              <td align="left"><b>Pendiente:</b></td>
              <td><b> <?php echo $recorreres->pendiente; ?></b></td>

          </tr>


          <tr>
            <td colspan="3">Nº de abono: <?php echo $reg->detalle; ?></td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
         
            <td colspan="3">&nbsp;</td>
          </tr>

          
      </table>

      
  
            <table>
            <tr>
            <td colspan="" align="left">________________</td>
            <td colspan="" align="right">________________</td>
          </tr>
          <tr>
            <td colspan="" align="left">Recibi conforme</td>
            <td colspan="" align="right">Entregue conforme</td>
          </tr>
          <tr>
            </table>

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