var tablah,tablaf,tablas;

function init() {



    listarh();
    listarf()
    listars()

    listar_ncuentah()
    listar_ncuentaf()
    listar_ncuentas()
    //cargamos los items de categoria



}


function listarh()
{
    tablah=$('#tbllistado').dataTable(
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
                    url: '../ajax/cuentascobrar.php?op=listarh',
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


   /* $.ajax({
        url:'../ajax/cuentascobrar.php?op=listar',
        type:"get",
        success:function (data) {
            console.log(data)
        }
    })*/

}
function listarf()
{
    tablaf=$('#tbllistadof').dataTable(
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
                    url: '../ajax/cuentascobrar.php?op=listarf',
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
    tablah=$('#tbllistado_ncuenta').dataTable(
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
                    url: '../ajax/cuentascobrar.php?op=listar_ncuentah',//lista la nueva cuenta
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
function listar_ncuentaf(){
    tablaf=$('#tbllistado_ncuentaf').dataTable(
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
                    url: '../ajax/cuentascobrar.php?op=listar_ncuentaf',//lista la nueva cuenta
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
function listar_ncuentas(){
    tablaf=$('#tbllistado_ncuentas').dataTable(
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
                    url: '../ajax/cuentascobrar.php?op=listar_ncuentas',//lista la nueva cuenta
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


function detalles_clienteh(idhipoteca,nombre,telefono,direccion,cedula,monto){
    $.ajax({
        url: "../ajax/cuentascobrar.php?op=modalclienteh",
        type: "get", //send it through get method
        data: {
            'idhipoteca':idhipoteca,
            'monto':monto
        },
        success: function(r) {
            $("#detallesAbonosh").html(r).dataTable({

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

            bootbox.alert(xhr)
            //Do Something to handle error
        }

    });


    $('#nombreh').val(nombre)
    $('#cedulah').val(cedula)
    $('#direccionh').val(direccion)
    $('#telefonoh').val(telefono)

}

function detalles(id){
    console.log('Pabel Andino');
}
init();