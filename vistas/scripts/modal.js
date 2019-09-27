

function init() {

    $("#ultimoaprov").prop('disabled', true);
   listarAbonosdeldia()
}

function listarAbonosdeldia() {
    $.ajax({
        url: "../ajax/gestionar_hipoteca.php?op=muestraTodosAbonos",
        type: "get", //send it through get method

        success: function(r) {
            $("#tbllistadoHipotecas").html(r).dataTable({

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

        },

        error: function(xhr) {
            //Do Something to handle error
        }

    });
}
function leerEscribir(){

    if($('#leersi').is(":checked")){
        $("#ultimoaprov").prop('disabled', false);
    }else  if($('#leerno').is(":checked")){
        $("#ultimoaprov").prop('disabled', true);
        $("#ultimoaprov").val("");
    }


}
init();