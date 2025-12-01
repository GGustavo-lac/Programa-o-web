// Carrossel de Imagens com navegação automática e manual
class Carousel {
    constructor(containerSelector) {
        this.container = document.querySelector(containerSelector);
        if (!this.container) return;
        
        this.slidesContainer = this.container.querySelector('.carousel-slides');
        this.slides = this.container.querySelectorAll('.carousel-slide');
        this.prevBtn = this.container.querySelector('.carousel-btn.prev');
        this.nextBtn = this.container.querySelector('.carousel-btn.next');
        this.indicatorsContainer = this.container.querySelector('.carousel-indicators');
        
        this.currentIndex = 0;
        this.autoPlayInterval = null;
        this.autoPlayDelay = 4000; // 4 segundos
        
        this.init();
    }
    
    init() {
        // Criar indicadores
        this.createIndicators();
        
        // Event listeners para botões
        this.prevBtn.addEventListener('click', () => this.prev());
        this.nextBtn.addEventListener('click', () => this.next());
        
        // Event listeners para indicadores
        this.indicators = this.container.querySelectorAll('.indicator');
        this.indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => this.goToSlide(index));
        });
        
        // Pausar autoplay ao passar mouse
        this.container.addEventListener('mouseenter', () => this.stopAutoPlay());
        this.container.addEventListener('mouseleave', () => this.startAutoPlay());
        
        // Suporte para toque em dispositivos móveis
        this.addTouchSupport();
        
        // Iniciar autoplay
        this.startAutoPlay();
        
        // Atualizar indicador inicial
        this.updateIndicators();
    }
    
    createIndicators() {
        this.slides.forEach((_, index) => {
            const indicator = document.createElement('span');
            indicator.classList.add('indicator');
            if (index === 0) indicator.classList.add('active');
            this.indicatorsContainer.appendChild(indicator);
        });
    }
    
    updateIndicators() {
        const indicators = this.container.querySelectorAll('.indicator');
        indicators.forEach((indicator, index) => {
            if (index === this.currentIndex) {
                indicator.classList.add('active');
            } else {
                indicator.classList.remove('active');
            }
        });
    }
    
    goToSlide(index) {
        this.currentIndex = index;
        const offset = -this.currentIndex * 100;
        this.slidesContainer.style.transform = `translateX(${offset}%)`;
        this.updateIndicators();
    }
    
    next() {
        this.currentIndex = (this.currentIndex + 1) % this.slides.length;
        this.goToSlide(this.currentIndex);
    }
    
    prev() {
        this.currentIndex = (this.currentIndex - 1 + this.slides.length) % this.slides.length;
        this.goToSlide(this.currentIndex);
    }
    
    startAutoPlay() {
        this.autoPlayInterval = setInterval(() => {
            this.next();
        }, this.autoPlayDelay);
    }
    
    stopAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
            this.autoPlayInterval = null;
        }
    }
    
    addTouchSupport() {
        let startX = 0;
        let endX = 0;
        
        this.container.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
        });
        
        this.container.addEventListener('touchend', (e) => {
            endX = e.changedTouches[0].clientX;
            this.handleSwipe(startX, endX);
        });
    }
    
    handleSwipe(startX, endX) {
        const threshold = 50; 
        const diff = startX - endX;
        
        if (Math.abs(diff) > threshold) {
            if (diff > 0) {
                this.next();
            } else {
                this.prev();
            }
        }
    }
}

o
document.addEventListener('DOMContentLoaded', () => {
    const carousel = new Carousel('.carousel-container');

});
