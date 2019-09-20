<?php

require "../config/Conexion.php";

Class Persona
{
    //Constructor y crear instancaias a la clase sin parametros y accesder a todas las funciones que aqui se encuentran
    public function __construct()
    {
    }

    public function insertar($tipo_persona,$nombre,$genero,$tipo_documento,$num_documento,$direccion,$telefono,$email)
    {
        $sql = "INSERT INTO  persona(tipo_persona,nombre,genero,tipo_documento,num_documento,direccion,telefono,email,estado) VALUES ('$tipo_persona', '$nombre','$genero','$tipo_documento','$num_documento','$direccion','$telefono','$email','Aceptado')";
        return ejecutarConsulta($sql);
    }


    public  function  editar($idpersona,$tipo_persona,$nombre,$genero,$tipo_documento,$num_documento,$direccion,$telefono,$email)
    {
        $sql = "UPDATE  persona SET  tipo_persona='$tipo_persona',nombre='$nombre', genero='$genero',tipo_documento='$tipo_documento',num_documento='$num_documento',direccion='$direccion',telefono='$telefono',email='$email',estado='Aceptado' WHERE idpersona='$idpersona' ";
        return ejecutarConsulta($sql);
    }

    public  function eliminar($idpersona)
    {
        $sql = "UPDATE persona SET estado='Anulado'  WHERE idpersona = '$idpersona'";
        return ejecutarConsulta($sql);
    }



    public function mostrar($idpersona)
    {
        $sql = "SELECT * FROM persona WHERE idpersona = '$idpersona'";
        return ejecutarConsultaSimpleFila($sql);

    }

    public function listarP()
    {
        //$sql = "SELECT a.idpersona,a.idpersona,c.nombre as persona, a.codigo, a.nombre, a.stock, a.descripcion,a.imagen,a.condicion FROM persona a INNER JOIN persona c ON a.idpersona=c.idpersona";
        $sql = "SELECT * FROM persona WHERE tipo_persona = 'Proveedor' AND  estado='Aceptado' ORDER BY idpersona DESC";
        return ejecutarConsulta($sql);
    }

    public  function  listarC()
    {
        $sql = "SELECT * FROM persona WHERE tipo_persona = 'Cliente' OR tipo_persona='Fiador' AND  estado='Aceptado' ORDER BY idpersona DESC";
        return ejecutarConsulta($sql);
    }

    public  function  listarCliente()
    {
        $sql = "SELECT * FROM persona WHERE tipo_persona = 'Cliente' AND  estado='Aceptado' ORDER BY idpersona DESC ";
        return ejecutarConsulta($sql);
    }

    public function listarCasa(){
        $sql = "SELECT * FROM persona WHERE tipo_persona = 'Casa'  AND  estado='Aceptado' ORDER BY idpersona DESC ";
        return ejecutarConsulta($sql);
    }
    public function listarFiador()
    {
        //$sql = "SELECT a.idpersona,a.idpersona,c.nombre as persona, a.codigo, a.nombre, a.stock, a.descripcion,a.imagen,a.condicion FROM persona a INNER JOIN persona c ON a.idpersona=c.idpersona";
        $sql = "SELECT * FROM persona WHERE tipo_persona = 'Fiador' AND estado='Aceptado' ORDER BY idpersona DESC";
        return ejecutarConsulta($sql);
    }


}
?>
