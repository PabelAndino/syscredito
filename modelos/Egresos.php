
<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Egresos
{
    //Implementamos nuestro constructor
    public function __construct()
    {

    }

   //List METHODS
    public function listarEgresosTodos(){//Solo los acpetados para mostrarlos en un PiCkerView
        $sql="SELECT * FROM egresos";
        return ejecutarConsulta($sql);

    }

    public function listarEgresos(){
        $sql = "SELECT * FROM egresos WHERE estado='Aceptado'";
        return ejecutarConsulta($sql);
    }

    public function listarDetallesEgresosTodos(){
        $sql = "SELECT de.id_detalles_egresos, de.idusuario,de.fecha ,us.nombre as usuario,de.categoria_egreso ,eg.categoria_egreso as categoria, de.detalles, de.monto, de.moneda, de.estado   FROM detalles_egresos de INNER JOIN usuario us ON de.idusuario=us.idusuario
                INNER JOIN egresos eg ON de.categoria_egreso = eg.idegresos ";
        return ejecutarConsulta($sql);
    }
    
    //SAVE METHODS
    public function guardarEgreso($egreso_input,$descripcion_input){
        $sql = "INSERT INTO egresos (categoria_egreso,detalles,estado) VALUES ('$egreso_input','$descripcion_input','Aceptado')";
        return ejecutarConsulta($sql);
    }
   
    //EDIT FUNCTIONS
   
    public function updateEgreso($idegreso,$egreso_input,$detalles)
    {
        $sql = "UPDATE egresos SET categoria_egreso='$egreso_input',detalles = '$detalles' WHERE idegresos='$idegreso'";
        return ejecutarConsulta($sql);
    }

    public function editarDetallesEgreso($iddetalle_egreso,$monto,$idegreso,$descripcion_egreso,$moneda,$fecha){
        $sql="UPDATE detalles_egresos SET categoria_egreso='$idegreso',fecha='$fecha',detalles='$descripcion_egreso',monto='$monto',moneda='$moneda'
                WHERE id_detalles_egresos='$iddetalle_egreso' ";
                return ejecutarConsulta($sql);
    }
    public function eliminarEgreso($idegreso)
    {
        $sql = "UPDATE egresos SET estado = 'Anulado' WHERE idegresos='$idegreso' ";
        return ejecutarConsulta($sql);
    }

    public function restaurarEgreso($idegreso)
    {
        $sql = "UPDATE egresos SET estado = 'Aceptado' WHERE idegresos='$idegreso' ";
        return ejecutarConsulta($sql);
    }
    
    public function guardarDetallesEgreso($idusuario,$monto,$idegreso,$descripcion_egreso,$moneda,$fecha){
            $sql ="INSERT INTO detalles_egresos (idusuario,categoria_egreso,fecha,detalles,monto,moneda,estado)
                    VALUES ('$idusuario','$idegreso','$fecha','$descripcion_egreso','$monto','$moneda','Aceptado') ";
                    return ejecutarConsulta($sql);
    }

    public function eliminarDetallesEgreso($idegreso_detalles)
    {
        $sql = "UPDATE detalles_egresos SET estado = 'Anulado' WHERE id_detalles_egresos='$idegreso_detalles' ";
        return ejecutarConsulta($sql);
    }

    public function restaurarDetallesEgreso($idegreso_detalles)
    {
        $sql = "UPDATE detalles_egresos SET estado = 'Aceptado' WHERE id_detalles_egresos='$idegreso_detalles' ";
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