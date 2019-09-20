var tabla;

//Función que se ejecuta al inicio
function init(){

    cargarFecha()
    cargarSocios()
    hideMontoseditar()
    listarCuentasBancos()
    $('#formularioSocios').on('submit',function (e) {
        guardarSocios(e)
    })
    $('#formulario_ncuenta').on('submit',function (e) {
        guardarNuevaCuentaBancos(e)
    })
}

//SAVE FUNCTIONS
function guardarSocios(e) {
    e.preventDefault()
    let idsocio=$('#idsocio').val()
    let nombres=$('#nombres').val()
    let direccion=$('#direccion').val()
    let tipo_documento=$('#tipo_documento').val()
    let cedula_ruc=$('#cedula_ruc').val()
    let telefono=$('#telefono').val()
    let correo=$('#correo').val()
    $.ajax({
        url:'../ajax/cuenta_banco.php?op=guardarSocios',
        type:'get',
        data:{
            'idsocio':idsocio,
            'nombres':nombres,
            'direccion':direccion,
            'tipo_documento':tipo_documento,
            'cedula_ruc':cedula_ruc,
            'telefono':telefono,
            'correo':correo
        },
        success:function (data) {
            bootbox.alert({
                message:data,
                callback:function (data) {
                   cargarSocios()
                }
            })
        }
    })
}
function guardarNuevaCuentaBancos(e) {
    e.preventDefault()
    let idcuenta_banco = $('#idcuenta_banco').val()
    let socio= $('#socios_picker').val()
    let nombre_banco= $('#banco_nombre').val()
    let num_cuenta= $('#num_cuenta').val()
    let fecha= $('#fecha').val()
    let moneda=$('#moneda').val()
    let monto= $('#monto').val()

    $.ajax({
        url:"../ajax/cuenta_banco.php?op=guardarCuentaBanco",
        type: "get",
        data:{

            'idcuenta_banco':idcuenta_banco,
            'socio':socio,
            'nombre_banco':nombre_banco,
            'num_cuenta':num_cuenta,
            'fecha':fecha,
            'moneda':moneda,
            'monto':monto
        },
        success:function (data) {
            bootbox.alert({
                message:data,
                callback:function(data) {
                    listarCuentasBancos()
                }
            })
        }
    })
}

//LIST SHOW FUNCTIONS
function listarCuentasBancos() {

    $.ajax({
        url:"../ajax/cuenta_banco.php?op=listarCuentasBanco",
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
//SELECT FUNCTIONS
function cargarSocios() {
    $.post("../ajax/cuenta_banco.php?op=selectSocios",function (r) {
      $('#socios_picker').html(r)
      $('#socios_picker').selectpicker('refresh')
})
}



//OTHERS
function hideMontoseditar() {
    $('#montos_picker').hide().removeClass('hidden');
    //To show it: $("#myId").removeClass('d-none');
}
function cargarFecha() {
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha').val(today);
}

init();