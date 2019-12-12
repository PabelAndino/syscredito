var cont=0;
var tabla;
var arr = []; //variable que guarda los stocks idarticulos agregados para luego verificar si existen
var $idcliente_ncuenta;
var ultimoabono;
var pendiente_de_abono = 0.00;
var abono_a_capital = 0.00;

var IDipoteca,Monto,Interes,Ultimoabonoid;
var capitalAAbonar //asignara el capital a abonar porque no sale de la funcion ajax que lo obtiene y no puede ser llamado de una
//funcion externa entonces se asignara a esta variable global

//Función que se ejecuta al inicio
function init(){
        listarAbonosdeldia();
  
        fechaActual()
        pickerChange()
        initFUNCTIONS()
        listarBancos()

        getTipoCambio()
        setTipoCambio()
        
}

function setTipoCambio(){
    


    var $cambio = $('select#monedaHipoteca').on('change',function(){
        let tipo_cambio = $('#cambio_dolar').val()
        let moneda = $(this).val(); //cada que cambie asignara su valor a la variable moneda
        let monto = parseFloat($("#monto_ncuenta").val().replace(',', ''))//reemplazara la coma del monto por nada y quedara una sola sifra
        let moneda_val = ($('#banco_moneda').text()).trim() //el Label que indica si es dolares o cordobas la cuenta de socios a la que se debitara
        console.log(moneda_val)
        if(moneda === "Cordobas"){ //si la moneda seleccionada es cordobas

            if(moneda_val === "Dolares"){ //si la moneda selccionada es cordobas y la cuenta esta en dolares
                console.log("No joda primo")
                let calculo = (monto / parseFloat(tipo_cambio)).toFixed(2)
             //   $('#monto_total').val(monto)
                $('#cambio').val(calculo)
            }else{
                $('#cambio').val(parseFloat(monto).toFixed(2))

            }
            // let calculo = parseFloat(monto * parseFloat(tipo_cambio)).toFixed(2)
            // console.log("Conversion ",calculo,moneda_val)
        }else{ //si la moneda seleccionada es dolares
            if(moneda_val === "Dolares"){ // si la moneda seleccionada es dolares y si la cuenta esta en dolares 
                $('#cambio').val(parseFloat(monto).toFixed(2))
                
            }else{ //si la cuenta esta en cordobas y la moneda seleccionada en dolares

                let calculo = (monto * parseFloat(tipo_cambio)).toFixed(2)
                $('#cambio').val(calculo)

                
            }
            
        }
        



   })


}

function resetCambioMoneda(){//resetea la moneda y el tipo de cambio al hacer ciertos cambios en controles
    $("#monedaHipoteca").val('default');
    $("#monedaHipoteca").selectpicker("refresh");
    $('#cambio').val('')
}

function getTipoCambio(){
    $.ajax({
        url: 'https://free.currconv.com/api/v7/convert?q=USD_NIO&compact=ultra&apiKey=20c75241f5f1d3c74188',
        type: 'GET',
        dataType:'json',
        success: function(res) {
            console.log(res)
 
            for (var clave in res){
                // Controlando que json realmente tenga esa propiedad
                if (res.hasOwnProperty(clave)) {
                  // Mostrando en pantalla la clave junto a su valor
                  $('#cambio_dolar').val(res[clave])
                 // console.log("La clave es " + clave+ " y el valor es " + res[clave]);
                // setCambio() //una vez es llamada mostrado el tipo de cambio llama a la funcion para que pueda mostrar el tipo de cambio y calcularlo
                }
              }
        },
        error:function(){
            $('#cambio_dolar').val('Sin conexion')
        }
      })


      
      
}
//Funciones Recargar
function recargar() {
    location.reload();
}
//SPECIAL FUNCTIONSS

