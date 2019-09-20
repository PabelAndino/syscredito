var cont=0;
var tabla;
var arr = []; //variable que guarda los stocks idarticulos agregados para luego verificar si existen
var $idCl;
var ultimoabono;

var IDipoteca,Monto,Interes,Ultimoabonoid;

//Función que se ejecuta al inicio
function init(){
    listarAbonosdeldia();
    limpiarGarantia();
    listarNuevaCuenta()
    limpiarAbono();
    fechaFormat();
    var $idC = $('select#buscarClientesAbono').on('change',function(){
        var idCliente = $(this).val();
        $idCl = idCliente;

    });


    $("#btnBuscarCuenta").on('click',function () {
        listarVentasCliente($idCl);
    });


    $("#formularioAbonoFinanciamiento").on("submit",function(e){
        guardaryeditarAbonoFinanciamiento(e);

        arr.length = 0;
    });
    $("#formularioFiador").on("submit",function(e){
        guardaryeditarFiador(e);
        arr.length = 0;
    });
    $("#formularioCliente").on("submit",function(e){
        guardaryeditarCliente(e);
        arr.length = 0;
    });
    $("#formularioGarantia").on("submit",function(e){
        guardaryeditarGarantia(e);
        arr.length = 0;
    });
    $("#formularioFinanciamiento").on("submit",function(e){
        guardaryeditarFinanciamiento(e);
        arr.length = 0;
    });
    $.post("../ajax/gestionar_hipoteca.php?op=selectCliente", function(r){
        $("#idcliente").html(r);
        $('#idcliente').selectpicker('refresh');
    });
    $.post("../ajax/gestionar_hipoteca.php?op=selectFiador", function(r){
        $("#idfiador").html(r);
        $('#idfiador').selectpicker('refresh');

    });

    $.post("../ajax/gestionar_hipoteca.php?op=selectCasaComercial", function(r){
        $("#idcasac").html(r);
        $('#idcasac').selectpicker('refresh');

    });

    $.post("../ajax/gestionar_hipoteca.php?op=selectGarantia", function(r){
        $("#idgarantia").html(r);
        $('#idgarantia').selectpicker('refresh');

    });
    $.post("../ajax/financiamiento.php?op=buscarClientesAbono",function (r) {
        $("#buscarClientesAbono").html(r);
        $('#buscarClientesAbono').selectpicker('refresh');
    });
}
function fechaFormat() {
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fechaFinanciamiento').val(today);
}
//Funciones Recargar
function recargar() {
    location.reload();
}
function cargarCategoria() {
    $.post("../ajax/gestionar_hipoteca.php?op=selectCategoria",function (r) {
        $("#idcategoriaGarantia").html(r); // r es las opciones que nos esta devolviendo el archivo articulo.php en la carpeta ajax cuando la cvariable op sea selectCategoria
        $("#idcategoriaGarantia").selectpicker('refresh');
    });
}
function actualizarPickerGarantia() {

    $.post("../ajax/gestionar_hipoteca.php?op=selectGarantia", function(r){
        $("#idgarantia").html(r);
        $('#idgarantia').selectpicker('refresh');

    });
}
function actualizarPickerFiador() {

    $.post("../ajax/gestionar_hipoteca.php?op=selectFiador", function(r){
        $("#idfiador").html(r);
        $('#idfiador').selectpicker('refresh');

    });

}
function actualizarPickerCliente() {

    $.post("../ajax/gestionar_hipoteca.php?op=selectCliente", function(r){
        $("#idcliente").html(r);
        $('#idcliente').selectpicker('refresh');
    });
}
function cargarCliente() {

    $.post("../ajax/gestionar_hipoteca.php?op=selectCliente", function(r){
        $("#idcliente2").html(r);
        $('#idcliente2').selectpicker('refresh');
    });
}
//Función limpiar
function limpiarGarantia()
{
    $("#nombreGarantia").val("");
    cargarCliente();
    $("#cliente").val("");
    $("#precioGarantia").val("");
    $("#descripcionGarantia").val("");
    $("#fila").remove();
    arr.length = 0;

    //recorre la cantidad de filas segun los indices y las remueve una a una hasta terminar
    for(i=0;i<cont;i++){
        $("#fila" + i).remove();
        console.log(i);
    }
    //Obtenemos la fecha actual
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fechaHipoteca').val(today);

}
function limpiarFiador()
{
    $("#nombreFiador").val("");
    $("#emailFiador").val("");
    $("#num_documentoFiador").val("");
    $("#direccionFiador").val("");
    $("#telefonoFiador").val("");
    $("#idpersonaFiador").val("");
    //  $("#detalles").closest().remove();


}
function limpiarCliente()
{
    $("#nombreCliente").val("");
    $("#emailCliente").val("");
    $("#num_documentoCliente").val("");
    $("#direccionCliente").val("");
    $("#telefonoCliente").val("");
    $("#idpersonaCliente").val("");
    //  $("#detalles").closest().remove();


}
function limpiarAbono()
{
    //recorre la cantidad de filas segun los indices y las remueve una a una hasta terminar
    /*  for(i=0;i<cont;i++){
          $("#fila" + i).remove();
          console.log(i);
      }*/
    //Obtenemos la fecha actual
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_horaAbono').val(today);

}
//Función mostrar formulario
function mostrarform(flag)
{

}
function listarVentasCliente(idCl){
    tabla=$('#tblCuentasCliente').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons: [

            ],
            "ajax":
                {
                    url: '../ajax/financiamiento.php?op=mostrarCuentasAbono&id='+idCl,//&id se envia al $_GET del php
                    type : "get",
                    dataType : "json",
                    error: function(e){
                        console.log(e.responseText);
                    }
                },
            "bDestroy": true,
            "iDisplayLength": 5,//Paginación
            "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
        }).DataTable();

}
function listarNuevaCuenta() {
    let fecha = Date.now();
    $.ajax({
        url: "../ajax/financiamiento.php?op=listarNuevaCuenta",
        type: "get", //send it through get method


        success: function(r) {
            $("#detallesNuevaCuenta").html(r).dataTable({

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
            //Do Something to handle error
        }

    });
}
function listarAbonosdeldia() {
    $.ajax({
        url: "../ajax/financiamiento.php?op=muestraFinanciamientos",
        type: "get", //send it through get method

        success: function(r) {
            $("#tbllistadoHipotecas").html(r).dataTable({

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
            //Do Something to handle error
        }

    });
}
//Funciones GuardarEditar
function guardaryeditarFiador(e){
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formularioFiador")[0]);


    $.ajax({
        url: "../ajax/gestionar_hipoteca.php?op=guardaryeditarFiador" ,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {
            bootbox.alert(datos);
            mostrarform(false);

            actualizarPickerFiador();
        }

    });

    limpiarFiador();
    arr.length = 0;
}
function guardaryeditarCliente(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formularioCliente")[0]);

    $.ajax({
        url: "../ajax/gestionar_hipoteca.php?op=guardaryeditarCliente" ,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {
            bootbox.alert(datos);
            mostrarform(false);

            actualizarPickerCliente();
        }

    });

    limpiarCliente();
    arr.length = 0;
}
function guardaryeditarGarantia(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formularioGarantia")[0]);

    $.ajax({
        url: "../ajax/gestionar_hipoteca.php?op=guardaryeditarGarantia" ,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {
            bootbox.alert(datos);
            mostrarform(false);

            actualizarPickerGarantia();
        }

    });

    limpiar();
    arr.length = 0;
}
function guardaryeditarFinanciamiento(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formularioFinanciamiento")[0]);

    $.ajax({
        url: "../ajax/financiamiento.php?op=guardaryeditarFinanciamiento" ,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {
            bootbox.alert({
                message: datos,
                callback: function (result) {
                    recargar()
                }
            });
        }

    });


    arr.length = 0;
}
function guardaryeditarAbonoFinanciamiento(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formularioAbonoFinanciamiento")[0]);

    $.ajax({
        url: "../ajax/financiamiento.php?op=guardaryeditarAbonoFinanciamiento" ,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {
            bootbox.alert({
                message: datos,
                callback: function (result) {
                    recargar()
                }
            });



            mostrarform(false);

            //actualizarPickerGarantia();
        }

    });




    arr.length = 0;
    mostrarCuentas(IDipoteca,Monto,IDipoteca,Ultimoabonoid);

}
function eliminarF(idfinanciamiento) {
    bootbox.confirm("Seguro que desea eliminar el financiamiento??",function (result) {

        if(result) { //si le dio a si

            $.ajax({
                url: "../ajax/financiamiento.php?op=eliminarF",
                type: "get", //send it through get method
                data: {
                    'id':idfinanciamiento


                    /*$("#detallesAbonos").html(r).dataTable({

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
                        "pagingType": "full_numbers"}).DataTable();*/

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

    });
}

function editarAbonoF(iddetalle,nota,interes,capital,moneda) {

    let fecha2=$('#fechaF').val() //porque si se recibe la fecha desde la funcion no solo manda el anio

    $('#fecha_horaAbono').val(fecha2);
    $('#commentAbono').val(nota);
    $('#abonointeres').val(interes);
    $('#abonocapital').val(capital);
    $('#idabonodetalles').val(iddetalle);
    console.log(iddetalle,fecha2,nota,interes,capital,moneda)



}
function eliminarAbonoF(iddetalle) {


    bootbox.confirm("Seguro que desea eliminar el Abono??",function (result) {

        if(result) { //si le dio a si

            $.ajax({
                url: "../ajax/financiamiento.php?op=eliminarAbono",
                type: "get", //send it through get method
                data: {
                    'id':iddetalle


                        /*$("#detallesAbonos").html(r).dataTable({

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
                            "pagingType": "full_numbers"}).DataTable();*/

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

    });


}
function verificarSiestaVaciosloscamposCapitaleInteres() {
    var interes = document.getElementById("abonointeres");
    var capital = document.getElementById("abonocapital");

    if(interes.value == ""){
        console.log("Vamos bien, campos interes y capital vacios");
    }
}
function abonar(id) {

}
//Declaración de variables necesarias para trabajar con las compras y
//sus detalles
var impuesto=15;
var detalles=0;
$("#btnGuardar").hide();
function mostrarNumero() {


    $.post("../ajax/venta.php?op=mostrarNumero",function (q) {

        $("#num_comprobante").val(q);


    });

}
function mostrarCuentas(idFinanciamiento,monto,interes,ultimoabonoid)
{
    console.log("QUE HIPOTECA LLEGA ",idFinanciamiento);
    // $.post("../ajax/gestionar_hipoteca.php?op=obtenerMonto&montos="+monto);
    $.ajax({
        url: "../ajax/financiamiento.php?op=obtenerMonto",
        type: "get", //send it through get method
        data: {
            'monto': monto,
            'interes': interes,

        }/*,
        success: function(response) {
            //Do Something
        },
        error: function(xhr) {
            //Do Something to handle error
        }*/
    });
    $.ajax({
        url: "../ajax/financiamiento.php?op=listarDetallesAbono",
        type: "get", //send it through get method
        data: {
            'id':idFinanciamiento,
            'monto': monto,


        },
        success: function(r) {
            $("#detallesAbonos").html(r).dataTable({

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
            $('#detallesAbonos').find("caption").text("El cliente mas chingon");
        },

        error: function(xhr) {
            //Do Something to handle error
        }

    });

    $.ajax({
        url: "../ajax/financiamiento.php?op=muestraSumaCapital",
        type: "get", //send it through get method
        data: {
            'idfinanciamiento': idFinanciamiento

        }
        ,
        success: function(r) {
            var siguienteMonto=(monto-r);
            var siguienteInteres= (siguienteMonto * interes)/100;
            $('#siguienteMonto').val(siguienteMonto);
            $('#siguienteInteres').val(siguienteInteres);
            $('#abonointeres').val(siguienteInteres);
            console.log(r);
        },
        error: function(xhr) {
            console.log("No devuelve ni M",r);
        }
    });

    $.post("../ajax/financiamiento.php?op=listarDetallesCuenta&id="+idFinanciamiento,function(r){

        $("#detallesCuenta").html(r);

        $("#primerMontoAbono").val(monto);


        var resultado = ((monto*interes))/100
        $("#idfinanciamientoAbonar").val(idFinanciamiento);
        $("#primerInteresAbono").val(resultado);
        // $("#abonointeres").val();
        var hipoteca =$("#idhipoteca").val();
        //console.log(hipoteca);
        verificarSiestaVaciosloscamposCapitaleInteres();

    });


    $.post("../ajax/financiamiento.php?op=mostrarUltimoAbono&id="+idFinanciamiento,function(r,status){
        ultimoabono = r;
        $('#ultimoidabono').val(ultimoabono);
        mostrarUltimoAbono(ultimoabono);

    });

    IDipoteca=idFinanciamiento;
    Monto=monto;
    Interes=interes;
    Ultimoabonoid=ultimoabonoid;

}
function mostrarUltimoAbono(idultimoabono) {

    $.post("../ajax/gestionar_hipoteca.php?op=muestraAbonoeInteres&ultimoabono="+idultimoabono, function(data, status)
    {
        console.log("Ultimo Abono desde funcion ", ultimoabono);
        data = JSON.parse(data);
        // $('#abonocapital').val(data.capital);
        //  $('#abonointeres').val(data.interes);

    });

}
function mostrarAbonoInfoF(idfinanciamiento,monto) {
    $.ajax({
        url: "../ajax/financiamiento.php?op=listarDetallesAbonoModal",
        type: "get", //send it through get method
        data: {
            'id':idfinanciamiento,
            'monto': monto,


        },
        success: function(r) {
            $("#detallesAbonosmodal").html(r).dataTable({

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
            //Do Something to handle error
        }

    });
    $.post("../ajax/financiamiento.php?op=listarDetallesCuenta&id="+idfinanciamiento,function(r){

        $("#detallesCuentamodal").html(r);


    });
}
const objetos = {
    nombre:document.getElementById("nombreGarantia"),
    descripcion : document.getElementById("descripcionGarantia"),
    categoria : $('#idcategoriaGarantia option:selected').text(),
    idcategoria: $('#idcategoriaGarantia').val(),
    idcliente: $('#idcliente2').val(),
    moneda:$('#monedaGarantia').val(),
    precio:$('#precioGarantia').val(),
    sourceImage: $('#imagen').val(),
    imagen :$('#imagenactualGarantia').val()
};
function sacarDetalles() {

    var nombre = document.getElementById("nombreGarantia");
    var descripcion = document.getElementById("descripcionGarantia");

    var categoria = $('#idcategoriaGarantia option:selected').text();
    var idcategoria = $('#idcategoriaGarantia').val();
    var idcliente = $('#idcliente2').val();
    var moneda =$('#monedaGarantia').val();
    var precio =$('#precioGarantia').val();
    var sourceImage = $('#imagen').val();
    var imagen = $('#imagenactualGarantia').val();
    //console.log(idcliente);
    agregarDetalle(nombre,idcliente,descripcion.value,idcategoria,categoria,"CODIGO",precio,moneda,"Deuda",imagen,sourceImage);

}
function cargarImagen() {
    /*$(window).load(function () {
        $(function () {
            $('#file-input').change(function (e) {
                addImage(e);
            });
            function addImage(e) {
                var file = e.target.files[0],
                    imageType = /image.*!/;
                if(!file.type.match(imageType))
                    return;
                var reader = new FileReader();
                reader.onload = fileOnload;
                reader.readAsDataURL(file);
            }
            function fileOnload(e) {
                var result =e.target.result;
                $('#imgSalida').attr("src",result);
            }
        });
    });*/

    /*    document.getElementById("file").onchange = function (ev) {
            var reader = new FileReader();
            reader.readAsDataURL(e.target.files[0]);
            reader.onload = function () {
                var preview = document.getElementById("preview"), image = document.createElement('img');
                img.src = reader.result;
                preview.innerHTML = '';
                preview.append(image);
            }
        };*/

}
function agregarDetalle(nombre,idcliente,descripcion,idcategoria,categoria,codigo,precio,moneda,estado,image,sourceImage)
{

    var descuento=0;
    var precioVenta = 1
    if (idcliente!="" && nombre !="" && descripcion !="")
    {
        if(arr.includes(descripcion))
        { //verifica si ya existe el id en el array
            console.log(arr);
            console.log("El articulo ya existe 😏");
            bootbox.alert("El articulo ya existe 😏");

        } else
        {

            var fila='<tr class="filas" id="fila'+cont+'">'+
                //onkeypress="modificarSubototales()"

                '<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+

                '<td style="white-space: nowrap;min-width: 200px;max-width: 200px;overflow: scroll"><input type="hidden" name="descripcion[]" value="'+descripcion+'" >'+descripcion+'</td>'+

                '<td><input type="hidden" name="categoria[]" value="'+idcategoria+'">'+categoria+'</td>'+

                '<td><input type="hidden" name="codigo[]" value="'+codigo+'">'+codigo+'</td>'+

                '<td><input type="hidden" name="precio[]" value="'+precio+'">'+precio+'</td>'+

                '<td><input type="hidden" name="moneda[]" value="'+moneda+'">'+moneda+'</td>'+




                '</tr>';
            cont++;
            detalles=detalles+1;

            $('#tablaGarantia').append(fila);
            arr.push(descripcion);
            console.log(arr);


            //  arr.push(articulo); //agrega al array todos los id de articulos

        }
    }
    else
    {
        alert("Error al ingresar el detalle, REVISE QUE NOMBRE, CLIENTO Y DESCRIPCION NO ESTEN VACIOS");
    }
}
function evaluar(){
    var interes = document.getElementById("interesFinanciamiento");
    var monto = document.getElementById("montoFinanciamiento");
    var result = ((monto.value) * (interes.value))/100;
    console.log(result.toFixed(2));
    $('#temporal').val(result.toFixed(2));


    $.ajax({
        url: "../ajax/financiamiento.php?op=testFecha",
        type: "get", //send it through get method

        success: function(r) {
            console.log(r);
            bootbox.alert(r);
        },

        error: function(xhr) {
            //Do Something to handle error
        }

    });
}
function eliminarDetalle(indice)
{
    $("#fila" + indice).remove();
    calcularTotales();
    detalles=detalles-1;
    evaluar();
}
function generarbarcode() {
    /*codigo=$("#codigo").val();
    JsBarcode("#barcode",codigo);*/
    var fecha = new Date();
    $.post("../ajax/articulo.php?op=generarCodigo", function (data,status) { //este data sera llenado con lo que reciba de mostrar del ajax

        $("#codigo").val(fecha.getFullYear().toString() + fecha.getDate().toString() + (fecha.getMonth()+1).toString() + data);

        codigo=$("#codigo").val();
        JsBarcode("#barcode",codigo);
        $("#print").show();
    });
}
function mostrarbarcode(){
    codigo=$("#codigo").val();
    JsBarcode("#barcode",codigo);
    $("#print").show();
}
function imprimir() {
    $("#print").printArea();
}
init();