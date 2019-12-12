<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Clientes
{
    //Implementamos nuestro constructor
    public function __construct()
    {

    }

    public function guardarCliente($nombre,$direccion,$genero,$estado_civil,$tipo_documento,$num_documento,$telefono,$correo){
        $sql="INSERT INTO cliente (nombres, direccion,genero, estado_civil,tipo_documento,num_documento,telefono,correo,tipo,estado) VALUES('$nombre','$direccion','$genero','$estado_civil','$tipo_documento','$num_documento','$telefono','$correo','Cliente','Aceptado')";
        return ejecutarConsulta($sql);
    }

    public function actualizarCliente($idcliente,$nombre,$direccion,$genero,$estado_civil,$tipo_documento,$num_documento,$telefono,$correo){
        $sql = "UPDATE cliente SET nombres = '$nombre',direccion = '$direccion',genero='$genero',estado_civil='$estado_civil',tipo_documento='$tipo_documento',
                num_documento='$num_documento',telefono = '$telefono',correo='$correo' WHERE idcliente='$idcliente'";
        return ejecutarConsulta($sql);
    }

    public function guardarFiador($nombre,$direccion,$genero,$estado_civil,$tipo_documento,$num_documento,$telefono,$correo,$ingresos){
        $sql="INSERT INTO cliente (nombres, direccion,genero, estado_civil,tipo_documento,num_documento,telefono,correo,igresos,tipo,estado) VALUES('$nombre','$direccion','$genero','$estado_civil','$tipo_documento','$num_documento','$telefono','$correo','$ingresos','Fiador','Aceptado')";
        return ejecutarConsulta($sql);
    }

    public function actualizarFiador($idfiador,$nombre,$direccion,$genero,$estado_civil,$tipo_documento,$num_documento,$telefono,$correo,$ingresos){
        $sql = "UPDATE cliente SET nombres = '$nombre',direccion = '$direccion',genero='$genero',estado_civil='$estado_civil',tipo_documento='$tipo_documento',
                num_documento='$num_documento',telefono = '$telefono',correo='$correo',igresos='$ingresos' WHERE idcliente='$idfiador'";
        return ejecutarConsulta($sql);
    }


    public function listarClientes(){
        $sql="SELECT * FROM cliente WHERE tipo = 'Cliente' ";
        return ejecutarConsulta($sql);
    }
    public function listarFiador(){
        $sql="SELECT * FROM cliente WHERE tipo = 'Fiador' ";
        return ejecutarConsulta($sql);
    }

    function eliminarCliente($idcliente){
        $sql="UPDATE cliente SET estado='Anulado' WHERE idcliente='$idcliente'";
        return ejecutarConsulta($sql);

    }
    function restaurarCliente($idcliente){
        $sql="UPDATE cliente SET estado='Aceptado' WHERE idcliente='$idcliente'";
        return ejecutarConsulta($sql);

    }
    function eliminarFiador($idfiador){
        $sql="UPDATE cliente SET estado='Anulado' WHERE idcliente='$idfiador'";
        return ejecutarConsulta($sql);

    }
    function restaurarFiador($idfiador){
        $sql="UPDATE cliente SET estado='Aceptado' WHERE idcliente='$idfiador'";
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

}
?>
