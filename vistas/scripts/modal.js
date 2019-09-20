

function init() {

    $("#ultimoaprov").prop('disabled', true);

}

function leerEscribir(){

    if($('#leersi').is(":checked")){
        $("#ultimoaprov").prop('disabled', false);
    }else  if($('#leerno').is(":checked")){
        $("#ultimoaprov").prop('disabled', true);
        $("#ultimoaprov").val("");
    }


}
init();