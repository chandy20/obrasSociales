$(function () {
    $(".institucional").fadeOut();
    $(".familiar").fadeOut();
    $(".funcionario").fadeOut();
    mostrarFormulario();

    $("select.gradoFuncionario").change(function () {
        var grado = $(this).val();
        esconderCamposFallecido(grado);
    });
    var grado = $("select.gradoFuncionario").val();
    esconderCamposFallecido(grado);
})

function mostrarFormulario() {
    var tipo_solicitud = $("select.tipo_solicitud").val();
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
    var grado = $("select.gradoFuncionario").val();
    esconderCamposFallecido(grado);
}


function esconderCamposFallecido(grado) {
    if (grado != "" && (grado == 30 || grado == 31)) {
        $('.fallecido').parent().parent().parent().addClass('hidden');
        $('.fallecido').each(function () {
            $(this).val("").change();
        });
    } else {
        $('.fallecido').parent().parent().parent().removeClass('hidden');
    }
}

function soloNumeros(input) {
    $(input).val($(input).val().replace(/\D/g, ''));
}

function actualizarProgramasPadres(datoSelect) {
    var data = {
        area_id: $(datoSelect).val()
    };
    var url = "/app_dev.php/admin/app/programas/programasPorArea";
    var programa_selector = $("select[name*='programaPadre']:eq(0)");
    if (programa_selector.length < 1) {
        programa_selector = $("select[name*='programa']:eq(0)");
    }
    $.ajax({
        type: 'post',
        url: url,
        data: data,
        success: function (data) {
            programa_selector.html('<option value="">Seleccione una opción</option>');
            for (var i = 0, total = data.length; i < total; i++) {
                programa_selector.append('<option value="' + data[i].id + '">' + data[i].nombre + '</option>');
            }
            programa_selector.change();
        }
    });
}

function actualizarProgramas(datoSelect) {
    var data = {
        programa_id: $(datoSelect).val()
    };
    var url = "/app_dev.php/admin/app/programas/programasPorProgramaPadre";
    var programa_selector = $("select[name*='programas']:eq(0)");
    if (programa_selector.length < 1) {
        programa_selector = $("select[name*='programa']:eq(1)");
    }
    $.ajax({
        type: 'post',
        url: url,
        data: data,
        success: function (data) {
            programa_selector.html('<option value="">Seleccione una opción</option>');
            for (var i = 0, total = data.length; i < total; i++) {
                programa_selector.append('<option value="' + data[i].id + '">' + data[i].nombre + '</option>');
            }
            programa_selector.change();
        }
    });
}


function cambiarValorPrograma(datoSelect) {
    var programa_id = $(datoSelect).val()
    var url = "/app_dev.php/admin/app/conceptosjunta/" + programa_id + "/cambiarValorPrograma";
    var campoValorMes = $(datoSelect).parent().parent().find('input.valorMes:eq(0)');
    $.ajax({
        type: 'post',
        url: url,
        success: function (data) {
            campoValorMes.val('');
            if (data.valorMes) {
                campoValorMes.val(data.valorMes);
                campoValorMes.attr('readOnly', true);
            } else {
                campoValorMes.removeAttr('readOnly');
            }
        }
    });
}