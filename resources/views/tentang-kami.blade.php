<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <x-meta title="Tentang Kami - Rayakan Digital"
        description="Berawal dari sebuah visi untuk menyatukan tradisi dan teknologi, kami menghadirkan Rayakan Digital sebagai jembatan untuk merayakan setiap momen berharga Anda."
        keywords="tentang rayakan digital, undangan digital, sejarah, visi misi, tim" />

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
        <section class="grain-bg relative isolate overflow-hidden border-b border-neutral-200 bg-white dark:border-secondary-700 dark:bg-secondary-900">
            <div class="orb-orange pointer-events-none absolute -left-44 -top-32 h-[36rem] w-[36rem]" aria-hidden="true"></div>
            <div class="orb-warm pointer-events-none absolute -right-48 bottom-0 h-[38rem] w-[38rem]" aria-hidden="true"></div>

            <div class="relative mx-auto grid min-h-[42rem] max-w-7xl items-center gap-14 px-6 py-16 sm:px-8 lg:grid-cols-[1.05fr_.95fr] lg:gap-10 lg:px-12 lg:py-24">
                <div data-aos="fade-right" class="max-w-2xl">
                    <span class="inline-flex items-center gap-2 rounded-full border border-primary-200 bg-primary-50 px-3.5 py-2 text-[11px] font-bold uppercase tracking-[0.18em] text-primary-700 dark:border-primary-800 dark:bg-primary-900/30 dark:text-primary-300">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-primary-500 text-[10px] text-white" aria-hidden="true">
                            <i class="fa-solid fa-heart"></i>
                        </span>
                        Tentang Rayakan Digital
                    </span>

                    <h1 class="mt-6 font-heading text-4xl font-bold leading-[1.08] tracking-tight text-secondary-900 dark:text-white sm:text-5xl lg:text-6xl">
                        Teknologi yang terasa dekat di setiap
                        <span class="text-primary-500">momen berharga.</span>
                    </h1>

                    <p class="mt-6 max-w-xl text-base leading-8 text-neutral-600 dark:text-neutral-300 sm:text-lg">
                        Kami menyatukan makna tradisi dengan kemudahan teknologi, agar setiap cerita dapat dirayakan
                        secara personal, indah, dan mudah dibagikan.
                    </p>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('undangan-web') }}"
                            class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-primary-500 px-7 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary-500/25 transition duration-200 hover:-translate-y-0.5 hover:bg-primary-600 hover:shadow-xl focus:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/30 motion-reduce:transform-none">
                            Kenali layanan kami
                            <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                        </a>
                        <a href="{{ route('hubungi-kami') }}"
                            class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-neutral-300 bg-white/80 px-7 py-3.5 text-sm font-bold text-secondary-800 transition duration-200 hover:-translate-y-0.5 hover:border-primary-300 hover:text-primary-600 focus:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/20 dark:border-secondary-700 dark:bg-secondary-800/80 dark:text-neutral-100 dark:hover:border-primary-700 dark:hover:text-primary-400 motion-reduce:transform-none">
                            <i class="fa-regular fa-comments" aria-hidden="true"></i>
                            Bicara dengan kami
                        </a>
                    </div>
                </div>

                <div data-aos="fade-left" data-aos-delay="150" class="relative mx-auto w-full max-w-xl">
                    <div class="absolute inset-x-10 top-1/2 h-64 -translate-y-1/2 rounded-full bg-primary-500/20 blur-3xl dark:bg-primary-600/15" aria-hidden="true"></div>
                    <div class="grain-bg relative overflow-hidden rounded-[2rem] border border-secondary-700 bg-secondary-900 p-7 shadow-2xl sm:p-9">
                        <div class="absolute -right-24 -top-24 h-64 w-64 rounded-full bg-primary-500/15 blur-3xl" aria-hidden="true"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between gap-4">
                                <img src="{{ asset('img/logo.png') }}" alt="Logo Rayakan Digital" width="56" height="56"
                                    class="h-12 w-12 rounded-xl object-contain sm:h-14 sm:w-14">
                                <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-neutral-400">Sejak 2025</span>
                            </div>

                            <p class="mt-8 font-heading text-2xl font-bold leading-snug text-white sm:text-3xl">
                                “Setiap momen punya cerita. Teknologi membantu cerita itu sampai kepada lebih banyak hati.”
                            </p>

                            <div class="mt-8 rounded-2xl border border-white/10 bg-white/5 p-4">
                                <img src="{{ asset('img/mockup.png') }}" alt="Produk digital Rayakan Digital pada perangkat seluler"
                                    width="493" height="347" fetchpriority="high" class="mx-auto w-full max-w-md drop-shadow-2xl">
                            </div>

                            <div class="mt-5 flex flex-wrap gap-2">
                                @foreach (['Undangan Web', 'Buku Tamu', 'Live Streaming'] as $service)
                                    <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-[10px] font-semibold text-neutral-300">{{ $service }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="border-b border-neutral-200 bg-neutral-50 dark:border-secondary-700 dark:bg-secondary-800/40" aria-label="Ringkasan Rayakan Digital">
            <dl class="mx-auto grid max-w-7xl gap-px bg-neutral-200 dark:bg-secondary-700 sm:grid-cols-3">
                @foreach ([
                    ['2025', 'Awal perjalanan kami'],
                    ['3 solusi', 'Layanan yang saling terhubung'],
                    ['1 tujuan', 'Momen terasa lebih bermakna'],
                ] as $index => [$value, $label])
                    <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}"
                        class="flex items-center justify-center gap-4 bg-neutral-50 px-6 py-7 text-center dark:bg-secondary-800/80 sm:flex-col sm:gap-1">
                        <dt class="font-heading text-3xl font-bold text-secondary-900 dark:text-white">{{ $value }}</dt>
                        <dd class="text-xs leading-5 text-neutral-500 dark:text-neutral-400">{{ $label }}</dd>
                    </div>
                @endforeach
            </dl>
        </section>

        <section class="bg-white py-20 dark:bg-secondary-900 sm:py-24">
            <div class="mx-auto grid max-w-7xl items-center gap-12 px-6 sm:px-8 lg:grid-cols-[.9fr_1.1fr] lg:gap-16 lg:px-12">
                <div data-aos="fade-right" class="relative">
                    <div class="overflow-hidden rounded-[2rem] border border-primary-200 bg-primary-500 shadow-2xl shadow-primary-500/15 dark:border-primary-800">
                        <img src="{{ asset('img/thumnail.jpg') }}" alt="Identitas Rayakan Digital" width="1200" height="630"
                            loading="lazy" class="aspect-[4/3] h-full w-full object-cover">
                    </div>
                    <div class="absolute -bottom-5 -right-3 max-w-[15rem] rounded-2xl border border-neutral-200 bg-white p-4 shadow-xl dark:border-secondary-700 dark:bg-secondary-800 sm:-right-5">
                        <i class="fa-solid fa-quote-left text-primary-500" aria-hidden="true"></i>
                        <p class="mt-2 text-xs font-semibold leading-6 text-secondary-800 dark:text-neutral-200">Merayakan cinta dengan sentuhan digital.</p>
                    </div>
                </div>

                <div data-aos="fade-left" data-aos-delay="100">
                    <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-primary-500">Cerita kami</span>
                    <h2 class="mt-3 font-heading text-3xl font-bold leading-tight text-secondary-900 dark:text-white sm:text-4xl">
                        Berawal dari satu pertanyaan sederhana.
                    </h2>
                    <p class="mt-5 text-sm leading-7 text-neutral-600 dark:text-neutral-300 sm:text-base">
                        Bagaimana jika teknologi tidak menggantikan tradisi, tetapi membantu maknanya menjangkau lebih
                        banyak orang? Dari pertanyaan itu, Rayakan Digital mulai bertumbuh pada 2025.
                    </p>
                    <p class="mt-4 text-sm leading-7 text-neutral-600 dark:text-neutral-300 sm:text-base">
                        Kami membangun pengalaman digital yang praktis tanpa kehilangan rasa personal—mulai dari
                        undangan, pengelolaan tamu, hingga cara keluarga dan sahabat mengikuti momen dari mana saja.
                    </p>

                    <div class="mt-8 grid gap-4">
                        @foreach ([
                            ['Tradisi tetap bermakna', 'Teknologi hadir untuk memperkuat cerita, bukan menghilangkan kehangatannya.', 'heart'],
                            ['Mudah untuk semua', 'Pengalaman dirancang agar nyaman digunakan oleh penyelenggara maupun tamu.', 'hand-pointer'],
                            ['Personal di setiap detail', 'Setiap perayaan memiliki karakter yang pantas ditampilkan dengan caranya sendiri.', 'wand-magic-sparkles'],
                        ] as [$title, $description, $icon])
                            <div class="flex gap-4 rounded-2xl border border-neutral-200 bg-neutral-50 p-4 dark:border-secondary-700 dark:bg-secondary-800">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary-100 text-primary-600 dark:bg-primary-900/40 dark:text-primary-400">
                                    <i class="fa-solid fa-{{ $icon }}" aria-hidden="true"></i>
                                </span>
                                <div>
                                    <h3 class="text-sm font-bold text-secondary-900 dark:text-white">{{ $title }}</h3>
                                    <p class="mt-1 text-xs leading-6 text-neutral-500 dark:text-neutral-400">{{ $description }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="border-y border-neutral-200 bg-neutral-50 py-20 dark:border-secondary-700 dark:bg-secondary-800/40 sm:py-24">
            <div class="mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">
                <div class="grid gap-6 lg:grid-cols-12">
                    <article data-aos="fade-up"
                        class="grain-bg relative overflow-hidden rounded-[2rem] bg-primary-500 p-7 text-white shadow-xl shadow-primary-500/15 sm:p-9 lg:col-span-5">
                        <div class="absolute -right-24 -top-24 h-64 w-64 rounded-full bg-white/10 blur-3xl" aria-hidden="true"></div>
                        <div class="relative z-10">
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 text-lg">
                                <i class="fa-regular fa-eye" aria-hidden="true"></i>
                            </span>
                            <span class="mt-8 block text-[11px] font-bold uppercase tracking-[0.2em] text-white/70">Visi kami</span>
                            <h2 class="mt-3 font-heading text-3xl font-bold leading-snug">
                                Menjadi partner digital yang dipercaya dalam setiap momen berharga.
                            </h2>
                            <p class="mt-5 text-sm leading-7 text-white/80">
                                Kami ingin membantu setiap cerita melampaui jarak dan waktu, tanpa kehilangan makna
                                yang membuatnya istimewa.
                            </p>
                        </div>
                    </article>

                    <article data-aos="fade-up" data-aos-delay="100"
                        class="rounded-[2rem] border border-neutral-200 bg-white p-7 shadow-sm dark:border-secondary-700 dark:bg-secondary-800 sm:p-9 lg:col-span-7">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-primary-500">Misi kami</span>
                                <h2 class="mt-3 font-heading text-3xl font-bold text-secondary-900 dark:text-white">Membuat perayaan digital lebih manusiawi.</h2>
                            </div>
                            <span class="hidden h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-primary-50 text-primary-600 dark:bg-primary-900/30 dark:text-primary-400 sm:flex">
                                <i class="fa-solid fa-rocket" aria-hidden="true"></i>
                            </span>
                        </div>

                        <ol class="mt-8 grid gap-4 sm:grid-cols-3">
                            @foreach ([
                                ['01', 'Menyederhanakan', 'Mengubah proses rumit menjadi pengalaman yang mudah dipahami.'],
                                ['02', 'Menghubungkan', 'Mendekatkan penyelenggara, keluarga, dan tamu melalui satu ekosistem.'],
                                ['03', 'Mendampingi', 'Memberikan dukungan yang hangat dari persiapan hingga hari perayaan.'],
                            ] as [$number, $title, $description])
                                <li class="rounded-2xl border border-neutral-200 bg-neutral-50 p-5 dark:border-secondary-700 dark:bg-secondary-900">
                                    <span class="font-heading text-2xl font-bold text-primary-300 dark:text-primary-800">{{ $number }}</span>
                                    <h3 class="mt-4 text-sm font-bold text-secondary-900 dark:text-white">{{ $title }}</h3>
                                    <p class="mt-2 text-xs leading-6 text-neutral-500 dark:text-neutral-400">{{ $description }}</p>
                                </li>
                            @endforeach
                        </ol>
                    </article>
                </div>
            </div>
        </section>

        <section class="bg-white py-20 dark:bg-secondary-900 sm:py-24">
            <div class="mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">
                <div data-aos="fade-up" class="mx-auto max-w-2xl text-center">
                    <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-primary-500">Nilai yang kami jaga</span>
                    <h2 class="mt-3 font-heading text-3xl font-bold text-secondary-900 dark:text-white sm:text-4xl">Cara kami bekerja, setiap hari.</h2>
                    <p class="mt-4 text-sm leading-7 text-neutral-600 dark:text-neutral-300 sm:text-base">Prinsip sederhana yang menjadi dasar setiap keputusan, desain, dan dukungan kami.</p>
                </div>

                <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ([
                        ['Personal', 'Kami melihat manusia dan cerita di balik setiap kebutuhan.', 'fingerprint', 'bg-primary-100 text-primary-600 dark:bg-primary-900 dark:text-primary-400'],
                        ['Inovatif', 'Kami terus mencari cara yang lebih praktis, relevan, dan menyenangkan.', 'wand-magic-sparkles', 'bg-violet-100 text-violet-600 dark:bg-violet-950 dark:text-violet-400'],
                        ['Andal', 'Kami menjaga kualitas, keamanan, dan konsistensi pengalaman.', 'shield-halved', 'bg-emerald-100 text-emerald-600 dark:bg-emerald-950 dark:text-emerald-400'],
                        ['Mendampingi', 'Kami hadir dengan bahasa yang jelas dan dukungan yang hangat.', 'handshake-angle', 'bg-sky-100 text-sky-600 dark:bg-sky-950 dark:text-sky-400'],
                    ] as $index => [$title, $description, $icon, $colorClass])
                        <article data-aos="fade-up" data-aos-delay="{{ $index * 100 }}"
                            class="group rounded-3xl border border-neutral-200 bg-neutral-50 p-6 transition duration-300 hover:-translate-y-1 hover:border-primary-200 hover:bg-white hover:shadow-xl dark:border-secondary-700 dark:bg-secondary-800 dark:hover:border-primary-800 dark:hover:bg-secondary-800 motion-reduce:transform-none">
                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl {{ $colorClass }}">
                                <i class="fa-solid fa-{{ $icon }}" aria-hidden="true"></i>
                            </span>
                            <h3 class="mt-6 text-lg font-bold text-secondary-900 dark:text-white">{{ $title }}</h3>
                            <p class="mt-2 text-sm leading-7 text-neutral-500 dark:text-neutral-400">{{ $description }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="bg-neutral-50 px-6 py-16 dark:bg-secondary-900 sm:px-8 sm:py-20">
            <div data-aos="zoom-in"
                class="grain-bg relative mx-auto max-w-5xl overflow-hidden rounded-[2rem] border border-secondary-700 bg-secondary-900 px-6 py-12 text-center text-white shadow-2xl sm:px-12 sm:py-16">
                <div class="orb-orange pointer-events-none absolute -left-32 -top-32 h-96 w-96" aria-hidden="true"></div>
                <div class="absolute -bottom-32 -right-20 h-72 w-72 rounded-full bg-primary-500/10 blur-3xl" aria-hidden="true"></div>
                <div class="relative z-10">
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3.5 py-2 text-[10px] font-bold uppercase tracking-[0.18em] text-primary-300">
                        <i class="fa-solid fa-heart" aria-hidden="true"></i>
                        Rayakan bersama kami
                    </span>
                    <h2 class="mx-auto mt-5 max-w-2xl font-heading text-3xl font-bold sm:text-4xl">Mari ciptakan momen yang layak dikenang.</h2>
                    <p class="mx-auto mt-4 max-w-xl text-sm leading-7 text-neutral-300 sm:text-base">Mulai dari satu cerita, lalu biarkan teknologi membantu Anda membagikannya dengan indah.</p>
                    <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                        <a href="{{ route('register') }}"
                            class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-primary-500 px-7 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary-500/25 transition hover:-translate-y-0.5 hover:bg-primary-600 focus:outline-none focus-visible:ring-4 focus-visible:ring-primary-400/30 motion-reduce:transform-none">
                            Mulai buat undangan
                            <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                        </a>
                        <a href="{{ route('themes.index') }}"
                            class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-white/20 bg-white/5 px-7 py-3.5 text-sm font-bold text-white transition hover:-translate-y-0.5 hover:bg-white/10 focus:outline-none focus-visible:ring-4 focus-visible:ring-white/20 motion-reduce:transform-none">
                            <i class="fa-regular fa-images" aria-hidden="true"></i>
                            Lihat koleksi tema
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <x-public-footer />
</body>

</html>
