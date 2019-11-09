<?php
if (strlen(session_id()) < 1)
    session_start();

require_once "../modelos/Solicitud.php";


$solicitudes=new Solicitud();


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
    case 'listarSolicitudes':
        $respta=$solicitudes->listarSolicitud();
        echo '<thead style="background-color:#e3a100">
                <th>Opciones</th>
                <th>Cliente</th>
                <th>Documento</th>
                <th>No Documento</th>
                <th>Estado</th>
              </thead>';
        while ($reg = $respta->fetch_object()){
            $ingresos = ($reg->ingresos);
            $ingresoArr =  ((unserialize($ingresos)));
            $opciones = '';
            $updateOption = '<button type="button" onclick="editSolicitud(' .$reg->idsolicitud.',\''.$reg->cliente.'\',\''.$reg->nombre_conyugue.'\',\''.$reg->tipo_local.'\',
            \''.$reg->leer_escribir.'\',\''.$reg->ultimo_estudio_anio.'\',\''.$reg->numero_dependientes.'\',\''.$reg->total_ingresos.'\',
            \''.$reg->sector.'\',\''.$reg->objetivo_prestamo.'\',\''.$reg->estado.'\')" class="btn btn-warning"><i class="fa fa-edit"></i></button>  ';
            // print_r($ingresoArr);
            if($reg->estado=='Anulado'){
            
                $opciones = '<button type="button" class="btn btn-success" onclick="activarSolicitud('.$reg->idsolicitud.')"><i class="fa fa-check"></i></button>';
                
            }else{
                $opciones = '<button type="button" onclick="anularSolicitud('.$reg->idsolicitud.')" class="btn btn-danger"><i class="fa fa-trash"></i></button>';
                
                
            }
            echo '<tr>
            <td>'.$updateOption.$opciones.'</td>
            <td>'.$reg->nombres.'</td>
            <td>'.$reg->tipo_documento.'</td>
            <td>'.$reg->num_documento.'</td>
            <td>'.($reg->estado=="Aceptado"?'<span class="label bg-green">Aceptado</span>':'<span class="label bg-red">Cancelado</span>') .' </td>

        </tr>';


        }

        break;

        //DELETE METHODS
    case 'anularSolicitud':
        $idsolicitud=$_GET['idsolicitud'];
        $respta=$solicitudes->anularSolicitud($idsolicitud);
        echo $respta ? "Anulado correctamente":"No se pudo anular la solicitud";
        break;
        //Activate Methods
    case 'activarSolicitud':
        $idsolicitud=$_GET['idsolicitud'];
        $respta=$solicitudes->activarSolicitud($idsolicitud);
        echo $respta ? "Activado correctamente":"No se pudo activar la solicitud";
        break;

    case 'selectIngreso':
        $idsolicitud = $_GET['idsolicitud'];
        $rspta = $solicitudes->listarIngresos($idsolicitud);
        while($reg= $rspta->fetch_object()){
            $ingreso = json_encode (unserialize($reg->ingresos));
            print_r($ingreso);
        }

    break;

    }

?>