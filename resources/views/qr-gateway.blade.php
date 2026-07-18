<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Konfirmasi Kehadiran - {{ $invitation->couple_name }}</title>

    <x-meta title="Konfirmasi Kehadiran {{ $invitation->couple_name }}"
        description="Konfirmasi kehadiran dan kirim ucapan untuk pernikahan {{ $invitation->couple_name }}." />

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800|playfair-display:400,500,600,700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    @vite(['resources/css/app.css'])

    <script>
        if (localStorage.getItem('dark-mode') === 'true' || (!('dark-mode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            background-image:
                radial-gradient(circle at 15% 20%, rgba(255, 122, 0, 0.08), transparent 40%),
                radial-gradient(circle at 85% 80%, rgba(255, 122, 0, 0.06), transparent 45%);
        }

        .dark body {
            background-image:
                radial-gradient(circle at 15% 20%, rgba(255, 122, 0, 0.12), transparent 40%),
                radial-gradient(circle at 85% 80%, rgba(255, 122, 0, 0.08), transparent 45%);
        }

        @keyframes float-in {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-float-in {
            animation: float-in 0.6s ease-out both;
        }
    </style>
</head>

<body
    class="font-sans antialiased bg-tertiary dark:bg-secondary-900 text-secondary-800 dark:text-neutral-200 min-h-screen flex items-center justify-center p-4 sm:p-6">

    <!-- Dark mode toggle -->
    <button type="button" id="theme-toggle"
        class="fixed top-4 right-4 z-50 w-10 h-10 rounded-full bg-white dark:bg-secondary-800 shadow-soft border border-neutral-200 dark:border-secondary-700 flex items-center justify-center text-neutral-600 dark:text-neutral-300 hover:text-primary-500 dark:hover:text-primary-400 transition-colors"
        aria-label="Ganti tema">
        <i class="fa-solid fa-sun dark:hidden"></i>
        <i class="fa-solid fa-moon hidden dark:inline"></i>
    </button>

    <div class="w-full max-w-md">
        <div
            class="bg-white dark:bg-secondary-800 rounded-3xl shadow-soft border border-neutral-100 dark:border-secondary-700 overflow-hidden animate-float-in">

            <!-- Header -->
            <div
                class="relative overflow-hidden bg-gradient-to-br from-primary-500 to-primary-700 px-6 py-9 text-center">
                <div class="absolute inset-0 pointer-events-none opacity-30"
                    style="background-image: radial-gradient(circle, rgba(255,255,255,0.5) 1px, transparent 1px); background-size: 22px 22px;">
                </div>
                <div class="relative">
                    <div
                        class="w-16 h-16 mx-auto bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mb-3 ring-1 ring-white/30">
                        <i class="fa-solid fa-envelope-open-text text-2xl text-white"></i>
                    </div>
                    <p class="text-primary-100 text-[11px] font-semibold uppercase tracking-[0.2em] mb-1">Konfirmasi
                        Kehadiran</p>
                    <h1 class="font-heading text-xl font-bold text-white">{{ $invitation->couple_name }}</h1>
                    @if ($invitation->event_date)
                        <p class="text-primary-100/90 text-xs mt-1.5 flex items-center justify-center gap-1.5">
                            <i class="fa-regular fa-calendar text-[10px]"></i>
                            {{ $invitation->event_date->translatedFormat('l, d F Y') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="p-6 sm:p-7">
                <!-- Form state -->
                <div id="rsvp-form-container">
                    <div class="text-center mb-6">
                        <p class="text-neutral-500 dark:text-neutral-400 text-sm leading-relaxed">
                            Silakan isi data diri Anda untuk konfirmasi kehadiran pada acara pernikahan
                            <strong
                                class="font-semibold text-secondary-800 dark:text-neutral-100">{{ $invitation->couple_name }}</strong>.
                        </p>
                    </div>

                    <form id="rsvp-form" class="space-y-5">
                        @csrf
                        <input type="hidden" name="invitation_id" value="{{ $invitation->id }}">

                        <!-- Guest name -->
                        <div>
                            <label for="guest_name"
                                class="flex items-center gap-1.5 text-sm font-semibold text-secondary-700 dark:text-neutral-300 mb-1.5">
                                <i class="fa-regular fa-user text-primary-500 text-xs"></i>
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="guest_name" id="guest_name" required
                                placeholder="Masukkan nama Anda"
                                class="block w-full rounded-xl border-neutral-200 dark:border-secondary-600 bg-neutral-50 dark:bg-secondary-700/60 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:bg-white dark:focus:bg-secondary-700 text-sm text-secondary-800 dark:text-neutral-200 transition-colors">
                            <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">Tuliskan nama lengkap Anda
                            </p>
                        </div>

                        <!-- Attendance -->
                        <div>
                            <label
                                class="flex items-center gap-1.5 text-sm font-semibold text-secondary-700 dark:text-neutral-300 mb-2">
                                <i class="fa-regular fa-circle-check text-primary-500 text-xs"></i>
                                Kehadiran <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <label
                                    class="group relative flex flex-col items-center justify-center gap-1.5 p-4 rounded-2xl border-2 border-neutral-200 dark:border-secondary-600 bg-neutral-50 dark:bg-secondary-700/40 cursor-pointer has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50 dark:has-[:checked]:bg-emerald-900/20 has-[:checked]:shadow-sm transition-all hover:border-neutral-300 dark:hover:border-neutral-500">
                                    <input type="radio" name="attendance" value="attending" required
                                        class="sr-only peer">
                                    <span
                                        class="w-9 h-9 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center group-has-[:checked]:scale-110 transition-transform">
                                        <i class="fa-solid fa-check text-emerald-600 dark:text-emerald-400 text-sm"></i>
                                    </span>
                                    <span
                                        class="block text-sm font-semibold text-secondary-700 dark:text-neutral-300 peer-checked:text-emerald-700 dark:peer-checked:text-emerald-400">Hadir</span>
                                </label>
                                <label
                                    class="group relative flex flex-col items-center justify-center gap-1.5 p-4 rounded-2xl border-2 border-neutral-200 dark:border-secondary-600 bg-neutral-50 dark:bg-secondary-700/40 cursor-pointer has-[:checked]:border-red-400 has-[:checked]:bg-red-50 dark:has-[:checked]:bg-red-900/20 has-[:checked]:shadow-sm transition-all hover:border-neutral-300 dark:hover:border-neutral-500">
                                    <input type="radio" name="attendance" value="not_attending" required
                                        class="sr-only peer">
                                    <span
                                        class="w-9 h-9 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center group-has-[:checked]:scale-110 transition-transform">
                                        <i class="fa-solid fa-xmark text-red-500 dark:text-red-400 text-sm"></i>
                                    </span>
                                    <span
                                        class="block text-sm font-semibold text-secondary-700 dark:text-neutral-300 peer-checked:text-red-600 dark:peer-checked:text-red-400">Tidak
                                        Hadir</span>
                                </label>
                            </div>
                        </div>

                        <!-- Pax -->
                        <div id="pax-field">
                            <label for="pax"
                                class="flex items-center gap-1.5 text-sm font-semibold text-secondary-700 dark:text-neutral-300 mb-1.5">
                                <i class="fa-solid fa-users text-primary-500 text-xs"></i>
                                Jumlah Rombongan <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center gap-3">
                                <button type="button" id="pax-minus"
                                    class="w-10 h-10 rounded-xl border border-neutral-200 dark:border-secondary-600 bg-neutral-50 dark:bg-secondary-700/60 flex items-center justify-center text-secondary-600 dark:text-neutral-300 hover:bg-primary-50 hover:border-primary-300 hover:text-primary-600 dark:hover:bg-primary-900/30 dark:hover:text-primary-400 transition disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-neutral-50 dark:disabled:hover:bg-secondary-700/60">
                                    <i class="fa-solid fa-minus text-xs"></i>
                                </button>
                                <input type="number" name="pax" id="pax" value="1" min="1" max="50" readonly
                                    class="w-16 text-center text-lg font-bold rounded-xl border-neutral-200 dark:border-secondary-600 bg-neutral-50 dark:bg-secondary-700/60 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-secondary-800 dark:text-neutral-100">
                                <button type="button" id="pax-plus"
                                    class="w-10 h-10 rounded-xl border border-neutral-200 dark:border-secondary-600 bg-neutral-50 dark:bg-secondary-700/60 flex items-center justify-center text-secondary-600 dark:text-neutral-300 hover:bg-primary-50 hover:border-primary-300 hover:text-primary-600 dark:hover:bg-primary-900/30 dark:hover:text-primary-400 transition disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-neutral-50 dark:disabled:hover:bg-secondary-700/60">
                                    <i class="fa-solid fa-plus text-xs"></i>
                                </button>
                                <span class="text-xs text-neutral-400 dark:text-neutral-500">orang</span>
                            </div>
                            <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">Termasuk diri Anda sendiri
                            </p>
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message"
                                class="flex items-center gap-1.5 text-sm font-semibold text-secondary-700 dark:text-neutral-300 mb-1.5">
                                <i class="fa-regular fa-heart text-primary-500 text-xs"></i>
                                Pesan untuk Pengantin
                            </label>
                            <textarea name="message" id="message" rows="3" maxlength="500"
                                placeholder="Tuliskan ucapan atau doa untuk pengantin..."
                                class="block w-full rounded-xl border-neutral-200 dark:border-secondary-600 bg-neutral-50 dark:bg-secondary-700/60 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:bg-white dark:focus:bg-secondary-700 text-sm text-secondary-800 dark:text-neutral-200 resize-none transition-colors"></textarea>
                            <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">Doa dan ucapan untuk kedua
                                mempelai (opsional)</p>
                        </div>

                        <!-- Submit -->
                        <button type="submit" id="submit-btn"
                            class="group w-full py-3.5 px-6 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-semibold text-sm shadow-soft hover:shadow-lg hover:from-primary-600 hover:to-primary-700 focus:ring-4 focus:ring-primary-500/30 active:scale-[0.99] transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                            <span id="btn-text" class="inline-flex items-center gap-2">
                                <i
                                    class="fa-regular fa-paper-plane text-sm group-hover:translate-x-0.5 transition-transform"></i>
                                Kirim Konfirmasi
                            </span>
                            <span id="btn-loading" class="hidden inline-flex items-center gap-2">
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                Mengirim...
                            </span>
                        </button>
                    </form>
                </div>

                <!-- Success state -->
                <div id="rsvp-success" class="hidden text-center py-6 animate-float-in">
                    <div class="relative w-20 h-20 mx-auto mb-5">
                        <div
                            class="absolute inset-0 bg-emerald-100 dark:bg-emerald-900/30 rounded-full animate-ping opacity-60">
                        </div>
                        <div
                            class="relative w-20 h-20 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-check text-3xl text-emerald-600 dark:text-emerald-400"></i>
                        </div>
                    </div>
                    <h2 class="font-heading text-2xl font-bold text-secondary-800 dark:text-neutral-100 mb-2">Terima
                        Kasih!</h2>
                    <p class="text-neutral-500 dark:text-neutral-400 text-sm mb-6 leading-relaxed">
                        Konfirmasi kehadiran dan pesan Anda telah kami terima.<br>
                        Sampai jumpa di hari bahagia. 🤍
                    </p>
                    <button type="button" onclick="window.location.reload()"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary-50 dark:bg-primary-900/40 text-primary-700 dark:text-primary-300 rounded-xl text-sm font-semibold hover:bg-primary-100 dark:hover:bg-primary-900/60 transition">
                        <i class="fa-solid fa-rotate-right text-xs"></i>
                        Konfirmasi Lagi
                    </button>
                </div>

                <!-- Error state -->
                <div id="rsvp-error" class="hidden text-center py-4 animate-float-in">
                    <div
                        class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 mb-4 flex items-start gap-3 text-left">
                        <i class="fa-solid fa-circle-exclamation text-red-500 dark:text-red-400 mt-0.5"></i>
                        <p id="error-message" class="text-sm text-red-700 dark:text-red-400 flex-1"></p>
                    </div>
                    <button type="button" onclick="location.reload()"
                        class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-semibold">Coba
                        Lagi</button>
                </div>
            </div>

            <!-- Footer -->
            <div
                class="px-6 py-4 bg-neutral-50 dark:bg-secondary-900/50 border-t border-neutral-100 dark:border-secondary-700 text-center">
                <p class="text-xs text-neutral-400 dark:text-neutral-500">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. Rayakan Cinta Dengan Sentuhan Digital.
                </p>
            </div>
        </div>
    </div>

    <script>
        // Dark mode toggle
        const themeToggle = document.getElementById('theme-toggle');
        if (themeToggle) {
            themeToggle.addEventListener('click', function () {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('dark-mode', isDark ? 'true' : 'false');
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('rsvp-form');
            const formContainer = document.getElementById('rsvp-form-container');
            const successContainer = document.getElementById('rsvp-success');
            const errorContainer = document.getElementById('rsvp-error');
            const errorMessage = document.getElementById('error-message');
            const submitBtn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');
            const btnLoading = document.getElementById('btn-loading');
            const paxField = document.getElementById('pax-field');
            const paxInput = document.getElementById('pax');
            const paxMinus = document.getElementById('pax-minus');
            const paxPlus = document.getElementById('pax-plus');
            const attendanceRadios = document.querySelectorAll('input[name="attendance"]');

            function togglePaxField() {
                const selected = document.querySelector('input[name="attendance"]:checked');
                if (selected && selected.value === 'attending') {
                    paxField.classList.remove('hidden');
                } else {
                    paxField.classList.add('hidden');
                }
            }

            attendanceRadios.forEach(radio => {
                radio.addEventListener('change', togglePaxField);
            });

            togglePaxField();

            function updatePaxButtons() {
                const val = parseInt(paxInput.value) || 1;
                paxMinus.disabled = val <= 1;
                paxPlus.disabled = val >= 50;
            }

            paxMinus.addEventListener('click', function () {
                let val = parseInt(paxInput.value) || 1;
                if (val > 1) {
                    paxInput.value = val - 1;
                }
                updatePaxButtons();
            });

            paxPlus.addEventListener('click', function () {
                let val = parseInt(paxInput.value) || 1;
                if (val < 50) {
                    paxInput.value = val + 1;
                }
                updatePaxButtons();
            });

            updatePaxButtons();

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const selectedAttendance = document.querySelector('input[name="attendance"]:checked');
                if (!selectedAttendance) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pilih Kehadiran',
                        text: 'Silakan pilih status kehadiran Anda.',
                        confirmButtonColor: '#FF7A00',
                    });
                    return;
                }

                submitBtn.disabled = true;
                btnText.classList.add('hidden');
                btnLoading.classList.remove('hidden');

                const formData = new FormData();
                formData.append('guest_name', document.getElementById('guest_name').value);
                formData.append('attendance', selectedAttendance.value);
                formData.append('pax', selectedAttendance.value === 'attending' ? paxInput.value : 1);
                formData.append('message', document.getElementById('message').value);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                fetch('{{ route("rsvp.store", $invitation) }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                    },
                })
                    .then(function (response) {
                        return response.json().then(function (data) {
                            return { status: response.status, data: data };
                        });
                    })
                    .then(function (result) {
                        if (result.status === 422) {
                            throw new Error(result.data.message || 'Terjadi kesalahan.');
                        }
                        if (result.data.success) {
                            formContainer.classList.add('hidden');
                            errorContainer.classList.add('hidden');
                            successContainer.classList.remove('hidden');
                        } else {
                            throw new Error(result.data.message || 'Terjadi kesalahan.');
                        }
                    })
                    .catch(function (error) {
                        submitBtn.disabled = false;
                        btnText.classList.remove('hidden');
                        btnLoading.classList.add('hidden');
                        errorMessage.textContent = error.message || 'Terjadi kesalahan. Silakan coba lagi.';
                        errorContainer.classList.remove('hidden');
                    });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>