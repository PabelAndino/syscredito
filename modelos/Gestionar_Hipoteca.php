
<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Gestionar_Hipoteca
{
    //Implementamos nuestro constructor
    public function __construct()
    {

    }

    //Implementamos un método para insertar registros
    public function insertar($idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,
                             $impuesto,$total_venta,$tipoventa,$idarticulo,$cantidad,$precio_compra,$precio_venta,$descuento){
            $sql="INSERT INTO venta (idcliente,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_venta,estado,tipoVenta)
            VALUES ('$idcliente','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_venta','Aceptado','$tipoventa')";
            //return ejecutarConsulta($sql);
            $idventanew=ejecutarConsulta_retornarID($sql);

            $num_elementos=0;
            $sw=true;

            while ($num_elementos < count($idarticulo))
            {
                $sql_detalle = "INSERT INTO detalle_venta(idventa, idarticulo,cantidad,precio_compra,precio_venta,descuento,estado) VALUES ('$idventanew', '$idarticulo[$num_elementos]',
                                                        '$cantidad[$num_elementos]','$precio_compra[$num_elementos]','$precio_venta[$num_elementos]','$descuento[$num_elementos]','Aceptado')";
                ejecutarConsulta($sql_detalle) or $sw = false;
                $num_elementos=$num_elementos + 1;
            }

            return $sw;
    }

    public function insertarGarantia($idcliente,$nombre,$idcategoria,$codigo,$descripcion,$valor,$moneda)
    {
        $sql="INSERT INTO garantia (idcliente,nombre,condicion,categoria,estado) VALUES ('$idcliente','$nombre','Pendiente','no_asignado','Aceptado')";
        //return ejecutarConsulta($sql);
        $idgarantianew=ejecutarConsulta_retornarID($sql);

        $num_elementos=0;
        $sw=true;

        while ($num_elementos < count($descripcion))
        {
            $sql_detalle = "INSERT INTO articulo_hipoteca_detalle(idgarantia,idcategoria,codigo,descripcion,valor,moneda,estado)
                            VALUES('$idgarantianew','$idcategoria[$num_elementos]','$codigo[$num_elementos]','$descripcion[$num_elementos]','$valor[$num_elementos]',
                                    '$moneda[$num_elementos]','Aceptado')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
        }

        return $sw;
    }

    public function insertarHipoteca($idusuario,$cliente,$fiador,$garantia,$fecha,$tipo,$monto,$interes,$moneda,$descripcion,$no_cuenta){
        $sql="INSERT INTO hipoteca(idusuario,idcliente,idfiador,idarticulo_garantia,fecha,tipo,monto,interes,moneda,nota,condicion,estado,no_cuenta)
              VALUES ('$idusuario','$cliente','$fiador','$garantia','$fecha','$tipo','$monto','$interes','$moneda','$descripcion','Pendiente','Aceptado','$no_cuenta')";
       $idhipoteca= ejecutarConsulta_retornarID($sql);

        $sqlncuenta="INSERT INTO nuevacuenta_hipoteca(nidhipoteca,estado)VALUES('$idhipoteca','sin_abonar')";

        return ejecutarConsulta($sqlncuenta);

    }

    public function getnoCuenta($solicitud){
        $sql = "SELECT no_credito, solicitud FROM hipoteca WHERE solicitud = '$solicitud' AND estado='Aceptado' ";
        return ejecutarConsulta($sql);
    }

    public function guardarHipoteca($idusuario,$idfiador,$garantia,$fecha_desembolso,$fecha_pago,$tipo,$monto,$interes,$plazo,$interes_moratorio,
                                    $moneda,$nota,$comision,$mantenimiento_valor,$cuenta_desenbolso,$solicitud,$no_credito,$monto_a_actualizar,$monto_prestamo){

        $sql = "INSERT INTO hipoteca(idusuario,idfiador,idarticulo_garantia,fecha_desembolso,fecha_pago,tipo,monto,interes,plazo,interes_moratorio,moneda,nota,comision,mantenimiento_valor,cuenta_desembolso,solicitud,condicion,estado,no_credito,cantidad_debitada) VALUES (
                                     '$idusuario','$idfiador','$garantia','$fecha_desembolso','$fecha_pago','$tipo','$monto_prestamo','$interes','$plazo','$interes_moratorio','$moneda','$nota','$comision','$mantenimiento_valor','$cuenta_desenbolso','$solicitud','Pendiente','Aceptado','$no_credito','$monto')";

        $returnid = ejecutarConsulta_retornarID($sql) ;

        if($returnid){
            
            
            $this->actualizaMontoSocio($cuenta_desenbolso,$monto_a_actualizar);
            $this->ingresoNCuenta($returnid);
            $this->cambiaEstadoGarantia($garantia);
             return $returnid;
        }else{
            return $returnid;
        }
  
    }
    function ingresoNCuenta($idhipoteca){//ingresa el estado de cada cuenta si esta en el estado de sin abono o abonado
        $verifica_nueva_cuenta= "INSERT INTO nuevacuenta_hipoteca (nidhipoteca,estado) VALUES('$idhipoteca','sin_abono')";
        return ejecutarConsulta( $verifica_nueva_cuenta);
    }
    function cambiaEstadoGarantia($idgarantia){ //este estado permite que no se muestre mas una vez que se hizo el prestamo ya que ya pasa a guardado
        $sql = "UPDATE garantia SET categoria = 'asignado' WHERE idgarantia= '$idgarantia'";
        return ejecutarConsulta(($sql));
    }
    function actualizaMontoSocio($idBanco,$monto){
        $sql = "UPDATE cuentas_bancos SET monto = '$monto' WHERE idcuentas_bancos = '$idBanco'";
        return ejecutarConsulta($sql);
    }
    public function updateBanco($idbanco,$monto)
    {
        $sql ="UPDATE ";
    }

    public function calcula_mora($idhipoteca){
        $sql = "SELECT DATE(h.fecha_desembolso) as fecha_desembolso,DATE(h.fecha_pago) as fecha_pago, h.interes,h.interes_moratorio,h.monto,h.mantenimiento_valor,nc.estado,h.moneda 
        FROM hipoteca h INNER JOIN nuevacuenta_hipoteca nc ON nc.nidhipoteca=h.idhipoteca WHERE nc.nidhipoteca = '$idhipoteca'";
        return ejecutarConsulta($sql);
    }

    public function muestra_fechas_atrasadas($idhipoteca){
        $sql= "SELECT DATEDIFF(CURDATE(), (SELECT DATE(fecha) FROM hipoteca WHERE idhipoteca = '$idhipoteca')) as fecha";
        return ejecutarConsulta($sql);
    }

    public function insertarAbono($idusuario,$idhipoteca,$fecha,$capital,$interes,$interes_pendiente,$interes_moratorio,$mantenimiento_valor,$nota){

       // $sql="INSERT INTO abono_hipoteca(idhipoteca,fecha,num_comprobante,estado) VALUES ('$idhipoteca','$fecha','0','Pendiente')";
       // $idabononew=ejecutarConsulta_retornarID($sql);
            $saldo = "sin_saldo";
            if($interes_pendiente > 0){
                $saldo = "saldo_pendiente";
            }

            $sql_detalle = "INSERT INTO detalle_abono_hipoteca(idhipoteca,idusuario,fecha,abono_capital,abono_interes,interes_pendiente,abono_interes_moratorio,mantenimiento_valor,nota,estado) 
            VALUES('$idhipoteca','$idusuario','$fecha','$capital','$interes','$interes_pendiente','$interes_moratorio','$mantenimiento_valor','$nota','$saldo')";
            $iddetalle=ejecutarConsulta_retornarID($sql_detalle);
            if($iddetalle){
           
                $sql_sumacapital="INSERT INTO suma_capital(idabono_detalle,abono_capital) VALUES('$iddetalle','$capital')";
                ejecutarConsulta($sql_sumacapital);
                
                $this->actualizar_ncuenta($idhipoteca);
                return $iddetalle;
             }else{
            return $iddetalle;
          }
       
    }

    public function insertarNuevaSolicitur($idcliente,$conyugue,$tipo_local,$sabeleer,$ultimo_anio,$num_dependientes,
                                         $ingresos,$total_ingresos,$sector,$objetivo_prestamo){
        $sql="INSERT INTO solicitud (cliente,nombre_conyugue,tipo_local,leer_escribir,ultimo_estudio_anio,
              numero_dependientes,ingresos,total_ingresos,sector,objetivo_prestamo,estado) VALUES('$idcliente','$conyugue'
              ,'$tipo_local','$sabeleer','$ultimo_anio','$num_dependientes','$ingresos','$total_ingresos','$sector','$objetivo_prestamo'
              ,'Aceptado')";

        return ejecutarConsulta($sql);
    }

    public function actualizar_ncuenta($idhipoteca){
        $sqlupdate_ncuenta="UPDATE nuevacuenta_hipoteca SET estado='abonado' WHERE nidhipoteca ='$idhipoteca'";
        return  ejecutarConsulta($sqlupdate_ncuenta);
    }

    public function guardarCliente($nombre,$direccion,$genero,$estado_civil,$tipo_documento,$num_documento){
        $sql="INSERT INTO cliente (nombres, direccion,genero, estado_civil,tipo_documento,num_documento,tipo,estado) VALUES('$nombre','$direccion','$genero','$estado_civil','$tipo_documento','$num_documento','Cliente','Aceptado')";
        return ejecutarConsulta($sql);
    }
    public function guardarFiador($nombre,$direccion,$genero,$estado_civil,$tipo_documento,$num_documento,$ingresos){
        $sql="INSERT INTO cliente (nombres, direccion,genero, estado_civil,tipo_documento,num_documento,igresos,tipo,estado) VALUES('$nombre','$direccion','$genero','$estado_civil','$tipo_documento','$num_documento','$ingresos','Fiador','Aceptado')";
        return ejecutarConsulta($sql);
    }
    public function selectCliente(){
        $sql ="SELECT * FROM cliente WHERE estado = 'Aceptado' AND tipo='Cliente'";
        return ejecutarConsulta($sql);
    }

    public function selectFiador(){
        $sql ="SELECT * FROM cliente WHERE estado = 'Aceptado' AND tipo='Fiador'";
        return ejecutarConsulta($sql);
    }
    public function selectSector(){
        $sql="SELECT * FROM sector WHERE estado ='Aceptado'";
        return ejecutarConsulta($sql);
    }
    public function selectSolicitud(){
        $sql="SELECT s.idsolicitud,c.nombres as cliente FROM solicitud s INNER JOIN cliente c ON c.idcliente=s.cliente   WHERE s.estado ='Aceptado'";
        return ejecutarConsulta($sql);
    }

    function editarAbono($iddetalle,$fecha,$capital,$interes,$nota){

        $sql="UPDATE detalle_abono_hipoteca SET fecha='$fecha', abono_capital='$capital',abono_interes='$interes',nota='$nota' WHERE iddetalle_abono='$iddetalle'" ;
        $rpsta= $this->editarAbonoSumaCapital($iddetalle,$capital) ;

        echo $rpsta ? "---Se edito La suma al capital Correctamente---"  : "----NO SE EDITO LA SUMA AL CAPITAL!!!----";
        return ejecutarConsulta($sql);

    }
    function editarAbonoSumaCapital($iddetalle,$capital){
        $sql="UPDATE suma_capital SET  abono_capital='$capital' WHERE idabono_detalle='$iddetalle'" ;
        return ejecutarConsulta($sql);
    }
    public function actualizarSolicitud($idsolicitud,$idcliente,$conyugue,$tipo_local,$sabeleer,$ultimo_anio,$num_dependientes,
    $ingresos,$total_ingresos,$sector,$objetivo_prestamo)
    {
       $sql = "UPDATE solicitud SET cliente = '$idcliente',nombre_conyugue = '$conyugue',tipo_local='$tipo_local',leer_escribir='$sabeleer',
       ultimo_estudio_anio = '$ultimo_anio',numero_dependientes = '$num_dependientes',ingresos='$ingresos', total_ingresos = '$total_ingresos',
       sector = '$sector', objetivo_prestamo = '$objetivo_prestamo' WHERE idsolicitud = '$idsolicitud'";
       return ejecutarConsulta($sql);
    }
    function insertarDetalleAbono($idabono,$fecha,$capital,$interes){ //La funcion se llama cuando ya se realizo un primer abono, ya no es necesario ingresar
        // mas abonos, solo los detalles del mismo
        $sql = "INSERT INTO detalle_abono_hipoteca(idabono,fecha,abono_capital,abono_interes) VALUES('$idabono','$fecha','$capital','$interes')";
       return ejecutarConsulta($sql);
    }
   


    public  function calculaStock($idproducto)
    {
        $sql = "SELECT nombre, stock from productos WHERE idproducto = $idproducto";
        return ejecutarConsulta($sql);

    }

    public function ventacabecera($idventa)
    {
        $sql = "SELECT v.idventa, v.idcliente, p.nombre as cliente, p.direccion, p.tipo_documento,p.num_documento,p.email,p.telefono,v.idusuario,u.nombre as usuario, v.tipo_comprobante,v.serie_comprobante,
          v.num_comprobante,DATE(fecha_hora) as fecha,v.impuesto,v.total_venta FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
        return ejecutarConsulta($sql);

    }

    public function ventadetalle($idventa)
    {
        $sql="SELECT a.nombre as articulo, a.codigo,d.cantidad,d.precio_venta,d.descuento,(d.cantidad*d.precio_venta-d.descuento) as subtotal  FROM detalle_venta d INNER JOIN articulo a ON d.idarticulo=a.idarticulo
              WHERE idventa='$idventa'";
        return ejecutarConsulta($sql);
    }

    public function selectCategoria(){
        $sql = "SELECT * FROM categoria_hipoteca WHERE condicion=1 ORDER BY idcategoria DESC";
        return ejecutarConsulta($sql);
    }

    public function selectGarantia(){
        $sql="SELECT idgarantia, nombre
            FROM garantia WHERE estado='Aceptado' AND categoria = 'no_asignado' ORDER BY idgarantia DESC";
        return ejecutarConsulta($sql);
    }

    public function buscarClientesAbono(){
        $sql = "SELECT DISTINCT c.idcliente, c.nombres as nombre,c.num_documento  FROM hipoteca h INNER JOIN solicitud s ON h.solicitud = s.idsolicitud INNER JOIN cliente c ON s.cliente = c.idcliente WHERE h.condicion = 'Pendiente' AND h.estado = 'Aceptado'";

        return ejecutarConsulta($sql);
    }
    public function mostrarCuentasAbono($id){
        $sql="SELECT h.idhipoteca,DATE(h.fecha_desembolso) as fecha_desembolso,DATE(h.fecha_pago) as fecha_pago,h.monto,h.interes,h.plazo,h.moneda,h.no_credito
             FROM hipoteca h INNER JOIN solicitud s ON h.solicitud=s.idsolicitud INNER JOIN cliente c ON s.cliente = c.idcliente  
             WHERE h.condicion='Pendiente' AND h.estado='Aceptado' AND c.idcliente = '$id'";
       return ejecutarConsulta($sql);
    }
    public function muestraUltimoAbono($idhipoteca){
        $sql ="SELECT DATE(da.fecha) as fecha,da.abono_capital,da.abono_interes,da.abono_interes_moratorio FROM hipoteca h 
        INNER JOIN detalle_abono_hipoteca da ON da.idhipoteca=h.idhipoteca WHERE h.idhipoteca = '$idhipoteca' ORDER BY da.iddetalle_abono DESC LIMIT 1";

        return ejecutarConsulta($sql);
    }


    public function listarDetalleCuenta($id){
        $sql="SELECT hp.idhipoteca, DATE(hp.fecha_desembolso) as fecha_desembolso,DATE(hp.fecha_pago) as fecha_pago,f.nombres as fiador,gr.nombre as garantia,hp.monto,hp.interes,hp.interes_moratorio,
              hp.moneda,hp.plazo,hp.nota FROM hipoteca hp INNER JOIN cliente f ON hp.idfiador = f.idcliente 
              INNER JOIN garantia gr ON hp.idarticulo_garantia=gr.idgarantia WHERE hp.idhipoteca='$id'";
        return ejecutarConsulta($sql);
    }
    public function listarDetallesAbono($idhipoteca){
      $sql="SELECT da.iddetalle_abono as iddetalle,DATE(da.fecha) as fecha,da.nota as nota,da.abono_interes,da.abono_capital,da.abono_interes_moratorio,da.interes_pendiente as saldo,h.moneda 
      FROM detalle_abono_hipoteca da INNER JOIN hipoteca h ON da.idhipoteca=h.idhipoteca WHERE da.idhipoteca= '$idhipoteca' ORDER BY da.fecha ASC";
      return ejecutarConsulta($sql);
    }
    public function listarDetallesAbonoMonto($id){
        $sql="SELECT da.abono_interes,da.abono_capital FROM detalle_abono_hipoteca da 
            INNER JOIN abono_hipoteca ah ON da.idabono=ah.idabono 
            INNER JOIN hipoteca h ON ah.idhipoteca=h.idhipoteca WHERE ah.idhipoteca='$id'";
        return ejecutarConsulta($sql);
    }
    public function listarNuevaCuena(){
        $sql="SELECT h.idhipoteca,DATE(h.fecha)as fecha,cl.idpersona as idcliente,cl.nombre,g.nombre as garantia, h.tipo,h.monto,h.interes,h.moneda,h.nota 
        FROM hipoteca h 
        INNER JOIN persona cl ON h.idcliente=cl.idpersona INNER JOIN garantia g ON g.idgarantia=h.idarticulo_garantia WHERE (h.fecha) = CURRENT_DATE() AND h.estado='Aceptado'";
        return ejecutarConsulta($sql);
    }

    public  function mostrarUltimoAbono($id){
        $sql="SELECT MAX(da.interes_pendiente)as saldo FROM detalle_abono_hipoteca da 
        INNER JOIN hipoteca h ON da.idhipoteca=h.idhipoteca WHERE h.idhipoteca= '$id'";
        return ejecutarConsulta($sql);
    }

    public  function mostrarUltimoPendiente($id){
        $sql="SELECT MAX(da.interes_pendiente)as saldo 
        FROM detalle_abono_hipoteca da INNER JOIN hipoteca h ON da.idhipoteca=h.idhipoteca WHERE h.idhipoteca= '$id'";
        return ejecutarConsulta($sql);
    }

    public function muestraAbonoeInteres($id){
        $sql="SELECT da.abono_capital as capital,da.abono_interes as interes FROM detalle_abono_hipoteca da 
              WHERE da.iddetalle_abono='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }
    public function muestraSumaCapital($idhipoteca){

        $sql="SELECT SUM(sc.abono_capital)as total_abonado FROM suma_capital sc INNER JOIN detalle_abono_hipoteca da ON sc.idabono_detalle=da.iddetalle_abono 
        INNER JOIN hipoteca h ON da.idhipoteca=h.idhipoteca WHERE h.idhipoteca= '$idhipoteca' ";
        return ejecutarConsulta($sql);
        
    }
    public function idDevuelto()
    {
        $sql= "SELECT MAX(idventa) AS id FROM venta";
        return ejecutarConsulta($sql);
    }

    public function muestraAbonos($date){


        $sql="SELECT h.idhipoteca,da.iddetalle_abono as detalle,DATE(da.fecha) as fecha,cl.nombres as cliente,da.abono_capital,da.abono_interes,(da.abono_capital + da.abono_interes) as total_abonado,
        h.moneda,h.monto 
        
                        FROM hipoteca h INNER JOIN solicitud sl ON h.solicitud=sl.idsolicitud 
                        INNER JOIN cliente cl ON sl.cliente = cl.idcliente 
                        INNER JOIN usuario us ON h.idusuario=us.idusuario 
                        
                        INNER JOIN detalle_abono_hipoteca da ON da.idhipoteca=h.idhipoteca 
                WHERE h.condicion='Pendiente' AND h.estado='Aceptado' 
              ";//AND DATE(da.fecha)='$date'
        return ejecutarConsulta($sql);
    }
    public function muestraAbonosDiarios($date){


        $sql="SELECT h.idhipoteca,da.iddetalle_abono as detalle,DATE(da.fecha) as fecha,cl.nombres as cliente,da.abono_capital,da.abono_interes,(da.abono_capital + da.abono_interes) as total_abonado,
        h.moneda,h.monto 
        
                        FROM hipoteca h INNER JOIN solicitud sl ON h.solicitud=sl.idsolicitud 
                        INNER JOIN cliente cl ON sl.cliente = cl.idcliente 
                        INNER JOIN usuario us ON h.idusuario=us.idusuario 
                        
                        INNER JOIN detalle_abono_hipoteca da ON da.idhipoteca=h.idhipoteca 
                WHERE h.condicion='Pendiente' AND h.estado='Aceptado' AND DATE(da.fecha)='$date'
              ";//
        return ejecutarConsulta($sql);
    }
    public function muestratodosAbonos(){


        $sql="SELECT h.idhipoteca,da.iddetalle_abono as detalle,DATE(da.fecha) as fecha,cl.nombres as cliente,da.abono_capital,da.abono_interes,(da.abono_capital + da.abono_interes) as total_abonado,
                h.moneda,h.monto FROM hipoteca h INNER JOIN solicitud sl ON h.solicitud=sl.idsolicitud INNER JOIN cliente cl ON sl.cliente = cl.idcliente 
                INNER JOIN usuario us ON h.idusuario=us.idusuario INNER JOIN abono_hipoteca ah ON ah.idhipoteca=h.idhipoteca INNER JOIN detalle_abono_hipoteca da ON da.idabono=ah.idabono 
                WHERE h.condicion='Pendiente' AND h.estado='Aceptado'
              ";
        return ejecutarConsulta($sql);
    }
    public function muestraHipotecasLista($idcliente){
        $fecha= date('Y/m/d');

        $sql="SELECT h.idhipoteca,da.iddetalle_abono as detalle,DATE(da.fecha) as fecha,cl.nombre as cliente,da.abono_capital,da.abono_interes,(da.abono_capital + da.abono_interes) as total_abonado,h.moneda FROM hipoteca h INNER JOIN persona cl ON h.idcliente=cl.idpersona 
              INNER JOIN usuario us ON h.idusuario=us.idusuario INNER JOIN abono_hipoteca ah ON ah.idhipoteca=h.idhipoteca INNER JOIN detalle_abono_hipoteca da ON da.idabono=ah.idabono  WHERE h.condicion='Pendiente' AND h.estado='Aceptado' AND (da.fecha) = CURRENT_DATE() AND h.idcliente='$idcliente'
              ";
        return ejecutarConsulta($sql);
    }

    function eliminarDetalleAbono($iddetalle){
        $sql="DELETE FROM detalle_abono_hipoteca WHERE iddetalle_abono = '$iddetalle'";
        return ejecutarConsulta($sql);
    }
    function eliminarHipoteca($idhipoteca){
        $sql="UPDATE hipoteca SET estado='Anulado' WHERE idhipoteca='$idhipoteca'";
        return ejecutarConsulta($sql);

    }

    function getSaldoSocio($idcuenta){
        $sql="SELECT monto FROM cuentas_bancos WHERE idcuentas_bancos= '$idcuenta' ";
        return ejecutarConsulta($sql);
    }

    function cabeceraTicket($id){
        $sql="SELECT h.idhipoteca,da.iddetalle_abono as detalle,da.fecha,cl.nombres as cliente,cl.tipo_documento,cl.num_documento,h.idhipoteca as num_cuenta, da.abono_capital,da.abono_interes,(da.abono_capital + da.abono_interes) as total_abonado,h.moneda,h.monto as total_prestamo,h.no_credito
         FROM hipoteca h INNER JOIN solicitud sl ON h.solicitud=sl.idsolicitud 
         INNER JOIN cliente cl ON sl.cliente = cl.idcliente 
         INNER JOIN usuario us ON h.idusuario=us.idusuario 
         
         INNER JOIN detalle_abono_hipoteca da ON da.idhipoteca=h.idhipoteca WHERE da.iddetalle_abono = '$id'";
        return ejecutarConsulta($sql);
    }

    function abonoDetalle($id){
        $sql="SELECT h.idhipoteca,da.iddetalle_abono as detalle,da.fecha,cl.nombres as cliente,cl.tipo_documento,cl.num_documento,h.idhipoteca as num_cuenta, 
        da.abono_capital,(da.abono_interes + da.abono_interes_moratorio + da.mantenimiento_valor) as intereses,(da.abono_interes + da.abono_interes_moratorio + da.mantenimiento_valor) as total_abonado,
        h.moneda,(da.interes_pendiente) as pendiente 
        FROM hipoteca h 
        INNER JOIN solicitud sl ON h.solicitud=sl.idsolicitud 
        INNER JOIN cliente cl ON sl.cliente = cl.idcliente 
        INNER JOIN usuario us ON h.idusuario=us.idusuario 
        
        INNER JOIN detalle_abono_hipoteca da ON da.idhipoteca=h.idhipoteca 
        WHERE da.iddetalle_abono =  '$id'";
        return ejecutarConsulta($sql);
    }

    function restanteTicket($id){
        $sql="SELECT SUM(da.abono_capital) as sumaTotal, h.monto, (h.monto - SUM(da.abono_capital)) as restante ,(da.interes_pendiente) as pendiente 
         FROM hipoteca h 
         INNER JOIN solicitud sl ON h.solicitud=sl.idsolicitud
         INNER JOIN cliente cl ON sl.cliente = cl.idcliente 
         INNER JOIN usuario us ON h.idusuario=us.idusuario 
         INNER JOIN detalle_abono_hipoteca da ON da.idhipoteca=h.idhipoteca
         WHERE da.iddetalle_abono = '$id'";

        return ejecutarConsulta($sql);

    }
    function restanteTicketHipoteca($id){
        $sql="SELECT SUM(da.abono_capital) as sumaTotal, h.monto, (h.monto - SUM(da.abono_capital)) as restante ,(da.interes_pendiente) as pendiente 
         FROM hipoteca h 
         INNER JOIN solicitud sl ON h.solicitud=sl.idsolicitud
         INNER JOIN cliente cl ON sl.cliente = cl.idcliente 
         INNER JOIN usuario us ON h.idusuario=us.idusuario 
         INNER JOIN detalle_abono_hipoteca da ON da.idhipoteca=h.idhipoteca
         WHERE h.idhipoteca = '$id'";

        return ejecutarConsulta($sql);

    }

    function ticketNuevaCuenta($idhipoteca){
        $sql="SELECT h.idhipoteca,DATE(h.fecha_desembolso) as fecha_desembolso ,DATE(h.fecha_pago) as fecha_pago ,h.monto,h.interes,h.tipo,cl.nombres as cliente,cl.tipo_documento, cl.num_documento as cedula,h.mantenimiento_valor,h.moneda
         FROM hipoteca h INNER JOIN solicitud s ON h.solicitud=s.idsolicitud INNER JOIN cliente cl ON s.cliente=cl.idcliente WHERE h.idhipoteca='$idhipoteca'";
        return ejecutarConsulta($sql);
    }

    function pruebaReasignarNoCredito($solicitud){

        $sql = "SELECT no_credito,idhipoteca FROM hipoteca WHERE solicitud='$solicitud' AND estado='Aceptado'";
        return ejecutarConsulta($sql);
       
    }

    function actualizarNoCreditos($idhipotecaCredit,$credito){
        $sql = "UPDATE hipoteca SET no_credito = '$credito' WHERE idhipoteca = '$idhipotecaCredit' AND estado='Aceptado'";
        return ejecutarConsulta($sql);
    }

    function actualizarMontoSocio($idcuenta,$monto){
        $sql = "UPDATE cuentas_bancos SET monto = '$monto' WHERE idcuentas_bancos='$idcuenta'";
        return ejecutarConsulta($sql);
    }
}
?>