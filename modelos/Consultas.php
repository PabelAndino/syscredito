

<?php
require "../config/Conexion.php";

Class Consultas
{
    //Constructor y crear instancaias a la clase sin parametros y accesder a todas las funciones que aqui se encuentran
    public function __construct()
    {
    }

  public function comprasFechas($fecha_inicio,$fecha_fin)
    {
        $sql = "SELECT DATE(i.fecha_hora) as fecha, u.nombre as usuario, p.nombre as proveedor, i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado
                FROM ingreso i INNER JOIN  persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE DATE(i.fecha_hora)>= '$fecha_inicio' AND DATE(i.fecha_hora)<='$fecha_fin'";



        return ejecutarConsulta($sql);



    }

    public function ventasFechaCliente($fecha_inicio,$fecha_fin,$idcliente)
    {
        $sql = "SELECT DATE(v.fecha_hora) as fecha, u.nombre as usuario, p.nombre as cliente, v.tipo_comprobante, v.serie_comprobante, v.num_comprobante, v.total_venta,v.impuesto, v.estado FROM venta v
              INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' AND v.idcliente='$idcliente'
        
        ";
        return ejecutarConsulta($sql);
    }

    public function ventasFecha($fecha_inicio,$fecha_fin)
    {
        $sql = "SELECT DATE(v.fecha_hora) as fecha,us.nombre as usuario,cl.nombre as cliente,v.num_comprobante, a.nombre as articulo,dv.precio_compra as precioCompra,
                ((dv.cantidad * dv.precio_compra))as vendido,dv.precio_venta,dv.cantidad,dv.descuento,((dv.cantidad * dv.precio_venta)-dv.descuento)as totalVenta
                FROM detalle_venta dv INNER JOIN articulo a ON dv.idarticulo=a.idarticulo INNER JOIN venta v ON dv.idventa=v.idventa INNER JOIN persona cl ON v.idcliente=cl.idpersona
                INNER JOIN usuario us ON v.idusuario=us.idusuario
                WHERE v.tipoVenta = 'Contado' OR v.tipoVenta = 'Reparacion_Mantenimiento_Entregado' AND  DATE(v.fecha_hora)>= '$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' AND v.estado = 'Aceptado' ORDER BY v.idventa DESC";

        return ejecutarConsulta($sql);
    }



    public function totalcomprahoy()
    {
        $sql="SELECT IFNULL(SUM(total_compra),0) as total_compra FROM ingreso WHERE DATE(fecha_hora)=curdate()";
        return ejecutarConsulta($sql);
    }

    public function totalventahoy()
    {
        $sql="SELECT IFNULL(SUM(total_venta),0) as total_venta FROM venta WHERE DATE(fecha_hora)=curdate()";
        return ejecutarConsulta($sql);
    }

    public function comprasultimos_10dias()
    {
        $sql="SELECT CONCAT(DAY(fecha_hora),'-',MONTH(fecha_hora)) as fecha,SUM(total_compra) as total FROM ingreso GROUP by fecha_hora ORDER BY fecha_hora DESC limit 0,10";
        return ejecutarConsulta($sql);
    }

    public function ventasultimos_12meses()
    {
        $sql="SELECT DATE_FORMAT(fecha_hora,'%M') as fecha,SUM(total_venta) as total FROM venta GROUP by MONTH(fecha_hora) ORDER BY fecha_hora DESC limit 0,10";
        return ejecutarConsulta($sql);
    }

}
?>
