import Alpine from 'alpinejs';
window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.store('darkMode', {
        on: false,
        toggle() {
            this.on = !this.on;
            localStorage.setItem('dark-mode', this.on);
            if (this.on) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        },
        init() {
            this.on = localStorage.getItem('dark-mode') === 'true' || (!('dark-mode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
        }
    });

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

    Alpine.data('checkout', () => ({
        processing: false,
        handleSubmit(event) {
            this.processing = true;
            const form = event.target;
            const formData = new FormData(form);
            const self = this;

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            })
            .then(r => r.json())
            .then(data => {
                if (data.snap_token && data.snap_token.startsWith('SIMULATION_TOKEN_')) {
                    window.location.href = '/payments/finish?order_id=' + data.order_id;
                    return;
                }

                window.snap.pay(data.snap_token, {
                    onSuccess: function () {
                        window.location.href = '/payments/finish?order_id=' + data.order_id;
                    },
                    onPending: function () {
                        window.location.href = '/payments/finish?order_id=' + data.order_id;
                    },
                    onError: function () {
                        alert('Pembayaran gagal, silakan coba lagi.');
                        self.processing = false;
                    },
                    onClose: function () {
                        self.processing = false;
                    },
                });
            })
            .catch(() => {
                self.processing = false;
            });
        },
    }));

    Alpine.data('addonCheckout', () => ({
        processing: false,
        handleSubmit(event) {
            this.processing = true;
            const form = event.target;
            const formData = new FormData(form);
            const self = this;

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            })
            .then(r => r.json())
            .then(data => {
                if (data.snap_token && data.snap_token.startsWith('SIMULATION_TOKEN_')) {
                    window.location.href = '/addon-payment/finish?reference_order_id=' + data.reference_order_id;
                    return;
                }

                window.snap.pay(data.snap_token, {
                    onSuccess: function () {
                        window.location.href = '/addon-payment/finish?reference_order_id=' + data.reference_order_id;
                    },
                    onPending: function () {
                        window.location.href = '/addon-payment/finish?reference_order_id=' + data.reference_order_id;
                    },
                    onError: function () {
                        alert('Pembayaran gagal, silakan coba lagi.');
                        self.processing = false;
                    },
                    onClose: function () {
                        self.processing = false;
                    },
                });
            })
            .catch(() => {
                self.processing = false;
            });
        },
    }));
});

Alpine.start();

import AOS from 'aos';
import 'aos/dist/aos.css';
AOS.init({
    duration: 800,
    once: true,
    offset: 100,
});

import './image-cropper';
import './sweetalert';
import './visitor-chart';
import './slug-editor';
