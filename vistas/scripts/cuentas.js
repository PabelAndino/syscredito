

function init() {
listarCuentas()


}


function recargar() {
    location.reload();
}
function listarCuentas(){
    $.ajax({
        url: "../ajax/cuentas.php?op=listar",
        type: 'get',
        success: function(r) {
            $("#detallesCuentas").html(r).dataTable({

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
                "order": [[ 0, "desc" ]],//Ordenar (columna,orden)
                "pagingType": "full_numbers"}).DataTable();

        }
    })


}

function pagarHipoteca(idhipoteca,idgarantia){
    bootbox.confirm("Esta seguro de Pagar la cuenta",function (result) {

        if(result) { //si le dio a si

            $.ajax({
                url: "../ajax/cuentas.php?op=pagarCuenta",
                type: "get", //send it through get method
                data: {
                    'idhipoteca':idhipoteca,
                    'idgarantia':idgarantia

                },

                success: function(data) {
                    bootbox.alert({
                        message: data,
                        callback: function (data) {
                            recargar()
                        }
                    })
                }

                /*error: function(xhr) {
                    //Do Something to handle error
                }*/

            });


        }

    })
}

function volver(idhipoteca,idgarantia){//Sirve por si quiere que la cuenta no este pagada, si despues de pagada quiere reactivar la misma cuenta
    bootbox.confirm("Esta seguro que quiere que la cuente No este pagada? ",function (result) {

        if(result) { //si le dio a si

            $.ajax({
                url: "../ajax/cuentas.php?op=volver",
                type: "get", //send it through get method
                data: {
                    'idhipoteca':idhipoteca,
                    'idgarantia':idgarantia

                },

                success: function(data) {
                    bootbox.alert({
                        message: data,
                        callback: function (data) {
                            recargar()
                        }
                    })
                }

                /*error: function(xhr) {
                    //Do Something to handle error
                }*/

            })


        }

    })
}

function eliminar(idhipoteca){
    bootbox.confirm("Esta seguro que quiere Eliminar la cuenta? ",function (result) {

        if(result) { //si le dio a si

            $.ajax({
                url: "../ajax/cuentas.php?op=eliminar",
                type: "get", //send it through get method
                data: {
                    'idhipoteca':idhipoteca

                },

                success: function(data) {
                    bootbox.alert({
                        message: data,
                        callback: function (data) {
                            recargar()
                        }
                    })
                }

                /*error: function(xhr) {
                    //Do Something to handle error
                }*/

            })


        }

    })
}
function restaurar(idhipoteca){//Si se elimino, se puede volver a recuperar
    bootbox.confirm("Esta seguro que quiere Restaurar la cuenta? ",function (result) {

        if(result) { //si le dio a si

            $.ajax({
                url: "../ajax/cuentas.php?op=restaurar",
                type: "get", //send it through get method
                data: {
                    'idhipoteca':idhipoteca

                },

                success: function(data) {
                    bootbox.alert({
                        message: data,
                        callback: function (data) {
                            recargar()
                        }
                    })
                }

                /*error: function(xhr) {
                    //Do Something to handle error
                }*/

            })


        }

    })
}


init();