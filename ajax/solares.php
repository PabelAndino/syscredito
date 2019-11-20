<?php
if (strlen(session_id()) < 1)
    session_start();

require_once "../modelos/Solares.php";


$solares=new Solares();
$idsolares=isset($_POST["idsolares"])? limpiarCadena($_POST["idsolares"]):"";
$idfinanciamientoAbonar=isset($_POST["idfinanciamientoAbonar"])? limpiarCadena($_POST["idfinanciamientoAbonar"]):"";

$fecha_hora=isset($_POST["fechaSolares"])? limpiarCadena($_POST["fechaSolares"]):"";
$plazos=isset($_POST["plazo"])? limpiarCadena($_POST["plazo"]):"";
$moneda=isset($_POST["monedaSolares"])? limpiarCadena($_POST["monedaSolares"]):"";
$monto=isset($_POST["monto"])? limpiarCadena($_POST["monto"]):"";
$interes=isset($_POST["interes"])? limpiarCadena($_POST["interes"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$idusuario=$_SESSION["idusuario"];
$prima=isset($_POST["prima"])? limpiarCadena($_POST["prima"]):"";
$detalles=isset($_POST["comment"])? limpiarCadena($_POST["comment"]):"";


$articuloFinanciamiento=isset($_POST["articuloFinanciamiento"])? limpiarCadena($_POST["articuloFinanciamiento"]):"";


$tipo_personaCliente=isset($_POST["tipo_personaCliente"])? limpiarCadena($_POST["tipo_personaCliente"]):"";
$nombreCliente=isset($_POST["nombreCliente"])? limpiarCadena($_POST["nombreCliente"]):"";
$tipo_documentoCliente=isset($_POST["tipo_documentoCliente"])? limpiarCadena($_POST["tipo_documentoCliente"]):"";
$num_documentoCliente=isset($_POST["num_documentoCliente"])? limpiarCadena($_POST["num_documentoCliente"]):"";
$direccionCliente=isset($_POST["direccionCliente"])? limpiarCadena($_POST["direccionCliente"]):"";
$telefonoCliente=isset($_POST["telefonoCliente"])? limpiarCadena($_POST["telefonoCliente"]):"";
$emailCliente=isset($_POST["emailCliente"])? limpiarCadena($_POST["emailCliente"]):"";
$idcliente2 = isset($_POST["idcliente2"])? limpiarCadena($_POST["idcliente2"]):"";
$generoSolares = isset($_POST["generoSolares"])? limpiarCadena($_POST["generoSolares"]):"";

$idcuentasolares=isset($_POST["idcuentasolares"])? limpiarCadena($_POST["idcuentasolares"]):"";

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

            $rspta=$persona->insertar($tipo_personaCliente,$nombreCliente,$generoSolares,$tipo_documentoCliente,$num_documentoCliente,$direccionCliente,$telefonoCliente,$emailCliente);

            echo $rspta ? "Cliente Ingresado" : "No se pudo registrar el Cliente";
        }
        else {
        }
        break;
    case 'guardaryeditarSolares':
        if (empty($idsolares)){

            $rspta=$solares->insertarSolares($idusuario,$idcliente,$detalles,$fecha_hora,$monto,$interes,$prima,$plazos,$moneda);

            echo $rspta ? "Financiamiento de Solar Registrado" : "No se pudo registrar el Financiamiento del Solar";
        }
        else {
        }
        break;
    case 'guardaryeditarAbono':
        if (empty($idabonodetalles)){

            $rspta=$solares->insertarAbonoSolares($idcuentasolares,$fechaAbono,$num_comprobante,$abonocapital,$abonointeres,$nota);

            echo $rspta ? "Abono Registrado" : "No se pudo registrar el abono";
        }
        else {
            $rspta=$solares->editarAbono($idabonodetalles,$fechaAbono,$abonocapital,$abonointeres,$nota);
            echo $rspta ? "Abono editado correcatamente" : "No se pudo editar el Abono";
        }
        break;
    case 'guardaryeditarDetallesAbono':
        if (empty($idabono)){

            $rspta=$solares->insertarDetalleAbono($idabono,$fecha,$abonocapital,$abonointeres);

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
        $id=$_GET['idsolares'];
        $rspta = $solares->muestraSumaCapital($id);
        while ($reg = $rspta->fetch_object()) {
            echo $reg->total_abonado;
        }
        break;
    case 'mostrarUltimoAbono':
        $id=$_GET['id'];
        $rspta = $solares->mostrarUltimoAbono($id);


        while ($reg = $rspta->fetch_object()) {
            echo $reg->id;
            //  echo json_encode($reg->capital);
        }
        break;
    case 'muestraAbonoeInteres':
        $id=$_GET['ultimoabono'];
        $rspta=$solares->muestraAbonoeInteres($id);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;
    /*case 'mostrarCuentasAbono':
        $id=$_GET['id'];
        $rspta=$solares->mostrarCuentasAbonodeldia($id);//Abonos del dia
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

        break;*/
    case 'muestraAbonosdeldia': //Abonos del DIA
        $rspta=$solares->muestraAbonosdelDia();
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
            $urlTICKET = '../reportes/TicketRepS.php?id=';
            echo '<tr>
                   <td><a target="_blank" href="' . $urlTICKET . $reg->detalle . '">   <button class="btn btn-info" type="button"><i class="fa fa-print"></i></button></a>
                   <a data-toggle="modal" href="#modalCuentasAbonosS"><button class="btn btn-bitbucket" type="button" onclick="mostrarAbonoInfoS(' . $reg->idsolares . ',' . $reg->monto . ')"><i class="fa fa-info"></i></button></a>
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
        $rspta=$solares->mostrarCuentasAbono($id);
        //Vamos a declarar un array
        $data= Array();
        while ($reg=$rspta->fetch_object()){

            $data[]=array(

                "0"=>'<button class="btn btn-success" onclick="mostrarCuentas('.$reg->idsolares.','.$reg->monto.','.$reg->prima.','.$reg->interes.','.$reg->plazo.')"><i class="fa fa-plus"></i></button>',
                "1"=>$reg->fecha,
                "2"=>$reg->monto,
                "3"=>$reg->interes,
                "4"=>$reg->detalles,
                "5"=>$reg->moneda,
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
        $rspta = $solares->listarDetalleCuenta($id);
        $total=0;
        echo '<thead style="background-color:#ff6851">
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                   <th>Prima</th>
                                    <th>Monto</th>
                                    <th>Interés %</th>
                                    <th style="white-space: nowrap;min-width: 200px;max-width: 200px;overflow: scroll">Detalles</th>
                                    <th>Moneda</th>
                                    
                                </thead>';
        while ($reg = $rspta->fetch_object())
        {
            echo '<tr>
                   <td>'.$reg->fecha.'</td>
                   <td>'.$reg->cliente.'</td>
                    <td>'.$reg->prima.'</td>
                   <td>'.$reg->monto.'</td>
                   <td>'.$reg->interes.'</td>
                   <td>'.$reg->detalles.'</td>
                   <td>'.$reg->moneda.'</td>
                   
                   </tr>';
        }

        break;
    case 'listarDetallesAbono':
        $id=$_GET['id'];
        $rspta = $solares->listarDetallesAbono($id);
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
        $prima=$_GET['prima'];
        $montoS=$montoS-$prima;
        while ($reg = $rspta->fetch_object())
        {

        $total =   $montoS - $reg->abono_capital;
            $montoS=$total;
          echo '<tr>
                       <td><button class="btn btn-warning" type="button" 
                       onclick="editarAbonoS('.$reg->iddetalle.',\''.$reg->nota.'\', \''.$reg->abono_interes.'\',  \''.$reg->abono_capital.'\',\''.$reg->moneda.'\')"><i class="fa fa-edit"></i></button>
                       <button class="btn btn-danger" type="button" 
                       onclick="eliminarAbono('.$reg->iddetalle.')"><i class="fa fa-trash"></i></button>
                       </td>
                       <td><input type="hidden" id="fechaS" value="'.$reg->fecha.'">'.$reg->fecha.'</td>
                       <td><input type="hidden" id="notaS" value="'.$reg->nota.'">'.$reg->nota.'</td>
                       <td><input type="hidden" id="interesS" value="'.$reg->abono_interes.'">'.$reg->abono_interes.'</td>
                       <td><input type="hidden" id="capitalS" value="'.$reg->abono_capital.'">'.$reg->abono_capital.'</td>
                       <td><input type="hidden" id="totalS" value="'.$total.'"> '.$total.'</td>
                       <td><input type="hidden" id="monedaS" value="'.$reg->moneda.'">'.$reg->moneda.'</td>    
                   </tr>';

        }
        break;
    case 'listarDetallesAbonoMontos':
        $id=$_GET['id'];
        $rspta=$solares->listarDetallesAbonoMonto($id);
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
    case 'listarDetallesAbonoModal':
        $id=$_GET['id'];
        $rspta = $solares->listarDetallesAbono($id);
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
    case 'listarNuevaCuenta':

        $rspta = $solares->listarNuevaCuenta();


        echo '<thead style="background-color:#6ce393">
                                           <th>Opciones</th>
                                           <th>Fecha</th>
                                           <th>Id C</th>
                                           <th>Cliente</th>
                                           <th>Plazo</th>
                                           
                                           <th>Monto</th>
                                           <th>Interés</th>
                                           <th>Moneda</th>
                                           <th>Detalles</th>
                                </thead>';




        while ($reg = $rspta->fetch_object())
        {
            $urlTICKET='../reportes/TicketRepSLista.php?id=';

            echo '<tr>
                       <td><a target="_blank" href="'.$urlTICKET.$reg->idsolares.'"><button class="btn btn-warning" type="button" ><i class="fa fa-print"></i></button> </a>
                       <button class="btn btn-danger" type="button" onclick="eliminarS('.$reg->idsolares.')"><i class="fa fa-trash"></i></button> 
                       </td>
                       <td> '.$reg->fecha.'</td>
                       <td> '.$reg->cedula.'</td>
                       <td> '.$reg->cliente.'</td>
                       <td> '.$reg->plazo.'</td>
                      
                       <td> '.$reg->monto.'</td>
                       <td> '.$reg->interes.'</td>
                       <td> '.$reg->moneda.'</td>  
                       <td> '.$reg->detalles.'</td>
                        
                   </tr>';

        }
        break;
    case 'buscarClientesAbono':
        $rspta = $solares->buscarClientesAbono();
        while ($reg=$rspta->fetch_object()){
            echo '<option value='.$reg->idpersona.'>'.$reg->nombre.' - '.$reg->num_documento.'</option>';
        }
        break;
    case 'imprimirFactura':


        break;
    case 'limpiarPlanpagos':
        echo '<thead style=" background-color: #b391e3">


                                <th>Plazo</th>
                                <th>Proximas Fechas</th>
                                <th>Interes</th>
                                <th>Capital</th>
                                <th>Pendiente Capital</th>
                                <th>Moneda</th>

                                </thead>';
        break;
    case 'planPagos':
        $fecha_actual = date("d-m-Y");
        $meses=$_GET['meses'];//recibe los plazos
        $prima=$_GET['prima'];
        $mont=$_GET['monto']-$prima;
        $interes=$_GET['interes'];

        //$mont=$mont-$prima;
        $montoResult= (round((($mont)/$meses),2));//hace la divicion y redondea con 3 decimales
        $mostrarfoot=0;//esto me permitira mostrar o no el <tfoot> con la ultima informacion segun convenga y no se muestra en un principio
    //hasta que es llamado al cumplir ciertas circunstancias

        $plazo=0;

        echo '<thead style=" background-color: #b391e3">


                                <th>Plazo</th>
                                <th>Proximas Fechas</th>
                                <th>Interes %</th>
                                <th>Interes</th>
                                <th>Capital</th>
                                <th>Total a Abonar</th>
                                <th>Pendiente Capital</th>
                                <th>Moneda</th>

                                </thead>';


        for($i = 1; $i <= $meses ; $i++){
            $restante=round(($mont-$montoResult),2);//resta continuamente
            $interesenmonda= (round((($mont*$interes)/100),2));
            $mont=$restante;
            $plazo=$i;


            if($i==$meses){//se valida porque hay casos donde muestra el plazo y mes de la ultima fila son iguales pero muestran diferentes resultados en el ultimo restante
                $montoResult=$montoResult+$restante; //en caso de que sean iguales se suma el ultimo restante al capital y da la ultima cifra a abonar

                $interesenmonda=(round((($montoResult*$interes)/100),2));

                $restante=0;//al mostrar la ultima cifra el restante se deja a cero para que no muestre el ultimo restante
                $mostrarfoot=1;//se pasa a false para que no muestre el tfoot si no lo mostrara con mismo plazo y fecha pero cifras distintas

            }
            if($restante>=0){//se permite que sea mayor o igual que cero porque en unos casos el valor da negativo


                echo '<tr>
                        <td>'.$i.'</td><!--plazo-->
                        <td> '.date("d-m-Y",strtotime($fecha_actual."+ $i month")).'</td><!--fecha-->
                        <td>'.$interes.'</td><!--interes en %-->
                        <td>'.$interesenmonda.'</td><!--interes ya calculado-->
                        <td>'.$montoResult.'</td><!--capital a pagar dividido entre meses-->
                        <td>'.($montoResult + $interesenmonda).'</td>
                        <td>'.$restante.'</td><!--capital restante segun abonos-->
                        <td>'."Dolares".'</td>
                       </tr>';

                $restante2=$restante;//le pasa a restante 2 el ultimo restante, esta variable sera usada por el tfoot ya que en ocaciones
                //al dividir el monto por el plazo por ejemplo 12(1 ano) entre 800 este da 66.7 pero al multiplicar 66.7 por 12 este no da la cifra correcta
                //entonces en el for se hace tal comprobacion y muestra 11 veces 66.7 y luego simplemente se le suma el restante que seria 66.63
                //entonces restante2 seria 66.63 y este le pasara el dato al capital que le falta y al multiplicar los 11 y sumarle esta ultima cifra completa el monoto total del capital
            }
            $fechas=date("d-m-Y",strtotime($fecha_actual."+ $i month"));//se hace fuera del del  if($restante>=0) porque si no no mostrar la ultima
            //fecha, ya que ekl ciclo comprueba y quita la ultima fecha cuando el restante sea negativo, y aun asi se necesita para en caso de que sea negativo
            //oueda ser mostrada en el tfoot
            $ultimafecha=$fechas; //recibe la ultima fecha en una variable aparte

        }


       break;
    case 'estadoPagos(wrong)':
//        $fecha_actual = date("d-m-Y");
//        $idsolares=$_GET['idsolares'];
//        $meses=$_GET['meses'];//recibe los plazos
//        $obtieneprima=$solares->obtienePrima($idsolares);
//        $prima=0;
//        $vecesabonadas=0;
//        $plazodevecesabonada=0;
//        $cont=0;
//
//        while ($reg = $obtieneprima->fetch_array())
//        {
//           $prima= $reg[0];
//        }
//
//        $mont=$_GET['monto'];
//        $mont=$mont-$prima;
//
//        $interes=$_GET['interes'];
//
//        //$mont=$mont-$prima;
//        $montoResult= (round((($mont)/$meses),2));//hace la divicion y redondea con 3 decimales
//        $mostrarfoot=0;//esto me permitira mostrar o no el <tfoot> con la ultima informacion segun convenga y no se muestra en un principio
//        //hasta que es llamado al cumplir ciertas circunstancias
//
//        $plazo=0;
//
//
//
//       /* echo '<thead style=" background-color: #b391e3">
//                                <th>Plazo</th>
//                                <th>Proximas Fechas</th>
//                                <th>Interes %</th>
//                                <th>Interes</th>
//                                <th>Capital</th>
//                                <th>Pendiente Capital</th>
//                                <th>Moneda</th>
//                                </thead>';*/
//
//
//        $rspta = $solares->listarDetallesAbono($idsolares);
//        $total=0;
//        $total=0;
//        echo '<thead style="background-color:#6ce393">
//                                    <th>Plazo</th>
//                                    <th>Fecha</th>
//                                    <th>Interes %</th>
//                                    <th>Interes</th>
//                                    <th>Capital</th>
//                                    <th>Pendiente Capital</th>
//                                    <th>Moneda</th>
//
//                                </thead>';
//        //$montoS=$_GET['monto'];
//        while ($reg = $rspta->fetch_object())
//        {
//            $total =   $mont - $reg->abono_capital;
//            $mont=$total;
//            $plazodevecesabonada++;//cuenta los plazos del abono
//            echo '<tr>
//                   <td style="background-color: #ffc900">'.$plazodevecesabonada. '</td>
//                   <td style="background-color: #ffc900">' .$reg->fecha.'</td>
//                   <td>' . $interes . '</td>
//                   <td style="background-color: #ffc900">'.$reg->abono_interes.'</td>
//                   <td style="background-color: #ffc900">'.$reg->abono_capital.'</td>
//                   <td> '.$total.'</td>
//                   <td>'.$reg->moneda.'</td>
//                   </tr>';
//
//        }
//
//
//        for($i = $plazodevecesabonada+1; $i <= ($meses) ; $i++) {//$i = $plazodevecesabonada+1 se hace porque $plazodevecesabonada cuenta cuantos abonos se han hecho, por lo cual
//            //al meterlo al for repite el ultimo valor, por ejemplo si se han hecho 2 abonos, muestra en la tabla el plazo 1 y 2 pero al entrar el plazo repite el 2, entonces se $i = $plazodevecesabonada+1 para que continue en 3
//
//            $restante = round(($mont - $montoResult), 2);//resta continuamente
//            $interesenmonda = (round((($mont * $interes) / 100), 2));
//            $mont = $restante;
//            $plazo = $i;
//
//            /*if ($i == $meses) {//se valida porque hay casos donde muestra el plazo y mes de la ultima fila son iguales pero muestran diferentes resultados en el ultimo restante
//                $montoResult = $montoResult + $restante; //en caso de que sean iguales se suma el ultimo restante al capital y da la ultima cifra a abonar
//                $interesenmonda = (round((($montoResult * $interes) / 100), 2));
//                $restante = 0;//al mostrar la ultima cifra el restante se deja a cero para que no muestre el ultimo restante
//                $mostrarfoot = 1;//se pasa a false para que no muestre el tfoot si no lo mostrara con mismo plazo y fecha pero cifras distintas
//
//            }*/
//            if ($restante < 0){
//                $montoResult = $montoResult + $restante; //en caso de que sean iguales se suma el ultimo restante al capital y da la ultima cifra a abonar
//                $interesenmonda = (round((($montoResult * $interes) / 100), 2));
//                $restante = 0;//al mostrar la ultima cifra el restante se deja a cero para que no muestre el ultimo restante
//                $mostrarfoot = 1;//se pasa a false para que no muestre el tfoot si no lo mostrara con mismo plazo y fecha pero cifras distintas
//
//            }
//            if ($interesenmonda >= 0) {//se permite que sea mayor o igual que cero porque en unos casos el valor da negativo
//
//                echo '<tr id="fila'.$plazo.'">
//                        <td>' . $plazo . '</td><!--plazo-->
//                        <td> ' . date("d-m-Y", strtotime($fecha_actual . "+ $i month")) . '</td><!--fecha-->
//                        <td>' . $interes . '</td><!--interes en %-->
//                        <td ><span name="calculaInteres'.$plazo.'" id="calculaInteres'.$plazo.'">' . $interesenmonda . '</span></td><!--interes ya calculado-->
//
//                        <td ><input type="number" name="calculaMonto" id="calculaMonto" onkeyup="if(event.keyCode == 13) recalculaPlazo('.$restante.','.$plazodevecesabonada.','.$interes.','.$montoResult.')">
//                        <input type="hidden" readonly name="calculaMontoinput" id="calculaMontoinput'.$plazo.'" value="'.$montoResult.'" ><span id="spanCapitalRestante'.$plazo.'">'.$montoResult.'</span></td><!--capital a pagar dividido entre meses-->
//                        <!-- Se agrego arriba un input hidden porque es la etiqueta que si contiene un Value, mismo que es extraido en javascript con .value no se hace con span porque no contiene el atributo value y no se puede extraer el valor-->
//                        <td><span name="subtotal"  id="subtotal'.$plazo.'"> ' . $restante . '</span></td><!--capital restante segun abonos-->
//                        <td>' . "Dolares" . '</td>
//                       </tr>';
//
//                $restante2 = $restante;//le pasa a restante 2 el ultimo restante, esta variable sera usada por el tfoot ya que en ocaciones
//                //al dividir el monto por el plazo por ejemplo 12(1 ano) entre 800 este da 66.7 pero al multiplicar 66.7 por 12 este no da la cifra correcta
//                //entonces en el for se hace tal comprobacion y muestra 11 veces 66.7 y luego simplemente se le suma el restante que seria 66.63
//                //entonces restante2 seria 66.63 y este le pasara el dato al capital que le falta y al multiplicar los 11 y sumarle esta ultima cifra completa el monoto total del capital
//
//                echo ' <script type="text/javascript">
//
//
//                             mandaPlazos('.$plazo.','.$total.');
//
//
//                       </script>';
//
//            }
//
//
//
//            $fechas=date("d-m-Y",strtotime($fecha_actual."+ $i month"));//se hace fuera del del  if($restante>=0) porque si no no mostrar la ultima
//            //fecha, ya que ekl ciclo comprueba y quita la ultima fecha cuando el restante sea negativo, y aun asi se necesita para en caso de que sea negativo
//            //oueda ser mostrada en el tfoot
//            $ultimafecha=$fechas; //recibe la ultima fecha en una variable aparte
//
//        }



        break;
    case 'estadoPagos':
        $fecha_actual = date("d-m-Y");
        $idsolares=$_GET['idsolares'];
        $meses=$_GET['meses'];//recibe los plazos
        $capital=$_GET['capital'];
        $obtieneprima=$solares->obtienePrima($idsolares);
        $prima=$_GET['prima'];
        $vecesabonadas=0;
        $plazodevecesabonada=0;
        $cont=0;

        $mont=$_GET['monto'];
        $mont=$mont-$prima;

        $interes=$_GET['interes'];

        //$mont=$mont-$prima;
        $montoResult= (round((($mont)/$meses),2));//hace la divicion y redondea con 3 decimales
        $mostrarfoot=0;//esto me permitira mostrar o no el <tfoot> con la ultima informacion segun convenga y no se muestra en un principio
        //hasta que es llamado al cumplir ciertas circunstancias

        $plazo=0;

        $rspta = $solares->listarDetallesAbono($idsolares);
        $total=0;
        $total=0;
        echo '<thead style="background-color:#6ce393">
                                    <th>Plazo</th>
                                    <th>Fecha</th>
                                    <th>Interes %</th>
                                    <th>Interes</th>
                                    <th>Capital</th>
                                    <th>Total a abonar</th>
                                    <th>Pendiente Capital</th>
                                    <th>Moneda</th>
                                    
                                </thead>';
        //$montoS=$_GET['monto'];
        while ($reg = $rspta->fetch_object())
        {
            $total =   $mont - $reg->abono_capital;
            $mont=$total;
            $plazodevecesabonada++;//cuenta los plazos del abono
            echo '<tr>
                   <td style="background-color: #ffc900">'.$plazodevecesabonada. '</td>
                   <td style="background-color: #ffc900">' .$reg->fecha.'</td>
                   <td>' . $interes . '</td>
                   <td style="background-color: #ffc900">'.$reg->abono_interes.'</td>
                   <td style="background-color: #ffc900">'.$reg->abono_capital.'</td>
                   <td>'.($reg->abono_interes+$reg->abono_capital).'</td>
                   <td> '.$total.'</td>
                   <td>'.$reg->moneda.'</td>   
                   </tr>';

        }


        for($i = $plazodevecesabonada+1; $i <= ($meses) ; $i++)
        {//$i = $plazodevecesabonada+1 se hace porque $plazodevecesabonada cuenta cuantos abonos se han hecho, por lo cual
            //al meterlo al for repite el ultimo valor, por ejemplo si se han hecho 2 abonos, muestra en la tabla el plazo 1 y 2 pero al entrar el plazo repite el 2, entonces se $i = $plazodevecesabonada+1 para que continue en 3
          if($capital<=0){
              $restante = round(($mont - ($montoResult)), 2);//resta continuamente
              $interesenmonda = (round((($mont * $interes) / 100), 2));
              $mont = $restante;
              $plazo = $i;
          }else{
              $restante = round(($mont - ($capital)), 2);//resta continuamente //Si agrego algo al al input para calcular los meses entoces se agregara a la resta

              $interesenmonda = (round((($mont * $interes) / 100), 2));
              $mont = $restante;
              $plazo = $i;
          }
            /*if ($i == $meses) {//se valida porque hay casos donde muestra el plazo y mes de la ultima fila son iguales pero muestran diferentes resultados en el ultimo restante
                $montoResult = $montoResult + $restante; //en caso de que sean iguales se suma el ultimo restante al capital y da la ultima cifra a abonar
                $interesenmonda = (round((($montoResult * $interes) / 100), 2));
                $restante = 0;//al mostrar la ultima cifra el restante se deja a cero para que no muestre el ultimo restante
                $mostrarfoot = 1;//se pasa a false para que no muestre el tfoot si no lo mostrara con mismo plazo y fecha pero cifras distintas

            }*/
            if ($restante < 0){
                $montoResult = $montoResult + $restante; //en caso de que sean iguales se suma el ultimo restante al capital y da la ultima cifra a abonar
                $interesenmonda = (round((($montoResult * $interes) / 100), 2));
                $restante = 0;//al mostrar la ultima cifra el restante se deja a cero para que no muestre el ultimo restante
                $mostrarfoot = 1;//se pasa a false para que no muestre el tfoot si no lo mostrara con mismo plazo y fecha pero cifras distintas

            }
            if ($interesenmonda >= 0 && $montoResult >= 0) {//se permite que sea mayor o igual que cero porque en unos casos el valor da negativo

                echo '<tr id="fila'.$plazo.'">
                        <td>' . $plazo . '</td><!--plazo-->
                        <td> ' . date("d-m-Y", strtotime($fecha_actual . "+ $i month")) . '</td><!--fecha-->
                        <td>' . $interes . '</td><!--interes en %-->
                        <td ><span name="calculaInteres'.$plazo.'" id="calculaInteres'.$plazo.'">' . $interesenmonda . '</span></td><!--interes ya calculado-->
                        
                        <td ><span>'.$capital.'</span></td><!--capital a pagar dividido entre meses-->
                        <!-- Se agrego arriba un input hidden porque es la etiqueta que si contiene un Value, mismo que es extraido en javascript con .value no se hace con span porque no contiene el atributo value y no se puede extraer el valor-->
                        <td >'.($capital+$interesenmonda).'</span></td>
                        <td><span name="subtotal"  id="subtotal'.$plazo.'"> ' . $restante . '</span></td><!--capital restante segun abonos-->
                        <td>' . "Dolares" . '</td>
                       </tr>';
                $capital=$montoResult; //Se muestra el capital divido entre meses pero se sustituye por
                $restante2 = $restante;//le pasa a restante 2 el ultimo restante, esta variable sera usada por el tfoot ya que en ocaciones
                //al dividir el monto por el plazo por ejemplo 12(1 ano) entre 800 este da 66.7 pero al multiplicar 66.7 por 12 este no da la cifra correcta
                //entonces en el for se hace tal comprobacion y muestra 11 veces 66.7 y luego simplemente se le suma el restante que seria 66.63
                //entonces restante2 seria 66.63 y este le pasara el dato al capital que le falta y al multiplicar los 11 y sumarle esta ultima cifra completa el monoto total del capital


            }



            $fechas=date("d-m-Y",strtotime($fecha_actual."+ $i month"));//se hace fuera del del  if($restante>=0) porque si no no mostrar la ultima
            //fecha, ya que ekl ciclo comprueba y quita la ultima fecha cuando el restante sea negativo, y aun asi se necesita para en caso de que sea negativo
            //oueda ser mostrada en el tfoot
            $ultimafecha=$fechas; //recibe la ultima fecha en una variable aparte

        }
        break;
    case 'eliminarAbono':
        $iddetalle=$_GET['iddetalle'];
        $rpsta=$solares->eliminarDetalleAbono($iddetalle);
        echo $rpsta ? "Abono Eliminado Correctamente" : "No se pudo eliminar";
        break;
    case 'eliminarS':
        $idS=$_GET['id'];
        $rpsta=$solares->eliminarSolares($idS);
        echo $rpsta ? " Cuenta Eliminada Correctamente " : " No se pudo eliminar la cuenta!!! ";
        break;

}
?>