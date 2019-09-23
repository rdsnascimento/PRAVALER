$(document).ready(function () {
    const exibir = (aba, obj) => {
        $(`#${aba}`).empty();
        $(`#${aba}`).prop("disabled", true);
        
        var cnpj = obj.value;

        $.ajax({
            url: "/cursoListarAtivos",
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

    /* limpa e desativa os campos */
    const abaCadastrarDesativarCampos = () => {
        $("#abaCadastrarNome").val('');
        $("#abaCadastrarCpf").val('');
        $("#abaCadastrarEmail").val('');
        $("#abaCadastrarData").val('');
        $("#abaCadastrarCelular").val('');
        $("#abaCadastrarEnderecoLogradouro").val('');
        $("#abaCadastrarEnderecoNum").val('');
        $("#abaCadastrarEnderecoBairro").val('');
        $("#abaCadastrarEstado").val('Selecione o estado');
        $("#abaCadastrarCidade").val('Selecione a cidade');

        $("#abaCadastrarNome").prop("disabled", true);
        $("#abaCadastrarCpf").prop("disabled", true);
        $("#abaCadastrarEmail").prop("disabled", true);
        $("#abaCadastrarData").prop("disabled", true);
        $("#abaCadastrarCelular").prop("disabled", true);
        $("#abaCadastrarEnderecoLogradouro").prop("disabled", true);
        $("#abaCadastrarEnderecoNum").prop("disabled", true);
        $("#abaCadastrarEnderecoBairro").prop("disabled", true);
        $("#abaCadastrarEstado").prop("disabled", true);
        $("#abaCadastrarCidade").prop("disabled", true);
    } 

    /* exibe conteudo seletor de instituicao */
    $("#abaCadastrarInstituicaoListar").change(function () {
        exibir('abaCadastrarCursoListar', this);
        abaCadastrarDesativarCampos();
    });

    /* ativa os campos ao selecionar o curso */
    $("#abaCadastrarCursoListar").change(function () {
        $("#abaCadastrarNome").prop("disabled", false);
        $("#abaCadastrarCpf").prop("disabled", false);
        $("#abaCadastrarEmail").prop("disabled", false);
        $("#abaCadastrarData").prop("disabled", false);
        $("#abaCadastrarCelular").prop("disabled", false);
        $("#abaCadastrarEnderecoLogradouro").prop("disabled", false);
        $("#abaCadastrarEnderecoNum").prop("disabled", false);
        $("#abaCadastrarEnderecoBairro").prop("disabled", false);
        $("#abaCadastrarEstado").prop("disabled", false);
    });

    /* ativa o campo de cidade */
    $("#abaCadastrarEstado").change(function () {
        $(`#abaCadastrarCidade`).empty();
        $.ajax({
            url: "/cidadeListar",
            method: "POST",
            data: {
                idEstado: this.value
            },
            success: function (data) {
                console.log(data)
                var obj = JSON.parse(data);

                var html = '<option selected disabled>Selecione a cidade</option>';
                obj.forEach((e) => {
                    html += `<option value='${e.idCidade}' nome='${e.nomeCidade}' fk_estado='${e.fk_idEstado}'>${e.nomeCidade}</option>\n`;
                });

                $("#abaCadastrarCidade").append(html);
                $("#abaCadastrarCidade").prop("disabled", false);
            }
        });
    });

});