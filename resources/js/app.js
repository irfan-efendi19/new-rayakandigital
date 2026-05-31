import Alpine from 'alpinejs';
window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.data('landing', () => ({
        showBackToTop: false,
        mobileMenuOpen: false,
        init() {
            window.addEventListener('scroll', () => {
                this.showBackToTop = window.scrollY > 400;
            }, { passive: true });
        },
        scrollTo(id) {
            const el = document.getElementById(id);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth' });
            }
        }
    }));

    Alpine.data('reveal', () => ({
        visible: false,
        init() {
            const observer = new IntersectionObserver(([entry]) => {
                if (entry.isIntersecting) {
                    this.visible = true;
                    observer.disconnect();
                }
            }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
            observer.observe(this.$el);
        }
    }));

    Alpine.data('accordion', () => ({
        open: null,
        toggle(id) {
            this.open = this.open === id ? null : id;
        }
    }));
});

Alpine.start();

import './image-cropper';
import './sweetalert';
import './visitor-chart';
import './slug-editor';
