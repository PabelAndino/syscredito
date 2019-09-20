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
           echo $respta ? "Cuenta Ingresada Correctamente":"No se pudo ingresar correctamente la cuenta, Intente de nuevo";
        }

        break;
        //LIST METHODS
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
                    <td><button type="button" class="btn btn-warning"><i class="fa fa-edit"></i></button></td>
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
    case 'listarPickerBanco':
        $respta=$cuentas_bancos->listarCuentasBancos();
        while ($reg=$respta->fetch_object()){
            echo '<option value="'.$reg->idcuentas_bancos.'">'.$reg->banco.'-'.$reg->num_cuenta.'</option>';
        }
        break;
        //OTHER METHODS
    case 'calculaSaldoBanco':
        $idbanco=$_GET['idbanco'];
        $respta=$cuentas_bancos->mostrarMonto($idbanco);

        while ($rep=$respta->fetch_object()){

            $monto = round(($rep->monto),2);
            echo ($monto);

        }
        break;
    case 'saldoBancoMoneda':
        $idbanco=$_GET['idbanco'];
        $respta=$cuentas_bancos->mostrarMonto($idbanco);

        while ($rep=$respta->fetch_object()){

            echo ($rep->moneda);

        }

        break;

}
?>