
<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Financiamiento
{
    //Implementamos nuestro constructor
    public function __construct()
    {

    }

    //Implementamos un método para insertar registros


    public function insertarFinanciamiento($idusuario,$cliente,$articulo,$casa,$fecha,$monto,$interes,$moneda){
        $sql="INSERT INTO financiamiento(idusuario,idcliente,articulo,casacomercial,fecha,monto,interes,moneda,condicion,estado)
              VALUES ('$idusuario','$cliente','$articulo','$casa','$fecha','$monto','$interes','$moneda','Pendiente','Aceptado')";

        $idfinanciamiento= ejecutarConsulta_retornarID($sql);

        $sqlncuenta="INSERT INTO nuevacuenta_financiamiento(nidfinanciamiento,estado)VALUES('$idfinanciamiento','sin_abonar')";

        return ejecutarConsulta($sqlncuenta);
    }
    public function insertarAbonoFinanciamiento($idfinanciamiento,$fecha,$num_comprobante,$capital,$interes,$nota){
        $sql="INSERT INTO abono_financiamiento(idfinanciamiento,fecha,num_comprobante,estado) VALUES ('$idfinanciamiento','$fecha','$num_comprobante','Pendiente')";
        $idabononew=ejecutarConsulta_retornarID($sql);

        $sw=true;
        $sql_detalle = "INSERT INTO detalle_abono_financiamiento(idabonofinanciamiento,fecha,abono_capital,abono_interes,nota) VALUES('$idabononew','$fecha','$capital','$interes','$nota')";
        $iddetalle=ejecutarConsulta_retornarID($sql_detalle);

        $sql_sumacapital="INSERT INTO suma_capital_financiamiento(idabono_detallefinanciamiento,abono_capital) VALUES('$iddetalle','$capital')";
        ejecutarConsulta($sql_sumacapital)or $sw = false;

        $this->actualizar_ncuenta($idfinanciamiento);

        return $sw;

    }

    public function actualizar_ncuenta($idfinanciamiento){
        $sqlupdate_ncuenta="UPDATE nuevacuenta_financiamiento SET estado='abonado' WHERE nidfinanciamiento='$idfinanciamiento'";
        return  ejecutarConsulta($sqlupdate_ncuenta);
    }
    function insertarDetalleAbono($idabono,$fecha,$capital,$interes){ //La funcion se llama cuando ya se realizo un primer abono, ya no es necesario ingresar
        // mas abonos, solo los detalles del mismo
        $sql = "INSERT INTO detalle_abono_hipoteca(idabono,fecha,abono_capital,abono_interes) VALUES('$idabono','$fecha','$capital','$interes')";
        return ejecutarConsulta($sql);
    }

    function editarAbono($iddetalle,$fecha,$capital,$interes,$nota){

        $sql="UPDATE detalle_abono_financiamiento SET fecha='$fecha', abono_capital='$capital',abono_interes='$interes',nota='$nota' WHERE iddetalle_abono_financiamiento='$iddetalle'" ;
        $rpsta= $this->editarAbonoSumaCapital($iddetalle,$capital) ;

        echo $rpsta ? "---Se edito La suma al capital Correctamente---"  : "----NO SE EDITO LA SUMA AL CAPITAL!!!----";
        return ejecutarConsulta($sql);

    }


    function editarAbonoSumaCapital($iddetalle,$capital){
        $sql="UPDATE suma_capital_financiamiento SET  abono_capital='$capital' WHERE idabono_detallefinanciamiento='$iddetalle'" ;
        return ejecutarConsulta($sql);
    }

    function eliminarDetalleAbono($iddetalle){
        $sql="DELETE FROM detalle_abono_financiamiento WHERE iddetalle_abono_financiamiento = '$iddetalle'";
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

    public function listarNuevaCuenta(){
        $sql="SELECT f.idfinanciamiento,DATE(f.fecha)as fecha,p.num_documento as cedula,p.nombre as cliente,f.articulo,cs.nombre as casa,f.monto,f.interes,f.moneda 
              FROM financiamiento f INNER JOIN persona p ON p.idpersona=f.idcliente INNER JOIN persona cs ON cs.idpersona=f.casacomercial WHERE (f.fecha) = CURRENT_DATE() AND f.estado='Aceptado'";
        return ejecutarConsulta($sql);
    }
    public function ticketNuevaCuenta($idfinanciamiento){
        $sql="SELECT f.idfinanciamiento,DATE(f.fecha)as fecha,DATE(DATE_ADD(f.fecha,INTERVAL 1 MONTH)) as siguienteFecha,f.monto,f.interes,f.articulo,cl.nombre as cliente,cl.tipo_documento,cl.num_documento as cedula,f.moneda 
              FROM financiamiento f INNER JOIN persona cl ON cl.idpersona=f.idcliente WHERE f.idfinanciamiento='$idfinanciamiento'";
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
        $sql = "SELECT DISTINCT per.idpersona,per.nombre,per.num_documento FROM financiamiento f 
                INNER JOIN persona per ON f.idcliente=per.idpersona WHERE f.estado = 'Aceptado' AND f.condicion = 'Pendiente'";

        return ejecutarConsulta($sql);
    }
    public  function mostrarCuentasAbono($id){
        $sql="SELECT idfinanciamiento,DATE(fecha)as fecha,monto,interes,moneda FROM financiamiento WHERE condicion='Pendiente' AND estado='Aceptado' AND idcliente = '$id'";
        return ejecutarConsulta($sql);
    }


    public function listarDetalleCuenta($idfinanciamiento){
        $sql="SELECT f.idfinanciamiento,DATE(f.fecha)as fecha,p.nombre as cliente,f.articulo,f.monto,f.interes,f.moneda FROM financiamiento f 
              INNER JOIN persona p ON f.idcliente=p.idpersona WHERE f.idfinanciamiento='$idfinanciamiento'";
        return ejecutarConsulta($sql);
    }
    public function listarDetallesAbono($idfinanciamiento){
        $sql="SELECT da.iddetalle_abono_financiamiento as iddetalle,DATE(da.fecha)as fecha,da.nota,da.abono_interes,da.abono_capital,f.moneda FROM detalle_abono_financiamiento da INNER JOIN abono_financiamiento af ON da.idabonofinanciamiento=af.idabonofinanciamiento 
              INNER JOIN financiamiento f ON af.idfinanciamiento=f.idfinanciamiento WHERE af.idfinanciamiento='$idfinanciamiento' ORDER BY da.fecha ASC";
        return ejecutarConsulta($sql);
    }
    public function listarDetallesAbonoMonto($id){
        $sql="SELECT da.abono_interes,da.abono_capital FROM detalle_abono_hipoteca da 
            INNER JOIN abono_hipoteca ah ON da.idabono=ah.idabono 
            INNER JOIN hipoteca h ON ah.idhipoteca=h.idhipoteca WHERE ah.idhipoteca='$id'";
        return ejecutarConsulta($sql);
    }
    public  function mostrarUltimoAbono($id){
        $sql="SELECT MAX(da.iddetalle_abono)as id FROM detalle_abono_hipoteca da INNER JOIN abono_hipoteca hp ON da.idabono=hp.idabono 
              INNER JOIN hipoteca h ON hp.idhipoteca=h.idhipoteca WHERE h.idhipoteca='$id'";
        return ejecutarConsulta($sql);
    }

    public function muestraAbonoeInteres($id){
        $sql="SELECT da.abono_capital as capital,da.abono_interes as interes FROM detalle_abono_hipoteca da 
              WHERE da.iddetalle_abono='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }
    public function muestraSumaCapital($idfinanciamiento){
        $sql="SELECT SUM(scf.abono_capital)as total_abonado FROM suma_capital_financiamiento scf INNER JOIN detalle_abono_financiamiento da ON scf.idabono_detallefinanciamiento=da.iddetalle_abono_financiamiento 
              INNER JOIN abono_financiamiento af ON da.idabonofinanciamiento=af.idabonofinanciamiento INNER JOIN financiamiento f ON af.idfinanciamiento=f.idfinanciamiento WHERE f.idfinanciamiento='$idfinanciamiento' ";
        return ejecutarConsulta($sql);
    }
    public function idDevuelto()
    {
        $sql= "SELECT MAX(idventa) AS id FROM venta";
        return ejecutarConsulta($sql);
    }

    function cabeceraTicket($iddetalleabono){
        $sql="SELECT f.idfinanciamiento, af.idabonofinanciamiento as detalle,DATE(da.fecha)as fecha,cl.nombre as cliente,cl.tipo_documento,cl.num_documento,f.idfinanciamiento as num_cuenta,da.abono_capital,da.abono_interes,(da.abono_capital + da.abono_interes) 
              as total_abonado,f.moneda, f.monto as total_prestamo FROM financiamiento f INNER JOIN persona cl ON cl.idpersona=f.idcliente INNER JOIN usuario us ON us.idusuario=f.idusuario INNER JOIN abono_financiamiento af 
              ON af.idfinanciamiento=f.idfinanciamiento INNER JOIN detalle_abono_financiamiento da ON da.idabonofinanciamiento=af.idabonofinanciamiento WHERE da.iddetalle_abono_financiamiento = '$iddetalleabono'";
        return ejecutarConsulta($sql);
    }

    function restanteTicket($iddetalle){
        $sql="SELECT SUM(da.abono_capital),f.monto,(f.monto -SUM(da.abono_capital)) as restante FROM financiamiento f INNER JOIN persona cl ON cl.idpersona=f.idcliente INNER JOIN usuario us ON us.idusuario=f.idusuario INNER JOIN abono_financiamiento af 
              ON af.idfinanciamiento=f.idfinanciamiento INNER JOIN detalle_abono_financiamiento da ON da.idabonofinanciamiento=af.idabonofinanciamiento WHERE da.iddetalle_abono_financiamiento = '$iddetalle'";

        return ejecutarConsulta($sql);

    }

    function abonoDetalle($id){
        $sql="SELECT f.idfinanciamiento, af.idabonofinanciamiento as detalle,DATE(da.fecha)as fecha,cl.nombre as cliente,cl.tipo_documento,cl.num_documento,f.idfinanciamiento as num_cuenta,da.abono_capital,da.abono_interes,(da.abono_capital + da.abono_interes) 
              as total_abonado,f.moneda  FROM financiamiento f INNER JOIN persona cl ON cl.idpersona=f.idcliente INNER JOIN usuario us ON us.idusuario=f.idusuario INNER JOIN abono_financiamiento af 
              ON af.idfinanciamiento=f.idfinanciamiento INNER JOIN detalle_abono_financiamiento da ON da.idabonofinanciamiento=af.idabonofinanciamiento WHERE da.iddetalle_abono_financiamiento = '$id'";
        return ejecutarConsulta($sql);
    }

    public function eliminarFinanciamiento($idfinanciamiento){
        $sql="UPDATE financiamiento SET estado='Cancelado' WHERE idfinanciamiento='$idfinanciamiento'";
        return ejecutarConsulta($sql);
    }

    public function muestraAbonosdelDia(){
        $fecha= date('y-m-d');

        $sql="SELECT f.idfinanciamiento,da.iddetalle_abono_financiamiento as detalle,DATE(da.fecha)as fecha,cl.nombre as cliente,da.abono_capital,da.abono_interes,(da.abono_capital + da.abono_interes) as total_abonado,f.moneda,f.monto FROM financiamiento f 
              INNER JOIN persona cl ON cl.idpersona=f.idcliente INNER JOIN usuario us ON us.idusuario=f.idusuario INNER JOIN abono_financiamiento af ON af.idfinanciamiento=f.idfinanciamiento INNER JOIN detalle_abono_financiamiento da ON da.idabonofinanciamiento=af.idabonofinanciamiento 
              WHERE f.condicion='Pendiente' AND f.estado='Aceptado' AND DATE(da.fecha)='$fecha'
              ";
        return ejecutarConsulta($sql);
    }


}
?>