
<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Solares
{
    //Implementamos nuestro constructor
    //Implementamos nuestro constructor
    public function __construct()
    {

    }

    //Implementamos un método para insertar registros


    public function insertarSolares($idusuario,$cliente,$detalles,$fecha,$monto,$interes,$prima,$plazo,$moneda){
        $sql="INSERT INTO solares(idusuario,idcliente,detalles,fecha,monto,interes,prima,plazo,moneda,condicion,estado)
              VALUES ('$idusuario','$cliente','$detalles','$fecha','$monto','$interes','$prima','$plazo','$moneda','Pendiente','Aceptado')";

        $idsolares= ejecutarConsulta_retornarID($sql);
        $sqlncuenta="INSERT INTO nuevacuenta_solares(nidsolares,estado)VALUES('$idsolares','sin_abonar')";

        return ejecutarConsulta($sqlncuenta);
    }

    public function insertarAbonoSolares($idsolares,$fecha,$num_comprobante,$capital,$interes,$nota){
        $sql="INSERT INTO abono_solares(idsolares,fecha,num_comprobante,estado) VALUES ('$idsolares','$fecha','$num_comprobante','Pendiente')";
        $idabononew=ejecutarConsulta_retornarID($sql);

        $sw=true;
        $sql_detalle = "INSERT INTO detalle_abono_solares(idabonosolares,fecha,abono_capital,abono_interes,nota) VALUES('$idabononew','$fecha','$capital','$interes','$nota')";
        $iddetalle=ejecutarConsulta_retornarID($sql_detalle);

        $sql_sumacapital="INSERT INTO suma_capital_solares(idabono_detallesolares,abono_capital) VALUES('$iddetalle','$capital')";
        ejecutarConsulta($sql_sumacapital)or $sw = false;

        $this->actualizar_ncuenta($idsolares);
        return $sw;

    }
    public function actualizar_ncuenta($idsolares){
        $sqlupdate_ncuenta="UPDATE nuevacuenta_solares SET estado='abonado' WHERE nidsolares='$idsolares'";
        return  ejecutarConsulta($sqlupdate_ncuenta);
    }
    function insertarDetalleAbono($idabono,$fecha,$capital,$interes){ //La funcion se llama cuando ya se realizo un primer abono, ya no es necesario ingresar
        // mas abonos, solo los detalles del mismo
        $sql = "INSERT INTO detalle_abono_solares(idabono,fecha,abono_capital,abono_interes) VALUES('$idabono','$fecha','$capital','$interes')";
        return ejecutarConsulta($sql);
    }

    function editarAbono($iddetalle,$fecha,$capital,$interes,$nota){

        $sql="UPDATE detalle_abono_solares SET fecha='$fecha', abono_capital='$capital',abono_interes='$interes',nota='$nota' WHERE iddetalle_abono_solares='$iddetalle'" ;
       $rpsta= $this->editarAbonoSumaCapital($iddetalle,$capital) ;

       echo $rpsta ? "---Se edito La suma al capital Correctamente---"  : "----NO SE EDITO LA SUMA AL CAPITAL!!!----";
      return ejecutarConsulta($sql);
    }

    function editarAbonoSumaCapital($iddetalle,$capital){
        $sql="UPDATE suma_capital_solares SET  abono_capital='$capital' WHERE idabono_detallesolares='$iddetalle'" ;
        return ejecutarConsulta($sql);
    }

    function eliminarDetalleAbono($iddetalle){
        $sql="DELETE FROM detalle_abono_solares WHERE iddetalle_abono_solares = '$iddetalle'";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para anular la venta
    public function anular($idventa)
    {
        $sql="UPDATE venta SET estado='Anulado' WHERE idventa='$idventa'";

        return ejecutarConsulta($sql);
    }

    public function anularDetalle($idventa)
    {
        $sql="UPDATE venta SET estado='Anulado' WHERE idventa='$idventa'";

        return ejecutarConsulta($sql);
    }

    public  function sumarNumeroFactura()
    {

        $sql = "SELECT (max(num_comprobante)+1) as num_comprobante FROM venta ";
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
            FROM garantia  ORDER BY idgarantia DESC";
        return ejecutarConsulta($sql);
    }

    public function buscarClientesAbono(){
        $sql = "SELECT DISTINCT per.idpersona,per.nombre,per.num_documento FROM solares s 
                INNER JOIN persona per ON s.idcliente=per.idpersona WHERE s.estado = 'Aceptado' AND s.condicion = 'Pendiente'";

        return ejecutarConsulta($sql);
    }
    public  function mostrarCuentasAbono($id){
        $sql="SELECT idsolares,DATE(fecha)as fecha,prima,monto,interes,detalles,plazo,moneda FROM solares 
              WHERE condicion='Pendiente' AND estado='Aceptado' AND idcliente = '$id'";
        return ejecutarConsulta($sql);
    }
    public function listarDetalleCuenta($idsolares){
        $sql="SELECT s.idsolares,DATE(s.fecha)as fecha,p.nombre as cliente,s.prima,s.monto, s.interes,s.detalles,s.moneda 
              FROM solares s INNER JOIN persona p ON s.idcliente=p.idpersona WHERE s.idsolares='$idsolares'";
        return ejecutarConsulta($sql);
    }
    public function listarDetallesAbono($idsolares){
        $sql="SELECT  da.iddetalle_abono_solares as iddetalle ,DATE(da.fecha)as fecha,da.nota,da.abono_interes,da.abono_capital,s.moneda FROM detalle_abono_solares da 
              INNER JOIN abono_solares asol ON da.idabonosolares=asol.idabonosolares INNER JOIN solares s ON asol.idsolares=s.idsolares WHERE s.idsolares= '$idsolares'      ORDER BY da.fecha ASC";
        return ejecutarConsulta($sql);
    }
    public function listarDetallesAbonoMonto($id){
        $sql="SELECT da.abono_interes,da.abono_capital FROM detalle_abono_hipoteca da 
            INNER JOIN abono_hipoteca ah ON da.idabono=ah.idabono 
            INNER JOIN hipoteca h ON ah.idhipoteca=h.idhipoteca WHERE ah.idhipoteca='$id'";
        return ejecutarConsulta($sql);
    }
    public  function mostrarUltimoAbono($id){
        $sql="SELECT MAX(da.iddetalle_abono_solares)as id FROM detalle_abono_solares da INNER JOIN abono_solares asol ON da.idabonosolares=asol.idabonosolares 
              INNER JOIN solares s ON asol.idsolares=s.idsolares WHERE s.idsolares='$id'";
        return ejecutarConsulta($sql);
    }

    public function muestraAbonoeInteres($id){
        $sql="SELECT da.abono_capital as capital,da.abono_interes as interes FROM detalle_abono_hipoteca da 
              WHERE da.iddetalle_abono='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }
    public function muestraSumaCapital($idsolares){
        $sql="SELECT SUM(scs.abono_capital)as total_abonado FROM suma_capital_solares as scs INNER JOIN detalle_abono_solares da ON scs.idabono_detallesolares=da.iddetalle_abono_solares 
              INNER JOIN abono_solares asol ON da.idabonosolares=asol.idabonosolares INNER JOIN solares s ON s.idsolares=asol.idsolares WHERE s.idsolares='$idsolares' ";
        return ejecutarConsulta($sql);
    }


    public  function cuentaAbono($idsolares){
        $sql="SELECT COUNT(ds.abono_interes) FROM detalle_abono_solares ds INNER JOIN abono_solares abs ON ds.idabonosolares =abs.idabonosolares 
              INNER JOIN solares s ON abs.idsolares=s.idsolares WHERE s.idsolares='$idsolares'";
        return ejecutarConsulta($sql);
    }
    public function obtienePrima($idsolares){
        $sql="SELECT s.prima FROM solares s WHERE s.idsolares='$idsolares'";
        return ejecutarConsulta($sql);
    }
    public function listarNuevaCuenta(){

        $sql="SELECT s.idsolares,DATE(s.fecha) as fecha,cl.num_documento as cedula,cl.nombre as cliente,s.plazo,s.monto,s.interes,s.moneda,s.detalles 
              FROM solares s INNER JOIN persona cl ON cl.idpersona=s.idcliente WHERE (s.fecha) = CURRENT_DATE() AND s.estado='Aceptado'";
        return ejecutarConsulta($sql);
    }

    public function eliminarSolares($idsolares){
        $sql="UPDATE solares SET estado='Cancelado' WHERE idsolares='$idsolares'";
        return ejecutarConsulta($sql);
    }

    public function ticketNuevaCuenta($idsolares){
        $sql="SELECT s.idsolares,DATE(s.fecha)as fecha,DATE(DATE_ADD(s.fecha,INTERVAL 1 MONTH)) as siguienteFecha,s.monto,s.interes,s.detalles as articulo,cl.nombre as cliente,cl.tipo_documento,cl.num_documento as cedula,s.moneda  
              FROM solares s INNER JOIN persona cl ON cl.idpersona=s.idcliente WHERE s.idsolares='$idsolares'";
        return ejecutarConsulta($sql);
    }
    function cabeceraTicket($idsolares){
        $sql=" SELECT s.idsolares,asol.idabonosolares as detalle,DATE(da.fecha)as fecha,cl.nombre as cliente,cl.tipo_documento,cl.num_documento ,s.idsolares as num_cuenta, da.abono_capital,da.abono_interes,(da.abono_capital + da.abono_interes) as total_abonado, s.moneda, s.monto as total_prestamo FROM solares s INNER JOIN persona cl ON cl.idpersona=s.idcliente INNER JOIN usuario us ON us.idusuario=s.idusuario 
                INNER JOIN abono_solares asol ON asol.idsolares=s.idsolares INNER JOIN detalle_abono_solares da ON da.idabonosolares=asol.idabonosolares WHERE da.iddetalle_abono_solares = '$idsolares'";
        return ejecutarConsulta($sql);
    }

    function restanteTicket($iddetalle){
        $sql="SELECT SUM(da.abono_capital),s.monto,((s.monto - s.prima )- (SUM(da.abono_capital)) ) as restante,s.prima FROM solares s INNER JOIN persona cl ON cl.idpersona=s.idcliente INNER JOIN usuario us ON us.idusuario=s.idusuario  
              INNER JOIN abono_solares asol ON asol.idsolares=s.idsolares INNER JOIN detalle_abono_solares da ON da.idabonosolares=asol.idabonosolares WHERE da.iddetalle_abono_solares = '$iddetalle'";

        return ejecutarConsulta($sql);

    }
    public function idDevuelto()
    {
        $sql= "SELECT MAX(idventa) AS id FROM venta";
        return ejecutarConsulta($sql);
    }

    function abonoDetalle($id){
        $sql="SELECT s.idsolares,asol.idabonosolares as detalle, DATE(da.fecha)as fecha,cl.nombre as cliente,cl.tipo_documento,cl.num_documento,s.idsolares as num_cuenta, da.abono_capital,da.abono_interes,(da.abono_capital + da.abono_interes) as total_abonado,
              s.moneda FROM solares s INNER JOIN persona cl ON cl.idpersona=s.idcliente INNER JOIN usuario us ON us.idusuario=s.idusuario
              INNER JOIN abono_solares asol ON asol.idsolares=s.idsolares INNER JOIN detalle_abono_solares da ON da.idabonosolares=asol.idabonosolares 
              WHERE da.iddetalle_abono_solares = '$id'";
        return ejecutarConsulta($sql);
    }

    public function muestraAbonosdelDia(){
        $fecha= date('y-m-d');

        $sql="SELECT s.idsolares,da.iddetalle_abono_solares as detalle,DATE(da.fecha)as fecha,cl.nombre as cliente,da.abono_capital,da.abono_interes,(da.abono_capital + da.abono_interes) as total_abonado,s.moneda,s.monto FROM solares s INNER JOIN persona cl ON cl.idpersona=s.idcliente INNER JOIN usuario us ON us.idusuario=s.idusuario 
              INNER JOIN abono_solares asol ON asol.idsolares=s.idsolares INNER JOIN detalle_abono_solares da ON da.idabonosolares=asol.idabonosolares 
              WHERE s.condicion='Pendiente' AND s.estado='Aceptado' AND DATE(da.fecha)='$fecha'
              ";
        return ejecutarConsulta($sql);
    }
}
?>