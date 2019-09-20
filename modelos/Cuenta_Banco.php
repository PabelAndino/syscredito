
<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Cuenta_Banco
{
    //Implementamos nuestro constructor
    public function __construct()
    {

    }

   //List METHODS
    public function listarSocios(){//Solo los acpetados para mostrarlos en un PiCkerView
        $sql="SELECT * FROM socios WHERE estado='Aceptado'";
        return ejecutarConsulta($sql);

    }
    public function listarSociosCompleto(){//Este metodo devuelve todos los socios Aceptados o anulados
        $sql="SELECT * FROM socios";
        return ejecutarConsulta($sql);

    }
    public function listarCuentasBancos(){
        $sql="SELECT DATE(cb.fecha) as fecha,cb.idcuentas_bancos,s.nombres as socio,s.cedula_ruc as documento,cb.nombre_banco as banco,cb.num_cuenta,dc.moneda,dc.monto 
              FROM cuentas_bancos cb  INNER JOIN socios s ON cb.socio=s.idsocios INNER JOIN detalle_ingreso_cuenta dc ON cb.idcuentas_bancos=dc.idcuentas_bancos WHERE cb.estado='Aceptado'";
        return ejecutarConsulta($sql);
    }

    public function mostrarMonto($idbanco){
        $sql="SELECT di.monto,di.moneda FROM cuentas_bancos cb INNER JOIN detalle_ingreso_cuenta di  WHERE cb.idcuentas_bancos='$idbanco' ORDER BY di.monto DESC LIMIT 1";
        return ejecutarConsulta($sql);
    }

    //SAVE METHODS
    public function guardarSocios($nombres,$direccion,$tipo_documento,$cedula_ruc,$genero,$telefono,$correo){
        $sql="INSERT INTO socios (nombres,direccion,tipo_documento,cedula_ruc,genero,telefono,correo,estado) VALUES('$nombres','$direccion','$tipo_documento','$cedula_ruc','$genero','$telefono','$correo','Aceptado')";
        return ejecutarConsulta($sql);
    }

    public function guardarCuentaBanco($socio,$nombre_banco,$num_cuenta,$fecha,$moneda,$monto){
        $sql="INSERT INTO cuentas_bancos(socio,nombre_banco,num_cuenta,fecha,estado) VALUES('$socio','$nombre_banco','$num_cuenta','$fecha','Aceptado')";
        $resp=true;
        $idbanco= ejecutarConsulta_retornarID($sql) or $resp =false;
        //$sql2="INSERT INTO detalle_ingreso_cuenta (idcuentas_bancos,fecha,monto) VALUES('$idbanco','$fecha','$monto')";

        $this->guaradarDetalleCuentaBanco($idbanco,$fecha,$moneda,$monto);
        return $resp;

    }

    public function guaradarDetalleCuentaBanco($idcuenta_banco,$fecha,$moneda,$monto){
        $sql="INSERT INTO detalle_ingreso_cuenta (idcuentas_bancos,fecha,moneda,monto) VALUES('$idcuenta_banco','$fecha','$moneda','$monto')";
        return ejecutarConsulta($sql);
    }

    //UPDATE FUNCTIONS
    public function editarSocios($idsocio,$nombres,$tipo_documento,$num_documento,$genero,$direccion,$telefono,$correo){
        $sql="UPDATE socios SET nombres='$nombres',tipo_documento='$tipo_documento',cedula_ruc='$num_documento',genero='$genero',direccion='$direccion',
              telefono='$telefono',correo='$correo' WHERE idsocios='$idsocio'";
        return ejecutarConsulta($sql);
    }

    //DELETE FUNCTIONS
    public function anularSocio($idsocio){
        $sql="UPDATE socios SET estado='Anulado' WHERE idsocios='$idsocio'";
        return ejecutarConsulta($sql);
    }
    //Activate Functions

    public function activarSocio($idsocio){
        $sql="UPDATE socios SET estado='Aceptado' WHERE idsocios='$idsocio'";
        return ejecutarConsulta($sql);
    }

}
?>