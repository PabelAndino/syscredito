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
        echo '<thead style="background-color:#e3a100">
                <th>Opciones</th>
                     <th>Nombres</th>
                     <th>Documento</th>
                     <th>No Documento</th>
                     <th>Genero</th>
                     <th>Dirección</th>
                     <th>Teléfono</th>
                     <th>Correo</th>
                     <th>Estado</th>
              </thead>';
        while ($reg = $respta->fetch_object()){
            if($reg->estado=='Anulado'){
                echo '<tr style="background-color: #ffcdbc">
                    <td><button type="button" onclick="editSocio(' .$reg->idsocios.',\''.$reg->nombres.'\',\''.$reg->tipo_documento.'\',\''.$reg->cedula_ruc.'\',
                    \''.$reg->genero.'\',\''.$reg->direccion.'\',\''.$reg->telefono.'\',\''.$reg->correo.'\')" class="btn btn-warning"><i class="fa fa-edit"></i></button>.<button type="button" class="btn btn-success" onclick="activarSocio('.$reg->idsocios.')"><i class="fa fa-check"></i></button>.<button type="button" onclick="anularSocio('.$reg->idsocios.')" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>
                    <td>'.$reg->nombres.'</td>
                    <td>'.$reg->tipo_documento.'</td>
                    <td>'.$reg->cedula_ruc.'</td>
                    <td>'.$reg->genero.'</td>
                    <td>'.$reg->direccion.'</td>
                    <td>'.$reg->telefono.'</td>
                    <td>'.$reg->correo.'</td>
                    <td>'.($reg->estado=="Aceptado"?'<span class="label bg-green">Aceptado</span>':'<span class="label bg-red">Cancelado</span>') .' </td>
        
                </tr>';
            }else{
                echo '<tr>
                    <td><button type="button" onclick="editSocio('.$reg->idsocios.',\''.$reg->nombres.'\',\''.$reg->tipo_documento.'\',\''.$reg->cedula_ruc.'\',
                    \''.$reg->genero.'\',\''.$reg->direccion.'\',\''.$reg->telefono.'\',\''.$reg->correo.'\')" class="btn btn-warning"><i class="fa fa-edit"></i></button>.<button type="button" class="btn btn-success" onclick="activarSocio('.$reg->idsocios.')"><i class="fa fa-check"></i></button>.<button type="button" onclick="anularSocio('.$reg->idsocios.')" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>
                    <td>'.$reg->nombres.'</td>
                    <td>'.$reg->tipo_documento.'</td>
                    <td>'.$reg->cedula_ruc.'</td>
                    <td>'.$reg->genero.'</td>
                    <td>'.$reg->direccion.'</td>
                    <td>'.$reg->telefono.'</td>
                    <td>'.$reg->correo.'</td>
                    <td>'.($reg->estado=="Aceptado"?'<span class="label bg-green">Aceptado</span>':'<span class="label bg-red">Cancelado</span>') .' </td>
        
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