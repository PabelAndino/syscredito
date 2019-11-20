var tablah,tablaf,tablas;

function init() {




    //cargamos los items de categoria
fechaActual()


}
function fechaActual() {

    document.getElementById("fechaPago").value = new Date().toISOString().substring(0, 10)
    // document.getElementById('fechaPago').valueAsDate = new Date();

    document.getElementById('fechaHipoteca').value = new Date().toISOString().substring(0, 10)
}


function planPagos() {

    let fechaDesembolso = $('#fechaHipoteca').val()
    let fechaPago = $('#fechaPago').val()

    $.ajax({
        url:'../ajax/tests.php?op=planpagos',
        type:'get',
        data:{
            'desembolso':fechaDesembolso,
            'pago':fechaPago
        },
        success : function (data) {
            console.log(data);
            /*$('#tbllistado').html(data).dataTable({
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
                "iDisplayLength": 36,//Paginación
                "order": [[ 0, "asc" ]],//Ordenar (columna,orden)
                "pagingType": "full_numbers"
            }).DataTable()*/
        }

    })
}

init();