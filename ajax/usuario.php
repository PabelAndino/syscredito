<?php
session_start();//Si no se inicia session aunque ponga bien el usaurio y contraseña no va a redireccionar correctamente
require_once "../modelos/Usuario.php";

$usuario = new Usuario();



$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$cargo=isset($_POST["cargo"])? limpiarCadena($_POST["cargo"]):"";
$login=isset($_POST["login"])? limpiarCadena($_POST["login"]):"";
$clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

/*$persona = [];
$persona = verif();




function verif()
{
    $per = [];
    foreach ($_POST as $value) {
        if(isset($value)){
            $per += $value;
        }else {
            $per = '';
        }
    }
    return $per;

}*/


switch ($_GET["op"])
{
    case 'guardaryeditar':

        if(!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
        {// si el usuario no a seleccionado nungun arhivo o si no a sido cargado
            $imagen=$_POST["imagenactual"];//entonces sera lo que tenga imagenactual

        }else
        {
            $ext = explode(".", $_FILES["imagen"]["name"]);
            if($_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png" || $_FILES['imagen']['type'] == "image/jpg"  ) //si la imagen es jpeg o png
            {
                $imagen = round(microtime(true)) . '.' .end($ext); //le pone un nuevo nombre a la imagen o la renombra
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen); //
            }
        }

        //el HASH

    //$clavehash = hash("SHA256",$clave);

        if(empty($idusuario))//si el id esta vacio
        {
            $rspta=$usuario->insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen,$_POST['permiso']);//$_POST['permiso'] los checkbox que se han marcado

            echo $rspta ? "usuario Registrado": "usuario no se pudo Registrar todos los datos";

        } else {

            $rspta=$usuario->editar($idusuario,$nombre,$tipo_documento,$num_documento, $direccion,$telefono,$email,$cargo,$login,$clave,$imagen,$_POST['permiso']);
            echo $rspta ? "usuario actualizado" : "usuario no se pudo actualizar";

        }

        break;

    case 'desactivar':
        $rspta=$usuario->desactivar($idusuario);
        echo $rspta ? "usuario desactivada" : "usuario no se pudo desactivar";
        break;

    case 'activar':
        $rspta=$usuario->activar($idusuario);
        echo $rspta ? "usuario Activada" : "usuario no se pudo activar";
        break;

    case 'mostrar':
        $rspta=$usuario->mostrar($idusuario);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta=$usuario->listar();
        //Vamos a declarar un array
        $data= Array();

        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-danger" onclick="desactivar('.$reg->idusuario.')"><i class="fa fa-close"></i></button>':
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-primary" onclick="activar('.$reg->idusuario.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->tipo_documento,
                "3"=>$reg->num_documento,
                "4"=>$reg->telefono,
                "5"=>$reg->email,
                "6"=>$reg->login,
                "7"=>"<img src='../files/usuarios/".$reg->imagen."' height='50px' width='50px' >",
                "8"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
                    '<span class="label bg-red">Desactivado</span>'
            );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

        break;

    case 'permisos':
        require_once "../modelos/Permiso.php";
        $permiso = new Permiso();
        $respuesta = $permiso->listar();

        $id=$_GET['id'];
        $marcados= $usuario->listamarcados($id);

        $valores=array();

        //Almacenamos los persmisos y los almacenamos en ese array
         while ($per= $marcados->fetch_object())
         {
                array_push($valores, $per->idpermiso);
         }

        while ($reg = $respuesta->fetch_object())
        {
            $sw=in_array($reg->idpermiso,$valores)?'checked':'';
            echo '<li> <input type="checkbox" '.$sw.' name="permiso[]" value="'.$reg->idpermiso.'">'.$reg->nombre.' </li>';
        }

        break;

    case 'verificar':

        $logina=$_POST['logina'];
        $clavea=$_POST['clavea'];

        $respuesta = $usuario->verificar($logina,$clavea);

        $fetch=$respuesta->fetch_object();

        if(isset($fetch)){
            $_SESSION['idusuario']=$fetch->idusuario;
            $_SESSION['nombre']=$fetch->nombre;
            $_SESSION['imagen']=$fetch->imagen;
            $_SESSION['login']=$fetch->login;

            //obtengo los permisos
            $marcados = $usuario->listamarcados($fetch->idusuario);

            $valores=array();

            while ($per = $marcados->fetch_object())
            {
                array_push($valores,$per->idpermiso);//le pasa todos los id permiso alarray valores
            }

            //gestiono los acceso a cada item del menu
            in_array(1,$valores)?$_SESSION['Administrador']=1:$_SESSION['Administrador']=0;//si el usuario tiene el permiso 1 que en este caso el 1 es el escritorio y declaro una variable de sesion llamada 'escritorio'
            in_array(2,$valores)?$_SESSION['Abono']=1:$_SESSION['Abono']=0;//y digo que si tiene el acceso indicado la variable de session  sera uno si no me devolvera cero
           


        }
        echo json_encode($fetch);

        break;

    case 'salir':

        //limpia las variables de sesion
        session_unset();
        //se lleva de un solo la sesion
        session_destroy();
        //y redirecciona
    header("Location: ../index.php");

        break;

}

?>