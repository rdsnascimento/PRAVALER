$(document).ready(function () {
    $('#cursoInstituicaoCadastrar').change(function () {
        $("#cursoNome").prop("disabled", false);
        $("#cursoDuracao").prop("disabled", false);
        $("#cursoStatus").prop("disabled", false);
    });

    const exibir = (aba, obj) => {
        $(`#${aba}`).empty();
        $(`#${aba}`).prop("disabled", true);
        if(aba === 'cursoCadastrado') $("#cursoListarResultado").hide();
        
        var cnpj = obj.value;
        $.ajax({
            url: "/cursoListar",
            method: "POST",
            data: {
                cnpj: cnpj
            },
            success: function (data) {
                var obj = JSON.parse(data);
                var html = '';

                if(obj.length == 0){
                    html = "<option selected disabled>Essa instituição não tem curso ativo</option>";
                    $(`#${aba}`).append(html);
                } else {
                    var html = '<option selected disabled>Selecione</option>';
                    obj.forEach((e) => {
                        html += `<option value='${e.idCurso}' nome='${e.nome}' duracao='${e.duracao}' status='${e.status}' fk_cnpj='${e.fk_cnpj}'>${e.nome}</option>\n`;
                    });
                    $(`#${aba}`).append(html)
                    $(`#${aba}`).prop("disabled", false);
                }
            }
        });
    };

    /* exibe conteudo seletor de instituicao */
    $("#cursoInstituicaoListar").change(function () {
        exibir('cursoCadastrado', this);
    });

    $("#cursoInstituicaoDeletar").change(function () {
        exibir('cursoCadastradoDeletar', this);
        deletarCamposLimpar();
    });

    /* exibe conteudo seletor de curso */
    $("#cursoInstituicaoAlterar").change(function () {
        exibir('cursoCadastradoAlterar', this);
        alterarCamposLimpar();
    });

    /* limpa e desativa os campos de curso na aba alterars */
    const alterarCamposLimpar = () => {
        $("#cursoNomeAlterar").val('');
        $("#cursoDuracaoAlterar").val('');
        $("#cursoStatusAlterar").prop('checked', false);

        /* desativa os campos */
        $("#cursoNomeAlterar").prop("disabled", true);
        $("#cursoDuracaoAlterar").prop("disabled", true);
        $("#cursoStatusAlterar").prop("disabled", true);
    }

    /* campos editaveis em alterar cursos */
    $("#cursoCadastradoAlterar").change(function () {
        let cursoNome = $(this).find(':selected').attr('nome');
        let cursoDuracao = $(this).find(':selected').attr('duracao');
        let cursoStatus = $(this).find(':selected').attr('status');

        /* seta os valores */
        $("#cursoNomeAlterar").val(cursoNome);
        $("#cursoDuracaoAlterar").val(cursoDuracao);

        /* ativa os campos */
        $("#cursoNomeAlterar").prop("disabled", false);
        $("#cursoDuracaoAlterar").prop("disabled", false);
        $("#cursoStatusAlterar").prop("disabled", false);

        if (cursoStatus == 0) {
            $("#cursoStatusAlterar").prop('checked', false);
        } else {
            $("#cursoStatusAlterar").prop('checked', true);
        }
    });

    /* Exibe a descricao do curso em deletar */
    $("#cursoCadastradoDeletar").change(function () {
        let cursoNome = $(this).find(':selected').attr('nome');
        let cursoDuracao = $(this).find(':selected').attr('duracao');
        let cursoStatus = $(this).find(':selected').attr('status');

        $("#cursodNome").html(cursoNome);
        $("#cursodDuracao").html(cursoDuracao);
        if (cursoStatus == 0) {
            $("#cursodStatus").html("Ativado");
        } else {
            $("#cursodStatus").html("Desativado");
        }
    });

    /* limpa os campos da aba deletar */
    const deletarCamposLimpar = () => {
        $("#cursodNome").html("");
        $("#cursodDuracao").html("");
        $("#cursodStatus").html("");
    }

    /* Exibe a descricao do curso em listar */
    $("#cursoCadastrado").change(function () {
        let cursoId = this.value;
        let cursoNome = $(this).find(':selected').attr('nome');
        let cursoDuracao = $(this).find(':selected').attr('duracao');
        let cursoCnpj = $(this).find(':selected').attr('fk_cnpj').replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, "$1.$2.$3/$4-$5");
        let cursoStatus = $(this).find(':selected').attr('status');

        $("#cursolId").html(cursoId);
        $("#cursolNome").html(cursoNome);
        $("#cursolDuracao").html(cursoDuracao);
        $("#cursolCnpj").html(cursoCnpj);

        cursoStatus == 0 ? $("#cursolStatus").html('Ativado') : $("#cursolStatus").html('Desativado');
        $("#cursoListarResultado").show();
    });
});