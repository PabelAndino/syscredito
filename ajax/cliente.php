<?php
if (strlen(session_id()) < 1)
    session_start();

require_once "../modelos/Clientes.php";


$clientes=new Clientes();
$idusuario=$_SESSION["idusuario"];

switch ($_GET["op"]){
    //Save methods
    case 'guardarCliente':
        $idcliente=$_GET['idcliente'];
        $nombre=$_GET['nombres'];
        $direccion=$_GET['direccion'];
        // $sector=$_GET['sector'];
        $genero=$_GET['genero'];
        $estado_civil=$_GET['estado_civil'];
        $tipo_documento=$_GET['tipo_documento'];
        $num_documento=$_GET['num_documento'];
        $telefono = $_GET['telefono'];
        $correo = $_GET['email'];



        if(empty($idcliente)){
            $repuesta=$clientes->guardarCliente($nombre,$direccion,$genero,$estado_civil,$tipo_documento,$num_documento,$telefono,$correo);
            echo $repuesta ? "Cliente Ingresado" : "Cliente no se pudo ingresar correctamente";
        }else{
            $repuesta=$clientes->actualizarCliente($idcliente,$nombre,$direccion,$genero,$estado_civil,$tipo_documento,$num_documento,$telefono,$correo);
            echo $repuesta ? "Cliente Editado" : "Cliente no se pudo editar correctamente";
        }

        break;
    case 'guardarFiador':

        $idfiador=$_GET['idfiador'];
        $nombre=$_GET['nombres'];
        $direccion=$_GET['direccion'];
        // $sector=$_GET['sector'];
        $genero=$_GET['genero'];
        $estado_civil=$_GET['estado_civil'];
        $tipo_documento=$_GET['tipo_documento'];
        $num_documento=$_GET['num_documento'];
        $telefono = $_GET['telefono'];
        $correo = $_GET['email'];
        $ingresos = $_GET['ingresos'];

        if(empty($idfiador)){
            $repuesta=$clientes->guardarFiador($nombre,$direccion,$genero,$estado_civil,$tipo_documento,$num_documento,$telefono,$correo,$ingresos);
            echo $repuesta ? "Fiador Ingresado" : "Fiador no se pudo ingresar correctamente";
        }else{
            $repuesta=$clientes->actualizarFiador($idfiador,$nombre,$direccion,$genero,$estado_civil,$tipo_documento,$num_documento,$telefono,$correo,$ingresos);
            echo $repuesta ? "Fiador Editado" : "Fiador no se pudo editar correctamente";
        }
        break;


    case 'listarClientes':

        $rspta = $clientes->listarClientes();
        $total=0;
        echo '<thead style="background-color:#ffb211">
                                    <th>Opciones</th>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Documento</th>
                                    <th>Número</th>
                                    <th>Género</th>
                                    <th>Est Civil</th>
                                    <th>Dirección</th>
                                    <th>Telefóno</th>
                                    <th>Correo</th>
                                    
                                    <th>Estado</th>
                                </thead>';
        while ($reg = $rspta->fetch_object())
        {
            $estado = '<span class="label bg-green">Aceptado</span>';
            if($reg->estado == "Anulado"){
                $estado = '<span class="label bg-red">Anulado</span>';
            }
            $editar = '<button type="button" class="btn btn-warning" onclick="editarCliente('.$reg->idcliente.',\''.$reg->nombres.'\',\''.$reg->tipo_documento.'\',\''.$reg->num_documento.'\',\''.$reg->genero.'\',\''.$reg->estado_civil.'\',\''
                        .$reg->direccion.'\',\''.$reg->telefono.'\',\''.$reg->correo.'\')"><i class="fa fa-edit"></i></button>';
            $eliminar ='';
            if($reg->estado == 'Aceptado'){
                $eliminar ='<button type="button" class="btn btn-danger" onclick="eliminarCliente('.$reg->idcliente.')"><i class="fa fa-trash"></i></button>';
            }
            if($reg->estado == 'Anulado'){
                $eliminar ='<button type="button" class="btn btn-info" onclick="restaurarCliente('.$reg->idcliente.')"><i class="fa fa-backward"></i></button>';
            }

            echo '<tr>
                   <td>'.$editar.' '.$eliminar.'</td>
                   <td>'.$reg->idcliente.'</td>
                   <td>'.$reg->nombres.'</td>
                   <td>'.$reg->tipo_documento.'</td>
                   <td>'.$reg->num_documento.'</td>
                   <td>'.$reg->genero.'</td>
                   <td>'.$reg->estado_civil.'</td>
                   <td>'.$reg->direccion.'</td>
                   <td>'.$reg->telefono.'</td>
                   <td>'.$reg->correo.'</td>
                   
                   <td>'.$estado.'</td>
                   </tr>';
        }

        break;
    case 'listarFiadores':

        $rspta = $clientes->listarFiador();
        $total=0;
        echo '<thead style="background-color:#ffb211">
                                    <th>Opciones</th>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Documento</th>
                                    <th>Número</th>
                                    <th>Género</th>
                                    <th>Est Civil</th>
                                    <th>Dirección</th>
                                    <th>Telefóno</th>
                                    <th>Correo</th>
                                    <th>Ingresos</th>
                                    <th>Estado</th>
                                </thead>';
        while ($reg = $rspta->fetch_object())
        {
            $estado = '<span class="label bg-green">Aceptado</span>';
            $editar = '<button type="button" class="btn btn-warning" onclick="editarFiador('.$reg->idcliente.',\''.$reg->nombres.'\',\''.$reg->tipo_documento.'\',\''.$reg->num_documento.'\',\''.$reg->genero.'\',\''.$reg->estado_civil.'\',\''
                .$reg->direccion.'\',\''.$reg->telefono.'\',\''.$reg->correo.'\',\''.$reg->igresos.'\')"><i class="fa fa-edit"></i></button>';
            $eliminar ='';
            if($reg->estado == 'Aceptado'){
                $eliminar ='<button type="button" class="btn btn-danger" onclick="eliminarFiador('.$reg->idcliente.')"><i class="fa fa-trash"></i></button>';
            }
            if($reg->estado == 'Anulado'){
                $eliminar ='<button type="button" class="btn btn-info" onclick="restaurarFiador('.$reg->idcliente.')"><i class="fa fa-backward"></i></button>';
            }
            if($reg->estado == "Anulado"){
                $estado = '<span class="label bg-red">Anulado</span>';
            }

            echo '<tr>
                   <td>'.$editar.' '.$eliminar.'</td>
                   <td>'.$reg->idcliente.'</td>
                   <td>'.$reg->nombres.'</td>
                   <td>'.$reg->tipo_documento.'</td>
                   <td>'.$reg->num_documento.'</td>
                   <td>'.$reg->genero.'</td>
                   <td>'.$reg->estado_civil.'</td>
                   <td>'.$reg->direccion.'</td>
                   <td>'.$reg->telefono.'</td>
                   <td>'.$reg->correo.'</td>
                   <td>'.$reg->igresos.'</td>
                   <td>'.$estado.'</td>
                   </tr>';
        }

        break;
    case 'eliminarCliente':
        $idcliente =$_GET['idcliente'];
        $respta = $clientes->eliminarCliente($idcliente);
        echo $respta ? "Cliente Eliminado" : "No se pudo Eliminar el cliente";

        break;

    case 'restaurarCliente':
        $idcliente =$_GET['idcliente'];
        $respta = $clientes->restaurarCliente($idcliente);
        echo $respta ? "Cliente Restaurado" : "No se pudo Restaurar el cliente";

        break;

    case 'eliminarFiador':
        $idfiador =$_GET['idfiador'];
        $respta = $clientes->eliminarFiador($idfiador);
        echo $respta ? "Fiador Eliminado" : "No se pudo Eliminar el fiador";

        break;

    case 'restaurarFiador':
        $idfiador =$_GET['idfiador'];
        $respta = $clientes->restaurarFiador($idfiador);
        echo $respta ? "Fiador Restaurado" : "No se pudo Restaurar el Fiador";

        break;

}


?>
