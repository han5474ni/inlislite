/**
 * JavaScript untuk halaman Tentang Inlislite Versi 3
 * Menangani interaksi tombol kembali dan animasi
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Tombol Kembali
    const backBtn = document.getElementById('backBtn');
    
    if (backBtn) {
        backBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Tambahkan efek animasi saat diklik
            this.style.transform = 'translateX(-4px)';
            
            // Reset animasi setelah 150ms
            setTimeout(() => {
                this.style.transform = 'translateX(0)';
            }, 150);
            
            // Navigasi kembali
            // Cek apakah ada history untuk kembali
            if (window.history.length > 1) {
                window.history.back();
            } else {
                // Jika tidak ada history, redirect ke dashboard
                window.location.href = window.location.origin + '/dashboard';
            }
        });
        
        // Tambahkan keyboard support (Enter dan Space)
        backBtn.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    }
    
    // Animasi untuk card saat scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe semua card
    const cards = document.querySelectorAll('.info-card, .feature-card, .platform-card, .section-card, .term-item');
    cards.forEach(card => {
        // Set initial state untuk animasi
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        
        observer.observe(card);
    });
    
    // Smooth scroll untuk internal links (jika ada)
    const internalLinks = document.querySelectorAll('a[href^="#"]');
    internalLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Tambahkan ripple effect untuk card saat diklik
    const addRippleEffect = function(e) {
        const card = e.currentTarget;
        const rect = card.getBoundingClientRect();
        const ripple = document.createElement('span');
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('ripple');
        
        // CSS untuk ripple effect
        ripple.style.position = 'absolute';
        ripple.style.borderRadius = '50%';
        ripple.style.background = 'rgba(13, 110, 253, 0.3)';
        ripple.style.transform = 'scale(0)';
        ripple.style.animation = 'ripple-animation 0.6s ease-out';
        ripple.style.pointerEvents = 'none';
        
        card.style.position = 'relative';
        card.style.overflow = 'hidden';
        card.appendChild(ripple);
        
        // Hapus ripple setelah animasi selesai
        setTimeout(() => {
            ripple.remove();
        }, 600);
    };
    
    // Tambahkan event listener untuk ripple effect
    cards.forEach(card => {
        card.addEventListener('click', addRippleEffect);
        
        // Tambahkan hover effect dengan JavaScript untuk browser yang tidak support CSS hover
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Handle responsive behavior
    const handleResize = function() {
        const isMobile = window.innerWidth <= 768;
        const headerTitle = document.querySelector('.header-title');
        const headerSubtitle = document.querySelector('.header-subtitle');
        
        if (isMobile) {
            // Adjustments untuk mobile jika diperlukan
            if (headerTitle) {
                headerTitle.style.fontSize = '1.1rem';
            }
            if (headerSubtitle) {
                headerSubtitle.style.fontSize = '0.8rem';
            }
        } else {
            // Reset ke ukuran desktop
            if (headerTitle) {
                headerTitle.style.fontSize = '';
            }
            if (headerSubtitle) {
                headerSubtitle.style.fontSize = '';
            }
        }
    };
    
    // Jalankan saat load dan resize
    handleResize();
    window.addEventListener('resize', handleResize);
    
    // Keyboard navigation untuk accessibility
    document.addEventListener('keydown', function(e) {
        // ESC key untuk kembali
        if (e.key === 'Escape' && backBtn) {
            backBtn.click();
        }
    });
    
    console.log('Tentang Inlislite V3 - Script loaded successfully');
});

// CSS untuk ripple animation (inject via JavaScript)
if (!document.getElementById('ripple-styles')) {
    const style = document.createElement('style');
    style.id = 'ripple-styles';
    style.textContent = `
        @keyframes ripple-animation {
            to {
                transform: scale(2);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
}
