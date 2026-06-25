/* ============================================================
   Etec Zona Leste — script.js
   1. Menu hambúrguer (mobile)
   2. Animações ao rolar (scroll reveal)
   3. Validação do formulário de contato
   4. Contador de estatísticas animado
   ============================================================ */

document.addEventListener('DOMContentLoaded', () => {

  /* ----------------------------------------------------------
     1. MENU HAMBÚRGUER
     Injeta o botão no cabeçalho e alterna a classe .aberto
     ---------------------------------------------------------- */
  const nav = document.querySelector('.navegacao');
  const cabecalhoConteudo = document.querySelector('.cabecalho-conteudo');

  if (nav && cabecalhoConteudo) {
    // Cria o botão
    const btnMenu = document.createElement('button');
    btnMenu.className = 'btn-menu';
    btnMenu.setAttribute('aria-label', 'Abrir menu');
    btnMenu.setAttribute('aria-expanded', 'false');
    btnMenu.innerHTML = `
      <span class="btn-menu-linha"></span>
      <span class="btn-menu-linha"></span>
      <span class="btn-menu-linha"></span>
    `;
    cabecalhoConteudo.appendChild(btnMenu);

    btnMenu.addEventListener('click', () => {
      const aberto = nav.classList.toggle('aberto');
      btnMenu.classList.toggle('ativo', aberto);
      btnMenu.setAttribute('aria-expanded', aberto);
      btnMenu.setAttribute('aria-label', aberto ? 'Fechar menu' : 'Abrir menu');
    });

    // Fecha ao clicar em um link
    nav.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        nav.classList.remove('aberto');
        btnMenu.classList.remove('ativo');
        btnMenu.setAttribute('aria-expanded', 'false');
      });
    });

    // Fecha ao clicar fora
    document.addEventListener('click', (e) => {
      if (!cabecalhoConteudo.contains(e.target)) {
        nav.classList.remove('aberto');
        btnMenu.classList.remove('ativo');
        btnMenu.setAttribute('aria-expanded', 'false');
      }
    });
  }


  /* ----------------------------------------------------------
     2. SCROLL REVEAL
     Adiciona .visivel aos elementos quando entram na viewport
     ---------------------------------------------------------- */
  const alvosReveal = document.querySelectorAll(
    '.card-info, .noticia-card, .bloco-texto, .painel, ' +
    '.hero-texto, .hero-card, .galeria-institucional, ' +
    '.titulo-secao, .topo-pagina h1, .topo-pagina .kicker'
  );

  alvosReveal.forEach((el, i) => {
    el.classList.add('reveal');
    // Escalonamento sutil entre cards da mesma fileira
    const delay = (i % 4) * 80;
    el.style.transitionDelay = delay + 'ms';
  });

  const observador = new IntersectionObserver((entradas) => {
    entradas.forEach(entrada => {
      if (entrada.isIntersecting) {
        entrada.target.classList.add('visivel');
        observador.unobserve(entrada.target);
      }
    });
  }, { threshold: 0.12 });

  alvosReveal.forEach(el => observador.observe(el));


  /* ----------------------------------------------------------
     3. VALIDAÇÃO DO FORMULÁRIO DE CONTATO
     ---------------------------------------------------------- */
  const formulario = document.querySelector('.formulario');

  if (formulario) {
    // Cria div de erro reutilizável
    function criarMensagemErro(texto) {
      const span = document.createElement('span');
      span.className = 'campo-erro';
      span.textContent = texto;
      return span;
    }

    function limparErros() {
      formulario.querySelectorAll('.campo-erro').forEach(e => e.remove());
      formulario.querySelectorAll('.campo-invalido').forEach(e => e.classList.remove('campo-invalido'));
    }

    function marcarInvalido(input, msg) {
      input.classList.add('campo-invalido');
      input.insertAdjacentElement('afterend', criarMensagemErro(msg));
      input.focus();
    }

    formulario.addEventListener('submit', (e) => {
      limparErros();
      let valido = true;

      const nome = formulario.querySelector('#nome');
      const endereco = formulario.querySelector('#endereco');
      const telefone = formulario.querySelector('#telefone');
      const email = formulario.querySelector('#email');

      if (nome && nome.value.trim().length < 3) {
        marcarInvalido(nome, 'Por favor, insira seu nome completo (mínimo 3 caracteres).');
        valido = false;
      }

      if (endereco && endereco.value.trim().length < 5) {
        marcarInvalido(endereco, 'Por favor, insira um endereço válido.');
        valido = false;
      }

      if (telefone) {
        const tel = telefone.value.replace(/\D/g, '');
        if (tel.length < 10 || tel.length > 11) {
          marcarInvalido(telefone, 'Digite um telefone válido com DDD (10 ou 11 dígitos).');
          valido = false;
        }
      }

      if (email) {
        const reEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!reEmail.test(email.value.trim())) {
          marcarInvalido(email, 'Por favor, insira um e-mail válido.');
          valido = false;
        }
      }

      if (!valido) {
        e.preventDefault();
        // Rola suavemente para o primeiro erro
        const primeiroErro = formulario.querySelector('.campo-invalido');
        if (primeiroErro) {
          primeiroErro.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        return;
      }

      // Feedback visual de envio
      const btn = formulario.querySelector('[type="submit"]');
      if (btn) {
        btn.textContent = 'Enviando…';
        btn.disabled = true;
      }
    });

    // Máscara de telefone
    const campoTel = formulario.querySelector('#telefone');
    if (campoTel) {
      campoTel.addEventListener('input', () => {
        let v = campoTel.value.replace(/\D/g, '').slice(0, 11);
        if (v.length > 10) {
          v = v.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
        } else if (v.length > 6) {
          v = v.replace(/^(\d{2})(\d{4})(\d{0,4})$/, '($1) $2-$3');
        } else if (v.length > 2) {
          v = v.replace(/^(\d{2})(\d{0,5})$/, '($1) $2');
        } else {
          v = v.replace(/^(\d*)$/, '($1');
        }
        campoTel.value = v;
      });
    }

    // Limpa o erro do campo ao começar a digitar
    formulario.querySelectorAll('input, textarea').forEach(campo => {
      campo.addEventListener('input', () => {
        campo.classList.remove('campo-invalido');
        const erroSeguinte = campo.nextElementSibling;
        if (erroSeguinte && erroSeguinte.classList.contains('campo-erro')) {
          erroSeguinte.remove();
        }
      });
    });
  }


  /* ----------------------------------------------------------
     4. CONTADOR DE ESTATÍSTICAS ANIMADO
     Injeta a seção de stats na home (só na index)
     ---------------------------------------------------------- */
  const hero = document.querySelector('.hero');
  const isHome = !!hero;

  if (isHome) {
    const stats = [
      { valor: 4,    sufixo: '',  label: 'Cursos técnicos' },
      { valor: 30,   sufixo: '+', label: 'Anos de história' },
      { valor: 2000, sufixo: '+', label: 'Alunos formados' },
      { valor: 98,   sufixo: '%', label: 'Aprovação no vestibular' },
    ];

    const secaoStats = document.createElement('section');
    secaoStats.className = 'secao secao-stats';
    secaoStats.innerHTML = `
      <div class="container">
        <div class="stats-grid">
          ${stats.map(s => `
            <div class="stat-item reveal">
              <span class="stat-numero" data-alvo="${s.valor}" data-sufixo="${s.sufixo}">0${s.sufixo}</span>
              <span class="stat-label">${s.label}</span>
            </div>
          `).join('')}
        </div>
      </div>
    `;

    // Insere após a seção hero
    hero.insertAdjacentElement('afterend', secaoStats);

    // Anima os contadores quando entram na tela
    function animarContador(el) {
      const alvo = parseInt(el.dataset.alvo, 10);
      const sufixo = el.dataset.sufixo || '';
      const duracao = 1800;
      const inicio = performance.now();

      function passo(agora) {
        const progresso = Math.min((agora - inicio) / duracao, 1);
        // Easing: ease-out cúbico
        const eased = 1 - Math.pow(1 - progresso, 3);
        el.textContent = Math.floor(eased * alvo) + sufixo;
        if (progresso < 1) requestAnimationFrame(passo);
      }
      requestAnimationFrame(passo);
    }

    const obsStats = new IntersectionObserver((entradas) => {
      entradas.forEach(entrada => {
        if (entrada.isIntersecting) {
          entrada.target.classList.add('visivel');
          entrada.target.querySelectorAll('.stat-numero').forEach(animarContador);
          obsStats.unobserve(entrada.target);
        }
      });
    }, { threshold: 0.3 });

    obsStats.observe(secaoStats);
  }

}); // fim DOMContentLoaded
