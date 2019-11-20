var tabla;

//Función que se ejecuta al inicio
function init(){



   listarSocios()

    $('#formularioSocios').on('submit',function (e) {
        guardarSocios(e)
    })
    tableCaption()
}


function tableCaption() {
    /*$(document).ready( function () {
        $('#listadoSocios').append('<caption class="top-right" >Table caption</caption>')
        var table = $('#listadoSocios').DataTable();
    } )*/

   // $('#listadoSocios caption').text('FUCK YOU!!!!');


}

//SAVE FUNCTIONS
function guardarSocios(e) {
    e.preventDefault()
    let idsocio=$('#idsocio').val()
    let nombres=$('#nombres').val()
    let direccion=$('#direccion').val()
    let tipo_documento=$('#tipo_documento').val()
    let cedula_ruc=$('#cedula_ruc').val()
    let genero=$('#genero').val()
    let telefono=$('#telefono').val()
    let correo=$('#correo').val()
    $.ajax({
        url:'../ajax/socios.php?op=guardarSocios',
        type:'get',
        data:{
            'idsocio':idsocio,
            'nombres':nombres,
            'direccion':direccion,
            'tipo_documento':tipo_documento,
            'cedula_ruc':cedula_ruc,
            'genero':genero,
            'telefono':telefono,
            'correo':correo
        },
        success:function (data) {
            bootbox.alert({
                message:data,
                callback:function (data) {
                    listarSocios()
                    limpiarCampos()
                }
            })
        }
    })
}
//EDIT FUNTIONS
function editSocio(idsocio,nombres,tipo_documento,cedula_ruc,genero,direccion,telefono,correo) {
    $('#idsocio').val(idsocio)
    $('#nombres').val(nombres)
    $('#tipo_documento').val(tipo_documento)
    $('#tipo_documento').selectpicker('refresh')
    $('#cedula_ruc').val(cedula_ruc)
    $('#genero').val(genero)
    $('#genero').selectpicker('refresh')
    $('#direccion').val(direccion)
    $('#telefono').val(telefono)
    $('#correo').val(correo)


}

//DELETE FUNCTIONS

function anularSocio(idsocio) {
    bootbox.confirm("Esta seguro que desea anular este Socio?",function (result) {
        if(result){
            $.ajax({
                url:"../ajax/socios.php?op=anularSocio",
                type:"get",
                data:{
                    'idsocio':idsocio
                },
                success:function (data) {
                    bootbox.alert({
                        message:data,
                        callback:function (data) {
                            listarSocios()
                        }
                    })
                }
            })
        }
    })

}

//RESTORE FUNCTIOS
function activarSocio(idsocio) {
    bootbox.confirm("Esta seguro que desea activar este socio?",function (result) {
        if(result){
            $.ajax({
                url:"../ajax/socios.php?op=activarSocio",
                type:"get",
                data:{
                    'idsocio':idsocio
                },
                success:function (data) {
                    bootbox.alert({
                        message:data,
                        callback:function (data) {
                            listarSocios()
                        }
                    })
                }
            })
        }
    })
}

//LIST SHOW FUNCTIONS
function listarSocios() {

    $.ajax({
        url: "../ajax/printTest.php?op=listarSocios",
        type: "get",
        success:function (data) {
            $('#listadoSocios').html(data).dataTable({
                "aProcessing": true,//Activamos el procesamiento del datatables
                "aServerSide": true,//Paginación y filtrado realizados por el servidor
                "bInfo" : false,
                "bDestroy": true,
                "bFilter": false,
                "paging": false,
                "order": [[ 0, "desc" ]],//Ordenar (columna,orden)

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

function limpiarCampos() {
    $('#idsocio').val("")
    $('#nombres').val("")
    $('#tipo_documento').val("")
    $('#tipo_documento').selectpicker('refresh')
    $('#cedula_ruc').val("")
    $('#genero').val("")
    $('#genero').selectpicker('refresh')
    $('#direccion').val("")
    $('#telefono').val("")
    $('#correo').val("")
}


function imprimirArea() {




    $('#printbtn').hide()
        $("#imprimirArea").show()
        window.print()

    }

init();