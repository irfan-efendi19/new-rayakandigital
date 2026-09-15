export function remainingSeconds(expiresAt, serverNow) {
    return Math.max(0, Math.ceil((Date.parse(expiresAt) - serverNow) / 1000)) || 0;
}

export function formatCountdown(seconds) {
    return [Math.floor(seconds / 3600), Math.floor(seconds / 60) % 60, seconds % 60]
        .map(value => String(value).padStart(2, '0')).join(':');
}

export function savingsPercent(referenceAmount, finalAmount) {
    return referenceAmount > 0
        ? Math.max(0, Math.min(100, Math.floor((referenceAmount - finalAmount) * 100 / referenceAmount)))
        : 0;
}

export function expirePrice(price, serverNow) {
    if (!price.promotion || remainingSeconds(price.promotion.expires_at, serverNow) > 0) return price;

    return { ...price, promotion: null, amount: price.original_amount, discount_amount: 0, savings_percent: 0 };
}

export function registerPromotions(Alpine) {
    Alpine.data('promotionCatalog', () => ({
        prices: {}, featured: null, voucherInput: '', code: '', message: '', refreshing: false,
        serverTime: 0, receivedAt: 0, currentTime: 0, timer: null, poll: null, controller: null,
        endpoint: '',

        init() {
            this.endpoint = this.$el.dataset.promotionUrl || this.$root?.dataset?.promotionUrl || '/promotions/catalog';
            this.code = this.$el.dataset.promotionCode || '';
            this.voucherInput = this.code;
            if (this.$el.dataset.promotionCatalog) {
                try {
                    this.accept(JSON.parse(this.$el.dataset.promotionCatalog));
                } catch (e) {
                    console.error('Failed to parse promotion catalog data', e);
                }
            }
            this.timer = window.setInterval(() => this.tick(), 1000);
            this.poll = window.setInterval(() => this.refresh(), 30000);
            this.onVisible = () => { if (!document.hidden) { this.tick(); this.refresh(); } };
            document.addEventListener('visibilitychange', this.onVisible);
        },

        accept(data) {
            this.serverTime = Date.parse(data.server_now);
            this.receivedAt = performance.now();
            this.currentTime = this.serverTime;
            this.prices = data.prices;
            this.message = data.message || '';
            this.updateFeatured();
        },

        updateFeatured() {
            // Sticky bar only shows for automatic promos (code === null).
            // Manual vouchers are not displayed publicly on the landing page.
            this.featured = Object.values(this.prices).filter(price => price.promotion && price.promotion.code === null)
                .sort((a, b) => b.discount_amount - a.discount_amount)[0] || null;
        },

        tick() {
            this.currentTime = this.serverTime + performance.now() - this.receivedAt;
            let expired = false;
            for (const [tier, price] of Object.entries(this.prices)) {
                const next = expirePrice(price, this.currentTime);
                if (next !== price) { this.prices[tier] = next; expired = true; }
            }
            this.updateFeatured();
            if (expired) this.refresh();
        },

        async refresh() {
            this.controller?.abort();
            const controller = new AbortController();
            this.controller = controller;
            this.refreshing = true;
            const targetUrl = this.endpoint || this.$root?.dataset?.promotionUrl || this.$el?.dataset?.promotionUrl || '/promotions/catalog';
            const url = new URL(targetUrl, window.location.origin);
            if (this.code) url.searchParams.set('promotion_code', this.code);
            try {
                const response = await fetch(url, {
                    headers: { Accept: 'application/json' }, cache: 'no-store', signal: controller.signal,
                });
                if (!response.ok) throw new Error('Harga promo belum dapat diperbarui. Silakan coba lagi.');
                const data = await response.json();
                if (this.controller === controller) this.accept(data);
            } catch (error) {
                if (error.name !== 'AbortError') this.message = error.message;
            } finally {
                if (this.controller === controller) this.refreshing = false;
            }
        },

        applyVoucher() {
            this.code = this.voucherInput.trim().toUpperCase();
            return this.refresh();
        },

        removeVoucher() {
            this.code = '';
            this.voucherInput = '';
            this.message = '';
            return this.refresh();
        },

        price(tier) { return this.prices[tier]; },
        savingsPercent,
        money(amount) { return new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 }).format(amount); },
        countdown(promotion) { return promotion ? formatCountdown(remainingSeconds(promotion.expires_at, this.currentTime)) : '00:00:00'; },
        canCheckout(tier) { return !this.refreshing && !this.message && (!this.code || this.price(tier)?.promotion); },

        destroy() {
            window.clearInterval(this.timer);
            window.clearInterval(this.poll);
            this.controller?.abort();
            document.removeEventListener('visibilitychange', this.onVisible);
        },
    }));
}
