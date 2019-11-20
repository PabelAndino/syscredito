<?php
if (strlen(session_id()) < 1)
    session_start();

require_once "../modelos/Egresos.php";


$egresos=new Egresos();
$idusuario=$_SESSION["idusuario"];

 function mostrar($monto,$total){

 }


switch ($_GET["op"]){
     //Select methods
    case 'selectEgresos':

        $rspta=$egresos->listarEgresos();
        while ($reg = $rspta->fetch_object()){
            echo '<option value='.$reg->idegresos.'>'.$reg->categoria_egreso.'</option>';
        }
        break;


        //SAVE METHODS

    case 'guardarEgresoDetalles':
        $iddetalle_egreso=$_POST['iddetalle_egreso'];
        $idegreso=$_POST['idegreso'];
        $descripcion_egreso=$_POST['descripcion_egreso'];
        $fecha=$_POST['fecha'];
        $moneda=$_POST['moneda'];
        $monto=$_POST['monto'];

        if(empty($iddetalle_egreso)){
            $respta = $egresos->guardarDetallesEgreso($idusuario,$monto,$idegreso,$descripcion_egreso,$moneda,$fecha);
            echo $respta ? "EGRESO ingresado Correctamente" : "No se pudo ingresar el egreso correctamente ";
          //echo $respta;
        }else{

            $respta = $egresos->editarDetallesEgreso($iddetalle_egreso,$monto,$idegreso,$descripcion_egreso,$moneda,$fecha);
            echo $respta ? "Detalles Egreso Editados Correctamente" : "No se pudo Editar los detalles correctamente ";
        }

        break;
        //LIST METHODS
    case 'guardarEgreso':
            $idegreso = $_POST['idegreso'];
            $egreso_input = $_POST['egreso_input'];
            $descripcion_input = $_POST['descripcion_input'];
            
            if(empty($idegreso)){
            
                $rspta = $egresos->guardarEgreso($egreso_input,$descripcion_input);
                echo $rspta ? "Egreso guardado Correctamente" : "No se pudo guardar el Tipo de Egreso";

            }else{
                $rspta = $egresos->updateEgreso($idegreso,$egreso_input,$descripcion_input);
                echo $rspta ? "Egreso actualizado Correctamente" : "No se pudo actualizar el Tipo de Egreso";
            }

     break;

    case 'eliminarEgreso':
            $idegreso = $_POST['idegreso'];

            $rspta = $egresos->eliminarEgreso($idegreso);
            echo $rspta ? "Egreso Anulado correctamente" : "No se pudo Anular el egreso";

     break;

    case 'restaurarEgreso':
        $idegreso = $_POST['idegreso'];

        $rspta = $egresos->restaurarEgreso($idegreso);
        echo $rspta ? "Egreso Restaurado correctamente" : "No se pudo Restaurar el Egreso";

     break;
    case 'listarDetallesEgresos':
        $respta=$egresos->listarDetallesEgresosTodos();
        echo '<thead style="background-color:#e3a100">
                <th>Opciones</th>
                <th>Usuario</th>
                <th>Egreso</th>
                <th>Detalles</th>
                <th>Monto</th>
                <th>Moneda</th>
                <th>Estado</th>
                
              </thead>';
        while ($reg = $respta->fetch_object()){

            
            echo '<tr>
                    <td><button type="button" onclick="editarDetallesEgreso('.$reg->id_detalles_egresos.',\''.$reg->categoria_egreso.'\',\''.$reg->fecha.'\',\''.$reg->moneda.'\',\''.$reg->monto.'\',\''.$reg->detalles.'\') " class="btn btn-warning"><i class="fa fa-edit"></i></button></td>
                    <td>'.$reg->usuario.'</td>
                    <td>'.$reg->categoria.'</td>
                    <td>'.$reg->detalles.'</td>
                    <td>'.$reg->monto.'</td>
                    <td>'.$reg->moneda.'</td>
                    <td>'.$reg->estado.'</td>
                   
        
                </tr>';
        }

    break;

    case 'listarEgresos':
        $respta=$egresos->listarEgresosTodos();
        echo '<thead style="background-color:#e3a100">
                <th>Opcions</th>
                <th>Egreso</th>
                <th>Detalles</th>
                <th>Estado</th>
               
              </thead>';
        while ($reg = $respta->fetch_object()){

            $editState = '';
            $state = '';
            if (($reg->estado) == 'Aceptado'){
                $editState = '<button class="btn btn-danger" type="button" onclick="eliminarEgreso('.$reg->idegresos.')"><i class="fa fa-trash"></i>Eliminar</button>';
                $state ='<span class="label bg-green">Aceptado</span>' ;
               
               }else if(($reg->estado) == 'Anulado'){
                $editState = '<button class="btn btn-twitter" type="button" onclick="restaurarEgresos('.$reg->idegresos.')" ><i class="fa fa-truck"></i>Restaurar</button>';
                $state ='<span class="label bg-red">Anulado</span>' ;
            }
                   echo '<tr>
                    <td><button type="button"  onclick="editarEgreso('.$reg->idegresos.',\''.$reg->categoria_egreso.'\',\''.$reg->detalles.'\')" class="btn btn-warning"><i class="fa fa-edit"></i></button>  '.$editState.' </td>
                    <td>'.$reg->categoria_egreso.'</td>
                    <td>'.$reg->detalles.'</td>
                    <td> '.$state.' </td>
                 
                </tr>';
        }

    break;

        //OTHER METHODS

}
?>