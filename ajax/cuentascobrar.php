<?php

require_once "../modelos/CUENTASCOBRAR.php";

$cc = new CUENTASCOBRAR();


switch ($_GET["op"])
{


    /*case 'listar':

        $fecha= date('Y-m');



        $rspta=$cc->listar();
        $data=Array();//almacenara todos los registros que voy a mostrar
        while ($reg=$rspta->fetch_object()) //recorrere todos los registros almacenare en la variable reg y almacenare en el indices cada dato y recorrera todos los registros
        {

           $fecha2= date('Y-m', strtotime($reg->fecha));

          // echo date('Y', strtotime($reg->fecha));
            $anterior_mes = [];
            $actual_mes = [];
            $no_abono = [];


           if(date('Y', strtotime($fecha2)) === date('Y')) {

               if(date('m', strtotime($fecha2)) === date('m')){
                   $actual_mes = [
                       $reg->idpersona,//"0"=>('Pendiente'),//al hacer click manda el idarticulo
                   ];
               }

               if(((int)date('m', strtotime($fecha2))) === (((int)date('m')) -1)){
                   $anterior_mes = [
                       $reg->idpersona,//"0"=>('Pendiente'),//al hacer click manda el idarticulo
                   ];
               }

               $test = '';

               foreach ($anterior_mes as $k1 => $v1){
                   foreach ($actual_mes as $k2 => $v2){
                       $test = $v1;
                       echo $test;
                   }
               }

               //echo json_encode($no_abono, JSON_PRETTY_PRINT);

             //  echo json_encode($actual_mes, JSON_PRETTY_PRINT);

               $data[]=array(
                   "0"=>$reg->idpersona,//"0"=>('Pendiente'),//al hacer click manda el idarticulo
                   "1"=>$reg->cliente,
                   "2"=>$reg->abono_capital,
                   "3"=>$reg->abono_interes,
                   "4"=>$reg->fecha,
                   "5"=>($fecha == $fecha2)? '<span class="label bg-green">PAGADO</span>':'<span class="label bg-red">PENDIENTE</span>'
               );
           }




        }

        $reult= array(
            "sEcho"=>1, //informacion para el datatable
            "iTotalRecords"=>count($data),//se envia el total de registros al datatable
            "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a vizualizar
            "aaData"=>$data
        );
        echo json_encode($reult);
        break;*/

    case 'listarh':
        $nombre="Pabel Andino";
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
        $rspta=$cc->listarcch();//cuentas por cobrar
        $data=Array();//almacenara todos los registros que voy a mostrar

        $dbclient=array();

        $maxs=array();
        while ($reg=$rspta->fetch_object()) //recorrere todos los registros almacenare en la variable reg y almacenare en el indices cada dato y recorrera todos los registros
        {
            $monto=$reg->monto;
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
                    "0"=>'<a data-toggle="modal" href="#modalClienteh">  <button type="button" id="button_detalle" class="btn btn-info" onclick="detalles_clienteh('.$reg->idhipoteca.',\''.$reg->cliente.'\', \''.$reg->telefono.'\',  \''.$reg->direccion.'\',  \''.$reg->num_documento.'\',  \''.$monto.'\')" ><i class="fa fa-info"></i></button></a>',//al hacer click manda el idarticulo
                    "1"=>$reg->cliente,
                    "2"=>$reg->abono_capital,
                    "3"=>$reg->abono_interes,
                    "4"=>$reg->moneda,
                    "5"=>($numercount <=0)?'<h4><span class="label bg-gray">Mas del Año</span></h4>':'<h4><span class="label bg-gray">  '.$numercount.'</span></h4>',
                    "6"=>$fecha_completa_de_consulta,
                    "7"=>$dia_pago,
                    "8"=> '<span class="label bg-red">PENDIENTE</span>'
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
    case 'listarf':

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
        $rspta=$cc->listarccf();//cuentas por cobrar
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
                    "0"=>('Pendiente'),//al hacer click manda el idarticulo
                    "1"=>$reg->cliente,
                    "2"=>$reg->casa,
                    "3"=>$reg->abono_capital,
                    "4"=>$reg->abono_interes,
                    "5"=>$reg->moneda,
                    "6"=>$reg->concepto,
                    "7"=>($numercount <=0)?'<h4><span class="label bg-gray">Mas del Año</span></h4>':'<h4><span class="label bg-gray">  '.$numercount.'</span></h4>',
                    "8"=>$fecha_completa_de_consulta,
                    "9"=>$dia_pago,
                    "10"=> '<span class="label bg-red">PENDIENTE</span>'
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