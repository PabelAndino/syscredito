
<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Garantias
{
    //Implementamos nuestro constructor
    public function __construct()
    {

    }

   //List METHODS
    public function listarGarantias(){//Solo los acpetados para mostrarlos en un PiCkerView
        $sql="SELECT g.idgarantia,g.idcliente,cl.nombres,g.nombre,g.condicion,g.categoria,g.estado,cl.num_documento FROM garantia g INNER JOIN cliente cl ON g.idcliente = cl.idcliente   ";
        return ejecutarConsulta($sql);

    }
    public function listarGarantiasDetalle($idgarantia){//Solo los acpetados para mostrarlos en un PiCkerView
        $sql="SELECT ad.idarticulo,ad.idgarantia,ad.idcategoria,ad.codigo,ad.descripcion,ad.valor,
        ad.moneda,ad.estado,c.nombre as categoria FROM articulo_hipoteca_detalle ad INNER JOIN categoria_hipoteca c ON ad.idcategoria = c.idcategoria WHERE ad.idgarantia ='$idgarantia'";
        return ejecutarConsulta($sql);

    }
    

}
?>