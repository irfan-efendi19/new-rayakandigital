const { test } = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');

function timers() {
    let id = 0;
    const tasks = new Map();
    return {
        tasks,
        setTimeout(callback, delay) { tasks.set(++id, { callback, delay }); return id; },
        clearTimeout(id) { tasks.delete(id); },
        async run(delay) {
            const task = [...tasks].find(([, value]) => value.delay === delay);
            assert.ok(task, `Expected a ${delay} ms timer`);
            tasks.delete(task[0]);
            task[1].callback();
            await new Promise(resolve => setImmediate(resolve));
        },
    };
}

test('check-in popups retain arrival order, deduplicate polling, and finish the queue', async () => {
    const clock = timers();
    const name = { textContent: '' };
    const order = { textContent: '' };
    const popup = { hidden: true, querySelector: selector => ({ '[data-guest-name]': name, '[data-guest-order]': order })[selector] };
    const sandbox = { window: {}, setTimeout: clock.setTimeout, clearTimeout: clock.clearTimeout };
    vm.runInNewContext(fs.readFileSync('public/welcome-screen/modules.js', 'utf8'), sandbox);
    const checkins = sandbox.window.WelcomeScreenModules.checkins({ querySelector: () => popup });
    const guests = [
        { id: 7, name: '<img src=x onerror=alert(1)>', checked_in_at: '2026-09-23T01:00:00Z', checkin_order: 1 },
        { id: 3, name: 'Tamu berikutnya', checked_in_at: '2026-09-23T01:00:01Z', checkin_order: 2 },
    ];
    checkins.enqueue(guests);
    checkins.enqueue(guests);
    assert.equal(name.textContent, guests[0].name);
    assert.equal(popup.hidden, false);
    await clock.run(7000);
    assert.equal(name.textContent, 'Tamu berikutnya');
    assert.equal(order.textContent, 'Tamu ke-2');
    await clock.run(7000);
    assert.equal(popup.hidden, true);
    assert.equal(clock.tasks.size, 0);
});

test('polling drains every page, retries the same cursor after failure, and overlaps the last second', async () => {
    const clock = timers();
    const initial = {
        checkin_since: '2026-09-23T01:00:00Z',
        checkins_url: '/checkins',
    };
    const responses = [
        { success: true, guests: [{ id: 1 }], has_more: true, next_cursor: { since: '2026-09-23T01:00:01Z', after_id: 100 } },
        new Error('offline'),
        { success: true, guests: [{ id: 2 }], has_more: false, next_cursor: { since: '2026-09-23T01:00:01Z', after_id: 105 } },
        { success: true, guests: [], has_more: false, next_cursor: null },
    ];
    const urls = [];
    const arrivals = [];
    const status = { textContent: '' };
    const root = { querySelector: selector => selector === '[data-screen-status]' ? status : null };
    const events = {};
    const sandbox = {
        URL, AbortController, Date, Set,
        setTimeout: clock.setTimeout, clearTimeout: clock.clearTimeout,
        location: { href: 'http://localhost/display' },
        document: {
            querySelector: () => root,
            getElementById: () => ({ textContent: JSON.stringify(initial) }),
            addEventListener() {},
        },
        window: {
            WelcomeScreenModules: Object.fromEntries(['greeting', 'background', 'gallery', 'wishes'].map(name => [name, () => ({ update() {}, destroy() {} })])),
            addEventListener(name, handler) { events[name] = handler; },
        },
        async fetch(url) {
            urls.push(new URL(url));
            const data = responses.shift();
            if (data instanceof Error) throw data;
            return { ok: true, json: async () => data };
        },
    };
    sandbox.window.WelcomeScreenModules.checkins = () => ({ enqueue: guests => arrivals.push(...guests), destroy() {} });
    vm.runInNewContext(fs.readFileSync('public/welcome-screen/app.js', 'utf8'), sandbox);
    await new Promise(resolve => setImmediate(resolve));
    await clock.run(50);
    assert.ok(status.textContent.includes('Koneksi terputus'));
    await clock.run(3000);
    assert.equal(urls[1].href, urls[2].href);
    assert.equal(urls[1].searchParams.get('after_id'), '100');
    assert.equal(status.textContent, '');
    await clock.run(3000);
    assert.equal(urls[3].searchParams.get('since'), '2026-09-23T01:00:01Z');
    assert.equal(urls[3].searchParams.get('after_id'), '0');
    assert.deepEqual(arrivals.map(guest => guest.id), [1, 2]);
    events.pagehide();
    assert.equal(clock.tasks.size, 0);
});
