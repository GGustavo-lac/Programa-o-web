// Configuração do Canvas para Confetes
const canvas = document.getElementById('confetti-canvas');
const ctx = canvas.getContext('2d');
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

window.addEventListener('resize', () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
});

// Classe Confete
class Confetti {
    constructor() {
        this.x = Math.random() * canvas.width;
        this.y = -10;
        this.size = Math.random() * 8 + 5;
        this.speedY = Math.random() * 3 + 2;
        this.speedX = Math.random() * 2 - 1;
        this.color = ['#ff0000', '#00ff00', '#0000ff', '#ffff00', '#ff00ff', '#00ffff'][Math.floor(Math.random() * 6)];
        this.rotation = Math.random() * 360;
        this.rotationSpeed = Math.random() * 10 - 5;
    }

    update() {
        this.y += this.speedY;
        this.x += this.speedX;
        this.rotation += this.rotationSpeed;
        
        if (this.y > canvas.height) {
            return false;
        }
        return true;
    }

    draw() {
        ctx.save();
        ctx.translate(this.x, this.y);
        ctx.rotate(this.rotation * Math.PI / 180);
        ctx.fillStyle = this.color;
        ctx.fillRect(-this.size / 2, -this.size / 2, this.size, this.size);
        ctx.restore();
    }
}

let confettis = [];
let animationId;

function animateConfetti() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    confettis = confettis.filter(confetti => {
        confetti.update();
        confetti.draw();
        return confetti.y < canvas.height;
    });

    if (confettis.length > 0) {
        animationId = requestAnimationFrame(animateConfetti);
    }
}

function launchConfetti() {
    for (let i = 0; i < 150; i++) {
        setTimeout(() => {
            confettis.push(new Confetti());
        }, i * 10);
    }
    animateConfetti();
}

// Sons
function playApplause() {
    const audio = new Audio('https://cdn.freesound.org/previews/397/397354_5121236-lq.mp3');
    audio.volume = 0.5;
    audio.play().catch(e => console.log('Erro ao tocar som'));
}

function playUhOh() {
    const audio = new Audio('https://cdn.freesound.org/previews/456/456965_5674468-lq.mp3');
    audio.volume = 0.5;
    audio.play().catch(e => console.log('Erro ao tocar som'));
}

function calcularIdade() {
    const anoNascimento = document.getElementById('birthYear').value;
    const resultDiv = document.getElementById('result');
    const ageDisplay = document.getElementById('ageDisplay');
    const ageText = document.getElementById('ageText');

    if (!anoNascimento) {
        alert('Por favor, digite o ano de nascimento!');
        playUhOh();
        return;
    }

    const anoAtual = new Date().getFullYear();
    const idade = anoAtual - parseInt(anoNascimento);

    if (idade < 0) {
        alert('Ano de nascimento inválido!');
        playUhOh();
        return;
    }

    if (idade > 150) {
        alert('Por favor, verifique o ano de nascimento!');
        playUhOh();
        return;
    }

    ageDisplay.textContent = idade;
    
    if (idade === 1) {
        ageText.textContent = 'ano';
    } else {
        ageText.textContent = 'anos';
    }

    resultDiv.classList.add('show');
    
    // Confetes e som de sucesso
    launchConfetti();
    playApplause();
}

document.getElementById('birthYear').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        calcularIdade();
    }
});