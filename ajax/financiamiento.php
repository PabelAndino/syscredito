<?php
if (strlen(session_id()) < 1)
    session_start();

require_once "../modelos/Financiamiento.php";


$financiamiento=new Financiamiento();
$montos=10;
$idfinanciamiento=isset($_POST["idfinanciamiento"])? limpiarCadena($_POST["idfinanciamiento"]):"";
$idfinanciamientoAbonar=isset($_POST["idfinanciamientoAbonar"])? limpiarCadena($_POST["idfinanciamientoAbonar"]):"";
$casaComercial=isset($_POST["idcasac"])? limpiarCadena($_POST["idcasac"]):"";
$generoFinanciamiento=isset($_POST["generoFinanciamiento"])? limpiarCadena($_POST["generoFinanciamiento"]):"";

$idpersonaFiador=isset($_POST["idpersonaFiador"])? limpiarCadena($_POST["idpersonaFiador"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$idusuario=$_SESSION["idusuario"];
$idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
$montoFinanciamiento=isset($_POST["montoFinanciamiento"])? limpiarCadena($_POST["montoFinanciamiento"]):"";
$interes=isset($_POST["interesFinanciamiento"])? limpiarCadena($_POST["interesFinanciamiento"]):"";
$moneda=isset($_POST["monedaFinanciamiento"])? limpiarCadena($_POST["monedaFinanciamiento"]):"";
$articuloFinanciamiento=isset($_POST["articuloFinanciamiento"])? limpiarCadena($_POST["articuloFinanciamiento"]):"";
$fecha_hora=isset($_POST["fechaFinanciamiento"])? limpiarCadena($_POST["fechaFinanciamiento"]):"";

$idfiador=isset($_POST["idfiador"])? limpiarCadena($_POST["idfiador"]):"";
$tipo_persona=isset($_POST["tipo_persona"])? limpiarCadena($_POST["tipo_persona"]):"";
$nombreFiador=isset($_POST["nombreFiador"])? limpiarCadena($_POST["nombreFiador"]):"";
$tipo_documentoFiador=isset($_POST["tipo_documentoFiador"])? limpiarCadena($_POST["tipo_documentoFiador"]):"";
$num_documentoFiador=isset($_POST["num_documentoFiador"])? limpiarCadena($_POST["num_documentoFiador"]):"";
$direccionFiador=isset($_POST["direccionFiador"])? limpiarCadena($_POST["direccionFiador"]):"";
$telefonoFiador=isset($_POST["telefonoFiador"])? limpiarCadena($_POST["telefonoFiador"]):"";
$emailFiador=isset($_POST["emailFiador"])? limpiarCadena($_POST["emailFiador"]):"";


$tipo_personaCliente=isset($_POST["tipo_personaCliente"])? limpiarCadena($_POST["tipo_personaCliente"]):"";
$nombreCliente=isset($_POST["nombreCliente"])? limpiarCadena($_POST["nombreCliente"]):"";
$tipo_documentoCliente=isset($_POST["tipo_documentoCliente"])? limpiarCadena($_POST["tipo_documentoCliente"]):"";
$num_documentoCliente=isset($_POST["num_documentoCliente"])? limpiarCadena($_POST["num_documentoCliente"]):"";
$direccionCliente=isset($_POST["direccionCliente"])? limpiarCadena($_POST["direccionCliente"]):"";
$telefonoCliente=isset($_POST["telefonoCliente"])? limpiarCadena($_POST["telefonoCliente"]):"";
$emailCliente=isset($_POST["emailCliente"])? limpiarCadena($_POST["emailCliente"]):"";
$idcliente2 = isset($_POST["idcliente2"])? limpiarCadena($_POST["idcliente2"]):"";

$idgarantia=isset($_POST["idgarantia"])? limpiarCadena($_POST["idgarantia"]):"";
$nombreGarantia = isset($_POST["nombreGarantia"])? limpiarCadena($_POST["nombreGarantia"]):"";
$idcategoriaGarantia = isset($_POST["idcategoriaGarantia"])? limpiarCadena($_POST["idcategoriaGarantia"]):"";
$monedaGarantia = isset($_POST["monedaGarantia"])? limpiarCadena($_POST["monedaGarantia"]):"";
$precioGarantia = isset($_POST["precioGarantia"])? limpiarCadena($_POST["precioGarantia"]):"";
$descripcionGarantia = isset($_POST["descripcionGarantia"])? limpiarCadena($_POST["descripcionGarantia"]):"";
$codigoGarantia = isset($_POST["codigoGarantia"])? limpiarCadena($_POST["codigoGarantia"]):"";

$idabonodetalles=isset($_POST["idabonodetalles"])? limpiarCadena($_POST["idabonodetalles"]):"";
$abonocapital = isset($_POST["abonocapital"])? limpiarCadena($_POST["abonocapital"]):"";
$abonointeres = isset($_POST["abonointeres"])? limpiarCadena($_POST["abonointeres"]):"";
$nota = isset($_POST["commentAbono"])? limpiarCadena($_POST["commentAbono"]):"";
$fechaAbono=isset($_POST["fecha_horaAbono"])? limpiarCadena($_POST["fecha_horaAbono"]):"";
$ultimoidabono=isset($_POST["ultimoidabono"])? limpiarCadena($_POST["ultimoidabono"]):"";
$primerMontoAbono = isset($_POST["primerMontoAbono"])? limpiarCadena($_POST["primerMontoAbono"]):"";
$globalMonto=isset($_POST["primer"])? limpiarCadena($_POST["primer"]):"";

function mostrar($monto,$total){

}


switch ($_GET["op"]){
    case 'guardaryeditar':

        if (empty($idventa)){

            $rspta=$venta->insertar($idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta,$tipoventa,
                $_POST["idarticulo"],$_POST["cantidad"],$_POST["preciocompra"],$_POST["precio_venta"],$_POST["descuento"]);

            echo $rspta ? "Venta registrada" : "No se pudieron registrar todos los datos de la venta";
        }
        else {
        }
        break;

    case 'guardaryeditarCliente':

        require_once "../modelos/Persona.php";
        $persona = new Persona();

        if (empty($idpersonaCliente)){

            $rspta=$persona->insertar($tipo_personaCliente,$nombreCliente,$generoFinanciamiento,$tipo_documentoCliente,$num_documentoCliente,$direccionCliente,$telefonoCliente,$emailCliente);

            echo $rspta ? "Cliente Ingresado" : "No se pudo registrar el Cliente";
        }
        else {
        }
        break;
    case 'guardaryeditarFinanciamiento':
        if (empty($idfinanciamiento)){

            $rspta=$financiamiento->insertarFinanciamiento($idusuario,$idcliente,$articuloFinanciamiento,$casaComercial,$fecha_hora,$montoFinanciamiento,$interes,$moneda);

            echo $rspta ? "Financiamiento Registrado" : "No se pudo registrar el Financiamiento";
        }
        else {

        }
        break;
    case 'guardaryeditarAbonoFinanciamiento':
        if (empty($idabonodetalles)){

            $rspta=$financiamiento->insertarAbonoFinanciamiento($idfinanciamientoAbonar,$fechaAbono,$num_comprobante,$abonocapital,$abonointeres,$nota);

            echo $rspta ? "Abono Registrado" : "No se pudo registrar el abono";
        }
        else {
            $rspta=$financiamiento->editarAbono($idabonodetalles,$fechaAbono,$abonocapital,$abonointeres,$nota);
            echo $rspta ? "Abono editado correcatamente" : "No se pudo editar el Abono";
        }
        break;
    case 'guardaryeditarDetallesAbono':
        if (empty($idabono)){

            $rspta=$hipoteca->insertarDetalleAbono($idabono,$fecha,$abonocapital,$abonointeres);

            echo $rspta ? "Hipoteca Registrada" : "No se pudo registrar la Hipoteca";
        }
        else {
        }
        break;
    case 'anular':
        $rspta=$venta->anular($idventa);
        echo $rspta ? "Venta anulada" : "Venta no se puede anular";
        break;
    case 'anularDetalle':
        $rspta=$venta->anularDetalle($idventa);
        echo $rspta ? "Venta anulada" : "Venta no se puede anular";
        break;
    case 'mostrar':

        $rspta=$venta->mostrar($idventa);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;
    case 'muestraSumaCapital':
        $id=$_GET['idfinanciamiento'];
        $rspta = $financiamiento->muestraSumaCapital($id);
        while ($reg = $rspta->fetch_object()) {
            echo $reg->total_abonado;
        }
        break;
    case 'mostrarUltimoAbono':
        $id=$_GET['id'];
        $rspta = $financiamiento->mostrarUltimoAbono($id);


        while ($reg = $rspta->fetch_object()) {
            echo $reg->id;
            //  echo json_encode($reg->capital);
        }
        break;
    case 'muestraAbonoeInteres':
        $id=$_GET['ultimoabono'];
        $rspta=$hipoteca->muestraAbonoeInteres($id);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;
    case 'muestraFinanciamientos': //Abonos del DIA
        $rspta=$financiamiento->muestraAbonosdelDia();
        //Codificar el resultado utilizando json
        echo '<thead style="background-color:#ff6851">

                                            <th>Opciones</th>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>Abono Capital</th>
                                            <th>Abono Interes</th>
                                            <th>Total Abonado</th>
                                            <th>Moneda</th>
                                    

                                    <!-- 
                                    <th style="white-space: nowrap;min-width: 200px;max-width: 200px;overflow: scroll">Nota</th>
                                    -->
                                </thead>';
        while ($reg = $rspta->fetch_object()) {
            $urlTICKET = '../reportes/TicketRepF.php?id=';
            echo '<tr>
                   <td><a target="_blank" href="' . $urlTICKET . $reg->detalle . '">   <button class="btn btn-info" type="button"><i class="fa fa-print"></i></button></a>
                   <a data-toggle="modal" href="#modalCuentasAbonosF"><button class="btn btn-bitbucket" type="button" onclick="mostrarAbonoInfoF(' . $reg->idfinanciamiento . ',' . $reg->monto . ')"><i class="fa fa-info"></i></button></a>
                   </td> 
                   <td>' . $reg->fecha . '</td>
                   <td>' . $reg->cliente . '</td>
                   <td>' . $reg->abono_capital . '</td>
                   <td>' . $reg->abono_interes . '</td>
                   <td>' . $reg->total_abonado . '</td>
                   <td>' . $reg->moneda . '</td>
                  
                   
                   </tr>';
        }
        break;

    case 'mostrarNumero': //MUSTRA EL NUMERO DE SERIE AUTOINCREMENTADO

        $rspta=$venta->sumarNumeroFactura();
        //Codificar el resultado utilizando json

        while ($reg = $rspta->fetch_array())
        {
            echo $reg[0];
        }

        break;
    case 'obtenerMonto':

        $monto=$_GET['monto'];
        $interes=$_GET['interes'];

        echo  $monto."  datos  ".$interes;
        break;
    case 'mostrarCuentasAbono':
        $id=$_GET['id'];
        $rspta=$financiamiento->mostrarCuentasAbono($id);
        //Vamos a declarar un array
        $data= Array();
        while ($reg=$rspta->fetch_object()){

            $data[]=array(

                "0"=>'<button class="btn btn-success" onclick="mostrarCuentas('.$reg->idfinanciamiento.','.$reg->monto.','.$reg->interes.')"><i class="fa fa-plus"></i></button>',
                "1"=>$reg->fecha,
                "2"=>$reg->monto,
                "3"=>$reg->interes,
                "4"=>$reg->moneda,
            );

        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

        break;

    case 'listarDetallesCuenta':
        $id=$_GET['id'];
        $rspta = $financiamiento->listarDetalleCuenta($id);
        $total=0;
        echo '<thead style="background-color:#ff6851">
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th style="white-space: nowrap;min-width: 200px;max-width: 200px;overflow: scroll">Artículo</th>
                                    <th>Monto</th>
                                    <th>Interés %</th>
                                    <th>Moneda</th>
                                    
                                </thead>';
        while ($reg = $rspta->fetch_object())
        {
            echo '<tr>
                   <td>'.$reg->fecha.'</td>
                   <td>'.$reg->cliente.'</td>
                   <td>'.$reg->articulo.'</td>
                   <td>'.$reg->monto.'</td>
                   <td>'.$reg->interes.'</td>
                   <td>'.$reg->moneda.'</td>
                   
                   </tr>';
        }

        break;
    case 'listarDetallesAbono':
        $id=$_GET['id'];
        $rspta = $financiamiento->listarDetallesAbono($id);
        $total=0;
        $total=0;
        echo '<thead style="background-color:#6ce393">
                                    <th>Editar</th>
                                    <th>Fecha</th>
                                    <th style="white-space: nowrap;min-width: 200px;max-width: 200px;overflow: scroll">Concepto</th>
                                    <th>Interes</th>
                                    <th>Capital</th>
                                    <th>Pendiente Capital</th>
                                    <th>Moneda</th>
                                    
                                </thead>';


        $montoS=$_GET['monto'];

        while ($reg = $rspta->fetch_object())
        {
            $total =   $montoS - $reg->abono_capital;
            $montoS=$total;
            echo '<tr>
                   <td><button class="btn btn-warning" type="button" onclick="editarAbonoF('.$reg->iddetalle.',\''.$reg->nota.'\', \''.$reg->abono_interes.'\',  \''.$reg->abono_capital.'\',\''.$reg->moneda.'\')"><i class="fa fa-edit"></i></button>
                   
                       <button class="btn btn-danger" type="button" onclick="eliminarAbonoF('.$reg->iddetalle.')"><i class="fa fa-trash"></i></button></td>
                       <td><input type="hidden" id="fechaF" value="'.$reg->fecha.'">'.$reg->fecha.'</td>
                       <td><input type="hidden" id="notaF" value="'.$reg->nota.'">'.$reg->nota.'</td>
                       <td><input type="hidden" id="interesF" value="'.$reg->abono_interes.'">'.$reg->abono_interes.'</td>
                       <td><input type="hidden" id="capitalF" value="'.$reg->abono_capital.'">'.$reg->abono_capital.'</td>
                       <td><input type="hidden" id="totalF" value="'.$total.'"> '.$total.'</td>
                       <td><input type="hidden" id="monedaF" value="'.$reg->moneda.'">'.$reg->moneda.'</td>   
                   </tr>';

        }
        break;
    case 'listarDetallesAbonoMontos':
        $id=$_GET['id'];
        $rspta=$hipoteca->listarDetallesAbonoMonto($id);
        //Vamos a declarar un array
        $data= Array();
        while ($reg=$rspta->fetch_object()){
            $data[]=array(

                "0"=>$reg->fecha,
                "1"=>$reg->nota,
                "2"=>$reg->interes,
                "3"=>$reg->capital,
                "4"=>$reg->moneda,
            );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

        break;
    case 'listarNuevaCuenta':

        $rspta = $financiamiento->listarNuevaCuenta();


        echo '<thead style="background-color:#6ce393">
                                           <th>Opciones</th>
                                           <th>Fecha</th>
                                           <th>Id C</th>
                                           <th>Cliente</th>
                                           <th>Garantia</th>
                                           <th>Tipo</th>
                                           <th>Monto</th>
                                           <th>Interés</th>
                                           <th>Moneda</th>
                                            
                                </thead>';




        while ($reg = $rspta->fetch_object())
        {
            $urlTICKET='../reportes/TicketRepFLista.php?id=';

            echo '<tr>
                       <td><a target="_blank" href="'.$urlTICKET.$reg->idfinanciamiento.'"><button class="btn btn-warning" type="button" ><i class="fa fa-print"></i></button> </a>
                       <button class="btn btn-danger" type="button" onclick="eliminarF('.$reg->idfinanciamiento.')"><i class="fa fa-trash"></i></button> 
                       </td>
                       <td> '.$reg->fecha.'</td>
                       <td> '.$reg->cedula.'</td>
                       <td> '.$reg->cliente.'</td>
                       <td> '.$reg->articulo.'</td>
                       <td> '.$reg->casa.'</td>
                       <td> '.$reg->monto.'</td>
                       <td> '.$reg->interes.'</td>
                       <td> '.$reg->moneda.'</td>  
                      
                        
                   </tr>';

        }
        break;
    case 'listarDetallesAbonoModal':
        $id=$_GET['id'];
        $rspta = $financiamiento->listarDetallesAbono($id);
        $total=0;
        $total=0;
        $opciones="Opciones";

        echo '<thead style="background-color:#6ce393">
                                    <th>Opciones</th>
                                    <th>Fecha</th>
                                    <th style="white-space: nowrap;min-width: 200px;max-width: 200px;overflow: scroll">Concepto</th>
                                    <th>Interes</th>
                                    <th>Capital</th>
                                    <th>Pendiente Capital</th>
                                    <th>Moneda</th>    
                                </thead>';


        $montoS=$_GET['monto'];

        while ($reg = $rspta->fetch_object())
        {
            $nota=(string) $reg->nota;

            $total =   $montoS - $reg->abono_capital;
            $montoS=$total;

            echo '<tr>
                       <td>
                       </td>
                       <td><input type="hidden" id="fechaA" value="'.$reg->fecha.'">'.$reg->fecha.'</td>
                       <td><input type="hidden" id="notaA" value="'.$reg->nota.'">'.$reg->nota.'</td>
                       <td><input type="hidden" id="interesA" value="'.$reg->abono_interes.'">'.$reg->abono_interes.'</td>
                       <td><input type="hidden" id="capitalA" value="'.$reg->abono_capital.'">'.$reg->abono_capital.'</td>
                       <td><input type="hidden" id="totalA" value="'.$total.'"> '.$total.'</td>
                       <td><input type="hidden" id="monedaA" value="'.$reg->moneda.'">'.$reg->moneda.'</td>   
                   </tr>';

        }
        break;
        case 'listar':
        $rspta=$venta->listar();
        //Vamos a declarar un array

        $data= Array();


        while ($reg=$rspta->fetch_object()){


            $urlTICKET='../reportes/TicketRep.php?id=';


            $urlFACT='../reportes/FacturaRep.php?id=';


            $data[]=array(
                "0"=>(($reg->estado=='Aceptado')?'<button class="btn btn-warning" onclick="mostrar('.$reg->idventa.')"><i class="fa fa-eye"></i></button>'.
                        ' <button class="btn btn-danger" onclick="anular('.$reg->idventa.')"><i class="fa fa-close"></i></button>':
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idventa.')"><i class="fa fa-eye"></i></button>').

                    // '<a target="_blank" href="'.$urlFACT.$reg->idventa.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>',
                    '<a target="_blank" href="'.$urlTICKET.$reg->idventa.'"> <button class="btn btn-flickr"><i class="fa fa-file-text"></i></button></a>'.
                    '<a target="_blank" href="'.$urlFACT.$reg->idventa.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>',
                "1"=>$reg->fecha,
                "2"=>$reg->cliente,
                "3"=>$reg->usuario,
                "4"=>$reg->tipo_comprobante,
                "5"=>$reg->num_comprobante,
                "6"=>$reg->total_venta,
                "7"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
                    '<span class="label bg-red">Anulado</span>'
            );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

        break;
    case 'selectCliente':

        require_once "../modelos/Persona.php";
        $persona = new Persona();

        $rspta = $persona->listarCliente();

        while ($reg = $rspta->fetch_object())
        {
            echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . ' - '.$reg->num_documento.'</option>';
        }
        break;
    case 'casaComercial':

        require_once "../modelos/Persona.php";
        $persona = new Persona();

        $rspta = $persona->listarCasa();

        while ($reg = $rspta->fetch_object())
        {
            echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . ' - '.$reg->num_documento.'</option>';
        }
        break;
    case 'selectFiador':

        require_once "../modelos/Persona.php";
        $persona = new Persona();

        $rspta = $persona->listarFiador();

        while ($reg = $rspta->fetch_object())
        {
            echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
        }
        break;
    case 'selectGarantia':
        $rspta = $hipoteca->selectGarantia();

        while ($reg = $rspta->fetch_object())
        {
            echo '<option value=' . $reg->idgarantia . '>' . $reg->nombre . '</option>';
        }
        break;
    case 'selectCategoria':

        $resp = $hipoteca->selectCategoria();
        while ($reg = $resp->fetch_object())//reg hara el recorrido
        {
            echo '<option value = ' . $reg->idcategoria. '>'. $reg->nombre . '</option>';
        }
        break;

    case 'listarArticulosVenta':

        require_once "../modelos/Articulo.php";
        $articulo=new Articulo();

        $rspta=$articulo->listarActivosVenta();
        //Vamos a declarar un array
        $data= Array();

        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" id="botonon" onclick="agregarDetalle('.$reg->stock.',\''.$reg->idarticulo.'\', \''.$reg->nombre.'\',  \''.$reg->precio_compra.'\',\''.$reg->precio_venta.'\')" ><span class="fa fa-plus"></span></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->categoria,
                "3"=>$reg->codigo,
                "4"=>$reg->stock,
                "5"=>$reg->precio_compra,
                "6"=>$reg->precio_venta,
                "7"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >"
            );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
        break;
    case 'buscarClientesAbono':
        $rspta = $financiamiento->buscarClientesAbono();
        while ($reg=$rspta->fetch_object()){
            echo '<option value='.$reg->idpersona.'>'.$reg->nombre.' - '.$reg->num_documento.'</option>';
        }
        break;
    case 'imprimirFactura':



        break;
    case 'testFecha':
        $fecha_actual = date("d-m-Y");
//sumo 1 mes
    for($i = 1; $i <= 5; $i++){

       // echo $i . date("d-m-Y",strtotime($fecha_actual."+ '.$i.' month"));
        echo '<tr>
                
                <td> '.$i .' '.date("d-m-Y",strtotime($fecha_actual."+ $i month")).'</td>
            
            </tr>';
    }

        break;
    case 'eliminarAbono':
        $iddetalleF=$_GET['id'];
        $rpsta=$financiamiento->eliminarDetalleAbono($iddetalleF);
        echo $rpsta ? " Abono Eliminado Correctamente " : " No se pudo eliminar ";
        break;

    case 'eliminarF':
        $idF=$_GET['id'];
        $rpsta=$financiamiento->eliminarFinanciamiento($idF);
        echo $rpsta ? " Cuenta Eliminada Correctamente " : " No se pudo eliminar la cuenta!!! ";
        break;

}
?>