function initFUNCTIONS() {

    $("#formularioAbono").on("submit",function(e){ //guardar fiador
        guardaryeditarAbono(e);

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
    $("#formularioHipoteca").on("submit",function(e){
        guardaryeditarHipoteca(e);
        arr.length = 0;
    });
    $("#formulario_nueva_solicitud").on("submit",function(e){

        guardarNuevaSolicitud(e)
        arr.length = 0;
    });
    $.post("../ajax/gestionar_hipoteca.php?op=selectCliente", function(r){
        $("#idcliente_solicitud").html(r);
        $('#idcliente_solicitud').selectpicker('refresh');
    });//Muestra clientes en PICKER
    $.post("../ajax/gestionar_hipoteca.php?op=selectFiador", function(r){
        $("#idfiador_picker").html(r);
        $('#idfiador_picker').selectpicker('refresh');
    })//Muestra Fiador en PICKER
    $.post("../ajax/gestionar_hipoteca.php?op=selectSector", function(r){
        $("#idsector_picker").html(r);
        $('#idsector_picker').selectpicker('refresh');
    })//Muestra Los sectores
    $.post("../ajax/gestionar_hipoteca.php?op=selectSolicitud", function(r){
        $("#idsolicitud_picker").html(r);
        $('#idsolicitud_picker').selectpicker('refresh');
    })//Muestra Las solicitudes picker
    $.post("../ajax/gestionar_hipoteca.php?op=selectGarantia", function(r){
        $("#idgarantia").html(r);
        $('#idgarantia').selectpicker('refresh');

    });//Muestra las garantias
    $.post("../ajax/gestionar_hipoteca.php?op=buscarClientesAbono",function (r) {
        $("#buscarClientesAbono").html(r);
        $('#buscarClientesAbono').selectpicker('refresh');
        $('#buscarClientesAbonolista').html(r);
        $('#buscarClientesAbonolista').selectpicker('refresh');

    });

    $("#ultimoaprov").prop('disabled', true);

    pickerChangeBanco()
    listarNuevasCuentas()
    calculaCuotaaEnviar()
   

}

function calculaCuotaaEnviar(){ //al presionar enter calcula la cuota
    $('#monto_pago').on("keydown", function (e) {
        if (e.keyCode === 13) {  //checks whether the pressed key is "Enter"
           // validate(e);
           e.preventDefault()
           

           calculaCuotaaEnviarFuncion()
             
        }


    })

    
}
function calculaCuotaaEnviarFuncion(){

           let mont = parseFloat($("#monto_pago").val()).toFixed(2)//El valor del monto
           let amortizacion = parseFloat($("#abono_capital").val()).toFixed(2)
          // let intereses = parseFloat($("#totalAbono").val()).toFixed(2)
           let cuota =  parseFloat($("#cuota").val()).toFixed(2)
           let interes =  parseFloat($('#abonointeres').val()).toFixed(2)
           let intereses =  parseFloat($('#intereses').val()).toFixed(2)
           let interes_moratorio = parseFloat($('#interes_moratorio_abono').val()).toFixed(2) 
           let mantenimiento = parseFloat($('#mantValortotal').val()).toFixed(2)
         //   let amortizacion = parseFloat($('#abono_capital').val()).toFixed(2)
          //  let cuota = parseFloat($('#cuota').val()).toFixed(2)
            let monto_pago = parseFloat($('#monto_pago').val()).toFixed(2)
            var cuotiado = monto_pago
            let pendiente = parseFloat(parseFloat(intereses) - parseFloat(monto_pago)).toFixed(2)

            if(parseFloat(monto_pago) != parseFloat(cuota)){
                if( parseFloat(monto_pago) >  parseFloat(cuota) ){//si das mas de la cuota
                    let montoLocal = parseFloat(monto_pago)
                    let cuotaLocal = parseFloat(cuota)
                    let a_capital =( parseFloat(montoLocal) - parseFloat(cuotaLocal) ) + parseFloat(amortizacion)
                    labelsPendientes(0.00,parseFloat(a_capital).toFixed(2))
                   
                }
                 if(parseFloat(monto_pago) < parseFloat(cuota)){ //si el monto que paga es menor a la cuota //una vez entra aqui puede que la monto sea mayor a los intereses pero menor que la cuota
                    
                        if( parseFloat(monto_pago) >= parseFloat(intereses) ){ //si el pago es mayor que los intereses sumados
                           
                            let montoLocal = parseFloat(monto_pago)
                            let interesLocal = parseFloat(intereses)
                            let a_capital = parseFloat(montoLocal) - parseFloat(interesLocal) //lo que se va a guardar de capital
                          
                            labelsPendientes(0.00,parseFloat(a_capital).toFixed(2))
                          
                        }
                         if(  parseFloat(monto_pago) < parseFloat(intereses) ){ //Si el monto es menor que la suma de intereses verificara uno a uno los intereses y no abonara al capital y tendra un pendiente 
                            let montoLocal = parseFloat(monto_pago)
                            let interesesLocal = parseFloat(intereses)//la suma de todos intereses
                            let interesLocal = parseFloat(interes)//solo interes
   
                             labelsPendientes(pendiente,0.00,)    
        
                         }          
        
                }
            }
            if(parseFloat(monto_pago) === parseFloat(cuota)){

                labelsPendientes(0.00,parseFloat(amortizacion).toFixed(2))
            }
           
        
}
//funcion cambia los Span y labels de los pendientes
function labelsPendientes(pendiente,a_capital){

    $('#label_pendiente').html(pendiente)
    $('#input_pendiente').val(pendiente)
    $('#label_a_capital').html(a_capital)
    $('#commentAbono').text('')



    if(parseFloat(a_capital) > 0){
        let saldo_viejo =  parseFloat($('#siguienteMontoHide').val())//el saldo que tiene cuando carga los valores,se asigno el mismo valor a un input oculto porque de otra manera
        //recalcula el resultado en cada enter ya que hay un resultado distinto en el texbox y lo calcula basado en cada resultado, mientras con el input oculto mantiene el mismo
        //resultado todo el tiempo
        $('#siguienteMonto').val(parseFloat(parseFloat(saldo_viejo) - parseFloat(a_capital)).toFixed(2) )

    }
}

function recalculaInteres(){//si se modifica un campo en el abono, que recalcule el resultado
    let abonoInteres =parseFloat( $('#abonointeres').val()).toFixed(2)
    let moratorio =  parseFloat($('#interes_moratorio_abono').val()).toFixed(2)
    let amort = ($('#abono_capital').val())//amortizacion
    let mantValor = parseFloat($('#mantValortotal').val()).toFixed(2)

    let saldoPendiente =  parseFloat($('#pendiente_pago').val()).toFixed(2)
    let intereses = parseFloat(parseFloat(abonoInteres) + parseFloat(moratorio) + parseFloat(mantValor)).toFixed(2)
    let cuota = parseFloat(parseFloat(amort) + parseFloat(intereses) + parseFloat(saldoPendiente)).toFixed(2)

    $('#intereses').val(intereses)
    $('#cuota').val(cuota)

}
//Agrega Comas en tiempo Real mientras se escrirbe
function mascara(o,f){  
    v_obj=o;  
    v_fun=f;  
    setTimeout("execmascara()",1);  
}  
function execmascara(){   
    v_obj.value=v_fun(v_obj.value);
}  
function cpf(v){     
    v=v.replace(/([^0-9\.]+)/g,''); 
    v=v.replace(/^[\.]/,''); 
    v=v.replace(/[\.][\.]/g,''); 
    v=v.replace(/\.(\d)(\d)(\d)/g,'.$1$2'); 
    v=v.replace(/\.(\d{1,2})\./g,'.$1'); 
    v = v.toString().split('').reverse().join('').replace(/(\d{3})/g,'$1,');    
    v = v.split('').reverse().join('').replace(/^[\,]/,''); 

    resetCambioMoneda()

    return v;  
}  
//Fin agrega comas mientras se escribe


//Agrega Comas cuando carga un numero, no las agrega mientras se escribe
function addCommas(nStr){
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
//Fin Agrega Comas


function listarNuevasCuentas(){
    $.ajax({
        url: "../ajax/gestionar_hipoteca.php?op=listarNuevasCuentas",
        type: 'get',
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
                "iDisplayLength": 20,//Paginación
                "order": [[ 0, "desc" ]],//Ordenar (columna,orden)
                "pagingType": "full_numbers"}).DataTable();

        }
    })


}
function fechaActual() {

    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

    $('#fecha_horaAbono').val(today);
    $('#fecha_horacreditos').val(today);
    $('#fechaPago').val(today);
    $('#fechaHipoteca').val(today);

  //  document.getElementById("fechaPago").value = new Date().toISOString().substring(0, 10)
   // document.getElementById('fechaPago').valueAsDate = new Date();
   // document.getElementById('fecha_horaAbono').value = new Date()

   // document.getElementById('fechaHipoteca').valueAsDate = new Date();
}

