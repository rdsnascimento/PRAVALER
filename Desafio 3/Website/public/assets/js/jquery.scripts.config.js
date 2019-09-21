// console.log(window.location.href);
var base_url = "../../wp-content/themes/mcb/db-compartilhe.php";

$(function () {

  $('#Pais').change(function () {
    var idPais = $('#Pais').val(),
      codPais = $('#Pais').children(':selected').data("valor2");;

    $('#CodigoPais').html('+' + codPais);
    limparCidadeEstado();
    carregarEstados(idPais, null, true);
  });

  $('#Estado').change(function () {
    carregarCidades($('#Estado').val(), null, true);
  });

  $('#CategoriaObjeto').change(function () {
    $('#SubcategoriaObjeto').html("<option>Carregando...</option>");
    $('#SubcategoriaObjeto').attr("disabled", "disabled");

    var idCategoria = $('#CategoriaObjeto').val();

    $.post(base_url, {
      idCategoria: idCategoria,
      tipo: 'categoria'
    }, function (data) {
      $('#SubcategoriaObjeto').html(data);
      $('#SubcategoriaObjeto').removeAttr("disabled", "disabled");
    });
  });

});

function carregarEstados(idPais, idEstado, desabilitar) {
  if (idPais == '31') {
    $('#Estado').html("<option>Carregando...</option>");
    $('#Estado').attr("disabled", "disabled");

    $.post(base_url, {
      idEstado: idEstado,
      tipo: 'carregarEstados'
    }, function (data) {
      if (desabilitar == true)
        $('#Estado').removeAttr("disabled", "disabled");
      $('#Estado').html(data);
    });
  }
}

function carregarCidades(idEstado, idCidade, desabilitar) {
  $('#Cidade').html("<option>Carregando...</option>");
  $('#Cidade').attr("disabled", "disabled");

  $.post(base_url, {
    idEstado: idEstado,
    idCidade: idCidade,
    tipo: 'carregarCidades'
  }, function (data) {
    if (desabilitar == true)
      $('#Cidade').removeAttr("disabled", "disabled");
    $('#Cidade').html(data);
  });
}

function limparCidadeEstado() {
  $('#Estado').html('<option value="" selected hidden>Estado</option>');
  $('#Estado').attr("disabled", "disabled");

  $('#Cidade').html('<option value="" selected hidden>Cidade</option>');
  $('#Cidade').attr("disabled", "disabled");
}

function lerTermos() {
  $('#exampleModal').modal('show');
  $('#termoAceite').prop("checked", false);
  $('#Enviar').attr('disabled', 'disabled');
}

function aceitarTermo() {
  $('#exampleModal').modal('hide');
  $('#termoAceite').prop("checked", true);
  $('#Enviar').removeAttr('disabled');
}

function recusarTermo() {
  $('#exampleModal').modal('hide');
  $('#termoAceite').prop("checked", false);
  $('#Enviar').attr('disabled', 'disabled');
}

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});