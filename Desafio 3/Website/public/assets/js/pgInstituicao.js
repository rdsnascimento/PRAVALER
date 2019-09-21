$(document).ready(function () {
    const selecionar = (aba, objeto) => {
        var cnpj = objeto.value.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, "$1.$2.$3/$4-$5");
        var nome = $(objeto).find(':selected').attr('nome');
        var status = $(objeto).find(':selected').attr('status');

        $(`#${aba}InstituicaoNome`).html(nome)
        $(`#${aba}InstituicaoCnpj`).html(cnpj)

        if (status == 0) {
            $(`#${aba}InstituicaoStatus`).html('Ativado')
        } else {
            $(`#${aba}InstituicaoStatus`).html('Desativado')
        }
    }

    $('#listarInstituicaoSelect').change(function () {
        selecionar('listar', this)
    });

    $('#deletarInstituicaoSelect').change(function () {
        selecionar('deletar', this)
    });

    $('#alterarInstituicaoSelect').change(function () {
        var cnpj = this.value.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, "$1.$2.$3/$4-$5");
        var nome = $(this).find(':selected').attr('nome');
        var status = $(this).find(':selected').attr('status');

        $("#alterarInstituicaoNome").val(nome)
        $("#alterarInstituicaoCnpj").val(cnpj)
        $("#alterarInstituicaoCnpjAlterior").val(cnpj)
        if (status == 0) {
            $("#alterarInstituicaoStatus").prop('checked', false);
        } else {
            $("#alterarInstituicaoStatus").prop('checked', true);
        }
    });
});