function leerEscribir(){

    if($('#leersi').is(":checked")){
        $("#ultimoaprov").prop('disabled', false);
    }else  if($('#leerno').is(":checked")){
        $("#ultimoaprov").prop('disabled', true);
        $("#ultimoaprov").val("");
    }


}
function pickerChange() {

    var $idc = $('select#idcliente_solicitud').on('change',function(){
        var idCliente = $(this).val();
        $idcliente_ncuenta = idCliente;
        console.log($idcliente_ncuenta,"ID CLIENTE");
    });


}
function pickerChangeBanco() {
    var $idbancos = $('select#idbancos').on('change',function(){
        var idBanco = $(this).val();
        console.log(idBanco, "Id Perrin")
        calculaSaldoBanco(idBanco )
        resetCambioMoneda()

    });
}

function calculaSaldoBanco(idbanco) {
    let monto 
    $.ajax({
        url:'../ajax/cuenta_banco.php?op=calculaSaldoBanco',
        type:'get',
        data:{'idbanco':idbanco},
        success:function (data) {
          let saldo=  parseFloat(data).toFixed(2)

            //  $('#saldo_banco').val(data)
            //  $('#acancelar').val((parseFloat($('#saldo_banco').val())+29).toFixed(2))
           // document.getElementById('saldo_banco').value= saldo
            $('#saldo_banco').val(saldo)
           
            
        }
    })
   
    saldoBancoMoneda(idbanco)
}
function saldoBancoMoneda(idbanco) {
    $.ajax({
        url:'../ajax/cuenta_banco.php?op=saldoBancoMoneda',
        type:'get',
        data:{'idbanco':idbanco},
        success:function (data) {
            $('#banco_moneda').html(data)
        }
    })
}
function listarBancos() {
  $.ajax({
      url:'../ajax/cuenta_banco.php?op=listarPickerBanco',
      type:'get',
      success:function (data) {
          $('#idbancos').html(data)
          $('#idbancos').selectpicker('refresh')
      }
  })
}
function listarNuevaCuenta() {
    let fecha = Date.now();
    $.ajax({
        url: "../ajax/gestionar_hipoteca.php?op=listarNuevaCuenta",
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
        url: "../ajax/gestionar_hipoteca.php?op=muestraHipotecas",
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
function cargarCliente() {//Carga los clientes en un PickerView

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
                    url: '../ajax/gestionar_hipoteca.php?op=mostrarCuentasAbono&id='+idCl,//&id se envia al $_GET del php
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
//Funciones GuardarEditar
function guardaryeditarFiador(){

    let nombre= $('#nombreFiador').val()
    let tipo_documento= $('#tipo_documentoFiador').val()
    let genero= $('#genero_fiador').val()
    let documento= $('#num_documentoFiador').val()
    let direccion= $('#direccionFiador').val()
    let telefono= $('#telefonoFiador').val()
    let email= $('#emailFiador').val()
    let estado_civil=$('#estado_civilFiador').val()
    let id_fiador =$('#id_fiador').val()
    let ingreso =$('#ingresos').val()
   // console.log(nombre,tipo_documento,genero,documento,direccion,telefono,email,estado_civil,ingreso)

    $.ajax({
        url:"../ajax/gestionar_hipoteca.php?op=guardarFiador",
        type:'get',
        data:{
            'idfiador':id_fiador,
            'nombres':nombre,
            'tipo_documento':tipo_documento,
            'num_documento':documento,
            'genero':genero,
            'direccion':direccion,
            'telefono':telefono,
            'email':email,
            'estado_civil':estado_civil,
            'ingresos':ingreso

        },
        success:function (data) {
            bootbox.alert({
                message:data,
                callback:function (data) {
                    $.post("../ajax/gestionar_hipoteca.php?op=selectFiador", function(r){
                        $("#idfiador_picker").html(r);
                        $('#idfiador_picker').selectpicker('refresh');
                    })
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
    url:"../ajax/gestionar_hipoteca.php?op=guardarCliente",
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
                $.post("../ajax/gestionar_hipoteca.php?op=selectCliente", function(r){
                    $("#idcliente_solicitud").html(r);
                    $('#idcliente_solicitud').selectpicker('refresh');
                })
            }
        })
    }

})




}
function guardarNuevaSolicitud(e) {

    e.preventDefault()//Este evento previene que el fomulario una vez insertado se actualice y recargue la pagina completa
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
     //   alert("My favourite sports are: " + ingresos.join(", ") + " "+ sabe_leer);

        console.log("idcliente "+idcliente,"sabe leer "+sabe_leer,"consyugue "+conyugue,"tipo local "+tipo_local,
            "ultimo año "+ultimo_anio,"num dependientes "+num_dependientes,"ingresos "+ingresos,
            "total ingresos "+total_ingresos,"sector "+sector,"objetivo prestamo "+objetivo_prestamo)

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
                    $.post("../ajax/gestionar_hipoteca.php?op=selectCliente", function(r){
                        $("#idcliente_solicitud").html(r);
                        $('#idcliente_solicitud').selectpicker('refresh');
                    })
                }
            })
        }

    })




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

            actualizarPickerGarantia();
        }

    });

    limpiar();
    arr.length = 0;
}
function valuesH(){//Esta funcion no esta haciendo nada de momento
    let saldo_banco =$('#saldo_banco').val()//parseFloat($('#saldo_banco').val()).toFixed(2)
    let monto = parseFloat($("#monto_ncuenta").val().replace(',', ''))//reemplazara la coma del monto por nada y quedara una sola sifra
    let solicitud = $('#idsolicitud_picker').val()
    let fiador= $('#idfiador_picker').val()
    let garantia= $('#idgarantia').val()
    let banco= $('#idbancos').val()
    let fecha_desembolso= $('#fechaHipoteca').val()
    let fecha_pago= $('#fechaPago').val()
    let moneda= $('#monedaHipoteca').val()
    let interes= $('#interes').val()
    let interes_moratorio= $('#interes_moratorio').val()
    let comision= $('#comision').val()
    let plazo= $('#plazo_month').val()
    let tipo= $('#tipo').val()
    let mantenimiento =$('#mantenimiento').val()
    let nota= $('#comment').val()
    let idhipoteca=$('#idhipoteca').val()
    let cambio_dolar = $('#cambio_dolar').val()
}


