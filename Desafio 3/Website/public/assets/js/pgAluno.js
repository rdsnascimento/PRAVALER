$(document).ready(function () {
    /* lista cursos */
    const exibir = (aba, obj, fk_cnpj = '', cursoId = '') => {
        $(`#${aba}`).empty();
        $(`#${aba}`).prop("disabled", true);

        var cnpj;
        if (fk_cnpj == '')
            cnpj = obj.value;
        else
            cnpj = fk_cnpj;

        $.ajax({
            url: "/cursoListarAtivos",
            method: "POST",
            data: {
                cnpj: cnpj
            },
            success: function (data) {
                var obj = JSON.parse(data);
                var html = '';

                if (obj.length == 0) {
                    html = "<option selected disabled>Essa instituição não tem curso ativo</option>";
                    $(`#${aba}`).append(html);
                } else {
                    var html = '<option selected disabled>Selecione</option>';
                    obj.forEach((e) => {
                        html += `<option value='${e.idCurso}' nome='${e.nome}' duracao='${e.duracao}' status='${e.status}' fk_cnpj='${e.fk_cnpj}'>${e.nome}</option>\n`;
                    });
                    $(`#${aba}`).append(html)
                    $(`#${aba}`).prop("disabled", false);
                    //se for na aba alterar seleciona a instituicao do aluno
                    if (cursoId != '') $(`#${aba}`).val(cursoId);
                }
            }
        });
    };

    /* limpa e desativa os campos */
    const desativarCampos = (aba = '') => {
        $(`#${aba}Nome`).val('');
        $(`#${aba}Cpf`).val('');
        $(`#${aba}Email`).val('');
        $(`#${aba}Data`).val('');
        $(`#${aba}Celular`).val('');
        $(`#${aba}EnderecoLogradouro`).val('');
        $(`#${aba}EnderecoNum`).val('');
        $(`#${aba}EnderecoBairro`).val('');
        $(`#${aba}Estado`).val('Selecione o estado');
        $(`#${aba}Cidade`).val('Selecione a cidade');

        $(`#${aba}Nome`).prop("disabled", true);
        $(`#${aba}Cpf`).prop("disabled", true);
        $(`#${aba}Email`).prop("disabled", true);
        $(`#${aba}Data`).prop("disabled", true);
        $(`#${aba}Celular`).prop("disabled", true);
        $(`#${aba}EnderecoLogradouro`).prop("disabled", true);
        $(`#${aba}EnderecoNum`).prop("disabled", true);
        $(`#${aba}EnderecoBairro`).prop("disabled", true);
        $(`#${aba}Estado`).prop("disabled", true);
        $(`#${aba}Cidade`).prop("disabled", true);
    }

    /* ativa os campos */
    const ativarCampos = (aba = '') => {
        $(`#${aba}Nome`).prop("disabled", false);
        $(`#${aba}Email`).prop("disabled", false);
        $(`#${aba}Data`).prop("disabled", false);
        $(`#${aba}Celular`).prop("disabled", false);
        $(`#${aba}EnderecoLogradouro`).prop("disabled", false);
        $(`#${aba}EnderecoNum`).prop("disabled", false);
        $(`#${aba}EnderecoBairro`).prop("disabled", false);
        $(`#${aba}Estado`).prop("disabled", false);
        if (aba != "abaAlterar")
            $(`#${aba}Cpf`).prop("disabled", false);
    }

    /* lista cidades */
    const listarCidades = (aba, idEstado, idCidade = '') => {
        $(`#${aba}Cidade`).empty();
        $.ajax({
            url: "/cidadeListar",
            method: "POST",
            data: {
                idEstado: idEstado
            },
            success: function (data) {
                var obj = JSON.parse(data);

                var html = '<option selected disabled>Selecione a cidade</option>';
                obj.forEach((e) => {
                    html += `<option value='${e.idCidade}' nome='${e.nomeCidade}' fk_estado='${e.fk_idEstado}'>${e.nomeCidade}</option>\n`;
                });
                $(`#${aba}Cidade`).empty();
                $(`#${aba}Cidade`).append(html);
                $(`#${aba}Cidade`).prop("disabled", false);

                //se for passadoo um id para cidade, selecione ela
                if (idCidade != '') $(`#${aba}Cidade`).val(idCidade);
            }
        });
    }

    /* ativa os campos da aba Alterar */
    const abaAlterarAtivaCampos = () => {
        $("#abaAlterarInstituicaoListar").prop("disabled", false);
        ativarCampos('abaAlterar');
    }

    /* exibe conteudo seletor de instituicao na aba cadastrar */
    $("#abaCadastrarInstituicaoListar").change(function () {
        exibir('abaCadastrarCursoListar', this);
        desativarCampos('abaCadastrar');
    });

    /* exibe conteudo seletor de instituicao na aba alterar */
    $("#abaAlterarInstituicaoListar").change(function () {
        exibir('abaAlterarCursoListar', this);
    });

    /* ativa os campos ao selecionar o curso */
    $("#abaCadastrarCursoListar").change(function () {
        ativarCampos('abaCadastrar');
    });

    /* ativa o campo de cidade na aba cadastrar */
    $("#abaCadastrarEstado").change(function () {
        listarCidades("abaCadastrar", this.value);
    });

    /* ativa o campo de cidade na aba alterar */
    $("#abaAlterarEstado").change(function () {
        listarCidades("abaAlterar", this.value);
    });

    /* exibe informacoes do aluno na aba deletar*/
    $("#abaDeletarSelAluno").change(function () {
        split = $(this).find(':selected').attr('data').split('-');
        novadata = split[2] + "/" + split[1] + "/" + split[0];

        $("#abaDeletarNome").html($(this).find(':selected').attr('nome'));
        $("#abaDeletarCpf").html(this.value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4"));
        $("#abaDeletarData").html(novadata);
        $("#abaDeletarEmail").html($(this).find(':selected').attr('email'));
        $("#abaDeletarCelular").html($(this).find(':selected').attr('celular'));
    });


    /* carrega e seleciona estado e cidade */
    $("#abaAlterarSelAluno").change(function () {
        /* ativa com campos desativados */
        abaAlterarAtivaCampos();
        let nome = $(this).find(':selected').attr('nome');
        let dataNascimento = $(this).find(':selected').attr('data');
        let cpf = this.value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
        let email = $(this).find(':selected').attr('email');
        let celular = $(this).find(':selected').attr('celular');
        let endereco = $(this).find(':selected').attr('endereco');
        let numero = $(this).find(':selected').attr('numero');
        let bairro = $(this).find(':selected').attr('bairro');
        let cursoId = $(this).find(':selected').attr('fk_idCurso');
        let estadoId = $(this).find(':selected').attr('fk_idEstado');
        let cidadeId = $(this).find(':selected').attr('fk_idCidade');

        /* descobre a instituicao */
        $.ajax({
            url: "/alunoAlterarListaInstituicao",
            method: "POST",
            data: {
                cursoId: cursoId
            },
            success: function (data) {
                var obj = JSON.parse(data);

                //seta os valores dos campos
                $("#abaAlterarInstituicaoListar").val(obj.fk_cnpj);
                exibir("abaAlterarCursoListar", '', obj.fk_cnpj, cursoId);

                $("#abaAlterarEstado").val(estadoId);
                listarCidades("abaAlterar", estadoId, cidadeId);

                $("#abaAlterarNome").val(nome);
                $("#abaAlterarCpf").val(cpf);
                $("#abaAlterarCpfInvisivel").val(cpf);
                $("#abaAlterarData").val(dataNascimento);
                $("#abaAlterarEmail").val(email);
                $("#abaAlterarCelular").val(celular);
                $("#abaAlterarEnderecoLogradouro").val(endereco);
                $("#abaAlterarEnderecoNum").val(numero);
                $("#abaAlterarEnderecoBairro").val(bairro);
            }
        });
    });

});

$(document).ready(function() {
    $('#tabelaResultado').DataTable({
        responsive: true
    });
});