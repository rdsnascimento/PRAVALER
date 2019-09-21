/* Realiza os calculos */
const calculo = (massa) => {
    let massaFinal = massa
    let tempo = 0

    while(massaFinal >= 0.1) {
        massaFinal -= (massaFinal * 0.25)
        tempo += 30
    }

    let horas = Math.trunc(tempo / 3600) 
    let minutos = Math.trunc((tempo % 3600) / 60) 
    let segundos = Math.trunc((tempo % 3600) % 60) 

    console.log(tempo)
    console.log(`H: ${horas}\nM: ${minutos}\nS: ${segundos}`)

    let resultado = `
        <h2 class="text-center titulo">RESULTADO</h2>
        <br/>
        <strong>Total:</strong> ${tempo} segundos<br/>
        <strong>Isso equivale a:</strong> ${horas}h ${minutos}m ${segundos}s
    `;
    $("#resultado").html(resultado);
}

/* Limpa formulario */
const limpar = () => {
    $("#massa").val('');
    $("#resultado").html('');
}

const main = () => {
    let massa = $("#massa").val();
    if ((!massa) || massa <= 0 || isNaN(massa)) {
        $("#massa").val('');
        $("#massa").focus();
    }
    else calculo(massa);
}