function guardaryeditarHipoteca(e) {
    e.preventDefault(); //No recargara la pagina despues de llamar esta funcion

   // var formData = new FormData($("#formularioHipoteca")[0]);
    let saldo_banco =$('#saldo_banco').val()//parseFloat($('#saldo_banco').val()).toFixed(2)
    let monto_ncuenta = parseFloat($("#monto_ncuenta").val().replace(',', ''))//reemplazara la coma del monto por nada y quedara una sola sifra *** El monto que enviara al prestamo
    let solicitud = $('#idsolicitud_picker').val()
    let fiador= $('#idfiador_picker').val()
    let garantia= $('#idgarantia').val()
    let banco= $('#idbancos').val()
    let fecha_desembolso= $('#fechaHipoteca').val()
    let fecha_pago= $('#fechaPago').val()
    let moneda= $('#monedaHipoteca').val()
    let interes= $('#interes').val()
    let interes_moratorio= $('#interes_moratorio').val()
    let comision= $('#comision').val()
    let plazo= $('#plazo_month').val()
    let tipo= $('#tipo').val()
    let mantenimiento =$('#mantenimiento').val()
    let nota= $('#comment').val()
    let idhipoteca=$('#idhipoteca').val()
    let cambio_dolar = $('#cambio_dolar').val()
    let conv_dolar  = $('#convert_ds').val()
    let conv_cords = $('#convert_cs').val()
    let cambio = parseFloat($('#cambio').val()).toFixed(2)
   // let monto_ncuenta = parseFloat($('#monto_ncuenta').val()).toFixed(2)//el monto que guardara en el prestamo del cliente
    
    



       if (parseFloat(saldo_banco) < parseFloat(cambio)){


           var alerta ="No hay fondo suficiente en esta cuenta, este banco solo tiene: "+ saldo_banco +" Y se esta solicitando: " + monto
            bootbox.alert( alerta )

       }else {

        console.log(moneda,cambio)

           $.ajax({ 
                url: "../ajax/gestionar_hipoteca.php?op=guardaryeditarHipoteca",
                type: "get",
                data:{
                    'montos':cambio, 'solicitud':solicitud, 'fiador':fiador, 'garantia':garantia,  'banco':banco, 'desembolso':fecha_desembolso,'pago':fecha_pago,
                    'moneda':moneda, 'interes':interes, 'interes_moratorio':interes_moratorio, 'comision':comision,  'plazo':plazo,
                    'tipo':tipo,'mantenimiento':mantenimiento,'nota':nota,'idhipoteca':idhipoteca,'saldo_banco':saldo_banco,'monto_ncuenta':monto_ncuenta

                },

                success: function(datos)
                {
                    bootbox.alert({
                        message: datos,
                        callback: function (result) {
                            listarNuevasCuentas()
                        }
                    });
                }

           })
       }

}
function guardaryeditarAbono(e) {
    e.preventDefault(); //

    let idhipoteca = $('#idhipotecaAbonar').val()
    let idabono = $('#idabonodetalles').val()
    let fecha = $('#fecha_horaAbono').val()
    let nota = $('#commentAbono').val()
    let interes =  parseFloat($('#abonointeres').val()).toFixed(2)
    let intereses = parseFloat($('#intereses').val()).toFixed(2)
    let interes_moratorio = parseFloat($('#interes_moratorio_abono').val()).toFixed(2) 
    let mantenimiento = parseFloat($('#mantValortotal').val()).toFixed(2)
    var amortizacion = parseFloat($('#abono_capital').val()).toFixed(2)
    let cuota = parseFloat($('#cuota').val()).toFixed(2)
    let monto_pago = parseFloat($('#monto_pago').val()).toFixed(2)
    
    var cuotiado = monto_pago 
    var saldoPendiente = 0
    
    let pendiente = parseFloat(parseFloat(intereses) - parseFloat(monto_pago)).toFixed(2)

    if( parseFloat(idabono.length ) === 0){ //comprueba que haya idabono para saber si va a hacer un abono o editarlo
      
        if(parseFloat(monto_pago) > parseFloat(cuota) ){
            let montoLocal = parseFloat(monto_pago)
            let cuotaLocal = parseFloat(cuota)
            let a_capital =( parseFloat(montoLocal) - parseFloat(cuotaLocal) ) + parseFloat(amortizacion)
            enviaGuardarAbono(idhipoteca,idabono,interes,interes_moratorio,mantenimiento,a_capital,0.00,fecha,nota)
            console.log(a_capital," a capital")
        }
        if(parseFloat(monto_pago) < parseFloat(cuota) ){

            if( parseFloat(monto_pago) >= parseFloat(intereses) ){ //si el pago es mayor que los intereses sumados
                   
    

                let montoLocal = parseFloat(monto_pago)
                let interesLocal = parseFloat(intereses)
                let a_capital = parseFloat(parseFloat(montoLocal) - parseFloat(interesLocal)).toFixed(2) //quedara en cero pero no quedar ningun pendiente
                enviaGuardarAbono(idhipoteca,idabono,interes,interes_moratorio,mantenimiento,a_capital,0.00,fecha,nota)
                console.log(a_capital," a capital")
              
            }
            if(  parseFloat(monto_pago) < parseFloat(intereses) ){ //Si el monto es menor que la suma de intereses verificara uno a uno los intereses y no abonara al capital y tendra un pendiente 
                let montoLocal = parseFloat(monto_pago)//este sera el interes que abonara ya que hay un pendiente de interes
                let interesesLocal = parseFloat(intereses)//la suma de todos intereses
                let interesLocal = parseFloat(interes)//solo interes
                enviaGuardarAbono(idhipoteca,idabono,montoLocal,0.00,0.00,0.00,pendiente,fecha,nota)//como hay un pendiente el resto se iguala a cero y solo se envia a interes el monto que esta pagando
                console.log('Hay pendiente de interes: ',pendiente)
                     

             } 
        }
        if(parseFloat(monto_pago) === parseFloat(cuota)){
                
          //  labelsPendientes(0.00,parseFloat(amortizacion).toFixed(2))//hay que usar la amortizacion
          enviaGuardarAbono(idhipoteca,idabono,interes,interes_moratorio,mantenimiento,amortizacion,0.00,fecha,nota)//la amortizacion sera el capital a enviar
          //ya que esta pagando la cuota completa
         

        }

    }else{
        console.log("Editar")
    }
        

}

