<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Konfirmasi Kehadiran - {{ $invitation->couple_name }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800|playfair-display:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-primary-50 via-white to-primary-50 dark:from-secondary-900 dark:via-secondary-900 dark:to-primary-950 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white dark:bg-secondary-800 rounded-3xl shadow-xl border border-neutral-100 dark:border-secondary-700 overflow-hidden">
            <div class="bg-gradient-to-r from-primary to-primary-600 px-6 py-8 text-center">
                <div class="w-16 h-16 mx-auto bg-white/20 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h1 class="font-heading text-xl font-bold text-white">Konfirmasi Kehadiran</h1>
                <p class="text-primary-100 text-sm mt-1">{{ $invitation->couple_name }}</p>
            </div>

            <div class="p-6">
                <div id="rsvp-form-container">
                    <div class="text-center mb-6">
                        <p class="text-neutral-600 dark:text-neutral-400 text-sm">
                            Silakan isi data diri Anda untuk konfirmasi kehadiran pada acara pernikahan
                            <strong class="text-secondary-800 dark:text-neutral-200">{{ $invitation->couple_name }}</strong>.
                        </p>
                    </div>

                    <form id="rsvp-form" class="space-y-5">
                        @csrf
                        <input type="hidden" name="invitation_id" value="{{ $invitation->id }}">

                        <div>
                            <label for="guest_name" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1.5">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="guest_name" id="guest_name" required
                                placeholder="Masukkan nama Anda"
                                class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm dark:bg-secondary-700 dark:text-neutral-200">
                            <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">Tuliskan nama lengkap Anda</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                                Kehadiran <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="relative flex items-center justify-center p-4 rounded-xl border-2 border-neutral-200 dark:border-neutral-600 cursor-pointer has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50 dark:has-[:checked]:bg-emerald-900/20 has-[:checked]:shadow-sm transition-all hover:border-neutral-300 dark:hover:border-neutral-500">
                                    <input type="radio" name="attendance" value="attending" required
                                        class="sr-only peer">
                                    <div class="text-center">
                                        <svg class="w-8 h-8 mx-auto text-emerald-500 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 peer-checked:text-emerald-700 dark:peer-checked:text-emerald-400">Hadir</span>
                                    </div>
                                </label>
                                <label class="relative flex items-center justify-center p-4 rounded-xl border-2 border-neutral-200 dark:border-neutral-600 cursor-pointer has-[:checked]:border-red-400 has-[:checked]:bg-red-50 dark:has-[:checked]:bg-red-900/20 has-[:checked]:shadow-sm transition-all hover:border-neutral-300 dark:hover:border-neutral-500">
                                    <input type="radio" name="attendance" value="not_attending" required
                                        class="sr-only peer">
                                    <div class="text-center">
                                        <svg class="w-8 h-8 mx-auto text-red-400 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        <span class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 peer-checked:text-red-600 dark:peer-checked:text-red-400">Tidak Hadir</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div id="pax-field">
                            <label for="pax" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1.5">
                                Jumlah Rombongan <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center gap-3">
                                <button type="button" id="pax-minus"
                                    class="w-10 h-10 rounded-xl border border-neutral-300 dark:border-neutral-600 flex items-center justify-center text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-secondary-700 transition disabled:opacity-50">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                    </svg>
                                </button>
                                <input type="number" name="pax" id="pax" value="1" min="1" max="50" readonly
                                    class="w-16 text-center rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm font-semibold dark:bg-secondary-700 dark:text-neutral-200">
                                <button type="button" id="pax-plus"
                                    class="w-10 h-10 rounded-xl border border-neutral-300 dark:border-neutral-600 flex items-center justify-center text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-secondary-700 transition disabled:opacity-50">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                            <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">Termasuk diri Anda sendiri</p>
                        </div>

                        <button type="submit" id="submit-btn"
                            class="w-full py-3 px-6 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl font-semibold text-sm shadow-md hover:shadow-lg hover:scale-[1.01] active:scale-[0.99] transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                            <span id="btn-text">Kirim Konfirmasi</span>
                            <span id="btn-loading" class="hidden">
                                <svg class="animate-spin inline-block w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                Mengirim...
                            </span>
                        </button>
                    </form>
                </div>

                <div id="rsvp-success" class="hidden text-center py-8">
                    <div class="w-16 h-16 mx-auto bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="font-heading text-xl font-bold text-secondary-800 dark:text-neutral-100 mb-2">Terima Kasih!</h2>
                    <p class="text-neutral-600 dark:text-neutral-400 text-sm mb-6">Konfirmasi kehadiran Anda telah diterima.</p>
                    <button type="button" onclick="window.location.reload()"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary-50 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 rounded-xl text-sm font-semibold hover:bg-primary-100 dark:hover:bg-primary-900/70 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Konfirmasi Lagi
                    </button>
                </div>

                <div id="rsvp-error" class="hidden text-center py-4">
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 mb-4">
                        <p id="error-message" class="text-sm text-red-700 dark:text-red-400"></p>
                    </div>
                    <button type="button" onclick="location.reload()"
                        class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-semibold">Coba Lagi</button>
                </div>
            </div>

            <div class="px-6 pb-6 text-center">
                <p class="text-xs text-neutral-400 dark:text-neutral-500">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. Undangan Pernikahan Digital.
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            paxMinus.addEventListener('click', function() {
                let val = parseInt(paxInput.value) || 1;
                if (val > 1) {
                    paxInput.value = val - 1;
                }
            });

            paxPlus.addEventListener('click', function() {
                let val = parseInt(paxInput.value) || 1;
                if (val < 50) {
                    paxInput.value = val + 1;
                }
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const selectedAttendance = document.querySelector('input[name="attendance"]:checked');
                if (!selectedAttendance) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pilih Kehadiran',
                        text: 'Silakan pilih status kehadiran Anda.',
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
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                fetch('{{ route("rsvp.store", $invitation) }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                    },
                })
                .then(function(response) {
                    return response.json().then(function(data) {
                        return { status: response.status, data: data };
                    });
                })
                .then(function(result) {
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
                .catch(function(error) {
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
