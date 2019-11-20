var tabla;

//Función que se ejecuta al inicio
function init(){

    listarGarantias()
    selectCategoria()
}

function selectCategoria(){

    $.post("../ajax/gestionar_hipoteca.php?op=selectCategoria",function (r) {
        $("#idcategoriaGarantia").html(r); // r es las opciones que nos esta devolviendo el archivo articulo.php en la carpeta ajax cuando la cvariable op sea selectCategoria
        $("#idcategoriaGarantia").selectpicker('refresh');
    })
}
function listarGarantias(){
    $.ajax({
        url:'../ajax/garantias.php?op=listarGarantias',
        type:'get',
        success:function(data){
            $("#tbllistado_garantia").html(data).dataTable({

                "aProcessing": true,//Activamos el procesamiento del datatables
                "aServerSide": true,//Paginación y filtrado realizados por el servidor
                dom: 'Bfrtip',//Definimos los elementos del control de tabla
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdf'
                ],

                "bDestroy": true,
                "iDisplayLength": 10,//Paginación
                "order": [[ 0, "desc" ]],//Ordenar (columna,orden)
                "pagingType": "full_numbers"}).DataTable();
        }
    })
}
function listarDetallesGarantia(idgarantia){
    $.ajax({
        url:'../ajax/garantias.php?op=listarGarantiasDetalle',
        type:'get',
        data:{'idgarantia':idgarantia},
        success:function(data){
            $("#tbllistado_detalles").html(data).dataTable({

                "aProcessing": true,//Activamos el procesamiento del datatables
                "aServerSide": true,//Paginación y filtrado realizados por el servidor
                dom: 'Bfrtip',//Definimos los elementos del control de tabla
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdf'
                ],

                "bDestroy": true,
                "iDisplayLength": 10,//Paginación
                "order": [[ 0, "desc" ]],//Ordenar (columna,orden)
                "pagingType": "full_numbers"}).DataTable();
        }
    })
}
function editGarantia(idgarantia,idcliente,nombre,condicion,categoria,estado){
    console.log(idgarantia,idcliente,nombre,condicion,categoria,estado)
    listarDetallesGarantia(idgarantia)
}


init();