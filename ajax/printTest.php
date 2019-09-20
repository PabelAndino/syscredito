<?php
if (strlen(session_id()) < 1)
    session_start();

require_once "../modelos/Cuenta_Banco.php";


$cuentas_bancos=new Cuenta_Banco();


 function mostrar($monto,$total){

 }

switch ($_GET["op"]){
     //Select methods


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
        }else{
            $editresp=$cuentas_bancos->editarSocios($idsocio,$nombres,$tipo_documento,$cedula_ruc,$genero,$direccion,$telefono,$correo);
            echo $editresp ? "Socio Editado Correctamente":"No se pudo editar el socio";
        }
        break;


        //LIST METHODS
    case 'listarSocios':
        $respta=$cuentas_bancos->listarSociosCompleto();
        echo '<thead >
               
                     <th>Nombres</th>
                     <th>Documento</th>
                     <th>No Doc</th>
                     <th>Genero</th>
                     <th>Dirección</th>
                     <th>Teléfono</th>
                     <th>Correo</th>
                     <th>Estado</th>
              </thead>';
        while ($reg = $respta->fetch_object()){
            if($reg->estado=='Anulado'){
                echo '<tr style="background-color: #ffcdbc">
                    
                    <td>1</td>
                    <td>198</td>
                    <td>121</td>
                    <td>9098</td>
                    <td>21</td>
                    <td>19082</td>
                    <td>1213</td>
                    <td>198</td>
        
                </tr>';
            }else{
                echo '<tr>
                    
                    <td>1</td>
                    <td>198</td>
                    <td>121</td>
                    <td>9098</td>
                    <td>21</td>
                    <td>19082</td>
                    <td>1213</td>
                    <td>198</td>
                </tr>';
            }

        }

        break;

        //DELETE METHODS
    case 'anularSocio':
        $idsocio=$_GET['idsocio'];
        $respta=$cuentas_bancos->anularSocio($idsocio);
        echo $respta ? "Anulado correctamente":"No se pudo anular el socio";
        break;
        //Activate Methods
    case 'activarSocio':
        $idsocio=$_GET['idsocio'];
        $respta=$cuentas_bancos->activarSocio($idsocio);
        echo $respta ? "Activado correctamente":"No se pudo activar el socio";
        break;

}
?>