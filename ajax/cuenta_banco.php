<?php
if (strlen(session_id()) < 1)
    session_start();

require_once "../modelos/Cuenta_Banco.php";


$cuentas_bancos=new Cuenta_Banco();


 function mostrar($monto,$total){

 }


switch ($_GET["op"]){
     //Select methods
    case 'selectSocios':

        $rspta=$cuentas_bancos->listarSocios();
        while ($reg = $rspta->fetch_object()){
            echo '<option value='.$reg->idsocios.'>'.$reg->nombres.' - '.$reg->cedula_ruc.'</option>';
        }
        break;


    case 'selectBancos':
            $rpsta = $cuentas_bancos->listarBancos();

            while($reg = $rpsta->fetch_object()){
                echo '<option value='.$reg->idbanco.'>'.$reg->nombre_banco.'</option>';
            }
            break;
        //SAVE METHODS
    case 'guardarSocios':

        $idsocio=$_GET['idsocio'];
        $nombres=$_GET['nombres'];
        $direccion=$_GET['direccion'];
        $tipo_documento=$_GET['tipo_documento'];
        $cedula_ruc=$_GET['cedula_ruc'];
        $genero=$_GET['genero'];
        $telefono=$_GET['telefono'];
        $correo=$_GET['correo'];

        if(empty($idsocio)){
            $respta=$cuentas_bancos->guardarSocios($nombres,$direccion,$tipo_documento,$cedula_ruc,$genero,$telefono,$correo);
            echo $respta ? "Socio Ingresado Correctamente":"Socio No se pudo guardar";
        }
        break;

    case 'guardarCuentaBanco':
        $idcuenta_banco=$_GET['idcuenta_banco'];
        $socio=$_GET['socio'];
        $nombre_banco=$_GET['nombre_banco'];
        $num_cuenta=$_GET['num_cuenta'];
        $fecha=$_GET['fecha'];
        $moneda=$_GET['moneda'];
        $monto=$_GET['monto'];

        if(empty($idcuenta_banco)){
            $respta = $cuentas_bancos->guardarCuentaBanco($socio,$nombre_banco,$num_cuenta,$fecha,$moneda,$monto);
           echo $respta ? "Cuenta Ingresada Correctamente" : "No se pudo ingresar correctamente la cuenta, Intente de nuevo";
          //echo $respta;
        }else{

            $respta = $cuentas_bancos->editarCuentaBanco($idcuenta_banco,$socio,$nombre_banco,$num_cuenta,$fecha,$moneda,$monto);
            echo $respta ? "Cuenta Editada Correctamente" : "No se pudo Editar correctamente la cuenta, Intente de nuevo";
        }

        break;
        //LIST METHODS
    case 'guardarBanco':
        $idbanco = $_POST['idbanco'];
        $nombre_banco = $_POST['nombre_banco'];
        $descripcion = $_POST['descripcion'];
        
        if(empty($idbanco)){
           
            $rspta = $cuentas_bancos->guardarBanco($nombre_banco,$descripcion);
            echo $rspta ? "Banco guardado Correctamente" : "No se pudo guardar el banco";

        }else{
            $rspta = $cuentas_bancos->updateBanco($idbanco,$nombre_banco,$descripcion);
            echo $rspta ? "Banco actualizado Correctamente" : "No se pudo actualizar el banco";
        }

    break;

    case 'eliminarBanco':
            $idbanco = $_POST['idbanco'];

            $rspta = $cuentas_bancos->eliminarBanco($idbanco);
            echo $rspta ? "Banco Anulado correctamente" : "No se pudo Anular el banco";

    break;

    case 'restaurarBanco':
        $idbanco = $_POST['idbanco'];

        $rspta = $cuentas_bancos->restaurarBanco($idbanco);
        echo $rspta ? "Banco Restaurar correctamente" : "No se pudo Restaurar el banco";

    break;
    case 'listarCuentasBanco':
        $respta=$cuentas_bancos->listarCuentasBancos();
        echo '<thead style="background-color:#e3a100">
                <th>Opciones</th>
                <th>Fecha</th>
                <th>No Cuenta</th>
                <th>Socio</th>
                <th>Documento</th>
                <th>Banco</th>
                <th>No Cuenta Banco</th>
                <th>Moneda</th>
                <th>Monto</th>
              </thead>';
        while ($reg = $respta->fetch_object()){

            
            echo '<tr>
                    <td><button type="button" onclick="editarCuentaBanco('.$reg->idcuentas_bancos.',\''.$reg->socioid.'\',\''.$reg->idbanco.'\',\''.$reg->num_cuenta.'\',\''.$reg->fecha.'\',\''.$reg->moneda.'\',\''.$reg->monto.'\',) " class="btn btn-warning"><i class="fa fa-edit"></i></button></td>
                    <td>'.$reg->fecha.'</td>
                    <td>'.$reg->idcuentas_bancos.'</td>
                    <td>'.$reg->socio.'</td>
                    <td>'.$reg->documento.'</td>
                    <td>'.$reg->banco.'</td>
                    <td>'.$reg->num_cuenta.'</td>
                    <td>'.$reg->moneda.'</td>
                    <td>'.$reg->monto.'</td>
        
                </tr>';
        }

    break;

    case 'listarBancos':
        $respta=$cuentas_bancos->listarTodosBancos();
        echo '<thead style="background-color:#e3a100">
                <th>Opciones</th>
                <th>Banco</th>
                <th>Descripcion</th>
                <th>Estado</th>
              </thead>';
        while ($reg = $respta->fetch_object()){

            $editState = '';
            $state = '';
            if (($reg->estado) == 'Aceptado'){
                $editState = '<button class="btn btn-danger" type="button" onclick="eliminarBancos('.$reg->idbanco.')"><i class="fa fa-trash"></i>Eliminar</button>';
                $state ='<span class="label bg-green">Aceptado</span>' ;
               
               }else if(($reg->estado) == 'Anulado'){
                $editState = '<button class="btn btn-twitter" type="button" onclick="restaurarBancos('.$reg->idbanco.')" ><i class="fa fa-truck"></i>Restaurar</button>';
                $state ='<span class="label bg-red">Anulado</span>' ;
            }
                   echo '<tr>
                    <td><button type="button"  onclick="actualizarBanco('.$reg->idbanco.',\''.$reg->nombre_banco.'\',\''.$reg->descripcion.'\')" class="btn btn-warning"><i class="fa fa-edit"></i></button>  '.$editState.' </td>
                    <td>'.$reg->nombre_banco.'</td>
                    <td>'.$reg->descripcion.'</td>
                    <td> '.$state.' </td>
                 
                </tr>';
        }

    break;
    case 'listarPickerBanco':
        $respta=$cuentas_bancos->listarCuentasBancos();
        while ($reg=$respta->fetch_object()){
            echo '<option value="'.$reg->idcuentas_bancos.'">'.$reg->socio.'-'.$reg->num_cuenta.'</option>';
        }
        break;
        //OTHER METHODS
    case 'calculaSaldoBanco':
        $idbanco=$_GET['idbanco'];
        $montoresp=$cuentas_bancos->mostrarMonto($idbanco);
        $abonadoresp = $cuentas_bancos->calculaSaldo($idbanco);
        $resptamoneda=$cuentas_bancos->mostrarMonedaBanco($idbanco);
        $abonado = 0;
        $saldo = 0 ;
        while ($rep=$resptamoneda->fetch_object()){

            $moneda = ($rep->moneda);
            if($moneda == "Dolares"){
               // echo "Dolares ", $rep->monto;
            }else{
              //  echo "Cordobas ", $rep->monto;        
            }

        }

        while($reg=$abonadoresp->fetch_object()){
            $monto_abonado = round(($reg->monto_abonado),2);
            //Obtiene la cantidad de dinero que se a prestado para luego restarlo al monto y que calcule cuanto queda
            $abonado = $monto_abonado;
        }
        while ($rep=$montoresp->fetch_object()){

            $monto = round(($rep->monto),2);
            $saldo = $monto - $abonado ; //resta la suma de lo que se a prestado y lo resta al monto original para obtener el total o cuanto queda
            echo ($saldo);

        }
        break;
    case 'saldoBancoMoneda':
        $idbanco=$_GET['idbanco'];
        $respta=$cuentas_bancos->mostrarMonedaBanco($idbanco);

        while ($rep=$respta->fetch_object()){

            echo ($rep->moneda);

        }



        break;

}
?>