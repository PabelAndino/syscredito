<?php

require_once "../modelos/CUENTASCOBRAR.php";

$cc = new CUENTASCOBRAR();


switch ($_GET["op"])
{

    case 'listarh':
        $rspta = $cc->listarH();
        $total=0;
        echo '<thead style="background-color:#ffb211">
                    <th>Opciones</th>
                    <th>ID Prestamo</th>
                    <th>Cliente</th>
                    <th>Desembolso</th>
                    <th>Pago</th>
                    <th>Monto</th>
                    <th>Interés%</th>
                    <th>Mantenimiento%</th>
                    <th>Moratorio%</th>
                    <th>Plazo</th>
                    <th>Moneda</th>
                    <th style="white-space: nowrap;min-width: 200px;max-width: 200px;overflow: scroll">Nota</th>
                </thead>';

        while ($reg = $rspta->fetch_object())
        {
            echo '<tr>
                   <td>'."Option".'</td>
                   <td>'.$reg->idhipoteca.'</td>
                   <td>'.$reg->nombres.'</td>
                  
                   <td>'.date('d-m-Y',strtotime($reg->fecha_desembolso)).'</td>
                   <td>'.date('d-m-Y',strtotime($reg->fecha_pago)).'</td>
                   <td>'.$reg->monto.'</td>
                   <td>'.$reg->interes.'</td>
                   <td>'.$reg->mantenimiento.'</td>
                   <td>'.$reg->interes_moratorio.'</td>
                   <td>'.$reg->plazo.'</td>
                   <td>'.$reg->moneda.'</td>
                   <td>'.$reg->nota.'</td>
                   </tr>';
        }


        break;
    case 'listarAbonos':

        $fechadesde=$_GET['fechadesde'];
        $fechahasta=$_GET['fechahasta'];
        $tipo_cambio = $_GET['tipo_cambio'];
        $moneda = $_GET['moneda'];//la moneda que viene desde el fomulario
        $rspta = $cc->listarAbonos($fechadesde,$fechahasta);
        $data= Array();
        while ($reg = $rspta->fetch_object())
        {
            $interes = $reg->abono_interes;
            $mantenimiento = $reg->mantenimiento;
            $interes_moratorio = $reg->moratorio;
            $capital = $reg->abono_capital;
            $moneda_consulta = $reg->moneda;//la moneda que viene de Mysql
            if($moneda == "Cordobas" && $moneda_consulta == "Dolares"){//Si quiere saber cuantos cordobas es por todo
                $moneda_consulta = "Cordobas";
                $interes = $interes * $tipo_cambio;
                $mantenimiento = $mantenimiento * $tipo_cambio;
                $interes_moratorio = $interes_moratorio * $tipo_cambio;
                $capital = $capital * $tipo_cambio;

            }
            if($moneda == "Dolares" && $moneda_consulta == "Cordobas"){//Si Quiere sabes cuantos dolares tiene
                $moneda_consulta = "Dolares";
                $interes = $interes / $tipo_cambio;
                $mantenimiento = $mantenimiento / $tipo_cambio;
                $interes_moratorio = $interes_moratorio / $tipo_cambio;
                $capital = $capital / $tipo_cambio;
            }
            $data[]=array(
                "0"=>"Option",//$conteo2,//meses
                "1"=>$reg->idhipoteca,//$fechaInicio,//fechas
                "2"=>date('d-m-Y',strtotime($reg->fecha)),//$totalInteres,
                "3"=>$reg->nombres,//$interesM,//$totalInteresMoratorio,//interes Moratorio
                "4"=>round(($capital),2),//$totalMantenimiento /* round((($mantenimiento * $capital)/100 ),2 ) */,
                "5"=>round(($interes),2),//round(($totalInteres + $totalInteresMoratorio + $totalMantenimiento ),2),
                "6"=>round(($mantenimiento),2),//$moneda.$dia_menos
                "7"=>round(($interes_moratorio),2),
                "8"=>$reg->nota,
                "9"=>$moneda_consulta


            );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);


        break;
    case 'listars':

        $fecha= date('Y-m');
        $anio_actual= date('Y');
        $anio_antepasado=$anio_actual-2;
        $anio_pasado=$anio_actual-1;
        $mes_actual=date('m');

        $clientes=array();
        $clientes2=array();
        $todos_meses=array(
            1=>12,
            2=>11,
            3=>10,
            4=>9,
            5=>8,
            6=>7,
            7=>6,
            8=>5,
            9=>4,
            10=>3,
            11=>2,
            12=>1);//se guardan todos los meses
        //cada mes es asignado de manera inversa para poder trabajar con el anio anterior
        $row=0;
        $rspta=$cc->listarccs();//cuentas por cobrar
        $data=Array();//almacenara todos los registros que voy a mostrar

        $dbclient=array();

        $maxs=array();
        while ($reg=$rspta->fetch_object()) //recorrere todos los registros almacenare en la variable reg y almacenare en el indices cada dato y recorrera todos los registros
        {

            $fecha2= date('Y-m', strtotime($reg->fecha));
            $fecha_completa_de_consulta=date('Y-m-d', strtotime($reg->fecha));
            $anio=date('Y', strtotime($reg->fecha));
            $dia_pago=date('d',strtotime($reg->dia_pago));

            $mes=date('m', strtotime($reg->fecha));

            if($anio_actual > $anio || $mes_actual > $mes ) {
                //si la fecha de hoy(El mes es igual o menor) para que no muestre los que ya pagaron el mes

                $aniomenor=$anio_actual-2;
                $numercount=$mes_actual-$mes;

                if( $anio == ($anio_antepasado)){//si el anio es 3 anios anterior al actual lo enumera a cero
                    //para que mande el mensaje de que esta fuera de anio,
                    $numercount=0;
                }else if($anio == ($anio_pasado)){

                    foreach ($todos_meses as $key => $values){
                        if($mes==$key){
                            $numercount= ($mes_actual+$values)-2;
                        }
                    }
                }



                $data[]=array(
                    "0"=>'<button class="fc-button">',//al hacer click manda el idarticulo
                    "1"=>$reg->cliente,
                    "2"=>$reg->plazo,
                    "3"=>$reg->prima,
                    "4"=>$reg->abono_capital,
                    "5"=>$reg->abono_interes,
                    "6"=>$reg->moneda,
                    "7"=>$reg->detalles,
                    "8"=>($numercount <=0)?'<h4><span class="label bg-gray">Mas del Año</span></h4>':'<h4><span class="label bg-gray">  '.$numercount.'</span></h4>',
                    "9"=>$fecha_completa_de_consulta,
                    "10"=>$dia_pago,
                    "11"=> '<span class="label bg-red">PENDIENTE</span>'
                );

            }


        }

        $result= array(
            "sEcho"=>1, //informacion para el datatable
            "iTotalRecords"=>count($data),//se envia el total de registros al datatable
            "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a vizualizar
            "aaData"=>$data
        );
        echo json_encode($result);

        break;

    case 'listar_ncuentah':

        $rspta=$cc->listarnch();
        //Vamos a declarar un array

        $data= Array();

        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>"Opciones",
                "1"=>$reg->cliente,
                "2"=>$reg->monto,
                "3"=>$reg->interes,
                "4"=>$reg->moneda,
                "5"=>'<span class="label bg-orange">'.$reg->tipo.'</span>',
                "6"=>$reg->fecha_prestamo,
                "7"=>  $reg->siguienteFecha,
                "8"=>'<span class="label bg-orange">'.$reg->estado.'</span>'
            );
        }
        $result=array(
            "sEcho"=>1, //informacion para el datatable
            "iTotalRecords"=>count($data),//se envia el total de registros al datatable
            "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a vizualizar
            "aaData"=>$data
        );
        echo json_encode($result);
        break;
    case 'listar_ncuentaf':

        $rspta=$cc->listarncf();
        //Vamos a declarar un array

        $data= Array();

        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>"Opciones",
                "1"=>$reg->cliente,
                "2"=>$reg->casa,
                "3"=>$reg->monto,
                "4"=>$reg->interes,
                "5"=>$reg->moneda,
                "6"=>$reg->concepto,
                "7"=>$reg->fecha,
                "8"=> '<span class="label bg-orange">'. $reg->siguienteFecha.'</span>',
                "9"=>'<span class="label bg-red">PENDIENTE</span>'
            );
        }
        $result=array(
            "sEcho"=>1, //informacion para el datatable
            "iTotalRecords"=>count($data),//se envia el total de registros al datatable
            "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a vizualizar
            "aaData"=>$data
        );
        echo json_encode($result);
        break;
    case 'listar_ncuentas':

        $rspta=$cc->listarncs();
        //Vamos a declarar un array

        $data= Array();

        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>"Opciones",
                "1"=>$reg->cliente,
                "2"=>$reg->plazo,
                "3"=>$reg->prima,
                "4"=>$reg->monto,
                "5"=>$reg->interes,
                "6"=>$reg->moneda,
                "7"=>$reg->detalles,
                "8"=>$reg->fecha,
                "9"=> '<span class="label bg-orange">'. $reg->siguienteFecha.'</span>',
                "10"=>'<span class="label bg-red">PENDIENTE</span>'
            );
        }
        $result=array(
            "sEcho"=>1, //informacion para el datatable
            "iTotalRecords"=>count($data),//se envia el total de registros al datatable
            "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a vizualizar
            "aaData"=>$data
        );
        echo json_encode($result);
        break;
    case 'modalclienteh':
        $id=$_GET['idhipoteca'];
        $montoS=$_GET['monto'];
        $rspta = $cc->listarDetallesAbonoh($id);
        $total=0;
        $total=0;
        $opciones="Opciones";

        echo '<thead style="background-color:#6ce393">
                                    
                                    <th>Fecha</th>
                                    <th style="white-space: nowrap;min-width: 200px;max-width: 200px;overflow: scroll">Concepto</th>
                                    <th>Interes</th>
                                    <th>Capital</th>
                                    <th>Pendiente Capital</th>
                                    <th>Moneda</th>    
                                </thead>';




        while ($reg = $rspta->fetch_object())
        {

            $nota=(string) $reg->nota;

            $total =   $montoS - $reg->abono_capital;
            $montoS=$total;



            echo '<tr>
                       
                       <td>'.$reg->fecha.'</td>
                       <td>'.$reg->nota.'</td>
                       <td>'.$reg->abono_interes.'</td>
                       <td>'.$reg->abono_capital.'</td>
                       <td>'.$total.'</td>
                       <td>'.$reg->moneda.'</td>   
                   </tr>';

        }


        break;
}

?>