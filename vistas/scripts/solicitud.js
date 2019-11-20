var tabla;

//Función que se ejecuta al inicio
function init(){


  $('#formulario_nueva_solicitud').on('submit',function (e) {
       
    //  guardarNuevaSolicitud(e)


    })
   listarSolicitudes()

  
    tableCaption()
    listarSectorCliente()
}

function listarSectorCliente(){
    $.post("../ajax/gestionar_hipoteca.php?op=selectCliente", function(r){
        $("#idcliente_solicitud").html(r);
        $('#idcliente_solicitud').selectpicker('refresh');
    })
    $.post("../ajax/gestionar_hipoteca.php?op=selectSector", function(r){
        $("#idsector_picker").html(r);
        $('#idsector_picker').selectpicker('refresh');
    })
}

function tableCaption() {
    /*$(document).ready( function () {
        $('#listadoSocios').append('<caption class="top-right" >Table caption</caption>')
        var table = $('#listadoSocios').DataTable();
    } )*/

   // $('#listadoSocios caption').text('FUCK YOU!!!!');


}

//SAVE FUNCTIONS
function guardarNuevaSolicitud() {
   // e.preventDefault()
    let sabe_leer //= ($('#leersi').is(":checked")) ? "Si" ? $('#leerno').is(":checked") : "No" :

    if($('#leersi').is(":checked")){ //verifica si sabe leer
        sabe_leer='Si'
    }else  if($('#leerno').is(":checked")){
        sabe_leer='No'
    }
    let idsolicitud= $('#idsolicitud').val() 
    let idcliente=$('#idcliente_solicitud').val()
    let conyugue=$('#nombre_conyugue').val()
    let tipo_local=$('#tipo_local').val()
    let ultimo_anio=$('#ultimoaprov').val()
    let num_dependientes=$('#num_dependientes').val()
    let ingresos = []//Guarda todos los ingresos de los checkbox
    let total_ingresos=$('#total_ingresos').val()
    let sector=$('#idsector_picker').val()
    let objetivo_prestamo=$('#objetico_prestamo').val()


        $.each($("input[name='check']:checked"), function(){ //verifica que todos los checks seleccionados
            ingresos.push($(this).val());
        });

    $.ajax({
        url:"../ajax/gestionar_hipoteca.php?op=guardarSolicitud",
        type:'get',
        data:{
            'idsolicitud':idsolicitud,
            'idcliente':idcliente,
            'sabeleer':sabe_leer,
            'conyugue':conyugue,
            'tipo_local':tipo_local,
            'ultimo_anio':ultimo_anio,
            'num_dependientes':num_dependientes,
            'ingresos':ingresos,
            'total_ingresos':total_ingresos,
            'sector':sector,
            'objetivo_prestamo':objetivo_prestamo

        },
        success:function (data) {
            bootbox.alert({
                message:data,
                callback:function (data) {
                   listarSolicitudes() 
                }
            })
        }

    })
}
//EDIT FUNTIONS
function editSolicitud(idsolicitud,cliente,nombre_conyugue,tipo_local,leer_escribir,
    ultimo_estudio_anio,numero_dependientes,total_ingresos,sector,obj_prestamo,estado) {
    
      console.log(idsolicitud,cliente,nombre_conyugue,tipo_local,leer_escribir,
        ultimo_estudio_anio,numero_dependientes,total_ingresos,sector,obj_prestamo,estado)
 
    $('#idsolicitud').val(idsolicitud)    
    $('#idcliente_solicitud').val(cliente)
    $('#idcliente_solicitud').selectpicker('refresh')
    $('#nombre_conyugue').val(nombre_conyugue)
    $('#tipo_local').val(tipo_local)
    
    if(leer_escribir === 'Si'){
        $('#leersi').prop('checked',true)
    }else if(leer_escribir === 'No'){
        $('#leerno').prop('checked',true)
    }

    $('#ultimoaprov').val(ultimo_estudio_anio)
    $('#num_dependientes').val(numero_dependientes)
    
    $('#total_ingresos').val(total_ingresos)
    $('#idsector_picker').val(sector)
    $('#idsector_picker').selectpicker('refresh')

    $('#objetico_prestamo').val(obj_prestamo)
    
    $.each($("input[name='check']"), function(){ //Primero que esta funcion es llamada por en uncheck todos los chechks
        //para cuando sea llamada la funcion ingresos mensuales pueda llenar los checks, si no se vacian aqui, una vez que se llenan,
        //aunque se llene con otro valor que tiene menos checks siempre quedan llenos, entonces primero se vacian y luego se llenan
         $(this).prop('checked',false)
     })
    ingresosMensuales(idsolicitud)

}

