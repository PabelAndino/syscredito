<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Categorias
{
    //Implementamos nuestro constructor
    public function __construct()
    {

    }

    public function listar(){
        $sql = "SELECT * FROM categoria_hipoteca  ORDER BY idcategoria DESC";
        return ejecutarConsulta($sql);
    }
    public function insertar($nombre, $descripcion)
    {
        $sql = "INSERT INTO categoria_hipoteca (nombre,descripcion,condicion) VALUES ('$nombre', '$descripcion', '1')";
        return ejecutarConsulta($sql);
    }

    public  function  editar($idcategoria,$nombre,$descripcion)
    {
        $sql = "UPDATE categoria_hipoteca SET nombre = '$nombre', descripcion ='$descripcion' WHERE idcategoria = '$idcategoria'";
        return ejecutarConsulta($sql);
    }
    public  function desactivar($idcategoria)
    {
        $sql = "UPDATE categoria_hipoteca SET condicion = '0' WHERE idcategoria = '$idcategoria'";
        return ejecutarConsulta($sql);
    }

    public function  activar($idcategoria)
    {
        $sql = "UPDATE categoria_hipoteca SET condicion = '1' WHERE idcategoria = '$idcategoria'";
        return ejecutarConsulta($sql);
    }

    public function mostrar($idcategoria)
    {
        $sql = "SELECT * FROM categoria_hipoteca WHERE idcategoria = '$idcategoria' ";
        return ejecutarConsultaSimpleFila($sql);

    }

}
?>