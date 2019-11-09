
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
    public function pagarCuenta($idhipoteca,$idgarantia)
    {
        $sql="UPDATE hipoteca SET condicion='Pagado' WHERE idhipoteca='$idhipoteca'";
        

         $respuesta = ejecutarConsulta($sql) ;
         if($respuesta){
             $this->entregarGarantia($idgarantia);
             return $respuesta;
         }else{
             return $respuesta;
         }

    }

    private function entregarGarantia($idgarantia){
        $sql = "UPDATE garantia SET condicion = 'Entregado' WHERE idgarantia = '$idgarantia' ";
        return ejecutarConsulta($sql);
    }
    private function regresarGarantia($idgarantia){
        $sql = "UPDATE garantia SET condicion = 'Pendiente' WHERE idgarantia = '$idgarantia' ";
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

    public function volver($idhipoteca,$idgarantia){
        $sql="UPDATE hipoteca SET condicion='Pendiente' WHERE idhipoteca='$idhipoteca'";
        $respuesta = ejecutarConsulta($sql) ;
         if($respuesta){
             $this->regresarGarantia($idgarantia);
             return $respuesta;
         }else{
             return $respuesta;
         }

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
        $sql="SELECT h.idhipoteca,g.idgarantia,g.nombre,h.fecha_desembolso,h.fecha_pago,h.monto,h.interes,h.interes_moratorio,h.tipo,h.moneda,h.plazo,cl.nombres,cl.num_documento,h.condicion,h.estado 
        FROM hipoteca h INNER JOIN solicitud s ON h.solicitud = s.idsolicitud INNER JOIN cliente cl ON s.cliente=cl.idcliente INNER JOIN articulo_hipoteca_detalle ahd ON h.idarticulo_garantia = ahd.idarticulo INNER JOIN garantia g ON ahd.idgarantia = g.idgarantia";
        return ejecutarConsulta($sql);
    }

    public function listarCuentaDia()//que solo los pueda editar cuando no este abonado, ya abonado no puede editarlo,..
    {
        $sql="SELECT h.idhipoteca,h.fecha_desembolso,h.fecha_pago,h.monto,h.interes,h.interes_moratorio,h.tipo,h.moneda,h.plazo,cl.nombres,cl.num_documento,h.condicion,h.estado,h.no_credito FROM hipoteca h INNER JOIN solicitud s ON h.solicitud = s.idsolicitud 
        INNER JOIN cliente cl ON s.cliente=cl.idcliente INNER JOIN nuevacuenta_hipoteca nh ON nh.nidhipoteca=h.idhipoteca WHERE nh.estado = 'sin_abono' ";
        return ejecutarConsulta($sql);
    }

    
}

?>