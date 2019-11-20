
<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Solicitud
{
    //Implementamos nuestro constructor
    public function __construct()
    {

    }

   //List METHODS
    public function listarSolicitud(){//Solo los acpetados para mostrarlos en un PiCkerView
        $sql="SELECT s.idsolicitud,s.cliente,cl.nombres,cl.tipo_documento,cl.num_documento,s.nombre_conyugue,s.tipo_local,
        s.leer_escribir,s.ultimo_estudio_anio,s.numero_dependientes,s.ingresos,s.total_ingresos,s.sector,s.objetivo_prestamo,s.estado 
        FROM solicitud s INNER JOIN cliente cl ON s.cliente=cl.idcliente ";
        return ejecutarConsulta($sql);

    }
    public function listarIngresos($idsolicitud){
        $sql = "SELECT ingresos FROM solicitud WHERE idsolicitud = '$idsolicitud'";
        return ejecutarConsulta($sql);
    }


    //UPDATE FUNCTIONS
    public function actualizarSolicitud($idsolicitud,$idcliente,$conyugue,$tipo_local,$sabeleer,$ultimo_anio,$num_dependientes,
    $ingresos,$total_ingresos,$sector,$objetivo_prestamo)
    {
       $sql = "UPDATE solicitud SET cliente = '$idcliente',nombre_conyugue = '$conyugue',tipo_local='$tipo_local',leer_escribir='$sabeleer',
       ultimo_estudio_anio = '$ultimo_anio',numero_dependientes = '$num_dependientes',ingresos='$ingresos', total_ingresos = '$total_ingresos',
       sector = '$sector', objetivo_prestamo = '$objetivo_prestamo' WHERE idsolicitud = '$idsolicitud'";
       return ejecutarConsulta($sql);
    }
    

    //DELETE FUNCTIONS
    public function anularSolicitud($idsolicitud)
    {
        $sql = "UPDATE solicitud SET estado = 'Anulado' WHERE idsolicitud='$idsolicitud'";
        return ejecutarConsulta($sql);
    }
    //Activate Functions

    public function activarSolicitud($idsolicitud)
    {
        $sql = "UPDATE solicitud SET estado = 'Aceptado' WHERE idsolicitud='$idsolicitud'";
        return ejecutarConsulta($sql);
    }

}
?>