

//Función que se ejecuta al inicio
function init(){

    listarCliente()
    listarFiador()

    $("#formulario").on("submit",function(e)
    {
        guardaryeditar(e);
    })

}



//Función limpiar
function limpiarCliente()
{
    $('#id_cliente').val("")
    $('#nombreCliente').val("")


    $('#num_documentoCliente').val("")
    $('#direccionCliente').val("")
    $('#telefonoCliente').val("")
    $('#emailCliente').val("")
    $('#ingresosCliente').val("")
}



//Función Listar
function listarCliente() {
    $.ajax({
        url: '../ajax/cliente.php?op=listarClientes',
        type: 'get',
        success: function (r) {
            $("#tbllistado").html(r).dataTable({

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
                "iDisplayLength": 20,//Paginación
                "order": [[0, "desc"]],//Ordenar (columna,orden)
                "pagingType": "full_numbers"
            }).DataTable();

        }
    })
}
function listarFiador() {
    $.ajax({
        url: '../ajax/cliente.php?op=listarFiadores',
        type: 'get',
        success: function (r) {
            $("#tbllistadoFiador").html(r).dataTable({

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
                "iDisplayLength": 20,//Paginación
                "order": [[0, "desc"]],//Ordenar (columna,orden)
                "pagingType": "full_numbers"
            }).DataTable();

        }
    })
}
//Función para guardar o editar

function guardaryeditarFiador(){

    let nombre= $('#nombreCliente').val()
    let tipo_documento= $('#tipo_documentoCliente').val()
    let genero= $('#genero_cliente').val()
    let documento= $('#num_documentoCliente').val()
    let direccion= $('#direccionCliente').val()
    let telefono= $('#telefonoCliente').val()
    let email= $('#emailCliente').val()
    let estado_civil=$('#estado_civil').val()
    let idfiador =$('#id_cliente').val()
    let ingreso = $('#ingresosCliente').val()
    // console.log(nombre,tipo_documento,genero,documento,direccion,telefono,email,estado_civil,ingreso)

    $.ajax({
        url:"../ajax/cliente.php?op=guardarFiador",
        type:'get',
        data:{
            'idfiador':idfiador,
            'nombres':nombre,
            'tipo_documento':tipo_documento,
            'num_documento':documento,
            'genero':genero,
            'direccion':direccion,
            'telefono':telefono,
            'email':email,
            'ingresos':ingreso

        },
        success:function (data) {
            bootbox.alert({
                message:data,
                callback:function (data) {
                    listarFiador()
                }
            })
        }

    })


}
function guardaryeditarCliente() {

    let nombre= $('#nombreCliente').val()
    let tipo_documento= $('#tipo_documentoCliente').val()
    let genero= $('#genero_cliente').val()
    let documento= $('#num_documentoCliente').val()
    let direccion= $('#direccionCliente').val()
    let telefono= $('#telefonoCliente').val()
    let email= $('#emailCliente').val()
    let estado_civil=$('#estado_civil').val()
    let idcliente =$('#id_cliente').val()
    console.log(nombre,tipo_documento,genero,documento,direccion,telefono,email,estado_civil)

    $.ajax({
        url:"../ajax/cliente.php?op=guardarCliente",
        type:'get',
        data:{
            'idcliente':idcliente,
            'nombres':nombre,
            'tipo_documento':tipo_documento,
            'num_documento':documento,
            'genero':genero,
            'direccion':direccion,
            'telefono':telefono,
            'email':email,
            'estado_civil':estado_civil

        },
        success:function (data) {
            bootbox.alert({
                message:data,
                callback:function (data) {
                    listarCliente()
                    limpiarCliente()
                }
            })
        }

    })




}
function editarCliente(idcliente,nombres,tipo_doc,num_doc,genero,est_civil,direccion,telefono,correo) {
    //console.log(idcliente,nombres,tipo_doc,num_doc,genero,est_civil,direccion,telefono,correo,ingresos)
    $('#id_cliente').val(idcliente)
    $('#nombreCliente').val(nombres)
    $('#tipo_documentoCliente').val(tipo_doc)
    $('#tipo_documentoCliente').selectpicker('refresh')
    $('#genero_cliente').val(genero)
    $('#genero_cliente').selectpicker('refresh')
    $('#estado_civil').val(est_civil)
    $('#estado_civil').selectpicker('refresh')
    $('#num_documentoCliente').val(num_doc)
    $('#direccionCliente').val(direccion)
    $('#telefonoCliente').val(telefono)
    $('#emailCliente').val(correo)


}
function editarFiador(idcliente,nombres,tipo_doc,num_doc,genero,est_civil,direccion,telefono,correo,ingresos) {
    console.log(idcliente,nombres,tipo_doc,num_doc,genero,est_civil,direccion,telefono,correo,ingresos)
    $('#id_cliente').val(idcliente)
    $('#nombreCliente').val(nombres)
    $('#tipo_documentoCliente').val(tipo_doc)
    $('#tipo_documentoCliente').selectpicker('refresh')
    $('#genero_cliente').val(genero)
    $('#genero_cliente').selectpicker('refresh')
    $('#estado_civil').val(est_civil)
    $('#estado_civil').selectpicker('refresh')
    $('#num_documentoCliente').val(num_doc)
    $('#direccionCliente').val(direccion)
    $('#telefonoCliente').val(telefono)
    $('#emailCliente').val(correo)
    $('#ingresosCliente').val(ingresos)

}


//Función para desactivar registros
function eliminarCliente(idcliente)
{
    bootbox.confirm("¿Está Seguro de Eliminar el Cliente?", function(result){
        if(result)
        {

            $.ajax({
                url:"../ajax/cliente.php?op=eliminarCliente",
                type:'get',
                data:{
                    'idcliente':idcliente
                },
                success:function (result) {
                    bootbox.alert(result)
                    listarCliente()
                }
            })
        }
    })
}
function restaurarCliente(idcliente)
{
    bootbox.confirm("¿Está Seguro de Restaurar el Cliente?", function(result){
        if(result)
        {

            $.ajax({
                url:"../ajax/cliente.php?op=restaurarCliente",
                type:'get',
                data:{
                    'idcliente':idcliente
                },
                success:function (result) {
                    bootbox.alert(result)
                    listarCliente()
                }
            })
        }
    })
}
//Función para desactivar registros
function eliminarFiador(idfiador)
{
    bootbox.confirm("¿Está Seguro de Eliminar el Fiador?", function(result){
        if(result)
        {

            $.ajax({
                url:"../ajax/cliente.php?op=eliminarFiador",
                type:'get',
                data:{
                    'idfiador':idfiador
                },
                success:function (result) {
                    bootbox.alert(result)
                    listarFiador()
                }
            })
        }
    })
}
function restaurarFiador(idfiador)
{
    bootbox.confirm("¿Está Seguro de Restaurar el Fiador?", function(result){
        if(result)
        {

            $.ajax({
                url:"../ajax/cliente.php?op=restaurarFiador",
                type:'get',
                data:{
                    'idfiador':idfiador
                },
                success:function (result) {
                    bootbox.alert(result)
                    listarFiador()
                }
            })
        }
    })
}


init();