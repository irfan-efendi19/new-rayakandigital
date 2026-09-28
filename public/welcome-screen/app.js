(function () {
    'use strict';

    const root = document.querySelector('[data-welcome-screen]');
    const source = document.getElementById('welcome-screen-data');
    if (!root || !source || !window.WelcomeScreenModules) return;
    const initial = JSON.parse(source.textContent);
    const modules = window.WelcomeScreenModules;
    const displays = ['greeting', 'background', 'gallery', 'wishes'].map(name => modules[name](root));
    const checkins = modules.checkins(root);
    const errors = new Set();
    const timers = new Set();
    const requests = new Set();
    let stopped = false;
    let cursor = { since: initial.checkin_since || new Date().toISOString(), after_id: 0 };

    function status(name, failed) {
        if (failed) errors.add(name); else errors.delete(name);
        const label = root.querySelector('[data-screen-status]');
        if (label) label.textContent = errors.size ? 'Koneksi terputus · mencoba menyambung kembali…' : '';
    }

    async function get(url) {
        const controller = new AbortController();
        requests.add(controller);
        const timeout = setTimeout(() => controller.abort(), 10000);
        try {
            const response = await fetch(url, {
                headers: { Accept: 'application/json' }, cache: 'no-store', signal: controller.signal,
            });
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            return await response.json();
        } finally {
            clearTimeout(timeout);
            requests.delete(controller);
        }
    }

    function schedule(callback, delay) {
        if (stopped) return;
        const timer = setTimeout(() => { timers.delete(timer); callback(); }, delay);
        timers.add(timer);
    }

    function render(data) {
        displays.forEach(display => display.update(data));
    }

    async function pollData() {
        if (stopped || !initial.data_url) return;
        try {
            const data = await get(initial.data_url);
            if (!stopped) render(data);
            status('data', false);
        } catch {
            status('data', true);
        } finally {
            schedule(pollData, 5000);
        }
    }

    async function pollCheckins() {
        if (stopped || !initial.checkins_url) return;
        let delay = 3000;
        try {
            const url = new URL(initial.checkins_url, location.href);
            url.searchParams.set('since', cursor.since);
            url.searchParams.set('after_id', cursor.after_id);
            const data = await get(url);
            if (!data.success || !Array.isArray(data.guests)) throw new Error('Invalid check-in response');
            if (stopped) return;
            checkins.enqueue(data.guests);
            if (data.next_cursor) {
                cursor = { ...data.next_cursor, after_id: data.has_more ? data.next_cursor.after_id : 0 };
            }
            if (data.has_more) delay = 50;
            status('checkins', false);
        } catch {
            status('checkins', true);
        } finally {
            schedule(pollCheckins, delay);
        }
    }

    const fullscreen = root.querySelector('[data-screen-fullscreen]');
    fullscreen?.addEventListener('click', async () => {
        try {
            if (document.fullscreenElement) await document.exitFullscreen();
            else await document.documentElement.requestFullscreen();
        } catch {
            fullscreen.textContent = 'Gunakan F11 untuk layar penuh';
        }
    });
    document.addEventListener('fullscreenchange', () => {
        if (fullscreen) fullscreen.textContent = document.fullscreenElement ? 'Keluar layar penuh ⛶' : 'Layar penuh ⛶';
    });
    window.addEventListener('pagehide', () => {
        stopped = true;
        timers.forEach(clearTimeout);
        requests.forEach(controller => controller.abort());
        displays.forEach(display => display.destroy?.());
        checkins.destroy();
    }, { once: true });
    window.addEventListener('pageshow', event => { if (event.persisted) location.reload(); });

    render(initial);
    pollData();
    pollCheckins();
}());
