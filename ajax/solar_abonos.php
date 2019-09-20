<?php

require_once "../modelos/Articulo.php";

$articulo = new Articulo();

$idarticulo = isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"])  : "";//aqui recibo las primeras datos atravez del metodo POST
$idcategoria = isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"])  : "";
$codigo = isset($_POST["codigo"])? limpiarCadena($_POST["codigo"])  : "";
$nombre = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]): "";
$stock = isset($_POST["stock"])? limpiarCadena($_POST["stock"])  : "";
$descripcion = isset($_POST["descripcion"])? limpiarCadena( $_POST["descripcion"]):"";
$imagen = isset($_POST["imagen"])? limpiarCadena($_POST["imagen"])  : "";

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
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/articulos/" . $imagen); //
            }
        }


        if(empty($idarticulo))//si el id esta vacio
        {
            $rspta=$articulo->insertar($idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen);
            echo $rspta ? "articulo Registrada": "articulo no se pudo registrar";

        } else {

            $rspta=$articulo->editar($idarticulo,$idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen);
            echo $rspta ? "articulo actualizada" : "articulo no se pudo actualizar";

        }

        break;

    case 'desactivar':
        $rspta=$articulo->desactivar($idarticulo);
        echo $rspta ? "articulo desactivada" : "articulo no se pudo desactivar";
        break;

    case 'activar':
        $rspta=$articulo->activar($idarticulo);
        echo $rspta ? "articulo Activada" : "articulo no se pudo activar";
        break;

    case 'mostrar':
        $rspta=$articulo->mostrar($idarticulo);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta=$articulo->listar();
        $data=Array();//almacenara todos los registros que voy a mostrar
        while ($reg=$rspta->fetch_object()) //recorrere todos los registros almacenare en la variable reg y almacenare en el indices cada dato y recorrera todos los registros
        {
            $data[]=array(
                "0"=>($reg->condicion)?'<button class="btn btn-warning"><i class="fa fa-pencil" onclick="mostrar('.$reg->idarticulo.')"></i> </button>'.' <button class="btn btn-danger"><i class="fa fa-close" onclick="desactivar('.$reg->idarticulo.')"></i> </button>':'<button class="btn btn-warning"><i class="fa fa-pencil" onclick="mostrar('.$reg->idarticulo.')"></i> </button>'.' <button class="btn btn-primary"><i class="fa fa-check" onclick="activar('.$reg->idarticulo.')"></i> </button>',//al hacer click manda el idarticulo
                "1"=>$reg->nombre,
                "2"=>$reg->categoria,
                "3"=>$reg->codigo,
                "4"=>$reg->stock,
                "5"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >",

                "6"=>($reg->condicion)?'<span class="label bg-green">Activado</span>': '<span class="label bg-red">Desactivado</span>'
            );
        }

        $reult= array(
            "sEcho"=>1, //informacion para el datatable
            "iTotalRecords"=>count($data),//se envia el total de registros al datatable
            "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a vizualizar
            "aaData"=>$data
        );
        echo json_encode($reult);
        break;

    case 'selectCategoria':
        require_once  "../modelos/Categoria.php";
        $categoria = new Categoria();
        $resp = $categoria->select();
        while ($reg = $resp->fetch_object())//reg hara el recorrido
        {
            echo '<option value = ' . $reg->idcategoria. '>'. $reg->nombre . '</option>';
        }
        break;

    case 'generarCodigo':
        $rspta=$articulo->generarCodigo();
        while ($reg = $rspta->fetch_array())
        {
            echo $reg[0];
        }

        break;
}

?>