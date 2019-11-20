
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

    public function listarBancos(){
        $sql = "SELECT * FROM banco WHERE estado='Aceptado'";
        return ejecutarConsulta($sql);
    }

    public function listarTodosBancos(){
        $sql = "SELECT * FROM banco ";
        return ejecutarConsulta($sql);
    }
    public function listarSociosCompleto(){//Este metodo devuelve todos los socios Aceptados o anulados
        $sql="SELECT * FROM socios";
        return ejecutarConsulta($sql);

    }
    public function listarCuentasBancos(){
        $sql="SELECT DATE(cb.fecha) as fecha,cb.idcuentas_bancos,s.nombres as socio,s.idsocios as socioid,s.cedula_ruc as documento,b.nombre_banco as banco,b.idbanco,cb.num_cuenta,cb.moneda,cb.monto 
        FROM cuentas_bancos cb  INNER JOIN socios s ON cb.socio=s.idsocios  INNER JOIN banco b ON b.idbanco=cb.banco WHERE cb.estado='Aceptado'";
        return ejecutarConsulta($sql);
    }

    public function mostrarMonto($idbanco){
        $sql="SELECT * FROM cuentas_bancos WHERE idcuentas_bancos = '$idbanco'";
        return ejecutarConsulta($sql);
    }
    public function mostrarMonedaBanco($idbanco){//En que tipo de moneda se guardo la cuenta de los socios
        $sql="SELECT moneda,monto FROM cuentas_bancos  WHERE idcuentas_bancos='$idbanco'";
        return ejecutarConsulta($sql);
    }
    public function calculaSaldo($idbanco){
        $sql ="SELECT SUM(cantidad) as monto_abonado FROM saldo_banco WHERE idcuentas_banco = '$idbanco'";
        return ejecutarConsulta($sql);
    }

    //SAVE METHODS
    public function guardarSocios($nombres,$direccion,$tipo_documento,$cedula_ruc,$genero,$telefono,$correo){
        $sql="INSERT INTO socios (nombres,direccion,tipo_documento,cedula_ruc,genero,telefono,correo,estado) VALUES('$nombres','$direccion','$tipo_documento','$cedula_ruc','$genero','$telefono','$correo','Aceptado')";
        return ejecutarConsulta($sql);
    }

    public function guardarBanco($nombre_banco,$descripcion)
    {
        $sql = "INSERT INTO banco (nombre_banco,descripcion,estado) VALUES ('$nombre_banco','$descripcion','Aceptado')";
        return ejecutarConsulta($sql);
    }

    public function guardarCuentaBanco($socio,$nombre_banco,$num_cuenta,$fecha,$moneda,$monto){
        $sql="INSERT INTO cuentas_bancos(socio,banco,num_cuenta,fecha,moneda,monto,estado) VALUES('$socio','$nombre_banco','$num_cuenta','$fecha','$moneda','$monto','Aceptado')";
        return ejecutarConsulta($sql);
       
        // $resp=true;
        // $idbanco= ejecutarConsulta_retornarID($sql) or $resp =false;
        // //$sql2="INSERT INTO detalle_ingreso_cuenta (idcuentas_bancos,fecha,monto) VALUES('$idbanco','$fecha','$monto')";

        // $this->guaradarDetalleCuentaBanco($idbanco,$fecha,$moneda,$monto);
        // return $resp;

    }

    //EDIT FUNCTIONS
    public function editarCuentaBanco($idcuenta_banco,$socio,$nombre_banco,$num_cuenta,$fecha,$moneda,$monto){
        $sql = "UPDATE cuentas_bancos SET socio = '$socio',banco='$nombre_banco',num_cuenta = '$num_cuenta',fecha='$fecha',moneda='$moneda',monto='$monto' WHERE idcuentas_bancos = '$idcuenta_banco'";
        return ejecutarConsulta($sql);
    }

    public function guaradarDetalleCuentaBanco($idcuenta_banco,$fecha,$moneda,$monto){
        $sql="INSERT INTO detalle_ingreso_cuenta (idcuentas_bancos,fecha,moneda,monto) VALUES('$idcuenta_banco','$fecha','$moneda','$monto')";
        return ejecutarConsulta($sql);
    }


    public function updateBanco($idbanco,$nombre_banco,$descripcion)
    {
        $sql = "UPDATE banco SET nombre_banco='$nombre_banco',descripcion = '$descripcion' WHERE idbanco='$idbanco'";
        return ejecutarConsulta($sql);
    }

    public function eliminarBanco($idbanco)
    {
        $sql = "UPDATE banco SET estado = 'Anulado' WHERE idbanco='$idbanco' ";
        return ejecutarConsulta($sql);
    }

    public function restaurarBanco($idbanco)
    {
        $sql = "UPDATE banco SET estado = 'Aceptado' WHERE idbanco='$idbanco' ";
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