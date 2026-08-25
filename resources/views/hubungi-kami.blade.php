<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <x-meta title="Hubungi Kami - Rayakan Digital"
        description="Hubungi tim Rayakan Digital untuk konsultasi gratis, pertanyaan layanan, atau dukungan teknis. Kami siap membantu Anda merayakan momen berharga."
        keywords="kontak rayakan digital, hubungi kami, layanan pelanggan, konsultasi undangan digital" />

    @stack('meta')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
    <script>
        if (localStorage.getItem('dark-mode') === 'true' || (!('dark-mode' in localStorage) && window.matchMedia(
            '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="bg-neutral-50 font-sans text-secondary-800 antialiased dark:bg-secondary-900 dark:text-neutral-200">
    <x-public-navbar />
    <div class="h-16" aria-hidden="true"></div>

    <main class="overflow-hidden">
        <section class="grain-bg relative isolate border-b border-neutral-200 bg-white dark:border-secondary-700 dark:bg-secondary-900">
            <div class="orb-orange pointer-events-none absolute -left-40 -top-32 h-[34rem] w-[34rem]" aria-hidden="true"></div>
            <div class="orb-warm pointer-events-none absolute -right-40 bottom-0 h-[32rem] w-[32rem]" aria-hidden="true"></div>

            <div class="relative mx-auto max-w-7xl px-6 pb-14 pt-16 text-center sm:px-8 sm:pb-16 sm:pt-20 lg:px-12">
                <div data-aos="fade-up" class="mx-auto max-w-3xl">
                    <span class="inline-flex items-center gap-2 rounded-full border border-primary-200 bg-primary-50 px-3.5 py-2 text-[11px] font-bold uppercase tracking-[0.18em] text-primary-700 dark:border-primary-800 dark:bg-primary-900/30 dark:text-primary-300">
                        <span class="h-2 w-2 rounded-full bg-emerald-500" aria-hidden="true"></span>
                        Tim kami siap membantu
                    </span>
                    <h1 class="mt-6 font-heading text-4xl font-bold leading-tight tracking-tight text-secondary-900 dark:text-white sm:text-5xl lg:text-6xl">
                        Ada yang bisa kami <span class="text-primary-500">bantu?</span>
                    </h1>
                    <p class="mx-auto mt-5 max-w-2xl text-base leading-8 text-neutral-600 dark:text-neutral-300 sm:text-lg">
                        Ceritakan kebutuhan atau kendala Anda. Tim Rayakan Digital akan memberikan jawaban yang jelas,
                        hangat, dan tepat sasaran.
                    </p>

                    <div class="mt-7 flex flex-wrap items-center justify-center gap-x-6 gap-y-3 text-xs font-semibold text-neutral-500 dark:text-neutral-400">
                        <span class="inline-flex items-center gap-2">
                            <i class="fa-solid fa-bolt text-primary-500" aria-hidden="true"></i>
                            Respons cepat
                        </span>
                        <span class="inline-flex items-center gap-2">
                            <i class="fa-solid fa-comments text-primary-500" aria-hidden="true"></i>
                            Konsultasi ramah
                        </span>
                        <span class="inline-flex items-center gap-2">
                            <i class="fa-solid fa-shield-heart text-primary-500" aria-hidden="true"></i>
                            Data tetap aman
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-neutral-50 py-16 dark:bg-secondary-900 sm:py-20">
            <div class="mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">
                <div class="grid items-start gap-8 lg:grid-cols-[0.82fr_1.18fr] lg:gap-10">
                    <aside data-aos="fade-right"
                        class="grain-bg relative overflow-hidden rounded-[2rem] bg-secondary-900 p-7 text-white shadow-2xl sm:p-9 lg:sticky lg:top-24">
                        <div class="orb-orange pointer-events-none absolute -left-32 -top-32 h-80 w-80" aria-hidden="true"></div>
                        <div class="absolute -bottom-28 -right-20 h-72 w-72 rounded-full bg-primary-500/10 blur-3xl" aria-hidden="true"></div>

                        <div class="relative z-10">
                            <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-primary-400">Kontak langsung</span>
                            <h2 class="mt-3 font-heading text-3xl font-bold leading-tight">Mari bicara tentang kebutuhan Anda.</h2>
                            <p class="mt-4 text-sm leading-7 text-neutral-300">
                                Pilih kanal yang paling nyaman. Untuk kebutuhan mendesak, WhatsApp adalah cara tercepat
                                untuk terhubung dengan tim kami.
                            </p>

                            <div class="mt-8 grid gap-3">
                                <a href="https://wa.me/62895349823366?text=Halo%20Rayakan%20Digital%2C%20saya%20ingin%20bertanya%20tentang%20layanan%20Anda."
                                    target="_blank" rel="noopener noreferrer"
                                    class="group flex items-center gap-4 rounded-2xl border border-white/10 bg-white/5 p-4 transition duration-200 hover:-translate-y-0.5 hover:border-emerald-400/40 hover:bg-white/10 focus:outline-none focus-visible:ring-4 focus-visible:ring-emerald-400/20 motion-reduce:transform-none">
                                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-500 text-lg text-white shadow-lg shadow-emerald-500/20">
                                        <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="block text-[10px] font-bold uppercase tracking-wider text-neutral-400">WhatsApp Support</span>
                                        <span class="mt-1 block text-sm font-bold text-white">+62 8953 49823 366</span>
                                    </span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-xs text-neutral-500 transition group-hover:text-emerald-400" aria-hidden="true"></i>
                                </a>

                                <a href="mailto:support@rayakandigital.id"
                                    class="group flex items-center gap-4 rounded-2xl border border-white/10 bg-white/5 p-4 transition duration-200 hover:-translate-y-0.5 hover:border-primary-400/40 hover:bg-white/10 focus:outline-none focus-visible:ring-4 focus-visible:ring-primary-400/20 motion-reduce:transform-none">
                                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary-500 text-base text-white shadow-lg shadow-primary-500/20">
                                        <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="block text-[10px] font-bold uppercase tracking-wider text-neutral-400">Email</span>
                                        <span class="mt-1 block truncate text-sm font-bold text-white">support@rayakandigital.id</span>
                                    </span>
                                    <i class="fa-solid fa-arrow-right text-xs text-neutral-500 transition group-hover:text-primary-400" aria-hidden="true"></i>
                                </a>
                            </div>

                            <dl class="mt-8 grid gap-6 border-t border-white/10 pt-8 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
                                <div class="flex gap-3">
                                    <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/5 text-primary-400">
                                        <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                                    </span>
                                    <div>
                                        <dt class="text-xs font-bold text-white">Alamat kantor</dt>
                                        <dd class="mt-1.5 text-xs leading-6 text-neutral-400">Desa Tugusumberjo, Peterongan, Kabupaten Jombang</dd>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/5 text-primary-400">
                                        <i class="fa-regular fa-clock" aria-hidden="true"></i>
                                    </span>
                                    <div>
                                        <dt class="text-xs font-bold text-white">Jam operasional</dt>
                                        <dd class="mt-1.5 text-xs leading-6 text-neutral-400">Senin–Jumat, 09.00–18.00 WIB<br>Sabtu, 09.00–14.00 WIB</dd>
                                    </div>
                                </div>
                            </dl>

                            <div class="mt-8 flex items-start gap-3 rounded-2xl border border-primary-400/20 bg-primary-500/10 p-4">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary-500 text-xs text-white">
                                    <i class="fa-solid fa-bolt" aria-hidden="true"></i>
                                </span>
                                <p class="text-xs leading-6 text-neutral-300">
                                    Pesan WhatsApp pada jam operasional biasanya mendapat respons dalam
                                    <strong class="text-white">kurang dari 30 menit</strong>.
                                </p>
                            </div>
                        </div>
                    </aside>

                    <div data-aos="fade-left" data-aos-delay="100"
                        class="rounded-[2rem] border border-neutral-200 bg-white p-6 shadow-xl shadow-secondary-900/5 dark:border-secondary-700 dark:bg-secondary-800 sm:p-8 lg:p-10">
                        <div class="flex flex-col gap-4 border-b border-neutral-100 pb-7 dark:border-secondary-700 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-primary-500">Formulir kontak</span>
                                <h2 class="mt-2 font-heading text-2xl font-bold text-secondary-900 dark:text-white sm:text-3xl">Ceritakan kebutuhan Anda</h2>
                                <p class="mt-2 max-w-xl text-sm leading-6 text-neutral-500 dark:text-neutral-400">Semakin lengkap informasinya, semakin tepat bantuan yang dapat kami berikan.</p>
                            </div>
                            <span class="inline-flex w-fit items-center gap-2 whitespace-nowrap rounded-full bg-emerald-50 px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-400">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span>
                                Online
                            </span>
                        </div>

                        <form id="contactForm" class="mt-7 grid gap-5" action="{{ route('hubungi-kami.submit') }}" method="POST">
                            @csrf

                            <div class="grid gap-5 sm:grid-cols-2">
                                <div class="grid gap-2">
                                    <label for="name" class="text-xs font-bold text-secondary-800 dark:text-neutral-200">
                                        Nama lengkap <span class="text-primary-500" aria-hidden="true">*</span>
                                    </label>
                                    <div class="relative">
                                        <i class="fa-regular fa-user pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm text-neutral-400" aria-hidden="true"></i>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                                            autocomplete="name" placeholder="Nama Anda" required maxlength="255"
                                            class="w-full rounded-xl border border-neutral-200 bg-neutral-50 py-3.5 pl-11 pr-4 text-sm text-secondary-900 placeholder:text-neutral-400 transition focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/10 dark:border-secondary-700 dark:bg-secondary-900 dark:text-white dark:placeholder:text-neutral-500 dark:focus:border-primary-500 dark:focus:bg-secondary-900">
                                    </div>
                                </div>

                                <div class="grid gap-2">
                                    <label for="email" class="text-xs font-bold text-secondary-800 dark:text-neutral-200">
                                        Alamat email <span class="text-primary-500" aria-hidden="true">*</span>
                                    </label>
                                    <div class="relative">
                                        <i class="fa-regular fa-envelope pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm text-neutral-400" aria-hidden="true"></i>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                            autocomplete="email" inputmode="email" placeholder="nama@email.com" required maxlength="255"
                                            class="w-full rounded-xl border border-neutral-200 bg-neutral-50 py-3.5 pl-11 pr-4 text-sm text-secondary-900 placeholder:text-neutral-400 transition focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/10 dark:border-secondary-700 dark:bg-secondary-900 dark:text-white dark:placeholder:text-neutral-500 dark:focus:border-primary-500 dark:focus:bg-secondary-900">
                                    </div>
                                </div>
                            </div>

                            <div class="grid gap-2">
                                <label for="subject" class="text-xs font-bold text-secondary-800 dark:text-neutral-200">
                                    Subjek pesan <span class="text-primary-500" aria-hidden="true">*</span>
                                </label>
                                <div class="relative">
                                    <i class="fa-regular fa-message pointer-events-none absolute left-4 top-1/2 z-10 -translate-y-1/2 text-sm text-neutral-400" aria-hidden="true"></i>
                                    <select id="subject" name="subject" required
                                        class="w-full rounded-xl border border-neutral-200 bg-neutral-50 py-3.5 pl-11 pr-10 text-sm text-secondary-900 transition focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/10 dark:border-secondary-700 dark:bg-secondary-900 dark:text-white dark:focus:border-primary-500 dark:focus:bg-secondary-900">
                                        <option value="">Pilih topik yang ingin dibahas</option>
                                        <option value="general" @selected(old('subject') === 'general')>Pertanyaan Umum</option>
                                        <option value="order" @selected(old('subject') === 'order')>Pemesanan Undangan</option>
                                        <option value="technical" @selected(old('subject') === 'technical')>Kendala Teknis</option>
                                        <option value="partnership" @selected(old('subject') === 'partnership')>Kerja Sama</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid gap-2">
                                <div class="flex items-center justify-between gap-4">
                                    <label for="message" class="text-xs font-bold text-secondary-800 dark:text-neutral-200">
                                        Pesan Anda <span class="text-primary-500" aria-hidden="true">*</span>
                                    </label>
                                    <span class="text-[10px] text-neutral-400">Maks. 2.000 karakter</span>
                                </div>
                                <textarea id="message" name="message" rows="6" maxlength="2000"
                                    placeholder="Jelaskan pertanyaan atau kendala Anda secara singkat..." required
                                    class="w-full resize-none rounded-xl border border-neutral-200 bg-neutral-50 px-4 py-3.5 text-sm leading-7 text-secondary-900 placeholder:text-neutral-400 transition focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/10 dark:border-secondary-700 dark:bg-secondary-900 dark:text-white dark:placeholder:text-neutral-500 dark:focus:border-primary-500 dark:focus:bg-secondary-900">{{ old('message') }}</textarea>
                            </div>

                            <div class="flex flex-col-reverse gap-4 pt-1 sm:flex-row sm:items-center sm:justify-between">
                                <p class="flex items-start gap-2 text-[11px] leading-5 text-neutral-400">
                                    <i class="fa-solid fa-lock mt-0.5 text-emerald-500" aria-hidden="true"></i>
                                    <span>Dengan mengirim formulir, Anda menyetujui <a href="{{ route('kebijakan-privasi') }}" class="font-semibold text-neutral-600 underline decoration-neutral-300 underline-offset-2 hover:text-primary-500 dark:text-neutral-300 dark:decoration-secondary-600">kebijakan privasi</a> kami.</span>
                                </p>
                                <button type="submit"
                                    class="inline-flex min-h-12 shrink-0 items-center justify-center gap-2 rounded-xl bg-primary-500 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary-500/20 transition duration-200 hover:-translate-y-0.5 hover:bg-primary-600 hover:shadow-xl focus:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25 disabled:cursor-not-allowed disabled:opacity-60 motion-reduce:transform-none">
                                    <span data-submit-label>Kirim pesan</span>
                                    <span data-submit-loading class="hidden items-center gap-2">
                                        <i class="fa-solid fa-circle-notch animate-spin" aria-hidden="true"></i>
                                        Mengirim...
                                    </span>
                                    <i data-submit-icon class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                                </button>
                            </div>

                            <p id="formStatus" class="sr-only" aria-live="polite"></p>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="border-y border-neutral-200 bg-white py-12 dark:border-secondary-700 dark:bg-secondary-800/40">
            <div class="mx-auto grid max-w-6xl gap-6 px-6 text-center sm:grid-cols-3 sm:px-8">
                @foreach ([
                    ['30 menit', 'Rata-rata respons WhatsApp', 'clock'],
                    ['4 kanal', 'Pilihan topik bantuan', 'layer-group'],
                    ['100%', 'Dibantu oleh tim manusia', 'user-group'],
                ] as $index => [$value, $label, $icon])
                    <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}" class="flex items-center justify-center gap-4 sm:flex-col sm:gap-2">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary-50 text-primary-500 dark:bg-primary-900/30 dark:text-primary-400">
                            <i class="fa-solid fa-{{ $icon }}" aria-hidden="true"></i>
                        </span>
                        <div class="text-left sm:text-center">
                            <p class="font-heading text-2xl font-bold text-secondary-900 dark:text-white">{{ $value }}</p>
                            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">{{ $label }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>

    <x-public-footer />

    <script>
        const contactForm = document.getElementById('contactForm');

        contactForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const submitButton = contactForm.querySelector('button[type="submit"]');
            const submitLabel = submitButton.querySelector('[data-submit-label]');
            const submitLoading = submitButton.querySelector('[data-submit-loading]');
            const submitIcon = submitButton.querySelector('[data-submit-icon]');
            const formStatus = document.getElementById('formStatus');
            const formData = new FormData(contactForm);

            submitButton.disabled = true;
            submitLabel.classList.add('hidden');
            submitIcon.classList.add('hidden');
            submitLoading.classList.remove('hidden');
            submitLoading.classList.add('inline-flex');
            formStatus.textContent = 'Pesan sedang dikirim.';

            try {
                const response = await fetch(contactForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                    },
                });

                const data = await response.json().catch(() => ({}));

                if (!response.ok) {
                    const validationMessage = data.errors
                        ? Object.values(data.errors).flat()[0]
                        : null;

                    throw new Error(validationMessage || data.message || 'Terjadi kesalahan. Silakan coba lagi.');
                }

                formStatus.textContent = 'Pesan berhasil terkirim.';

                Swal.fire({
                    icon: 'success',
                    title: 'Pesan terkirim!',
                    text: 'Terima kasih. Tim kami akan segera menghubungi Anda.',
                    timer: 4000,
                    showConfirmButton: true,
                    confirmButtonColor: '#FF7A00',
                });

                contactForm.reset();
            } catch (error) {
                formStatus.textContent = `Pesan gagal dikirim. ${error.message}`;

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal mengirim',
                    text: error.message,
                    confirmButtonColor: '#FF7A00',
                });
            } finally {
                submitButton.disabled = false;
                submitLabel.classList.remove('hidden');
                submitIcon.classList.remove('hidden');
                submitLoading.classList.add('hidden');
                submitLoading.classList.remove('inline-flex');
            }
        });
    </script>
</body>

</html>
