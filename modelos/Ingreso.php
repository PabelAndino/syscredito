<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Ingreso
{
    //Implementamos nuestro constructor
    public function __construct()
    {

    }

    //Implementamos un método para insertar registros
    public function insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,
                             $total_compra,$idarticulo,$cantidad,$costoU,$ivaU,$ivaST,$porcentajeVenta,$precioVenta)
    {
        $sql="INSERT INTO ingreso (idproveedor,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_compra,estado)
        VALUES ('$idproveedor','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_compra','Aceptado')";
        //return ejecutarConsulta($sql);
        $idingresonew=ejecutarConsulta_retornarID($sql);

        $num_elementos=0;
        $sw=true;

        while ($num_elementos < count($cantidad))//mientras hayan articulos que se ejecute esta sentencia
        {
            $sql_detalle = "INSERT INTO detalle_ingreso(idingreso,cantidad,idarticulo,costoU,ivaU,ivaST,porcentajeVenta,precioVenta,estado) VALUES 
                            ('$idingresonew','$cantidad[$num_elementos]','$idarticulo[$num_elementos]','$costoU[$num_elementos]','$ivaU[$num_elementos]','$ivaST[$num_elementos]',
                                                        '$porcentajeVenta[$num_elementos]','$precioVenta[$num_elementos]','Aceptado')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
        }

        return $sw;
    }


    //Implementamos un método para anular categorías
    public function anular($idingreso)
    {
        $sql="UPDATE ingreso SET estado='Anulado' WHERE idingreso='$idingreso'";
        return ejecutarConsulta($sql);
    }




    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idingreso)
    {
        $sql="SELECT i.idingreso,DATE(i.fecha_hora) as fecha,i.idproveedor,p.nombre as proveedor,u.idusuario,u.nombre as usuario,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE i.idingreso='$idingreso'";
        return ejecutarConsultaSimpleFila($sql);
    }


    public function listarDetalles($idingreso)
    {
        $sql="SELECT di.idingreso,di.cantidad,a.nombre,di.costoU,di.ivaU,di.ivaST,di.porcentajeVenta,di.precioVenta 
              FROM detalle_ingreso di INNER JOIN articulo a on di.idarticulo=a.idarticulo WHERE di.idingreso = '$idingreso' ";

        return ejecutarConsulta($sql);
    }

    public function listarDetalle($idingreso)
    {
        $sql="SELECT di.idingreso,di.idarticulo,a.nombre,di.cantidad,di.precio_compra,di.precio_venta
              FROM detalle_ingreso di inner join articulo a on di.idarticulo=a.idarticulo where di.idingreso='$idingreso'";
        return ejecutarConsulta($sql);
    }

    //Implementar un método para listar los registros
    public function listar()
    {
        $sql="SELECT i.idingreso,DATE(i.fecha_hora) as fecha,i.idproveedor,p.nombre as proveedor,u.idusuario,u.nombre as usuario,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario  ORDER BY i.idingreso desc";
        return ejecutarConsulta($sql);
    }

}



?>