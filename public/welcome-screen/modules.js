(function () {
    'use strict';

    function greeting(root) {
        return {
            update(data) {
                const title = root.querySelector('[data-screen-title]');
                const names = root.querySelector('[data-screen-names]');
                if (title) title.textContent = data.title || 'Selamat Datang di Pernikahan';
                if (names) names.textContent = data.names || '';
            },
        };
    }

    function background(root) {
        const container = root.querySelector('[data-screen-background]');
        let signature;
        return {
            update(data) {
                if (!container) return;
                const next = JSON.stringify(data.background);
                if (next === signature) return;
                signature = next;
                container.replaceChildren();
                root.classList.toggle('has-background', Boolean(data.background?.url));
                if (!data.background?.url) return;
                const media = document.createElement(data.background.type === 'video' ? 'video' : 'img');
                if (data.background.type === 'video') {
                    media.autoplay = true;
                    media.muted = true;
                    media.loop = true;
                    media.playsInline = true;
                    media.setAttribute('muted', '');
                } else {
                    media.alt = '';
                }
                media.addEventListener('error', () => {
                    root.classList.remove('has-background');
                    media.hidden = true;
                }, { once: true });
                media.src = data.background.url;
                container.append(media);
                if (media.tagName === 'VIDEO') media.play().catch(() => {});
            },
            destroy() { container?.querySelector('video')?.pause(); },
        };
    }

    function gallery(root) {
        const container = root.querySelector('[data-screen-gallery]');
        let photos = [];
        let signature;
        let index = 0;
        let revision = 0;
        let loadVersion = 0;
        let timer;
        let active;

        function show(attempt = 0) {
            if (!container || !photos.length || attempt >= photos.length) return;
            const image = new Image();
            const currentRevision = revision;
            const currentLoad = ++loadVersion;
            image.alt = `Foto pernikahan ${index + 1}`;
            image.onload = () => {
                if (currentRevision !== revision || currentLoad !== loadVersion) return;
                container.hidden = false;
                root.classList.add('has-gallery');
                container.querySelectorAll('img:not(.is-active)').forEach(item => item.remove());
                container.append(image);
                requestAnimationFrame(() => requestAnimationFrame(() => {
                    if (currentRevision !== revision || currentLoad !== loadVersion) return;
                    active?.classList.remove('is-active');
                    image.classList.add('is-active');
                    active = image;
                }));
            };
            image.onerror = () => {
                if (currentRevision !== revision || currentLoad !== loadVersion) return;
                index = (index + 1) % photos.length;
                show(attempt + 1);
            };
            image.src = photos[index].url;
        }

        return {
            update(data) {
                if (!container) return;
                const next = JSON.stringify(data.galleries || []);
                if (next === signature) return;
                signature = next;
                revision++;
                clearInterval(timer);
                photos = data.galleries || [];
                index = 0;
                active = null;
                container.replaceChildren();
                container.hidden = true;
                root.classList.remove('has-gallery');
                show();
                if (photos.length > 1) timer = setInterval(() => {
                    index = (index + 1) % photos.length;
                    show();
                }, 6000);
            },
            destroy() { revision++; clearInterval(timer); },
        };
    }

    function wishes(root) {
        const container = root.querySelector('[data-screen-wishes]');
        let items = [];
        let signature;
        let index = 0;
        let timer;
        function show() {
            if (!container || !items.length) return;
            const message = container.querySelector('[data-wish-message]');
            const name = container.querySelector('[data-wish-name]');
            if (message) message.textContent = items[index].message;
            if (name) name.textContent = items[index].name;
            const quote = container.querySelector('blockquote');
            quote?.getAnimations?.().forEach(animation => { animation.cancel(); animation.play(); });
        }
        return {
            update(data) {
                if (!container) return;
                const next = JSON.stringify([data.show_wishes_wall, data.wishes]);
                if (next === signature) return;
                signature = next;
                const currentId = items[index]?.id;
                items = data.show_wishes_wall ? (data.wishes || []) : [];
                index = Math.max(0, items.findIndex(item => item.id === currentId));
                container.hidden = items.length === 0;
                clearInterval(timer);
                if (!items.length) {
                    container.querySelectorAll('[data-wish-message], [data-wish-name]').forEach(item => { item.textContent = ''; });
                    return;
                }
                show();
                if (items.length > 1) timer = setInterval(() => { index = (index + 1) % items.length; show(); }, 8000);
            },
            destroy() { clearInterval(timer); },
        };
    }

    function checkins(root) {
        const container = root.querySelector('[data-screen-checkin]');
        const known = new Set();
        const queue = [];
        let displaying = false;
        let timer;

        function next() {
            if (!container) return;
            const guest = queue.shift();
            displaying = Boolean(guest);
            container.hidden = !displaying;
            if (!guest) return;
            const name = container.querySelector('[data-guest-name]');
            const order = container.querySelector('[data-guest-order]');
            if (name) name.textContent = guest.name;
            if (order) order.textContent = guest.checkin_order ? `Tamu ke-${guest.checkin_order}` : '';
            const progress = container.querySelector('[data-checkin-progress]');
            if (progress) {
                progress.style.animation = 'none';
                void progress.offsetWidth;
                progress.style.animation = '';
            }
            timer = setTimeout(next, 7000);
        }

        return {
            enqueue(guests) {
                if (!container) return;
                guests.forEach(guest => {
                    const key = `${guest.id}:${guest.checked_in_at}`;
                    if (!guest.checked_in_at || known.has(key)) return;
                    known.add(key);
                    queue.push(guest);
                });
                if (!displaying) next();
            },
            destroy() { clearTimeout(timer); queue.length = 0; },
        };
    }

    window.WelcomeScreenModules = { greeting, background, gallery, wishes, checkins };
}());
