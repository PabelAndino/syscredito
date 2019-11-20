var cont=0;
var tabla;
var arr = []; //variable que guarda los stocks idarticulos agregados para luego verificar si existen
var $idCl;
var ultimoabono;
var plazos;
var modalPlazoOpen=false;
var IDSolares,Monto,Interes,Ultimoabonoid,Prima;


//Función que se ejecuta al inicio
function init(){
    limpiarGarantia();
    limpiarAbono();
    listarNuevaCuenta()
    listarAbonosdeldia()
    //cargarFechaSolares();
    var $idC = $('select#buscarClientesAbono').on('change',function(){
        var idCliente = $(this).val();
        $idCl = idCliente;
        console.log($idCl,"ajaaaaaa");
    });
    $('select#plazo').on('change',function(){

    });

    $("#btnBuscarCuenta").on('click',function () {
        listarCuentasCliente($idCl);
    });
    $("#formularioAbono").on("submit",function(e){
        guardaryeditarAbono(e);

        arr.length = 0;
    });
    $("#formularioSolares").on("submit",function(e){
        guardaryeditarSolares(e);
        arr.length = 0;
    });
    $("#formularioCliente").on("submit",function(e){
        guardaryeditarCliente(e);
        arr.length = 0;
    });

    $("#formularioHipoteca").on("submit",function(e){
        guardaryeditarHipoteca(e);
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
    $.post("../ajax/gestionar_hipoteca.php?op=selectGarantia", function(r){
        $("#idgarantia").html(r);
        $('#idgarantia').selectpicker('refresh');

    });
    $.post("../ajax/solares.php?op=buscarClientesAbono",function (r) {
        $("#buscarClientesAbono").html(r);
        $('#buscarClientesAbono').selectpicker('refresh');
    });
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
    $('#fechaSolares').val(today);

}
function cargarFechaSolares() {
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fechaSolares').val(today);
}
function limpiarSolares()
{
    $("#idcliente").val("");
    actualizarPickerCliente();
    cargarFechaSolares();
    $("#plazo").val("");
    $("#monedaSolares").val("");
    $("#monto").val("");
    $("#interes").val("");
    $("#prima").val("");
    $("#comment").val("");
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
function limpiarModalCuenta() {
        //let table= $('#planPagos').DataTable();
        //table.clear().draw();
       //  $('#planPagos tfoot input').val('');
       // $('#planPagos').empty();
     // $('#planPagos').DataTable().fnDraw(false)
    $('#planPagos').dataTable().fnClearTable();


console.log("tabla limpia");
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
function mostrarAbonoInfoS(idsolares,monto) {
    $.ajax({
        url: "../ajax/solares.php?op=listarDetallesAbonoModal",
        type: "get", //send it through get method
        data: {
            'id':idsolares,
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
    $.post("../ajax/solares.php?op=listarDetallesCuenta&id="+idsolares,function(r){

        $("#detallesCuentamodal").html(r);


    });
}
function listarCuentasCliente(idCl){
    tabla=$('#tblCuentasCliente').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons: [

            ],
            "ajax":
                {
                    url: '../ajax/solares.php?op=mostrarCuentasAbono&id='+idCl,//&id se envia al $_GET del php
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
        url: "../ajax/solares.php?op=listarNuevaCuenta",
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
        url: "../ajax/solares.php?op=muestraAbonosdeldia",
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

function guardaryeditarSolares(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formularioSolares")[0]);

    $.ajax({
        url: "../ajax/solares.php?op=guardaryeditarSolares" ,
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
function guardaryeditarAbono(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formularioAbono")[0]);

    $.ajax({
        url: "../ajax/solares.php?op=guardaryeditarAbono" ,
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

            //actualizarPickerGarantia();
        }

    });


    arr.length = 0;
    mostrarCuentas(IDSolares,Monto,Interes,Ultimoabonoid);
    mostrardetallesabono(IDSolares,Monto);

}
function editarAbonoS(iddetalle,nota,interes,capital,moneda) {

    let fecha2=$('#fechaS').val() //porque si se recibe la fecha desde la funcion no solo manda el anio

    $('#fecha_horaAbono').val(fecha2);
    $('#commentAbono').val(nota);
    $('#abonointeres').val(interes);
    $('#abonocapital').val(capital);
    $('#idabonodetalles').val(iddetalle);
    console.log(iddetalle,fecha2,nota,interes,capital,moneda)



}
function eliminarAbono(iddetalle) {


    bootbox.confirm("Seguro que desea eliminar el Abono??",function (result) {

        if(result) { //si le dio a si

            $.ajax({
                url: "../ajax/solares.php?op=eliminarAbono",
                type: "get", //send it through get method
                data: {
                    'iddetalle':iddetalle,

                },
                success: function(r) {

                    bootbox.alert({
                        message: r,
                        callback: function (r) {
                            recargar()
                        }
                    })
                   /* $("#detallesAbonos").html(r).dataTable({

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


                }


                /*error: function(xhr) {
                    //Do Something to handle error
                }*/

            });


        }

    });


}
function eliminarS(idsolares) {
    bootbox.confirm("Seguro que desea eliminar el financiamiento??",function (result) {

        if(result) { //si le dio a si

            $.ajax({
                url: "../ajax/solares.php?op=eliminarS",
                type: "get", //send it through get method
                data: {
                    'id':idsolares


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
function mostrardetallesabono(idSolares,monto) {
    $.ajax({
        url: "../ajax/solares.php?op=listarDetallesAbono",
        type: "get", //send it through get method
        data: {
            'id':idSolares,
            'monto': monto,
            'prima':Prima,

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

        },

        error: function(xhr) {
            //Do Something to handle error
        }

    });

    console.log('La prima', Prima)

}
function mostrarCuentas(idSolares,monto,prima,interes,plazo)
{
    console.log("QUE HIPOTECA LLEGA ",idSolares);
    // $.post("../ajax/gestionar_hipoteca.php?op=obtenerMonto&montos="+monto);
    $.ajax({
        url: "../ajax/solares.php?op=obtenerMonto",
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
        url: "../ajax/solares.php?op=listarDetallesAbono",
        type: "get", //send it through get method
        data: {
            'id':idSolares,
            'monto': monto,
            'prima':prima

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
                "order": [[ 1, "desc" ]],//Ordenar (columna,orden)
                "pagingType": "full_numbers"}).DataTable();

        },

        error: function(xhr) {
            //Do Something to handle error
        }

    });

    $.ajax({
        url: "../ajax/solares.php?op=muestraSumaCapital",
        type: "get", //send it through get method
        data: {
            'idsolares': idSolares

        }
        ,
        success: function(r) {
            var siguienteMonto=(((monto-prima)-r)).toFixed(2);
            var siguienteInteres= ((siguienteMonto * interes)/100).toFixed(2);
            $('#siguienteMonto').val(siguienteMonto);
            $('#siguienteInteres').val(siguienteInteres);
            $('#abonointeres').val(siguienteInteres);
           // console.log(r);
        },
        error: function(xhr) {
            console.log("No devuelve ni M",r);
        }
    });

    $.post("../ajax/solares.php?op=listarDetallesCuenta&id="+idSolares,function(r){

        $("#detallesCuenta").html(r);

        $("#primerMontoAbono").val(monto-prima);


        var resultado = (((monto-prima)*interes))/100;
        var siguienteCapital=((monto-prima)/plazo);
        $("#siguientecapital").val((siguienteCapital).toFixed(2));
        $("#idhipotecaAbonar").val(idSolares);
        $("#primerInteresAbono").val(resultado);
        // $("#abonointeres").val();
        var hipoteca =$("#idhipoteca").val();
        //console.log(hipoteca);
        verificarSiestaVaciosloscamposCapitaleInteres();

    });

    $.post("../ajax/solares.php?op=mostrarUltimoAbono&id="+idSolares,function(r,status){
        ultimoabono = r;
        $('#ultimoidabono').val(ultimoabono);
        mostrarUltimoAbono(ultimoabono);

    });
    $('#idcuentasolares').val(idSolares);
    plazos=plazo;
    IDSolares=idSolares;
    Monto=monto;
    Interes=interes;
    Prima=prima;

}
function estadoCuenta(){

    $.ajax({
        url:"",
        type:"get",
        data:{
            'plazo':plazos
        }

    });
}
function mostrarUltimoAbono(idultimoabono) {

    $.post("../ajax/solares.php?op=muestraAbonoeInteres&ultimoabono="+idultimoabono, function(data, status)
    {
       // console.log("Ultimo Abono desde funcion ", ultimoabono);
        data = JSON.parse(data);
        // $('#abonocapital').val(data.capital);
        //  $('#abonointeres').val(data.interes);

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
}
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
    var interes = document.getElementById("interes");
    var monto = document.getElementById("monto");
    var result = ((monto.value) * (interes.value))/100;
    console.log(result.toFixed(2));
   // $('#temporal').val(result.toFixed(2));
}
function eliminarDetalle(indice)
{
    $("#fila" + indice).remove();
    calcularTotales();
    detalles=detalles-1;
    evaluar();
}
function generarbarcode(){
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
function planPagos(){

    let plazos=$('#plazo').val();
    let monto=$('#monto').val();
    let intereses=$('#interes').val();
    let prima=$('#prima').val();
    if(!(parseFloat(monto) && parseInt(plazos) && parseFloat(intereses))){
        bootbox.alert("El PLAZO, MONTO, O INTERES no debe de estar vacio para poder mostrar plan ni deben ser cero(0)");
    }else{
        $.ajax({
            url: "../ajax/solares.php?op=planPagos",
            type: "get", //send it through get method
            data: {
                'meses':plazos,
                'monto':monto,
                'interes':intereses,
                'prima':prima

            },
            success: function(r) {

                $("#planPagos").html(r).dataTable({

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
                    "iDisplayLength": 48,//Paginación
                    "order": [[ 0, "asc" ]],//Ordenar (columna,orden)
                    "pagingType": "full_numbers"}).DataTable();

                console.log(r);



            },

            error: function(xhr) {
                //Do Something to handle error
            }

        });
    }


}
function estadoPagos(){

    let Capital= $("#inputEstadoPagos").val();

    $.ajax({
        url:'../ajax/solares.php?op=estadoPagos',
        type:'get',
        data:{
            'idsolares':IDSolares,
            'meses':plazos,
            'monto':Monto,
            'interes':Interes,
            'capital':Capital,//le manda el nuevo capital que le gustaria abonar para saber en cuanto quedan los plazos
            'prima':Prima

        },
        success:function (r) {
            $("#controlPagos").html(r).dataTable({

                "aProcessing": true,//Activamos el procesamiento del datatables
                "aServerSide": true,//Paginación y filtrado realizados por el servidor
                dom: 'Bfrtip',//Definimos los elementos del control de tabla
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    {extend: 'print',footer:true}
                ],

                "bDestroy": true,
                "iDisplayLength": 48,//Paginación
                "order": [[ 0, "asc" ]],//Ordenar (columna,orden)
                "pagingType": "full_numbers"}).DataTable();

           // console.log(r);
        }
    });


}
var Plazos;
var UltimoCapital;

function mandaPlazos(plazos,ultimoCapital) {
Plazos=(plazos); //Obtiene los plazos donde se recorre la tabla en el php, el i del for completo,
UltimoCapital=ultimoCapital;
//console.log(Plazos);
//console.log(ultimoCapital," Ultimo capital");
}

function recalculaPlazo(restanteCapital,resto,interes,capitaldivididoentremeses){

    var table=$('#controlPagos').DataTable();
    var inputCapital= document.getElementById("calculaMonto").value;
    $('#spanCapitalRestante'+[0]).html(inputCapital);
  //  var capitalrestante =document.getElementById("calculaMontoinput"+[resto+1]).value;
   // capitalrestante=inputCapital

            for(let i=resto+1;i<=((Plazos));i++){//el resto es el plazo de veces ya abonadas

                let primerEstado=resto+1;
                $('#spanCapitalRestante'+[primerEstado]).html(inputCapital);
                var spanRestantePagos=$('#spanCapitalRestante'+[i]).html();

                var subtotal = UltimoCapital -(parseFloat(spanRestantePagos));
                var Interes= parseFloat((subtotal*interes)/100).toFixed(2);
                $('#calculaInteres'+[i+1]).html(Interes);

                if(subtotal>=0){
                   // var caprestanteRecorrido=document.getElementById("calculaMontoinput"+[i]).value;
                    document.getElementById("subtotal"+[i]).innerHTML = (parseFloat(subtotal).toFixed(2));
                    var ultimoResultado=document.getElementById("subtotal"+[i]).innerHTML = (parseFloat(subtotal).toFixed(2));
                    UltimoCapital=subtotal;
                   // console.log(spanRestantePagos);
                 if(subtotal<0){

                     $('#spanCapitalRestante'+[i]).html(ultimoResultado);
                     document.getElementById("subtotal"+[i]).innerHTML = (parseFloat(0).toFixed(2));
                 }

                }else{

                //    array.push($("#subtotal"+[i]).html());
                   var subtotal2=$("#subtotal"+[i]).html();

                 //   var ultimoSpan=$('#spanCapitalRestante'+[i]).html();

                   // var Interes2= parseFloat(((subtotal2)*interes)/100).toFixed(2);


                    //Interes=Interes2;
                    //$('#calculaInteres'+[i]).html(Interes2);
                  //  console.log(Interes2);
                    /*if(Interes2>0){
                        console.log(Interes2);
                        $('#calculaInteres'+[i]).html(Interes2);
                    }else{

                    }*/

                   /* if(Interes2>0){
                        console.log(Interes2);
                        $('#calculaInteres'+[i-1]).html(Interes2);
                       // console.log(Interes2);
                       // $('#calculaInteres'+[i]).html(Interes);
                       // $('#calculaInteres'+[i+1]).html(Interes);

                    }*/
                   //

                  //


                    //$('#fila'+ (i+1)).remove();
                    //se le pone i-1 porque de lo contrario eliminara los dos ultimos datos, porque si la tabla
                    //tiene un plazo de 22 y abona una cantidad grande entonces el plazo se reduce y solo mostraba datos repetidos y en el subtotal solo 0.00
                    //asi que se procede a eliminar los plazos que ya no estan restantes, sin embargo al no ponerle i-1 me elimina un plazo de mas






                }

           }

}

function comprubaDatosTabla() {
    var table = $('#controlPagos').DataTable();

    table
        .column( 5 )
        .data()
        .each( function ( value, index ) {
            console.log( 'Data in index: '+index+' is: '+value );
        } );
}

function imprimirTabla(){
    //$("#printTabla").window.printArea();
    var divToPrint = document.getElementById('printTabla');
    var htmlToPrint = '' +
        '<style type="text/css">' +
        'table th, table td {' +
        'border:1px solid #000;' +
        'padding;0.5em;' +
        '}' +
        '</style>';
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open("");
    newWin.document.write("<h3 align='center'>Print Page</h3>");
    newWin.document.write(htmlToPrint);
    newWin.print();
    newWin.close();
   // window.print();
}
init();