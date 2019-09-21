$(document).ready(function () {
    const selecionar = (aba, objeto) => {
    };

    $('#cursoInstituicaoListar').change(function () {
    
    });

    $('#cursoInstituicaoCadastrar').change(function () {
        $("#cursoNome").prop("disabled", false);
        $("#cursoDuracao").prop("disabled", false);
        $("#cursoStatus").prop("disabled", false);
    });

    $("#cursoInstituicaoListar").change(function () {
        $("#cursoCadastrado").empty();
        $("#cursoCadastrado").prop("disabled", true);
        $("#cursoListarResultado").hide();
        var cnpj = this.value;

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
                    $("#cursoCadastrado").append(html);
                } else {
                    var html = '<option selected disabled>Selecione</option>';
                    obj.forEach((e) => {
                        html += `<option value='${e.idCurso}' nome='${e.nome}' duracao='${e.duracao}' status='${e.status}' fk_cnpj='${e.fk_cnpj}'>${e.nome}</option>\n`;
                    });
                    $("#cursoCadastrado").append(html)
                    $("#cursoCadastrado").prop("disabled", false);
                }
            }
        });
    });

    $("#cursoCadastrado").change(function () {
        var cursoId = this.value;
        var cursoNome = $(this).find(':selected').attr('nome');
        var cursoDuracao = $(this).find(':selected').attr('duracao');
        var cursoCnpj = $(this).find(':selected').attr('fk_cnpj').replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, "$1.$2.$3/$4-$5");

        $("#cursolId").html(cursoId);
        $("#cursolNome").html(cursoNome);
        $("#cursolDuracao").html(cursoDuracao);
        $("#cursolCnpj").html(cursoCnpj);

        $("#cursoListarResultado").show();
    });
});