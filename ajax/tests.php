<?php

require_once "../modelos/CUENTASCOBRAR.php";

$cc = new CUENTASCOBRAR();


switch ($_GET["op"])
{

    case 'planpagos':
        $fechaDesembolso = $_GET['desembolso'];
        $fechaPago = $_GET['pago'];
        $interes_calculado = 7;
        $plazo = 6;

            $date = date('Y-m',strtotime($fechaDesembolso));
            $end_date = date('Y-m',strtotime($fechaPago));

            $mes_aniodesembolso = date('Y-m',strtotime($date));
            $mes_aniopago = date('Y-m',strtotime($end_date));
            $mes_desembolso = date('m',strtotime($date));
            $mes_pago = date('m',strtotime($end_date));
            $diadesembolso  = date('d',strtotime($fechaDesembolso));
            $diapago = date('d',strtotime($fechaPago));
            $aniodesembolso = date('Y',strtotime($date));
            $aniopago =date('Y',strtotime($end_date));
            $dias=array();
            $diascaculados = array();
            $diastotales = array();
            $contador=1;


                    if($mes_aniodesembolso < $mes_aniopago){ //verifica que no este en el mismo mes

                       // echo 'Es menor el mes ';

                        while(strtotime($date) <= strtotime($end_date)){

                            $meses_recorridos = date ("m", strtotime($date));
                            $anios_recorridos = date ("Y", strtotime($date));

                            $dias_delmes = cal_days_in_month(CAL_GREGORIAN, $meses_recorridos, $anios_recorridos);//calcula cuantos dias tiene el mes
                            //se le pasa el mes y el anio juntos, luego el mes aumenta en uno para ser el siguiente mes, hasta que cumple la sentencia del while
                            //que la fecha sea igual

                             //  echo $dias_delmes," Dias " ;

                            /*if($i==1){  // FUnciona pero hara mal la multiplicacion por dias;

                                $dias_delmes = $dias_delmes - $diadesembolso;
                            }else if($date == $end_date){
                                $dias_delmes = $diadesembolso;
                            }*/


                            array_push($dias,$dias_delmes);


                            $date = date ("Y-m", strtotime("+1 month", strtotime($date))); //en la inicializacion de $date se tuvo que poner nada mas el formato en Y-m porque si se pone
                            //en Y-m-d al hacer al aumento en esta linea de codigo habra problemas si se aunmenta un mes en donde este tiene 31 dias y el otro 30 por lo que saltara aun mes mas adelante
                            //por lo que solo guardar un unico mes cuando se le pasen dos meses,..
                         //   echo ' letra aumento: ',$i, ' dia del mes: ',$dias_delmes;
                         //   $i++;
                        }


                        echo ' *** Ultimo mes y dias: ' ;

                        // array_push($diascaculados,$dias[0]); //procesa en un array los primeros y ultimos datos de dias
                        //  array_push($diascaculados,end($dias));//los ultimos datos del array
                        foreach ($dias as $values){


                         //   echo '**sin calcular**', $v, ' i ', $i;
                            $diasTotales_delmes=$values; //en una primera instancia v son todos los dias del mes que es guardado en w


                            $values = round((($values * 7)/100),2); //luego lo saco el porcentaje del interes, ahora v contienen el interes
                           if($contador==1){ //verifica si es el primer elemento para asignar a la variable w la cantidad de dias que se tienen que tomar en la primera fecha
                               $diasTotales_delmes = $diasTotales_delmes - $diadesembolso;
                           }else if ($values !== count($dias) -1){ //verifica el ultimo item del array dias,
                               // en este caso recibe los ultimos dias del mes, pero no se necesitan todos los dias
                               //solamente los dias hasta donde le toca pagar entonces la variable w sera el total de dias hasta donde le toque pagar en la ultima fecha
                                $diasTotales_delmes = $diapago;
                           }

                            $dias_conPorcentajes = $values * $diasTotales_delmes; //luego x pasa a hacer la multiplicacion de de v que ahora tiene el porcentaje calculado y w que tiene los dias del mes donde V es el porcentaje por dia
                            //y w es la cantidad total de dias


                            echo '**calculado** ',$values;


                            array_push($diascaculados,$dias_conPorcentajes); //se asigna los calculos al array dias calculados

                            $contador++;

                        }


                        echo '/Dias calculados /';

                        //$ffinal =  end($dias) - $ffinal;
                        //  $r = ($diascaculados);


                      //  print_r($diascaculados);
                        print_r(array_sum($diascaculados));
                        // echo $r;

                        echo '/Dias calculados /';

                    }
                    else if($mes_aniodesembolso == $mes_aniopago){ //meses diferentes en el mismo anio
                        echo 'Es el mismo mes ';

                        $dias_delmes = cal_days_in_month(CAL_GREGORIAN, $mes_desembolso, $aniodesembolso);
                        echo $dias_delmes;
                        array_push($dias,$dias_delmes);

                        foreach ($dias as $v) {

                            echo '**sin calcular**', $v;
                            $v = round((($v * 7)/100),2); //luego lo saco el porcentaje del interes, ahora v contienen el interes de los dias de un mes
                            echo '**calculado** ',$v;
                            array_push($diascaculados,$v); //el array cotendra cuanto es el interes por dia del mes

                        }

                        echo '/Dias calculados /';

                        $finicio =    (date('d',strtotime($fechaDesembolso))); //la fecha del desembolso

                        $ffinal =   (date('d',strtotime($fechaPago))) ; //la fecha que quedo de pagar
                        //$ffinal =  end($dias) - $ffinal;
                        $r =  ($ffinal - $finicio)* $diascaculados[0];//cuantos dias entre las 2 fechas/ luego cuanto es el porcentaje en esos dias

                        print_r($r);

                    }
                    /*else if($aniodesembolso < $aniopago){ //anios diferentes

                        echo ' Diferente anio ';
                        while(strtotime($date) <= strtotime($end_date)){

                            $meses_recorridos = date ("m", strtotime($date));
                            $anios_recorridos = date ("Y", strtotime($date));

                            $dias_delmes = cal_days_in_month(CAL_GREGORIAN, $meses_recorridos, $anios_recorridos);//calcula cuantos dias tiene el mes
                            //se le pasa el mes y el anio juntos, luego el mes aumenta en uno para ser el siguiente mes, hasta que cumple la sentencia del while
                            //que la fecha sea igual

                            echo $dias_delmes," Dias " ;

                            array_push($dias,$dias_delmes);

                            $date = date ("Y-m", strtotime("+1 month", strtotime($date)));



                        }

                    }*/


        break;

}

?>