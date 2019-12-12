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


            <?php


                $capital = $_GET['capital'];
                $interes = $_GET['interes'];
                $mantenimiento = $_GET['mantenimiento'];
                $saldo = $_GET['saldo'];
                $pendiente = $_GET['pendiente'];
                $moratorio = $_GET['moratorio'];
                $moneda = $_GET['moneda'];
                $cantidad=0;
                $total =(round((($moratorio)+($interes)+($mantenimiento)+($pendiente)+($capital)),2));

                echo '<table border="2" width="300px" class="titulo">
                      <tr>
                            <td>Capital</td>
                            <td>Interes</td>
                            <td>Mantenimiento</td>
        
                      </tr>
        
                     <tr>
                      <!-- <td colspan="3">----------------------------</td> -->
                     </tr>';
                echo "<tr>";
                echo "<td><i>".number_format($capital,2,'.',',')."</i></td>";
                echo "<td><i>".$interes."</i></td>";
                echo "<td><i>".$mantenimiento."</i></td>";
                echo "</tr>";
                echo "<tr>
               
                         <td>Mora</td>
                         <td>Total</td>
                         <td>Moneda</td>
                     
                      </tr>";
                echo "<tr>";
                echo "<td><i> ".$moratorio."</i></td>";
                echo "<td><i> ".number_format($total,2,'.',',')."</i></td>";
                echo "<td><i> ".$moneda."</i></td>";
                echo "</tr>";


            ?>
      </table>

      <table border="0.5">

           <tr>
              <td align="left"><b>Saldo:</b></td>
               <td></td>
               <td></td>
               <td><i><b> <?php echo  $saldo = $_GET['saldo']; ?></b></i></td>

          </tr>
          
          <!-- Mostramos los totales de la venta en el documento HTML -->

          <tr>
              <td align="left" colspan="3"><b>Pendiente:</b></td>

              <td><i><b> <?php echo $recorreres = $_GET['pendiente']; ?></b></i> </td>
          </tr>


          <tr>
              <td>Nº de abono: </td>

              <td ><?php echo  $saldo = $_GET['id']; ?></td>

          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
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