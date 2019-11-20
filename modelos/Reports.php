
<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Reports
{
    //Implementamos nuestro constructor
    public function __construct()
    {

    }

    //PRESTAMOS
     public function listarCarteraHombresDolares(){
        $sql="";
        return ejecutarConsulta($sql);
     }

    public function listarCarteraHombresCordobas(){
        $sql="";
        return ejecutarConsulta($sql);
    }

    public function listarCarteraMujeresDolares(){
        $sql="";
        return ejecutarConsulta($sql);
    }

    public function listarCarteraMujeresCordobas(){
        $sql="";
        return ejecutarConsulta($sql);
    }


}

?>