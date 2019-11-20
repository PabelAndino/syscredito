

//Función que se ejecuta al inicio
function init(){

    cargarFecha()
    listarDetallesEgresos()
    listarEgresos()
    cargarEgresosPicker()


    $('#formulario_ncuenta').on('submit',function (e) {
        guardarEgresosDetalle(e)
    })

    $('#formulario_egresos').on('submit',function(e){
        guardarEgresos(e)
    })
}

//SAVE FUNCTIONS

function guardarEgresosDetalle(e){
    e.preventDefault()
    let idegreso_picker = $('#idegreso_picker').val()
    let fecha = $('#fecha').val()
    let moneda = $('#moneda').val()
    let monto = $('#monto').val()
    let descripcion_egreso = $('#descripcion_egreso').val()
    let iddetalle_egreso = $('#iddetalle_egreso').val()

    $.ajax({
        url:"../ajax/egresos.php?op=guardarEgresoDetalles",
        type: "post",
        data:{
            'iddetalle_egreso':iddetalle_egreso,
            'idegreso':idegreso_picker,
            'fecha':fecha,
            'moneda':moneda,
            'monto':monto, 
            'descripcion_egreso':descripcion_egreso
        },
        success:function(data){
            bootbox.alert({
                message:data,
                callback:function(){
                    listarDetallesEgresos()
                }
            })
        }
    })
}

function guardarEgresos(e){
    e.preventDefault()
    let egreso_input = $('#egreso_input').val()
    let descripcion_input = $('#descripcion_input').val()
    let idegreso = $('#idegreso').val()

    $.ajax({
        url:"../ajax/egresos.php?op=guardarEgreso",
        type: "post",
        data:{
            'idegreso':idegreso,
            'egreso_input':egreso_input,
            'descripcion_input': descripcion_input
            
        },
        success:function(data){
            bootbox.alert({
                message:data,
                callback:function(){
                    listarEgresos()
                    cargarEgresosPicker()
                }
            })
        }
    })
}
//DeleteFunctios

function eliminarEgreso(idegreso){


    bootbox.confirm("Desea Eliminar este egreso ?",function(result){
        console.log(idegreso)
        if(result){
            $.ajax({
                url:'../ajax/egresos.php?op=eliminarEgreso',
                type:'post',
                data:{
                    'idegreso':idegreso
                },
                success:function(data){
                    bootbox.alert(data)
                    listarEgresos()
                    cargarEgresosPicker()
                }
            })
        }
    })
}
// Restaurar Functions

function restaurarEgresos(idegreso){
    bootbox.confirm("Seguro que desea restaurar el Egreso?",function (result) {

        if(result) { //si le dio a si

            $.ajax({
                url: "../ajax/egresos.php?op=restaurarEgreso",
                type: "post", //send it through get method
                data: {
                    'idegreso':idegreso
                },

                success: function(data) {
                    bootbox.alert({
                        message: data,
                        callback: function (data) {
                            listarEgresos()
                            cargarEgresosPicker()
                        }
                    })
                },

                error: function(error) {
                    bootbox.alert("Ocurrio el sieguiente error", error)
                }

            });


        }

    })
}

//LIST SHOW FUNCTIONS
function listarEgresosDetalles() {

    $.ajax({
        url:"../ajax/egresos.php?op=listarDetallesEgresos",
        type:"get",
        success:function (data) {
            $('#listadoCuentas').html(data).dataTable({
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
                "pagingType": "full_numbers"
            }).DataTable()
        }
    })

 

}
function listarEgresos(){
    $.ajax({
        url:"../ajax/egresos.php?op=listarEgresos",
        type:"get",
        success:function (data) {
            $('#tbEgresos').html(data).dataTable({
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
                "pagingType": "full_numbers"
            }).DataTable()
        }
    })
}
function listarDetallesEgresos(){
    $.ajax({
        url:"../ajax/egresos.php?op=listarDetallesEgresos",
        type:"get",
        success:function (data) {
            $('#listadoDetallesEgreso').html(data).dataTable({
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
                "pagingType": "full_numbers"
            }).DataTable()
        }
    })
}
//Update FUNCTIONS

function editarEgreso(idegreso,egreso_input,descripcion_input){

    $('#idegreso').val(idegreso)
     $('#egreso_input').val(egreso_input)
     $('#descripcion_input').val(descripcion_input)


}

function editarDetallesEgreso(iddetalle_egreso,idegreso,fecha,moneda,monto,descripcion){
    $('#iddetalle_egreso').val(iddetalle_egreso)
   // $('#socios_picker').val(socio)

    $('#idegreso_picker').val(idegreso)
    $('#idegreso_picker').selectpicker('refresh')

    $('#descripcion_egreso').val(descripcion)
    $('#fecha').val(fecha)

    $('#moneda').val(moneda)
    $('#moneda').selectpicker('refresh')

    $('#monto').val(monto)

   
   
}
//SELECT FUNCTIONS


function cargarEgresosPicker(){
    
    $.post("../ajax/egresos.php?op=selectEgresos",function(egresos) {
        $('#idegreso_picker').html(egresos)
        $('#idegreso_picker').selectpicker('refresh')
    })
}


//OTHERS
function limpiarDetalles(){
    location.reload()
}
function limpiarEgreso(){
    $('#idegreso').val("")
     $('#egreso_input').val("")
     $('#descripcion_input').val("")
}

function cargarFecha() {
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha').val(today);
}

init();