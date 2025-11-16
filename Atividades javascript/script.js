// Funções principais

function podeDirigir(idade) {
    if (idade >= 18) {
        return "Pode ser habilitado(a)";
    } else {
        return "Ainda não pode";
    }
}

function encontrarMaiorEntreTres(a, b, c) {
    if (a > b && a > c) {
        return a;
    } else if (b > a && b > c) {
        return b;
    } else {
        return c;
    }
}

function classificarMoedaFunc(valor) {
    if (valor === 0.01) {
        return "Um Centavo";
    } else if (valor === 0.05) {
        return "Cinco Centavos";
    } else if (valor === 0.10) {
        return "Dez Centavos";
    } else if (valor === 0.25) {
        return "Vinte e Cinco Centavos";
    } else if (valor === 0.50) {
        return "Cinquenta Centavos";
    } else if (valor === 1.00) {
        return "Um Real";
    } else {
        return "Valor Desconhecido";
    }
}

function senhaForte(senha) {
    if (senha.length > 8 && senha !== "12345678") {
        return true;
    } else {
        return false;
    }
}

function checarTemperatura(temperatura) {
    if (temperatura < 10) {
        return "Alerta de Frio";
    } else if (temperatura >= 10 && temperatura <= 25) {
        return "Temperatura Ideal";
    } else {
        return "Alerta de Calor";
    }
}

function nomeDoDia(numero) {
    switch (numero) {
        case 1:
            return "Domingo";
        case 2:
            return "Segunda";
        case 3:
            return "Terça";
        case 4:
            return "Quarta";
        case 5:
            return "Quinta";
        case 6:
            return "Sexta";
        case 7:
            return "Sábado";
        default:
            return "Número inválido";
    }
}

function tipoTriangulo(L1, L2, L3) {
    if (L1 == L2 && L2 == L3) {
        return "Equilátero";
    } else if (L1 == L2 || L1 == L3 || L2 == L3) {
        return "Isósceles";
    } else {
        return "Escaleno";
    }
}

function gerarNomeCompleto(objeto) {
    return objeto.primeiroNome + " " + objeto.sobrenome;
}

function calcularMediaSimples(N1, N2) {
    const media = (N1 + N2) / 2;
    if (media >= 7) {
        return "Aprovado";
    } else {
        return "Reprovado";
    }
}

function formatarTelefoneFunc(telefone) {
    const parte1 = telefone.slice(0, 4);
    const parte2 = telefone.slice(4, 8);
    return parte1 + "-" + parte2;
}

// Funções de interface

function mostrarResultado(id, texto, cor) {
    const elemento = document.getElementById(id);
    elemento.textContent = texto;
    elemento.className = 'resposta ativo ' + cor;
}

function verificarIdade() {
    const idade = parseInt(document.getElementById('idade').value);
    
    if (isNaN(idade)) {
        mostrarResultado('result1', 'Digite uma idade válida', 'vermelho');
        return;
    }
    
    const resultado = podeDirigir(idade);
    const cor = resultado.includes('Pode') ? 'verde' : 'vermelho';
    mostrarResultado('result1', resultado, cor);
}

function encontrarMaior() {
    const n1 = parseFloat(document.getElementById('num1').value);
    const n2 = parseFloat(document.getElementById('num2').value);
    const n3 = parseFloat(document.getElementById('num3').value);
    
    if (isNaN(n1) || isNaN(n2) || isNaN(n3)) {
        mostrarResultado('result2', 'Preencha todos os números', 'vermelho');
        return;
    }
    
    const maior = encontrarMaiorEntreTres(n1, n2, n3);
    mostrarResultado('result2', 'O maior número é: ' + maior, 'verde');
}

function classificarMoeda() {
    const valor = parseFloat(document.getElementById('moeda').value);
    
    if (isNaN(valor)) {
        mostrarResultado('result3', 'Selecione uma moeda', 'vermelho');
        return;
    }
    
    const resultado = classificarMoedaFunc(valor);
    mostrarResultado('result3', resultado, 'azul');
}

function verificarSenha() {
    const senha = document.getElementById('senha').value;
    
    if (!senha) {
        mostrarResultado('result4', 'Digite uma senha', 'vermelho');
        return;
    }
    
    const forte = senhaForte(senha);
    const texto = forte ? 'Senha forte!' : 'Senha fraca (use mais de 8 caracteres)';
    const cor = forte ? 'verde' : 'vermelho';
    mostrarResultado('result4', texto, cor);
}

function verificarTemperatura() {
    const temp = parseFloat(document.getElementById('temperatura').value);
    
    if (isNaN(temp)) {
        mostrarResultado('result5', 'Digite uma temperatura', 'vermelho');
        return;
    }
    
    const resultado = checarTemperatura(temp);
    let cor = 'azul';
    if (resultado.includes('Frio')) cor = 'azul';
    else if (resultado.includes('Ideal')) cor = 'verde';
    else cor = 'vermelho';
    
    mostrarResultado('result5', resultado, cor);
}

function mostrarDia() {
    const dia = parseInt(document.getElementById('dia').value);
    
    if (isNaN(dia)) {
        mostrarResultado('result6', 'Digite um número', 'vermelho');
        return;
    }
    
    const resultado = nomeDoDia(dia);
    const cor = resultado.includes('inválido') ? 'vermelho' : 'azul';
    mostrarResultado('result6', resultado, cor);
}

function classificarTriangulo() {
    const l1 = parseFloat(document.getElementById('lado1').value);
    const l2 = parseFloat(document.getElementById('lado2').value);
    const l3 = parseFloat(document.getElementById('lado3').value);
    
    if (isNaN(l1) || isNaN(l2) || isNaN(l3)) {
        mostrarResultado('result7', 'Preencha todos os lados', 'vermelho');
        return;
    }
    
    const tipo = tipoTriangulo(l1, l2, l3);
    mostrarResultado('result7', 'Triângulo ' + tipo, 'verde');
}

function gerarNome() {
    const primeiro = document.getElementById('primeiroNome').value;
    const sobrenome = document.getElementById('sobrenome').value;
    
    if (!primeiro || !sobrenome) {
        mostrarResultado('result8', 'Preencha ambos os campos', 'vermelho');
        return;
    }
    
    const nomeCompleto = gerarNomeCompleto({
        primeiroNome: primeiro,
        sobrenome: sobrenome
    });
    mostrarResultado('result8', nomeCompleto, 'verde');
}

function calcularMedia() {
    const n1 = parseFloat(document.getElementById('nota1').value);
    const n2 = parseFloat(document.getElementById('nota2').value);
    
    if (isNaN(n1) || isNaN(n2)) {
        mostrarResultado('result9', 'Digite ambas as notas', 'vermelho');
        return;
    }
    
    const media = (n1 + n2) / 2;
    const situacao = calcularMediaSimples(n1, n2);
    const texto = 'Média: ' + media.toFixed(1) + ' - ' + situacao;
    const cor = situacao === 'Aprovado' ? 'verde' : 'vermelho';
    mostrarResultado('result9', texto, cor);
}

function formatarTelefone() {
    const telefone = document.getElementById('telefone').value;
    
    if (telefone.length !== 8) {
        mostrarResultado('result10', 'Digite exatamente 8 dígitos', 'vermelho');
        return;
    }
    
    const formatado = formatarTelefoneFunc(telefone);
    mostrarResultado('result10', formatado, 'verde');
}