function enviaGuardarAbono(idhipoteca,idabonos,interes,interes_moratorio,mant_valor,capital,pendiente,fecha,nota){
     //   console.log("Datos a Enviar: ",idhipoteca,idabonos,interes,interes_moratorio,mant_valor,capital,pendiente,fecha,nota)
     
    $.ajax({
        url: "../ajax/gestionar_hipoteca.php?op=guardarAbono" ,
        type: "get",
        data: {
            'idhipoteca':idhipoteca,
            'idabono':idabonos,
            
            'interes': interes,
            'interes_moratorio': interes_moratorio,
            'mant_valor':mant_valor,
            'pendiente':pendiente,
            'capital': capital,
            
            'fecha':fecha,
            'nota':nota
         },

        success: function(datos)
        {
            bootbox.alert({
                message: datos,
                callback: function (result) {

                    let fecha = $('#fecha_horacreditos').val()
                    let idHipoteca = $('#hipoteca_hide').val()
                    let monto = $('#montos_hide').val()
                    $.ajax({
                        url: "../ajax/gestionar_hipoteca.php?op=listarDetallesAbono", //Muestra listado de abonos
                        type: "get", //send it through get method
                        data: {
                            'idhipoteca':idHipoteca,
                            'monto': monto,
                            'fecha':fecha
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

                    });//muestra el listado de abonos
                }
            });
        }

    })


}

//EDIT FUNCTION
function editarAbono(iddetalle,nota,interes,capital,moneda) {

    let fecha2=$('#fechaA').val() //porque si se recibe la fecha desde la funcion no solo manda el anio

    $('#fecha_horaAbono').val(fecha2);
    $('#commentAbono').val(nota);
    $('#abonointeres').val(interes);
    $('#abono_capital').val(capital);
    $('#idabonodetalles').val(iddetalle);
    console.log(iddetalle,fecha2,nota,interes,capital,moneda)



}
function editarHipoteca(idhipoteca,fecha_desembolso,fecha_pago,solicitud,fiador,garantia,monto,interes,interes_moratorio,mantenimiento,comision,plazo,nota,tipo,moneda) {
    $('#idhipoteca').val(idhipoteca)
    $('#idsolicitud_picker').val(solicitud)
    $('#idsolicitud_picker').selectpicker('refresh')
    $('#idfiador_picker').val(fiador)
    $('#idfiador_picker').selectpicker('refresh')
    $('#fechaHipoteca').val(fecha_desembolso)
    $('#fechaPago').val(fecha_pago)
    $('#monto_ncuenta').val(monto)
    $('#monto_ncuenta').attr('readonly',true)
    $('#monedaHipoteca').val(moneda)
    $('#monedaHipoteca').selectpicker('refresh')
    $('#interes').val(interes)
    $('#interes_moratorio').val(interes_moratorio)
    $('#mantenimiento').val(mantenimiento)
    $('#comision').val(comision)
    $('#plazo_month').val(plazo)
    $('#comment').val(nota)
    $('#tipo').val(tipo)
    $('#tipo').selectpicker('refresh')
    console.log(tipo)
   // console.log("idhipoteca",idhipoteca,"fecha_desembolso",fecha_desembolso,"fecha_pago",fecha_pago,"solicitud",solicitud,"monto",monto,"interes",interes,"interes_moratorio",interes_moratorio,"mantenimiento",mantenimiento,"moneda",moneda)
}

//DELETE FUNCTIONS
function eliminarAbonoH(iddetalle,numero_abono,idhipoteca) {
    console.log(numero_abono)
    bootbox.confirm("Seguro que desea eliminar el Abono? Sera borrado permanentemente",function (result) {

        if(result) { //si le dio a si

            $.ajax({
                url: "../ajax/gestionar_hipoteca.php?op=eliminarAbono",
                type: "get", //send it through get method
                data: {
                    'id':iddetalle,
                    'numero_abono':numero_abono,
                    'idhipoteca':idhipoteca


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
function eliminarH(idhipoteca) {
    bootbox.confirm("Seguro que desea eliminar la hipoteca??",function (result) {

        if(result) { //si le dio a si

            $.ajax({
                url: "../ajax/gestionar_hipoteca.php?op=eliminarH",
                type: "get", //send it through get method
                data: {
                    'id':idhipoteca
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
//OTHERS FUNC
function compruebaInteres(monto, cuota){
var totalMonto = parseFloat(monto).toFixed(2)
var totalCuota = parseFloat(cuota).toFixed(2)





}
function compruebaInteresMoratorio(){}
function compruebaMantenimiento(){}
function compruebaCapital(){}
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


    $('#comision_porcentaje').val(parseFloat(comision_porcentaje).toFixed(2))
    $('#comision_total').val(parseFloat(suma_comision).toFixed(2))
    console.log(suma_comision)
}

function muestraCuentasPendientesAbono() {

    let idcliente = $('#buscarClientesAbono').val()

    //console.log(idcliente)
    $.ajax({
        url:'../ajax/gestionar_hipoteca.php?op=mostrarCuentasAbono',
        type:'get',
        data : {
            'idcliente': idcliente
        },
        success:function (data) {
            $('#tblCuentasCliente').html(data).dataTable({
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
                "iDisplayLength": 5,//Paginación
                "order": [[ 0, "asc" ]],//Ordenar (columna,orden)
                "pagingType": "full_numbers"
            }).DataTable()
        }

    })

}

function verificarSiestaVaciosloscamposCapitaleInteres() {
   var interes = document.getElementById("abonointeres");
   var capital = document.getElementById("abonocapital");

   if(interes.value == ""){
       console.log("Vamos bien, campos interes y capital vacios");
   }
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
function mostrarCuentas(idHipoteca,monto,interes,plazo,iddias) //todas las cuentas que se necesitan mostrar para abonar*******el dia menos es
//si por ejemplo a alguien le toca pagar domingo y llega lunes entonces que se le redusca un dia
{
    $('#hipoteca_hide').val(idHipoteca) //se asignan para al guardar un abono pueda llamar la funcion ajax que recargara la tabla despues de guardar para imprimir
    $('#montos_hide').val(monto)//se asignan para al guardar un abono pueda llamar la funcion ajax que recargara la tabla despues de guardar para imprimir
let dia_menos = $('#dia_menos'+iddias).val()
let fecha = $('#fecha_horacreditos').val()
console.log("dias menos", dia_menos)
    $.ajax({
        url: "../ajax/gestionar_hipoteca.php?op=listarDetallesAbono", //Muestra listado de abonos
        type: "get", //send it through get method
        data: {
            'idhipoteca':idHipoteca,
            'monto': monto,
            'fecha':fecha
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

    });//muestra el listado de abonos

    $.ajax({
        url: "../ajax/gestionar_hipoteca.php?op=muestraSumaCapital", 
        type: "get", //send it through get method
        data: {
            'idhipoteca': idHipoteca

        }
        ,
        success: function(r) {

            let siguienteCapital = parseFloat(monto / plazo) .toFixed(2) //El abono
            var restanteMonto = (monto-r);
            $('#siguienteMonto').val(restanteMonto)//El monto Restante 
            //Esta funcion asigna el valor correcto a lo que se deberia abonar, ya que puede que llegue un momento que el monto restante
            //o lo que se reste de abonar sea menos de lo que debe abonar de acuerdo al plazo, entonces tiene que hacer la asignacion correcta
            //si lo que tiene que abonar es mas de lo que resta entonces le pasa el valor indicado
            $('#siguienteMontoHide').val(restanteMonto)
           if (restanteMonto < siguienteCapital){
               $('#abono_capital').val(restanteMonto)//Lo que corresponde abonar

           }
           else{
               $('#abono_capital').val(siguienteCapital)              
           }

            var siguienteInteres= (restanteMonto * interes)/100;

            $('#siguienteInteres').val(siguienteInteres);
           // $('#abonointeres').val(siguienteInteres);
           var localCap = $('#abono_capital').val()  
          
          
           calcula_moras(idHipoteca,plazo,monto,localCap,dia_menos)
        },

        error: function(xhr) {
            console.log("No devuelve nada",xhr);
        }
    });//recibe la suma de lo abonado para saber lo que resta, y el siguiente interes

    $.post("../ajax/gestionar_hipoteca.php?op=listarDetallesCuenta&id="+idHipoteca,function(r){//lista los detalles de la cuenta

        $("#detallesCuenta").html(r);

        $("#primerMontoAbono").val(monto);


        var resultado = ((monto*interes))/100
        $("#idhipotecaAbonar").val(idHipoteca);


    })

    $.post("../ajax/gestionar_hipoteca.php?op=mostrarPrimerInteres&idHipoteca="+idHipoteca,function(result) {//muesta primer interes

        let resultado = parseFloat(result).toFixed(2)

        $("#primerInteresAbono").val(resultado);

    })

    $.post("../ajax/gestionar_hipoteca.php?op=mostrarUltimoAbono&id="+idHipoteca,function(r,status){//muesta ultimo abono
        ultimoabono = r;
        $('#ultimoidabono').val(ultimoabono);
       //  mostrarUltimoAbono(ultimoabono);

    })

    $.post("../ajax/gestionar_hipoteca.php?op=mostrarUltimoPendiente&idhipoteca="+idHipoteca,function(r,status){//muesta ultimo Saldo pendiente si hay 
        let saldo_pendiente= r;
        $('#pendiente_pago').val(saldo_pendiente);
        

    })

    
    IDipoteca=idHipoteca;
    Monto=monto;
    Interes=interes;
   

  

}
function calcula_moras(idhipoteca,plazo,monto,amortizacion,dia_menos) {


    let fecha_credito = $('#fecha_horacreditos').val()
    $('#detalles_mora').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons: [

            ],
            "ajax":
                {
                    url: '../ajax/gestionar_hipoteca.php?op=calcula_moras',//&id se envia al $_GET del php
                    type : "get",
                    data:{
                        'idhipoteca':idhipoteca,
                        'dia_menos':dia_menos,
                        'fecha_horacreditos':fecha_credito
                    },
                    dataType : "json",
                    
                    error: function(e){
                        console.log(e.responseText);
                    }
                },
            "bDestroy": true,
            "iDisplayLength": 7,//Paginación
            "order": [[ 0, "desc" ]],//Ordenar (columna,orden),
            "footerCallback": function ( row, data, start, end, display ) {

                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total Interes
                totalInteres = api
                    .column(2)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                        // var c = intVal((a)) + intVal(b);
                    }, 0 );



                // Total over this pageº
                pageTotal = api
                    .column( 3, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // Update footer
                $( api.column( 2 ).footer() ).html(
                    // ' ( $'+ (total).toFixed(2) +' Total Int)'
                    ' ( $'+ addCommas(parseFloat(totalInteres).toFixed(2)) +' Total Int)'
        

                );

                // Total interes moratorio
                totalIntermor = api
                    .column( 3 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                        // var c = intVal((a)) + intVal(b);
                    }, 0 );

                // Update footer 2
                $( api.column( 3 ).footer() ).html(
                   // ' ( $'+ (total2).toFixed(2) +' Total Int Mor)'
                   ' ( $'+ addCommas(parseFloat(totalIntermor).toFixed(2)) +' Int Mor)'

                );


                // Total Matantenimiento Valor
                totalMantValor = api
                    .column( 4 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                        // var c = intVal((a)) + intVal(b);
                    }, 0 );

                // Update footer 2
                $( api.column( 4 ).footer() ).html(
                    ' ( $'+ (totalMantValor).toFixed(2) +' Total Mant Valor)'
                );

                // Total de las sumas de cada fila
            total = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                    // var c = intVal((a)) + intVal(b);
                }, 0 );

                // Update footer 2
                $( api.column( 5 ).footer() ).html(
                ' ( $'+ (total).toFixed(2) +' Total)'
                );
               
                
                $('#interes_moratorio_abono').val(parseFloat(totalIntermor).toFixed(2) )
                     
                    if(total > 0 && totalInteres > 0 && totalMantValor > 0){ //Si no se verifica asi, los datos anteriores son llamados dos veces y causan conflictos 
                        //con resultados distintos
                        var pendientePago = parseFloat($('#pendiente_pago').val()).toFixed(2)  
                        $('#abonointeres').val(parseFloat(totalInteres).toFixed(2) )
                        $('#mantValortotal').val(parseFloat(totalMantValor).toFixed(2) )
                        total = total + parseFloat(pendientePago) //va sumar al total de intereses el saldo pendiente para que pueda cobrarlo sin hacer mas procedimientos
                        $('#intereses').val(parseFloat(total).toFixed(2) ) //la suma de los intereses o total de intereses
                       
                      
                        
                        var saldo_pendiente = parseFloat($('#pendiente_pago').val());
                        if(saldo_pendiente == ''){
                            saldo_pendiente = 0
                        }
                        var localCuot =  parseFloat(total) + parseFloat(amortizacion)
                        $('#cuota').val(  parseFloat(localCuot).toFixed(2)) //agrega al capital la suma de los intereses mas el capital
                       
                      //  console.log('total ', pendientePago )
                    }

                   
                   
            }
            
        }).DataTable();
        
         
        
          
}

function mostrarUltimoAbono(idultimoabono) {

    $.post("../ajax/gestionar_hipoteca.php?op=muestraAbonoeInteres&ultimoabono="+idultimoabono, function(data, status)
    {

        data = JSON.parse(data);
       // $('#abonocapital').val(data.capital);
      //  $('#abonointeres').val(data.interes);

    });

}
function mostrarAbonoInfo(idHipoteca,monto) {
    $.ajax({
        url: "../ajax/gestionar_hipoteca.php?op=listarDetallesAbonoModal",
        type: "get", //send it through get method
        data: {
            'id':idHipoteca,
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
    $.post("../ajax/gestionar_hipoteca.php?op=listarDetallesCuenta&id="+idHipoteca,function(r){

        $("#detallesCuentamodal").html(r);


    });
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
    $('#temporal').val(result.toFixed(2));
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
function mostrarbarcode() {
    codigo=$("#codigo").val();
    JsBarcode("#barcode",codigo);
    $("#print").show();
}
function imprimirArea() {

    $('#nombres_data').val('Asi es')

   // window.print()

}

function eliminarHipoteca(idhipoteca,cuenta_desembolso,no_credito,cantidad_debitada,solicitud){
    console.log(idhipoteca,cuenta_desembolso,no_credito,cantidad_debitada,solicitud)

    // bootbox.confirm("Seguro que desea eliminar la hipoteca? Esto hara diferentes operaciones como devolver la cantidad que se presto, y el numero de este credito no aparecera mas",function(result){
    //     if(result){




    //         $.ajax({
    //             url:'../ajax/gestionar_hipoteca.php?op=eliminarH',
    //             type:'post',
    //             data:{
    //                 'idhipoteca':idhipoteca,'cuenta_desembolso':cuenta_desembolso,'no_credito':no_credito,
    //                 'cantidad_debitada':cantidad_debitada,'solicitud':solicitud
    //             },
    //             success:function(msj){
    //                 bootbox.alert({
    //                     message:msj,
    //                     callback:function(){
    //                         listarNuevasCuentas()
    //                     }
    //                 })
    //             }
    //         })
    //        }


    // })

    var form = $('<form><input name="usernameInput"/></form>');
    bootbox.alert(form,function(){
        var username = form.find('input[name=usernameInput]').val();
        console.log(username);
    })
   
}

function removerDia(){
    
    // var table = $('#detalles_mora').DataTable( {
    //     columnDefs: [ {
    //         orderable: false,
    //         className: 'select-checkbox',
    //         targets:   7
    //     } ],
    //     select: {
    //         style:    'multi',
    //         selector: 'td:first-child'
    //     },
    //     order: [[ 1, 'asc' ]]
    // });
  
    // $('#remove_day').click( function () {
    //     table.rows('.selected').remove().draw( );
    // });

    var table =  $('#detalles_mora').DataTable();
   
     $('#detalles_mora tbody').on( 'click', '.boxtard', function () { 
               // $(this).closest('tr').remove().draw(false) 
        table.row( $(this).parents('tr') )
        .remove()
        .draw();  
    
    } )


}
init();