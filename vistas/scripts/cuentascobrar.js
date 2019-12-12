var tablah,tablaf,tablas;

function init() {

    fechaActual()
    listarHipotecas()
    listarAbonos()
    //cargamos los items de categoria



}
function fechaActual() {

    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

    $('#fecha_desde').val(today)
    $('#fecha_hasta').val(today)


    //  document.getElementById("fechaPago").value = new Date().toISOString().substring(0, 10)
    // document.getElementById('fechaPago').valueAsDate = new Date();
    // document.getElementById('fecha_horaAbono').value = new Date()

    // document.getElementById('fechaHipoteca').valueAsDate = new Date();
}
function addCommas(nStr){
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function listarHipotecas()
{
    let desdefecha =  $('#fecha_desde').val()
    let hastafecha = $('#fecha_hasta').val()

    $.ajax({
        url: "../ajax/cuentascobrar.php?op=listarh",
        type: 'get',

        success: function(r) {
            $("#listadoh").html(r).dataTable({

                "aProcessing": true,//Activamos el procesamiento del datatables
                "aServerSide": true,//Paginación y filtrado realizados por el servidor
                dom: 'Bfrtip',//Definimos los elementos del control de tabla
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',

                ],

                "bDestroy": true,
                "iDisplayLength": 20,//Paginación
                "order": [[ 0, "desc" ]],//Ordenar (columna,orden)
                "pagingType": "full_numbers"}).DataTable();

        }
    })

}
function listarAbonos()
{

    let desdefecha =  $('#fecha_desde').val()
    let hastafecha = $('#fecha_hasta').val()
    let moneda = $('#moneda').val()
    let tipo_cambio = $('#tipo_cambio').val()

    $('#listadoAbonos').dataTable({
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [

        ],
        "ajax":
            {
                url: "../ajax/cuentascobrar.php?op=listarAbonos",
                type : "get",
                data:{
                    'fechadesde':desdefecha,
                    'fechahasta':hastafecha,
                    'moneda':moneda,
                    'tipo_cambio':tipo_cambio
                },
                dataType : "json",

                error: function(e){
                    console.log(e.responseText);
                }
            },
        "bDestroy": true,
        "iDisplayLength": 7,//Paginación
        "order": [[ 0, "desc" ]],//Ordenar (columna,orden),
        "footerCallback": function ( row, data, start, end, display ) {

            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            }


            // Total interes moratorio
            capital = api
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                    // var c = intVal((a)) + intVal(b);
                }, 0);

            // Update footer 2
            $(api.column(4).footer()).html(
                // ' ( $'+ (total2).toFixed(2) +' Total Int Mor)'
                '(' + addCommas(parseFloat(capital).toFixed(2)) + ' Capital)'
            )
            interes = api
                .column(5)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                    // var c = intVal((a)) + intVal(b);
                }, 0);

            // Update footer 2
            $(api.column(5).footer()).html(
                // ' ( $'+ (total2).toFixed(2) +' Total Int Mor)'
                '(' + addCommas(parseFloat(interes).toFixed(2)) + ' Interes)'
            )

            mantenimiento = api
                .column(6)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                    // var c = intVal((a)) + intVal(b);
                }, 0);

            // Update footer 2
            $(api.column(6).footer()).html(
                // ' ( $'+ (total2).toFixed(2) +' Total Int Mor)'
                '(' + addCommas(parseFloat(mantenimiento).toFixed(2)) + ' Mantenimiento)'
            )
            moratorio = api
                .column(7)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                    // var c = intVal((a)) + intVal(b);
                }, 0);

            // Update footer 2
            $(api.column(7).footer()).html(
                // ' ( $'+ (total2).toFixed(2) +' Total Int Mor)'
                '(' + addCommas(parseFloat(moratorio).toFixed(2)) + ' Moratorio)'
            )


            let total = parseFloat(capital) + parseFloat(interes) + parseFloat(mantenimiento) + parseFloat(moratorio)
            $('#monto_ncuenta').val(addCommas(parseFloat(capital).toFixed(2)))
            $('#interes').val(addCommas(parseFloat(interes).toFixed(2)))
            $('#mantenimiento').val(addCommas(parseFloat(mantenimiento).toFixed(2)))
            $('#interes_moratorio').val(addCommas(parseFloat(moratorio).toFixed(2)))
            $('#total').val(addCommas(parseFloat(total).toFixed(2)))

        }


    }).DataTable()


}
function listars()
{
    tablas=$('#tbllistados').dataTable(
        {
            "aProcessing": true,//Activa el procesamiento de los DataTables
            "aServerSide": true,//Paginacion y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elemntedos del control de tabla
            buttons:[
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdf'
            ],

            "ajax":
                {
                    url: '../ajax/cuentascobrar.php?op=listars',
                    type : "get",
                    dataType : "json",
                    error:function(e) {
                        console.log(e.responseText);
                    }
                },
            "bDestroy": true,
            'iDisplayLength': 20, //paginacion
            "order": [[ 0, "desc" ]] ,//Ordenar (columna,orden)
            "pagingType": "full_numbers"
        }).DataTable();

}


function listar_ncuentah(){

}
function listar_ncuentaf(){

}




init();