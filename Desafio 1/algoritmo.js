/* Realiza os calculos */
const calculo = (nome, quantidade, preco) => {
    let total = quantidade * preco
    let desconto;

    /* descobre qual o desconto */
    if (quantidade <= 5) desconto = 2;
    else if (quantidade <= 10) desconto = 3;
    else desconto = 5;

    /* total a pagar */
    let totalPagar = (total - (total * (desconto / 100)))
    let resultado = `
        <h2 class="text-center titulo">RESULTADO</h2>
        <br/>
        <strong>Nome do Produto:</strong> ${nome}<br/>
        <strong>Total:</strong> R$ ${total.toFixed(2)}<br/>
        <strong>Desconto:</strong> ${desconto}%<br/>
        <strong>Total a pagar:</strong> R$ ${totalPagar.toFixed(2)}<br/>
    `;
    $("#resultado").html(resultado);
}

/* Limpa formulario */
const limpar = () => {
    $("#produtoNome").val('');
    $("#produtoQuantidade").val('');
    $("#produtoPreco").val('');
    $("#resultado").html('');
}

const main = () => {
    let nome = $("#produtoNome").val();
    let quantidade = $("#produtoQuantidade").val();
    let preco = $("#produtoPreco").val();

    /* Verifica se os campos estao preenchidos e se sao numero */
    if (!nome) $("#produtoNome").focus();
    else if (!quantidade || quantidade <= 0 || isNaN(quantidade)) $("#produtoQuantidade").focus();
    else if (!preco || preco <= 0 || isNaN(preco)) $("#produtoPreco").focus();
    else calculo(nome, quantidade, preco);
}