$(function () {
    $(".institucional").fadeOut();
    $(".familiar").fadeOut();
    $(".funcionario").fadeOut();
    mostrarFormulario();
})

function mostrarFormulario() {
    var tipo_solicitud = $("#frontendbundle_solicitudes_idtiposolicitud").val();
    if (tipo_solicitud != "") {
        if (tipo_solicitud == 1) {
            $(".institucional").fadeOut();
        } else {
            $(".institucional").fadeIn();
        }
        if (tipo_solicitud == 2) {
            $(".familiar").fadeOut();
            $(".funcionario").fadeOut();
        } else {
            $(".familiar").fadeIn();
            $(".funcionario").fadeIn();
        }
    }
}
function soloNumeros(input) {
    $(input).val($(input).val().replace(/\D/g, ''));
}