function ingresosMensuales(idsolicitud){
    $.ajax({
        url:'../ajax/solicitud.php?op=selectIngreso',
        type: 'get',
        data:{ 'idsolicitud':idsolicitud },

        success:function(ingresos){
            ingresos = JSON.parse(ingresos) //convierte los elementos a JSON para poder ser recorrerlos
            
              ingresos.forEach(element => { //recorrer cada elemento del JSON que contienen los ingreoso
                 
                  $.each($("input[name='check']"), function(){ //recorrer todos los checks
                    // y verifica si el valor es igual al contenido en ingreso, si es igual le pone el check
                   // ingresos.push($(this).val());
                    if(($(this).attr('value') === element)){ 
                        $(this).prop('checked',true)
                    }
                   

                })
              })
        },
        error:function(ingresos){
            console.log(ingresos)
        }
        
    })
   
}

//DELETE FUNCTIONS

function anularSolicitud(idsolicitud) {
    bootbox.confirm("Esta seguro que desea anular esta solicitud?",function (result) {
        if(result){
            $.ajax({
                url:"../ajax/solicitud.php?op=anularSolicitud",
                type:"get",
                data:{
                    'idsolicitud':idsolicitud
                },
                success:function (data) {
                    bootbox.alert({
                        message:data,
                        callback:function (data) {
                            listarSolicitudes()
                        }
                    })
                }
            })
        }
    })

}

//RESTORE FUNCTIOS
function activarSolicitud(idsolicitud) {
    bootbox.confirm("Esta seguro que desea activar esta solicitud?",function (result) {
        if(result){
            $.ajax({
                url:"../ajax/solicitud.php?op=activarSolicitud",
                type:"get",
                data:{
                    'idsolicitud':idsolicitud
                },
                success:function (data) {
                    bootbox.alert({
                        message:data,
                        callback:function (data) {
                            listarSolicitudes()
                        }
                    })
                }
            })
        }
    })
}

//LIST SHOW FUNCTIONS
function listarSolicitudes() {

    $.ajax({
        url: "../ajax/solicitud.php?op=listarSolicitudes",
        type: "get",
        success:function (data) {
            $('#listadoSocios').html(data).dataTable({
                "aProcessing": true,//Activamos el procesamiento del datatables
                "aServerSide": true,//Paginación y filtrado realizados por el servidor
                dom: 'Bfrtip',//Definimos los elementos del control de tabla
                buttons: [

                    /*{
                    extend:'print',
                    text: 'CSV',
                    title: 'QUE NOTA PERRO QUE ME DICIEMBRE',
                    customize: function ( win ) {
                        $(win.document.body)
                            .css( 'font-size', '10pt' )
                            .prepend(
                                '<img src="http://datatables.net/media/images/logo-fade.png" style="position:marker  top:0; left:0;" />'
                            );

                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );
                    }

                },*//*
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdf'*/

                    'copy',
                    {
                        extend: 'excel',
                        messageTop: 'The information in this table is copyright to Sirius Cybernetics Corp.'
                    }
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
        $("#imprimirArea").show()
        window.print()

    }

init();