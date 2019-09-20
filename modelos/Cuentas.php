
<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Cuentas
{
    //Implementamos nuestro constructor
    public function __construct()
    {

    }

    //Implementamos un método para insertar registros
   

   

    //Implementamos un método para desactivar registros
    public function pagarCuenta($idhipoteca)
    {
        $sql="UPDATE hipoteca SET condicion='Pagado' WHERE idhipoteca='$idhipoteca'";
        return ejecutarConsulta($sql);
    }

    public function eliminarCuenta($idhipoteca)
    {
        $sql="UPDATE hipoteca SET estado='Cancelado' WHERE idhipoteca='$idhipoteca'";
        return ejecutarConsulta($sql);
    }

    public function restaurarCuenta($idhipoteca)
    {
        $sql="UPDATE hipoteca SET estado='Aceptado' WHERE idhipoteca='$idhipoteca'";
        return ejecutarConsulta($sql);
    }

    public function volver($idhipoteca){
        $sql="UPDATE hipoteca SET condicion='Pendiente' WHERE idhipoteca='$idhipoteca'";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para activar registros
    public function activar($idarticulo)
    {
        $sql="UPDATE articulo SET condicion='1' WHERE idarticulo='$idarticulo'";
        return ejecutarConsulta($sql);
    }

    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idarticulo)
    {
        $sql="SELECT * FROM articulo WHERE idarticulo='$idarticulo'";
        return ejecutarConsultaSimpleFila($sql);
    }

    //Implementar un método para listar los registros
    public function listar()
    {
        $sql="SELECT h.idhipoteca,h.fecha_desembolso,h.fecha_pago,h.monto,h.interes,h.interes_moratorio,h.tipo,h.moneda,h.plazo,cl.nombres,cl.num_documento,h.condicion,h.estado 
              FROM hipoteca h INNER JOIN solicitud s ON h.solicitud = s.idsolicitud INNER JOIN cliente cl ON s.cliente=cl.idcliente ";
        return ejecutarConsulta($sql);
    }

    public function listarCuentaDia()
    {
        $sql="SELECT h.idhipoteca,h.fecha_desembolso,h.fecha_pago,h.monto,h.interes,h.interes_moratorio,h.tipo,h.moneda,h.plazo,cl.nombres,cl.num_documento,h.condicion,h.estado 
              FROM hipoteca h INNER JOIN solicitud s ON h.solicitud = s.idsolicitud INNER JOIN cliente cl ON s.cliente=cl.idcliente ";
        return ejecutarConsulta($sql);
    }

    
}

?>