'use strict';
const form = document.querySelector('[data-post-form]');
if (form) {
    const content = document.getElementById('conteudo');
    const counter = document.getElementById('character-count');
    const updateCount = () => {
        counter.textContent = `${Array.from(content.value).length.toLocaleString('pt-BR')} / 20.000`;
    };
    content.addEventListener('input', updateCount);
    updateCount();
    // Confere os campos obrigatórios.
    for (const field of form.querySelectorAll('input[required], textarea[required]')) {
        field.addEventListener('input', () => field.setCustomValidity(''));
    }
    form.addEventListener('submit', (event) => {
        for (const field of form.querySelectorAll('input[required], textarea[required]')) {
            field.setCustomValidity(field.value.trim() ? '' : 'Preencha este campo. Espaços em branco não são suficientes.');
        }
        if (!form.reportValidity()) event.preventDefault();
    });
    const firstError = form.querySelector('.is-invalid');
    if (firstError) firstError.focus();
}
// Usa uma imagem padrão quando a foto não carrega.
for (const img of document.querySelectorAll('[data-news-image]')) {
    const fallback = () => {
        if (!img.src.endsWith('/assets/editorial.svg')) img.src = 'assets/editorial.svg';
    };
    img.addEventListener('error', fallback, {
        once:true
    });
    if (img.complete && !img.naturalWidth) fallback();
}
const note = (message) => {
    const box = document.querySelector('.toast-note');
    box.textContent = message;
    box.hidden = false;
    clearTimeout(window.noteTimer);
    window.noteTimer = setTimeout(() => box.hidden = true, 6500);
};
// O botão atualiza a página e consulta as fontes.
document.querySelectorAll('[data-refresh]').forEach(button => {
    button.addEventListener('click', () => location.reload());
});
// Guarda as notícias salvas neste navegador.
const savedKey = 'ponto-pauta-saved-v2';
let saved = [];
try {
    const data=JSON.parse(localStorage.getItem(savedKey)||'[]');
    if(Array.isArray(data)) saved=data.filter(x=>x && /^\d+$/.test(String(x.id)) && typeof x.title==='string' && typeof x.source==='string').slice(0,100);
} catch {
}
const persist = () => {
    try {
        localStorage.setItem(savedKey, JSON.stringify(saved));
        return true;
    } catch {
        note('Seu navegador não permitiu salvar a lista.');
        return false;
    }
};
const renderSaved = () => {
    document.querySelectorAll('[data-saved-count]').forEach(el=>el.textContent=saved.length);
    document.querySelectorAll('[data-save]').forEach(el=> {
        el.textContent=saved.some(x=>x.id===el.dataset.id)?'Remover dos salvos':'Salvar para ler depois';
        el.setAttribute('aria-pressed',String(saved.some(x=>x.id===el.dataset.id)));
    });
    const list=document.querySelector('[data-saved-list]');
    if(!list) return;
    list.replaceChildren();
    if(!saved.length) {
        const box=document.createElement('div');
        box.className='empty-state';
        const h=document.createElement('h2');
        h.textContent='Sua próxima leitura fica aqui.';
        const p=document.createElement('p');
        p.textContent='Abra uma notícia e escolha “Salvar para ler depois”.';
        box.append(h,p);
        list.append(box);
    }
    for(const item of saved) {
        const row=document.createElement('article');
        row.className='saved-item';
        const body=document.createElement('div');
        const h=document.createElement('h2');
        const a=document.createElement('a');
        a.href='index.php?action=news&id='+encodeURIComponent(item.id);
        a.textContent=item.title;
        h.append(a);
        const small=document.createElement('small');
        small.textContent=item.source;
        body.append(h,small);
        const remove=document.createElement('button');
        remove.className='text-button';
        remove.textContent='Remover';
        remove.addEventListener('click',()=> {
            saved=saved.filter(x=>x.id!==item.id);
            persist();
            renderSaved();
        });
        row.append(body,remove);
        list.append(row);
    }
};
document.querySelectorAll('[data-save]').forEach(button=>button.addEventListener('click',()=> {
    const previous=[...saved];
    const id=button.dataset.id;
    if(saved.some(x=>x.id===id)) saved=saved.filter(x=>x.id!==id);
    else {
        if(saved.length>=100) {
            note('Sua lista já tem 100 notícias. Remova uma antes de adicionar outra.');
            return;
        }
        saved.unshift( {
            id,title:button.dataset.title,source:button.dataset.source
        });
    }
    if(!persist()) saved=previous;
    else note(saved.some(x=>x.id===id)?'Notícia salva neste navegador.':'Notícia removida dos salvos.');
    renderSaved();
}));
document.querySelector('[data-clear-saved]')?.addEventListener('click',()=> {
    if(!saved.length)return;
    if(confirm('Limpar todas as notícias salvas neste navegador?')) {
        saved=[];
        persist();
        renderSaved();
    }
});
document.querySelector('[data-share]')?.addEventListener('click',async()=> {
    try {
        await navigator.clipboard.writeText(location.href);
        note('Link copiado.');
    } catch {
        note('Não foi possível copiar automaticamente. Copie o endereço na barra do navegador.');
    }
});
renderSaved();
const imageField=document.getElementById('imagem_url');
if(imageField) {
    const preview=document.getElementById('image-preview');
    const update=()=> {
        try {
            const url=new URL(imageField.value);
            if(url.protocol!=='https:')throw 0;
            preview.src=url.href;
            preview.hidden=false;
        } catch {
            preview.hidden=true;
        }
    };
    imageField.addEventListener('change',update);
    preview.addEventListener('error',()=> {
        preview.hidden=true;
    });
    update();
}
document.querySelectorAll('[data-font]').forEach(button=>button.addEventListener('click',()=> {
    const body=document.getElementById('texto-da-materia');
    if(!body)return;
    const size=parseFloat(getComputedStyle(body).fontSize);
    body.style.fontSize=Math.min(28,Math.max(16,size+(button.dataset.font==='increase'?2:-2)))+'px';
}));
