

//Función que se ejecuta al inicio
function init(){


fechaActual()
lists()


}
//Show

function muestraEstadoCuenta() {

    let plazo = $('#plazo_month').val()
    let monto = $('#monto_ncuenta').val()
    let interes = $('#interes').val()
    let moneda = $('#monedaHipoteca').val()
    let mValor = $('#mantenimiento').val()
    let fecha = $('#fechaPago').val()
    let fechaDesembolso = $('#fechaHipoteca').val()
    $.ajax({
        url:'../ajax/gestionar_hipoteca.php?op=muestraEstado',
        type:'get',
        data:{
            'plazos':plazo,
            'monto':monto,
            'interes':interes,
            'moneda':moneda,
            'mValor':mValor,
            'fechaPago':fecha,
            'desembolso':fechaDesembolso
        },
        success:function (data) {
            $('#detallesEstado').html(data).dataTable({
                "aProcessing": true,//Activamos el procesamiento del datatables
                "aServerSide": true,//Paginación y filtrado realizados por el servidor
                "bInfo" : false,
                "bDestroy": true,
                "bFilter": false,
                "paging": false,
                "order": [[ 0, "asc" ]],//Ordenar (columna,orden)
            }).DataTable()
        }
    })

    let comision =  $('#comision').val()
    let comision_porcentaje =  ((comision * monto)/100)
    let suma_comision
    if (comision_porcentaje === 0){
        suma_comision = parseFloat(comision_porcentaje)
    }else{
        suma_comision = parseFloat(comision_porcentaje) + parseFloat(monto)
    }

    $('#comision_porcentaje').val(comision_porcentaje)
    $('#comision_total').val(suma_comision)
    console.log(suma_comision)
}


//DELETE FUNCTIONS



//RESTORE FUNCTIOS


//LIST SHOW FUNCTIONS
function lists() {
    $.post("../ajax/gestionar_hipoteca.php?op=selectCliente", function(r){
        $("#idcliente_solicitud").html(r);
      //  $('#idcliente_solicitud').selectpicker('refresh');
    })
    $.post("../ajax/gestionar_hipoteca.php?op=selectFiador", function(r){
        $("#idfiador_picker").html(r);
     //   $('#idfiador_picker').selectpicker('refresh');
    })
    $.post("../ajax/gestionar_hipoteca.php?op=selectSolicitud", function(r){
        $("#idsolicitud_picker").html(r);
      //  $('#idsolicitud_picker').selectpicker('refresh');
    })
}
//SELECT FUNCTIONS




//OTHERS


function fechaActual() {

    // document.getElementById("fechaPago").value = new Date().toISOString().substring(0, 10)
     document.getElementById('fechaPago').valueAsDate = new Date();

    document.getElementById('fechaHipoteca').valueAsDate = new Date();
}


function imprimirArea() {

  //  $('#printbtn').hide()
     $('#btnPlanPago').hide()

        window.print()

}

init();