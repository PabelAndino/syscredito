<?php

require_once "../modelos/Cuentas.php";

$cuentas = new Cuentas();



switch ($_GET["op"])
{


    case 'listar':
        $rspta=$cuentas->listar();
       
        echo '
                <thead>
                <th>Opciones</th>
                <th>Cuenta</th>
                <th>Cliente</th>
                <th>Cedula</th>
                <th>Monto</th>
                <th>Interes</th>
                <th>Interes Moratorio</th>
                <th>Moneda</th>
                <th>Estado</th>
                <th>Condicion</th>
                </thead>
        ';
        while ($reg=$rspta->fetch_object()) //recorrere todos los registros almacenare en la variable reg y almacenare en el indices cada dato y recorrera todos los registros
        {
           $condition = '';
           $state = '';
           $color = '';
           if (($reg->condicion) == 'Pendiente'){
            $condition = '<button class="btn btn-success" type="button" onclick="pagarHipoteca('.$reg->idhipoteca.','.$reg->idgarantia.')"><i class="fa fa-upload"></i>Pagar</button>';
           }else if(($reg->condicion) == 'Pagado'){
             $condition = '<button class="btn btn-microsoft" type="button" onclick="volver('.$reg->idhipoteca.','.$reg->idgarantia.')" ><i class="fa fa-refresh"></i>Volver</button>';
             $color = "#FF987C";
           }
           
           if (($reg->estado) == 'Aceptado'){
            $state = '<button class="btn btn-danger" type="button" onclick="eliminar('.$reg->idhipoteca.','.$reg->idgarantia.')"><i class="fa fa-trash"></i>Eliminar</button>';
           }else if(($reg->estado) == 'Cancelado'){
            $state = '<button class="btn btn-twitter" type="button" onclick="restaurar('.$reg->idhipoteca.','.$reg->idgarantia.')" ><i class="fa fa-truck"></i>Regresar</button>';
           }

            

           echo '
                <tr style="background-color: '.$color.' ">
                <td>'. $condition.$state.'</td>
                <td>'.$reg->idhipoteca.'</td>
                <td>'.$reg->nombres.'</td>
                <td>'.$reg->num_documento.'</td>
                <td>'.$reg->monto.'</td>
                <td>'.$reg->interes.'</td>
                <td>'.$reg->interes_moratorio.'</td>
                <td>'.$reg->moneda.'</td>
                <td>'.$reg->estado.'</td>
                <td>'.$reg->condicion.'</td>
                </tr>
           
           ';
        }

        
        break;

    case 'pagarCuenta':

        $idhipoteca = $_GET['idhipoteca'];
        $idgarantia = $_GET['idgarantia'];
        $resp = $cuentas->pagarCuenta($idhipoteca,$idgarantia);

        echo $resp ? "Cuenta Pagada!!!" : "La cuenta no se pudo pagar";

    break;

    case 'volver'://Si la cuenta se pago y se quiere que se deba de nuevo o volver al estado de deuda
    $idhipoteca = $_GET['idhipoteca'];
    $idgarantia = $_GET['idgarantia'];
    $resp = $cuentas->volver($idhipoteca,$idgarantia);

        echo $resp ? "Se debe nuevamente la cuenta" : "La cuenta no se pudo regresar";

    break;

    case 'eliminar':
    $idhipoteca = $_GET['idhipoteca'];
        $resp = $cuentas->eliminarCuenta($idhipoteca);

        echo $resp ? "Se Elimino correctamente" : "No se pudo Eliminar";
    break;

    case 'restaurar'://si la cuenta se elimino y se quiere resturar nuevamente
    $idhipoteca = $_GET['idhipoteca'];
        $resp = $cuentas->restaurarCuenta($idhipoteca);

        echo $resp ? "Se Restauro correctamente" : "No se pudo Restaurar";
    break;




    }

?>