@push('scripts')
    @php
        $checklistItemsForJs = $checklists->mapWithKeys(fn($item) => [
            $item->id => [
                'code' => $item->category_code,
                'is_document' => (bool) $item->is_document,
                'completed' => (bool) $item->is_completed,
                'pria' => (bool) $item->is_completed_pria,
                'wanita' => (bool) $item->is_completed_wanita,
            ],
        ])->all();
    @endphp
    <script>
        function formatRupiahValue(value) {
            const digits = value.replace(/[^\d]/g, '');
            return digits ? Number(digits).toLocaleString('id-ID') : '';
        }

        function initRupiahInputs() {
            document.querySelectorAll('[data-rupiah]').forEach(function (input) {
                input.value = formatRupiahValue(input.value);
            });
        }

        document.addEventListener('input', function (e) {
            if (e.target.matches && e.target.matches('[data-rupiah]')) {
                e.target.value = formatRupiahValue(e.target.value);
            }
        });

        document.addEventListener('submit', function (e) {
            (e.target.querySelectorAll ? e.target.querySelectorAll('[data-rupiah]') : []).forEach(function (input) {
                input.value = formatRupiahValue(input.value).replace(/\./g, '');
            });
        }, true);

        document.addEventListener('DOMContentLoaded', initRupiahInputs);
        window.addEventListener('pageshow', initRupiahInputs);

        function plannerCalendar() {
            return {
                year: new Date().getFullYear(),
                month: new Date().getMonth(),
                today: new Date().toISOString().slice(0, 10),
                weddingDate: @json($weddingDate?->format('Y-m-d')),
                eventDates: @json($itemsByCategory['CALENDAR']->pluck('event_date')->filter()->map->format('Y-m-d')->values()->all()),

                get monthLabel() {
                    return new Date(this.year, this.month, 1).toLocaleDateString('id-ID', {
                        month: 'long',
                        year: 'numeric',
                    });
                },

                get weddingLabel() {
                    if (this.weddingDate) {
                        return 'Hari H: ' + new Date(this.weddingDate).toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'short',
                            year: 'numeric',
                        });
                    }

                    return 'Tanggal Hari H belum ditentukan';
                },

                get firstDayIndex() {
                    return (new Date(this.year, this.month, 1).getDay() + 6) % 7;
                },

                get daysInMonth() {
                    return new Date(this.year, this.month + 1, 0).getDate();
                },

                get cells() {
                    const cells = [];
                    const firstDayIndex = this.firstDayIndex;
                    const daysInMonth = this.daysInMonth;

                    for (let i = 0; i < firstDayIndex; i++) {
                        cells.push({ key: 'blank-' + i, isOutside: true, day: '', isToday: false, isWedding: false, hasEvent: false });
                    }

                    for (let d = 1; d <= daysInMonth; d++) {
                        const date = this.year + '-' + String(this.month + 1).padStart(2, '0') + '-' + String(d).padStart(2, '0');
                        cells.push({
                            key: date,
                            day: d,
                            isOutside: false,
                            isToday: date === this.today,
                            isWedding: this.weddingDate !== null && date === this.weddingDate,
                            hasEvent: this.eventDates.includes(date),
                        });
                    }

                    return cells;
                },

                prevMonth() {
                    this.month--;
                    if (this.month < 0) {
                        this.month = 11;
                        this.year--;
                    }
                },

                nextMonth() {
                    this.month++;
                    if (this.month > 11) {
                        this.month = 0;
                        this.year++;
                    }
                },

                addEventToDate(date) {
                    window.__selectedCalendarDate = date;
                    this.$dispatch('open-calendar-modal');
                },
            };
        }

        function plannerChecklist() {
            return {
                items: @json($checklistItemsForJs),

                checkboxCount(item) {
                    return item.is_document ? 2 : 1;
                },

                completedCheckboxCount(item) {
                    return item.is_document
                        ? (item.pria ? 1 : 0) + (item.wanita ? 1 : 0)
                        : (item.completed ? 1 : 0);
                },

                get totalItems() {
                    return Object.values(this.items)
                        .filter((item) => item.code !== 'ADMINISTRATION')
                        .reduce((sum, item) => sum + this.checkboxCount(item), 0);
                },

                get completedItems() {
                    return Object.values(this.items)
                        .filter((item) => item.code !== 'ADMINISTRATION')
                        .reduce((sum, item) => sum + this.completedCheckboxCount(item), 0);
                },

                get progressPercent() {
                    return this.totalItems > 0 ? Math.round((this.completedItems / this.totalItems) * 100) : 0;
                },

                categoryItems(code) {
                    return Object.values(this.items).filter((item) => item.code === code);
                },

                categoryTotal(code) {
                    return this.categoryItems(code)
                        .reduce((sum, item) => sum + this.checkboxCount(item), 0);
                },

                categoryCompleted(code) {
                    return this.categoryItems(code)
                        .reduce((sum, item) => sum + this.completedCheckboxCount(item), 0);
                },

                categoryProgress(code) {
                    const total = this.categoryTotal(code);
                    return total > 0 ? Math.round((this.categoryCompleted(code) / total) * 100) : 0;
                },

                async toggleItem(id, event) {
                    const checkbox = event.target;
                    const url = checkbox.dataset.toggleUrl;
                    const party = checkbox.dataset.party || null;
                    const key = party === 'pria' ? 'pria' : party === 'wanita' ? 'wanita' : 'completed';
                    const previous = this.items[id][key];
                    this.items[id][key] = checkbox.checked;

                    try {
                        const response = await fetch(url, {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({ party: party }),
                        });

                        if (!response.ok) {
                            throw new Error('Toggle gagal');
                        }

                        const data = await response.json();
                        this.items[id].completed = data.is_completed;
                        this.items[id].pria = data.is_completed_pria;
                        this.items[id].wanita = data.is_completed_wanita;
                    } catch (error) {
                        this.items[id][key] = previous;
                        checkbox.checked = previous;
                    }
                },
            };
        }

        function plannerCountdown(targetDate, weddingTime) {
            let targetDateTime = targetDate;
            if (weddingTime) {
                targetDateTime += 'T' + weddingTime;
            } else {
                targetDateTime += 'T23:59:59';
            }

            return {
                target: new Date(targetDateTime).getTime(),
                days: 0,
                hours: 0,
                minutes: 0,
                seconds: 0,
                initialized: false,
                timer: null,

                init() {
                    this.update();
                    this.timer = setInterval(() => this.update(), 1000);
                },

                update() {
                    const diff = this.target - Date.now();
                    if (diff <= 0) {
                        this.initialized = false;
                        if (this.timer) {
                            clearInterval(this.timer);
                        }
                        return;
                    }

                    this.initialized = true;
                    this.days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    this.hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    this.minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    this.seconds = Math.floor((diff % (1000 * 60)) / 1000);
                },

                destroy() {
                    if (this.timer) {
                        clearInterval(this.timer);
                    }
                },
            };
        }
    </script>
@endpush