<?php
if (strlen(session_id()) < 1)
    session_start();

require_once "../modelos/Garantias.php";


$garantias=new Garantias();


 function mostrar($monto,$total){

 }

switch ($_GET["op"]){
     //Select methods


        //SAVE METHODS
   


        //LIST METHODS
    case 'listarGarantias':
        $respta=$garantias->listarGarantias();
        echo '<thead style="background-color:#e3a100">
                <th>Opciones</th>
                <th>Id Cliente</th>
                <th>Dueño</th>
                <th>Cedula</th>
                <th>Garantia</th>
                <th>Categoria</th>
                <th>Condicion</th>
                <th>Estado</th>
              </thead>';
        while ($reg = $respta->fetch_object()){
            $data = "Test";
            
           
            $opciones = '';
            $updateOption = '<button type="button" onclick="editGarantia(' .$reg->idgarantia.',\''.$reg->idcliente.'\',\''.$reg->nombre.'\',\''.$reg->condicion.'\',
            \''.$reg->categoria.'\',\''.$reg->estado.'\')" class="btn btn-warning"><i class="fa fa-edit"></i></button>  ';
            // print_r($ingresoArr);
            if($reg->estado=='Anulado'){
            
                $opciones = '<button type="button" class="btn btn-success" onclick="activarSolicitud('.$data.')"><i class="fa fa-check"></i></button>';
                
            }else{
                $opciones = '<button type="button" onclick="anularSolicitud('.$data.')" class="btn btn-danger"><i class="fa fa-trash"></i></button>';
                
                
            }
            echo '<tr>
            <td>'.$updateOption.$opciones.'</td>
            <td>'.$reg->idcliente.'</td>
            <td>'.$reg->nombres.'</td>
            <td>'.$reg->num_documento.'</td>
            <td>'.$reg->nombre.'</td>
            <td>'.$reg->categoria.'</td>
            <td>'.$reg->condicion.'</td>
            <td>'.($reg->estado=="Aceptado"?'<span class="label bg-green">Aceptado</span>':'<span class="label bg-red">Cancelado</span>') .' </td>

        </tr>';


        }

        break;

        case 'listarGarantiasDetalle':
            $idgarantia = $_GET['idgarantia'];
            $respta=$garantias->listarGarantiasDetalle($idgarantia);
            echo '<thead style="background-color:#bdcab4">
                    <th>Opciones</th>
                    <th>Descripcion</th>
                    <th>Categoria</th>
                    <th>Codigo</th>
                    <th>Valor</th>
                    <th>Moneda</th>
                    <th>Estado</th>
                  </thead>';
            while ($reg = $respta->fetch_object()){
                $data = "Test";
               
               
                $opciones = '';
                $updateOption = '<button type="button" onclick="editGarantia(' .$reg->idarticulo.',\''.$reg->idcategoria.'\',\''.$reg->codigo.'\',\''.$reg->descripcion.'\',
                \''.$reg->valor.'\',\''.$reg->moneda.'\')" class="btn btn-warning"><i class="fa fa-edit"></i></button>  ';
                // print_r($ingresoArr);
                if($reg->estado=='Anulado'){
                
                    $opciones = '<button type="button" class="btn btn-success" onclick="activarSolicitud('.$data.')"><i class="fa fa-check"></i></button>';
                    
                }else{
                    $opciones = '<button type="button" onclick="anularSolicitud('.$data.')" class="btn btn-danger"><i class="fa fa-trash"></i></button>';
                    
                    
                }
                echo '<tr>
                <td>'.$updateOption.$opciones.'</td>
                <td>'.$reg->descripcion.'</td>
                <td>'.$reg->categoria.'</td>
                <td>'.$reg->codigo.'</td>
                <td>'.$reg->valor.'</td>
                <td>'.$reg->moneda.'</td>
                <td>'.($reg->estado=="Aceptado"?'<span class="label bg-green">Aceptado</span>':'<span class="label bg-red">Cancelado</span>') .' </td>
    
            </tr>';
    
    
            }
    
            break;
    
        //DELETE METHODS
    

    }

?>