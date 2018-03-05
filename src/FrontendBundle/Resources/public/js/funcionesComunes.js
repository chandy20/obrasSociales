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
function soloNumeros(e) {
    var key = e.charCode || e.keyCode || 0;
    // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
    return (
            key == 8 ||
            key == 9 ||
            key == 46 ||
            (key >= 37 && key <= 40) ||
            (key >= 48 && key <= 57) ||
            (key >= 96 && key <= 105));
}
