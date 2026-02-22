function atualizarMensagem() {

    const frases = [
        "Disciplina supera motivação.",
        "Pequenos passos todos os dias.",
        "Consistência cria resultados.",
        "Foco no processo, não só no objetivo."
    ];

    const indice = Math.floor(Math.random() * frases.length);

    document.getElementById("frase").innerText = frases[indice];
}