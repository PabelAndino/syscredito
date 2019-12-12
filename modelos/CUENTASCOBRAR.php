
<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class CUENTASCOBRAR
{
    //Implementamos nuestro constructor
    public function __construct()
    {

    }


    public function listarH(){
        $sql = "SELECT h.idhipoteca,cl.nombres,h.fecha_desembolso,h.fecha_pago,h.monto,h.interes,h.mantenimiento_valor as mantenimiento, h.interes_moratorio,h.plazo,h.moneda,h.nota 
                FROM hipoteca h INNER JOIN solicitud sl ON h.solicitud=sl.idsolicitud INNER JOIN cliente cl ON sl.cliente=cl.idcliente  	
                WHERE h.estado = 'Aceptado' AND h.condicion = 'Pendiente'";
        return ejecutarConsulta($sql);
    }
    public function listarAbonos($fechadesde,$fechashasta){
        $sql = "SELECT dt.idhipoteca,cl.nombres,dt.fecha,dt.abono_capital,dt.abono_interes,dt.mantenimiento_valor as mantenimiento,dt.abono_interes_moratorio as moratorio,dt.interes_pendiente,dt.nota,h.moneda 
        FROM detalle_abono_hipoteca dt INNER JOIN hipoteca h ON dt.idhipoteca=h.idhipoteca INNER JOIN solicitud sl ON h.solicitud=sl.idsolicitud INNER JOIN cliente cl ON sl.cliente=cl.idcliente 
        WHERE (dt.fecha BETWEEN '$fechadesde' AND '$fechashasta') ORDER BY dt.fecha DESC";
        return ejecutarConsulta($sql);
    }


}

?>