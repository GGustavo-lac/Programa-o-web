// Formulário de Newsletter
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const nomeInput = document.getElementById('nome');
    const emailInput = document.getElementById('email');
    const submitBtn = form.querySelector('input[type="button"]');
    
    if (form && submitBtn) {
        submitBtn.addEventListener('click', (e) => {
            e.preventDefault();
            
            // Obter valores do formulário
            const nome = nomeInput.value.trim();
            const email = emailInput.value.trim();
            
            // Validação básica
            if (!nome || !email) {
                showMessage('Por favor, preencha todos os campos!', 'error');
                return;
            }
            
            // Validação de email
            if (!validateEmail(email)) {
                showMessage('Por favor, insira um e-mail válido!', 'error');
                return;
            }
            
            // Simular envio
            submitBtn.value = 'Enviando...';
            submitBtn.disabled = true;
            
            setTimeout(() => {
                showMessage('✓ Cadastro feito com sucesso! Em breve você receberá nossas novidades.', 'success');
                form.reset(); // Limpa os campos do formulário
                submitBtn.value = 'Enviar';
                submitBtn.disabled = false;
                
                // Esconder mensagem após 5 segundos
                setTimeout(() => {
                    hideMessage();
                }, 5000);
            }, 1500);
        });
    }
});

// Função para validar email
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Função para mostrar mensagem
function showMessage(message, type) {
    // Verificar se já existe uma div de mensagem
    let messageDiv = document.querySelector('.form-message');
    
    if (!messageDiv) {
        
        messageDiv = document.createElement('div');
        messageDiv.className = 'form-message';
        const form = document.querySelector('form');
        form.appendChild(messageDiv);
    }
    
    messageDiv.textContent = message;
    messageDiv.className = `form-message ${type}`;
    messageDiv.style.display = 'block';
}

// Função para esconder mensagem
function hideMessage() {
    const messageDiv = document.querySelector('.form-message');
    if (messageDiv) {
        messageDiv.style.display = 'none';
    }

}
