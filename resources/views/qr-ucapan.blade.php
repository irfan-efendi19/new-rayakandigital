<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kirim Ucapan — {{ $invitation->couple_name }}</title>

    <x-meta title="Ucapan & Doa {{ $invitation->couple_name }}"
        description="Sampaikan ucapan dan doa terbaik Anda untuk pernikahan {{ $invitation->couple_name }}." />

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
        body {
            background-image:
                radial-gradient(ellipse at 20% 10%, rgba(139, 92, 246, 0.12) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 90%, rgba(139, 92, 246, 0.10) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 50%, rgba(139, 92, 246, 0.04) 0%, transparent 70%);
            background-attachment: fixed;
        }

        @keyframes float-in {
            from { opacity: 0; transform: translateY(20px) scale(0.96); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .animate-float-in { animation: float-in 0.5s cubic-bezier(0.22, 0.61, 0.36, 1) both; }

        .input-glow:focus {
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2), 0 1px 3px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>

<body class="font-sans antialiased bg-tertiary dark:bg-secondary-900 text-secondary-800 dark:text-neutral-200 min-h-screen flex items-center justify-center p-4 sm:p-6">

    <button type="button" id="theme-toggle"
        class="fixed top-4 right-4 z-50 w-11 h-11 rounded-full bg-white/80 dark:bg-secondary-800/80 backdrop-blur-md shadow-lg border border-neutral-200/60 dark:border-secondary-700/60 flex items-center justify-center text-neutral-600 dark:text-neutral-300 hover:text-violet-500 transition-all">
        <i class="fa-solid fa-sun dark:hidden text-base"></i>
        <i class="fa-solid fa-moon hidden dark:inline text-base"></i>
    </button>

    <div class="w-full max-w-md relative">
        <div class="relative bg-white dark:bg-secondary-800 rounded-[30px] shadow-2xl border border-neutral-100 dark:border-secondary-700 overflow-hidden animate-float-in">

            {{-- Header --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-violet-500 via-purple-600 to-indigo-600 px-6 py-9 text-center text-white">
                <div class="w-16 h-16 mx-auto mb-3 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-lg ring-1 ring-white/40">
                    <i class="fa-regular fa-comment-dots text-3xl text-white"></i>
                </div>
                <p class="text-violet-100 text-[10px] font-semibold uppercase tracking-[0.25em] mb-1">Ucapan & Doa Digital</p>
                <h1 class="font-heading text-2xl font-bold tracking-tight">{{ $invitation->couple_name }}</h1>
                <p class="text-white/80 text-xs mt-2 leading-relaxed">Berikan ucapan hangat dan doa restu terbaik Anda untuk membimbing perjalanan bahagia mempelai.</p>
            </div>

            {{-- Content --}}
            <div class="p-6 space-y-5">

                {{-- Form Ucapan --}}
                <div id="wish-form-wrap">
                    <form id="wish-form" class="space-y-3.5">
                        @csrf
                        <input type="hidden" name="invitation_id" value="{{ $invitation->id }}">
                        <div>
                            <label for="wish-name" class="block text-xs font-semibold text-secondary-700 dark:text-neutral-300 mb-1.5">Nama Anda <span class="text-red-500">*</span></label>
                            <input type="text" name="guest_name" id="wish-name" required placeholder="Masukkan nama Anda"
                                class="input-glow w-full rounded-2xl border border-neutral-200 dark:border-secondary-600 bg-neutral-50 dark:bg-secondary-700/60 px-4 py-3 text-sm text-secondary-800 dark:text-neutral-200 focus:border-violet-500 focus:ring-violet-500 transition-all">
                        </div>
                        <div>
                            <label for="wish-content" class="block text-xs font-semibold text-secondary-700 dark:text-neutral-300 mb-1.5">Pesan & Doa <span class="text-red-500">*</span></label>
                            <textarea name="message" id="wish-content" rows="3" maxlength="500" required placeholder="Tuliskan ucapan dan doa terbaik Anda..."
                                class="input-glow w-full rounded-2xl border border-neutral-200 dark:border-secondary-600 bg-neutral-50 dark:bg-secondary-700/60 px-4 py-3 text-sm text-secondary-800 dark:text-neutral-200 focus:border-violet-500 focus:ring-violet-500 resize-none transition-all"></textarea>
                            <div class="text-right text-[10px] text-neutral-400 mt-1">
                                <span id="wish-char">0</span>/500
                            </div>
                        </div>
                        <button type="submit" id="wish-submit-btn"
                            class="w-full py-3.5 px-5 bg-gradient-to-r from-violet-500 to-purple-600 text-white rounded-2xl text-sm font-semibold shadow-lg shadow-violet-500/20 hover:shadow-xl hover:shadow-violet-500/30 transition-all flex items-center justify-center gap-2">
                            <span id="wish-btn-text" class="inline-flex items-center gap-2">
                                <i class="fa-regular fa-paper-plane"></i> Kirim Ucapan
                            </span>
                            <span id="wish-btn-loading" class="hidden inline-flex items-center gap-2">
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg> Mengirim...
                            </span>
                        </button>
                    </form>
                </div>

                {{-- Success State --}}
                <div id="wish-success" class="hidden text-center py-6">
                    <div class="w-16 h-16 bg-violet-100 dark:bg-violet-900/30 rounded-full flex items-center justify-center mx-auto mb-3 shadow-md">
                        <i class="fa-solid fa-check text-2xl text-violet-600 dark:text-violet-400"></i>
                    </div>
                    <p class="text-base font-bold text-secondary-800 dark:text-neutral-100 mb-1">Ucapan Terkirim! 🤍</p>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400">Terima kasih banyak atas doa dan ucapannya.</p>
                    <button type="button" onclick="location.reload()"
                        class="mt-4 inline-flex items-center gap-1.5 text-xs font-semibold text-violet-600 dark:text-violet-400 hover:underline">
                        <i class="fa-solid fa-rotate-right text-[10px]"></i> Kirim ucapan lagi
                    </button>
                </div>

                {{-- Daftar Ucapan Terbaru --}}
                @if ($invitation->wishes->isNotEmpty())
                    <div class="pt-2">
                        <p class="text-xs font-bold text-neutral-400 uppercase tracking-widest mb-3">Ucapan Terbaru ({{ $invitation->wishes->count() }})</p>
                        <div class="space-y-2.5 max-h-72 overflow-y-auto pr-1">
                            @foreach ($invitation->wishes as $wish)
                                <div class="bg-neutral-50 dark:bg-secondary-700/50 rounded-2xl p-3.5 border border-neutral-200/60 dark:border-secondary-600/50">
                                    <div class="flex items-center gap-2 mb-1.5">
                                        <div class="w-6 h-6 rounded-full bg-gradient-to-br from-violet-400 to-purple-500 flex items-center justify-center text-white text-[10px] font-bold">
                                            {{ mb_strtoupper(mb_substr($wish->guest_name ?? 'T', 0, 1)) }}
                                        </div>
                                        <span class="text-xs font-bold text-secondary-800 dark:text-neutral-100">{{ $wish->guest_name ?? 'Tamu' }}</span>
                                    </div>
                                    <p class="text-xs text-neutral-600 dark:text-neutral-300 leading-relaxed">{{ $wish->message }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Link ke website undangan --}}
                <div class="pt-2">
                    <a href="{{ route('invitation.show', $invitation->slug) }}"
                        class="w-full py-3 px-5 bg-neutral-100 dark:bg-secondary-700 text-secondary-700 dark:text-neutral-200 rounded-2xl text-xs font-semibold hover:bg-neutral-200 dark:hover:bg-secondary-600 transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i> Kembali ke Website Undangan
                    </a>
                </div>
            </div>

            {{-- Footer --}}
            <div class="px-6 py-3.5 bg-neutral-50/80 dark:bg-secondary-900/60 border-t border-neutral-100 dark:border-secondary-700 text-center">
                <p class="text-[11px] text-neutral-400 dark:text-neutral-500">
                    &copy; {{ date('Y') }} {{ config('app.name') }} &mdash; Guestbook & Wishes
                </p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('theme-toggle')?.addEventListener('click', function() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('dark-mode', isDark ? 'true' : 'false');
        });

        const wishContent = document.getElementById('wish-content');
        const wishChar = document.getElementById('wish-char');
        if (wishContent && wishChar) {
            wishContent.addEventListener('input', function() { wishChar.textContent = this.value.length; });
        }

        document.getElementById('wish-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const submitBtn = document.getElementById('wish-submit-btn');
            const btnText = document.getElementById('wish-btn-text');
            const btnLoading = document.getElementById('wish-btn-loading');

            const nameVal = document.getElementById('wish-name')?.value.trim();
            const contentVal = document.getElementById('wish-content')?.value.trim();

            if (!nameVal || !contentVal) {
                alert('Silakan isi nama dan pesan ucapan Anda.');
                return;
            }

            submitBtn.disabled = true;
            if (btnText) btnText.classList.add('hidden');
            if (btnLoading) btnLoading.classList.remove('hidden');

            const formData = new FormData(this);
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (csrfToken) {
                formData.set('_token', csrfToken);
            }

            fetch('{{ route('wish.store', $invitation) }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function(res) {
                return res.json().then(function(data) {
                    return { status: res.status, data: data };
                });
            })
            .then(function(result) {
                if (result.status === 422) {
                    let errorMsg = result.data.message;
                    if (result.data.errors) {
                        errorMsg = Object.values(result.data.errors).flat().join(', ');
                    }
                    throw new Error(errorMsg || 'Terjadi kesalahan validasi.');
                }

                if (result.data && (result.data.success || result.data.wish || result.data.message)) {
                    document.getElementById('wish-form-wrap')?.classList.add('hidden');
                    document.getElementById('wish-success')?.classList.remove('hidden');
                } else {
                    throw new Error(result.data?.message || 'Gagal mengirim ucapan.');
                }
            })
            .catch(function(err) {
                if (submitBtn) submitBtn.disabled = false;
                if (btnText) btnText.classList.remove('hidden');
                if (btnLoading) btnLoading.classList.add('hidden');
                alert(err.message || 'Terjadi kesalahan saat mengirim ucapan. Silakan coba lagi.');
            });
        });
    </script>
</body>
</html>
