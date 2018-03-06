function mostrarFormulario() {
    var tipo_solicitud = $("#frontendbundle_solicitudes_idtiposolicitud").val();
    if (tipo_solicitud != "") {
        if (tipo_solicitud == 1) {
            $(".prueba").fadeOut();
        } else {
            $(".prueba").fadeIn();
        }
        if (tipo_solicitud == 2) {
            $(".prueba1").fadeOut();
        } else {
            $(".prueba1").fadeIn();
        }
    }
}
function soloNumeros(input) {
    $(input).val($(input).val().replace(/\D/g, ''));
}
