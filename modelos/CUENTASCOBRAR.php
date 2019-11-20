
<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class CUENTASCOBRAR
{
    //Implementamos nuestro constructor
    public function __construct()
    {

    }



    //Implementar un método para listar los registros
    public function listarcch()//cuentas por cobrar Hipoteca
    {
        $sql="SELECT cl.idpersona as id,h.idhipoteca,h.monto, cl.nombre as cliente,cl.telefono,cl.num_documento,cl.direccion,da.abono_capital, da.abono_interes,h.moneda,MAX(DATE(da.fecha)) as fecha,DATE(h.fecha) as dia_pago FROM hipoteca h INNER JOIN persona cl ON h.idcliente=cl.idpersona INNER JOIN usuario us ON h.idusuario=us.idusuario INNER JOIN abono_hipoteca ah ON ah.idhipoteca=h.idhipoteca
              INNER JOIN detalle_abono_hipoteca da ON da.idabono=ah.idabono WHERE h.estado='Aceptado' AND h.condicion='Pendiente' GROUP BY cl.idpersona ";
        return ejecutarConsulta($sql);
    }
    public function listarccf()//cuentas por cobrar Financiamiento
    {
        $sql="SELECT cl.idpersona as id,cl.nombre as cliente,cs.nombre as casa,da.abono_capital,da.abono_interes,f.moneda,f.articulo as concepto,MAX(DATE(da.fecha))as fecha,DATE(f.fecha)as dia_pago 
              FROM financiamiento f INNER JOIN persona cl ON f.idcliente=cl.idpersona INNER JOIN usuario us ON f.idusuario=us.idusuario INNER JOIN persona cs ON cs.idpersona=f.casacomercial 
              INNER JOIN abono_financiamiento af ON af.idfinanciamiento=f.idfinanciamiento INNER JOIN detalle_abono_financiamiento da ON da.idabonofinanciamiento=af.idabonofinanciamiento WHERE f.estado='Aceptado' AND f.condicion='Pendiente' GROUP BY cl.idpersona ";
        return ejecutarConsulta($sql);
    }
    public function listarccs()//cuentas por cobrar Solares
    {
        $sql="SELECT cl.idpersona,cl.nombre as cliente,s.plazo,s.prima,da.abono_capital,da.abono_interes,s.moneda,s.detalles,MAX(DATE(da.fecha))as fecha,s.fecha as dia_pago
              FROM solares s INNER JOIN persona cl ON cl.idpersona=s.idcliente INNER JOIN abono_solares asol ON asol.idsolares=s.idsolares INNER JOIN detalle_abono_solares da
              ON da.idabonosolares=asol.idabonosolares WHERE s.estado='Aceptado' AND s.condicion='Pendiente' GROUP BY cl.idpersona ";
        return ejecutarConsulta($sql);
    }



    public function listarnch(){//listar nueva cuenta Hipoteca
        $sql="SELECT cl.nombre as cliente,h.monto,h.interes,h.moneda,h.tipo,DATE(h.fecha) as fecha_prestamo,DATE(DATE_ADD(h.fecha,INTERVAL 1 MONTH)) as siguienteFecha,h.estado FROM hipoteca h INNER JOIN nuevacuenta_hipoteca nc ON nc.nidhipoteca=h.idhipoteca 
              INNER JOIN persona cl ON cl.idpersona=h.idcliente WHERE nc.estado='sin_abonar' AND h.condicion='Pendiente'";
        return ejecutarConsulta($sql);
    }
    public function listarncf(){//listar nueva cuenta Hipoteca
        $sql="SELECT cl.nombre as cliente,cs.nombre as casa,f.monto,f.interes,f.moneda,f.articulo as concepto,DATE(f.fecha)as fecha, DATE(DATE_ADD(f.fecha,INTERVAL 1 MONTH)) as siguienteFecha 
              FROM financiamiento f INNER JOIN nuevacuenta_financiamiento nc ON nc.nidfinanciamiento=f.idfinanciamiento INNER JOIN persona cl ON cl.idpersona=f.idcliente 
              INNER JOIN persona cs ON cs.idpersona=f.casacomercial WHERE nc.estado='sin_abonar' AND f.condicion='Pendiente'";
        return ejecutarConsulta($sql);
    }
    public function listarncs(){//listar nueva cuenta Hipoteca
        $sql="SELECT cl.idpersona,cl.nombre as cliente,s.plazo,s.prima,s.monto,s.interes,s.moneda,s.detalles,DATE(s.fecha)as fecha,DATE(DATE_ADD(s.fecha,INTERVAL 1 MONTH)) as siguienteFecha 
              FROM solares s INNER JOIN persona cl ON cl.idpersona=s.idcliente INNER JOIN nuevacuenta_solares ns ON ns.nidsolares=s.idsolares WHERE ns.estado='sin_abonar' AND s.condicion='Pendiente'";
        return ejecutarConsulta($sql);
    }

    public function listarDetallesAbonoh($id){
        $sql="SELECT  da.iddetalle_abono as iddetalle,DATE(da.fecha) as fecha,da.nota as nota,da.abono_interes,da.abono_capital,h.moneda FROM hipoteca h 
              INNER JOIN abono_hipoteca ah ON ah.idhipoteca=h.idhipoteca INNER JOIN detalle_abono_hipoteca da ON da.idabono=ah.idabono WHERE h.idhipoteca='$id' ORDER BY da.fecha ASC";
        return ejecutarConsulta($sql);
    }

}

?>