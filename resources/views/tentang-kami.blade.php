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

<body class="font-sans antialiased bg-neutral-50 dark:bg-secondary-900 text-secondary-800 dark:text-neutral-200">
    <x-public-navbar />
    <div class="h-16"></div>
    <div class="h-16"></div>

    <!-- ═══════════════════════════ HERO ═══════════════════════════ -->
    <section data-aos="fade-up"
        class="relative overflow-hidden bg-gradient-to-br from-white via-primary-50/30 to-secondary-50 dark:from-secondary-900 dark:via-secondary-900 dark:to-secondary-900 px-6 pt-20 pb-16 text-center">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute inset-0 bg-gradient-to-tr from-primary-500/[0.03] to-transparent"></div>
            <div class="absolute inset-0"
                style="background-image: radial-gradient(circle, #94a3b8 1px, transparent 1px); background-size: 32px 32px; opacity: 0.12;">
            </div>
        </div>
        <div class="relative max-w-2xl mx-auto">
            <span
                class="inline-flex items-center gap-2 bg-primary-100 dark:bg-primary-900/50 border border-primary-200 dark:border-primary-800 text-primary-700 dark:text-primary-300 text-xs font-semibold px-3 py-1.5 rounded-full mb-4">
                <i class="fa-regular fa-star text-primary-500 dark:text-primary-400 text-[10px]"></i>
                Our Origin Story
            </span>

            <h1 class="font-heading text-5xl md:text-6xl font-bold leading-tight text-secondary-800 dark:text-neutral-200 mb-3">
                Menciptakan Kenangan<br>Digital yang
            </h1>
            <h1 class="font-heading text-5xl md:text-6xl italic text-primary-500 dark:text-primary-400 mb-6">
                Abadi &amp; Bermakna
            </h1>

            <p class="text-neutral-500 text-base leading-relaxed max-w-lg mx-auto mb-10">
                Berawal dari sebuah visi untuk menyatukan tradisi dan teknologi, kami menghadirkan Rayakan Digital
                sebagai jembatan untuk merayakan setiap momen berharga Anda dengan cara yang lebih personal, indah, dan
                berkelanjutan.
            </p>

            <!-- <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <button class="bg-secondary-800 text-white font-semibold px-7 py-3.5 rounded-full hover:bg-secondary-900 transition text-sm">
                    Pelajari Layanan
                </button>
                <button class="border border-neutral-300 dark:border-secondary-600 text-secondary-800 dark:text-neutral-200 font-semibold px-7 py-3.5 rounded-full hover:border-primary-500 dark:hover:border-primary-400 hover:text-primary-500 dark:hover:text-primary-400 transition text-sm">
                    Hubungi Kami
                </button>
            </div> -->
        </div>
    </section>

    <!-- ═══════════════════════════ HERO IMAGE ═══════════════════════════ -->
    <section data-aos="fade-up" class="px-6 pb-20">
        <div class="max-w-4xl mx-auto relative">
            <div
                class="rounded-2xl overflow-hidden aspect-[16/7] relative bg-gradient-to-br from-neutral-100 to-neutral-200 dark:from-secondary-800 dark:to-secondary-800">
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-center text-neutral-500 dark:text-neutral-400">
                    </div>
                    <img class="w-full h-full object-cover"
                        src="https://asset.kompas.com/crops/i1x4qrVakfjJCRGtuBr7zKlPhkE=/49x0:892x562/1200x800/data/photo/2024/01/05/65977a9919349.jpg"
                        alt="Tim Rayakan Digital" />
                </div>
            </div>

            <!-- Flower accents -->
            <div class="absolute top-4 left-8 w-16 h-16 rounded-full bg-amber-400/40 blur-xl"></div>
            <div class="absolute top-4 right-8 w-16 h-16 rounded-full bg-primary-300/40 blur-xl"></div>
            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-32 h-32 rounded-full bg-primary-600/30 blur-2xl">
            </div>

            <!-- Cursive overlay -->

            <!-- Badge -->
            <div
                class="absolute bottom-5 right-5 flex items-center gap-2.5 bg-white dark:bg-secondary-800 px-4 py-2.5 rounded-2xl shadow-soft">
                <div class="w-8 h-8 bg-primary-500/10 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-star text-primary-500 text-xs"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-secondary-800 dark:text-neutral-200">Kualitas Premium</p>
                    <p class="text-[10px] text-neutral-500">Desain Sinematik Modern</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════ VISI & MISI ═══════════════════════════ -->
    <section data-aos="fade-up" class="px-6 py-16 bg-white dark:bg-secondary-800">
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-6">

            <!-- Visi -->
            <div
                class="bg-neutral-50 dark:bg-secondary-700 rounded-2xl p-8 border border-neutral-100 dark:border-secondary-600 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div
                    class="w-12 h-12 bg-primary-100 dark:bg-primary-900/50 rounded-xl flex items-center justify-center mb-5 text-primary-600 dark:text-primary-400">
                    <i class="fa-regular fa-eye"></i>
                </div>
                <h3 class="font-heading text-2xl font-bold mb-3 text-secondary-800 dark:text-neutral-200">Visi Kami</h3>
                <p class="text-neutral-500 text-sm leading-relaxed mb-5">
                    Menjadi partner utama dalam merayakan momen berharga melalui inovasi digital yang melampaui batas
                    jarak dan waktu, menciptakan kenangan yang abadi bagi setiap pasangan di seluruh penjuru negeri.
                </p>
                <a href="#" class="text-primary-500 font-semibold text-sm hover:underline inline-flex items-center gap-1">
                    Membangun Masa Depan Perayaan <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            <!-- Misi -->
            <div
                class="bg-neutral-50 dark:bg-secondary-700 rounded-2xl p-8 border border-neutral-100 dark:border-secondary-600 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div
                    class="w-12 h-12 bg-primary-100 dark:bg-primary-900/50 rounded-xl flex items-center justify-center mb-5 text-primary-600 dark:text-primary-400">
                    <i class="fa-solid fa-rocket"></i>
                </div>
                <h3 class="font-heading text-2xl font-bold mb-5 text-secondary-800 dark:text-neutral-200">Misi Kami</h3>
                <ul class="space-y-4">
                    <li class="flex gap-3">
                        <div class="w-2 h-2 rounded-full bg-primary-500 mt-2 shrink-0"></div>
                        <p class="text-neutral-500 text-sm leading-relaxed">Menyediakan layanan undangan digital yang
                            praktis, ekonomis, dan kekinian.</p>
                    </li>
                    <li class="flex gap-3">
                        <div class="w-2 h-2 rounded-full bg-primary-500 mt-2 shrink-0"></div>
                        <p class="text-neutral-500 text-sm leading-relaxed">Mengintegrasikan fitur buku tamu dan live
                            streaming berkualitas tinggi.</p>
                    </li>
                    <li class="flex gap-3">
                        <div class="w-2 h-2 rounded-full bg-primary-500 mt-2 shrink-0"></div>
                        <p class="text-neutral-500 text-sm leading-relaxed">Menjamin keamanan data dan kemudahan akses
                            bagi setiap tamu undangan.</p>
                    </li>
                </ul>
            </div>

        </div>
    </section>

    <!-- ═══════════════════════════ NILAI-NILAI ═══════════════════════════ -->
    <section data-aos="fade-up" class="px-6 py-20">
        <div class="max-w-5xl mx-auto">
            <div data-aos="fade-up" class="text-center mb-12">
                <h2 class="font-heading text-4xl font-bold text-secondary-800 dark:text-neutral-200 mb-3">Nilai-Nilai
                    Kami</h2>
                <p class="text-neutral-500 text-sm max-w-sm mx-auto">Filosofi yang mendasari setiap pixel dan baris kode
                    yang kami ciptakan untuk Anda.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">

                <div data-aos="fade-up" data-aos-delay="100"
                    class="bg-white dark:bg-secondary-800 rounded-2xl p-7 border border-neutral-100 dark:border-secondary-700 shadow-soft transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center mb-4 text-primary-600">
                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                    </div>
                    <h4 class="font-heading font-bold text-lg mb-2 text-secondary-800 dark:text-neutral-200">Inovasi
                    </h4>
                    <p class="text-neutral-500 text-sm leading-relaxed">Kami selalu mengeksplorasi teknologi terbaru
                        untuk memberikan pengalaman undangan yang interaktif dan berkesan bagi setiap tamu.</p>
                </div>

                <div data-aos="fade-up" data-aos-delay="200"
                    class="bg-white dark:bg-secondary-800 rounded-2xl p-7 border border-neutral-100 dark:border-secondary-700 shadow-soft transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center mb-4 text-primary-600">
                        <i class="fa-solid fa-film"></i>
                    </div>
                    <h4 class="font-heading font-bold text-lg mb-2 text-secondary-800 dark:text-neutral-200">Kualitas
                        Sinematik</h4>
                    <p class="text-neutral-500 text-sm leading-relaxed">Setiap visual dikurasi dengan presisi tinggi
                        untuk memberikan kesan mewah dan profesional layaknya karya film layar lebar.</p>
                </div>

                <div data-aos="fade-up" data-aos-delay="300"
                    class="bg-white dark:bg-secondary-800 rounded-2xl p-7 border border-neutral-100 dark:border-secondary-700 shadow-soft transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center mb-4 text-primary-600">
                        <i class="fa-regular fa-heart"></i>
                    </div>
                    <h4 class="font-heading font-bold text-lg mb-2 text-secondary-800 dark:text-neutral-200">Kepuasan
                        Pelanggan</h4>
                    <p class="text-neutral-500 text-sm leading-relaxed">Tim support kami adalah sahabat Anda dalam
                        perjalanan persiapan momen berharga, siap mendampingi hingga hari bahagia tiba.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ═══════════════════════════ PERJALANAN ═══════════════════════════ -->
    <section data-aos="fade-up" class="px-6 py-20 bg-white dark:bg-secondary-800">
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-12 items-center">

            <!-- Images column -->
            <div class="relative h-80 md:h-auto">
                <div
                    class="absolute left-0 top-0 w-[48%] h-full rounded-2xl overflow-hidden bg-gradient-to-br from-neutral-100 to-neutral-200 dark:from-secondary-800 dark:to-secondary-800">
                    <div class="w-full h-full flex items-end p-4">
                        <div class="bg-white/90 rounded-xl p-3 w-full">
                            <i class="fa-solid fa-quote-left text-primary-500 text-xs mb-1"></i>
                            <p class="text-xs text-secondary-700 dark:text-secondary-900 font-medium leading-snug">
                                "Momen
                                yang tepat diabadikan
                                dengan undangan yang sempurna."</p>
                        </div>
                    </div>
                </div>
                <div class="absolute right-0 top-6 w-[48%] h-[80%] rounded-2xl overflow-hidden"
                    style="background:linear-gradient(135deg,#b07d5a 0%,#7a4f30 100%);">
                    <div class="w-full h-full flex items-center justify-center">
                        <img class="w-full h-full object-cover"
                            src="https://asset.kompas.com/crops/i1x4qrVakfjJCRGtuBr7zKlPhkE=/49x0:892x562/1200x800/data/photo/2024/01/05/65977a9919349.jpg"
                            alt="Tim Rayakan Digital" />
                    </div>
                </div>
                <div
                    class="absolute -bottom-4 left-[46%] -translate-x-1/2 w-12 h-12 bg-primary-500 rounded-2xl flex items-center justify-center shadow-lg z-10">
                    <i class="fa-solid fa-heart text-white text-sm"></i>
                </div>
            </div>

            <!-- Text column -->
            <div>
                <span
                    class="inline-flex items-center gap-2 bg-primary-100 dark:bg-primary-900/50 border border-primary-200 dark:border-primary-800 text-primary-700 dark:text-primary-300 text-xs font-semibold px-3 py-1.5 rounded-full mb-3">
                    <i class="fa-regular fa-star text-primary-500 dark:text-primary-400 text-[10px]"></i>
                    Perjalanan Kami
                </span>
                <h2 class="font-heading text-4xl font-bold text-secondary-800 dark:text-neutral-200 leading-tight mb-2">
                    Perjalanan Kami<br>Membantu
                </h2>
                <h2 class="font-heading text-4xl italic text-primary-500 dark:text-primary-400 mb-6">Ribuan Pasangan
                </h2>

                <p class="text-neutral-500 text-sm leading-relaxed mb-4">
                    Sejak 2025, Rayakan Digital telah bertumbuh dari sebuah proyek kecil menjadi salah satu platform
                    undangan digital terdepan di Indonesia. Kami memahami bahwa setiap perayaan memiliki cerita uniknya
                    sendiri yang layak diceritakan dengan indah.
                </p>
                <p class="text-neutral-500 text-sm leading-relaxed mb-8">
                    Kami telah membantu pasangan untuk mengabadikan kebahagiaan mereka dengan cara yang
                    lebih elegan, ramah lingkungan, dan tentu saja, efisien. Perjalanan kami masih panjang, dan kami
                    ingin terus menjadi bagian dari setiap momen bersejarah dalam hidup Anda.
                </p>

                <!-- <div class="flex gap-10">
                    <div>
                        <p class="text-3xl font-heading font-bold text-secondary-800 dark:text-neutral-200">5k+</p>
                        <p class="text-xs text-neutral-400 font-semibold uppercase tracking-widest mt-1">Klien Puas</p>
                    </div>
                    <div class="w-px bg-neutral-200 dark:bg-secondary-600"></div>
                    <div>
                        <p class="text-3xl font-heading font-bold text-secondary-800 dark:text-neutral-200">200k+</p>
                        <p class="text-xs text-neutral-400 font-semibold uppercase tracking-widest mt-1">Tamu Terundang
                        </p>
                    </div>
                </div> -->
            </div>

        </div>
    </section>

    <!-- ═══════════════════════════ CTA ═══════════════════════════ -->
    <section data-aos="fade-up" class="px-6 py-20 bg-gradient-to-br from-primary-600 to-primary-800">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="font-heading text-4xl md:text-5xl font-bold text-white leading-tight mb-5">
                Siap Mengabadikan Momen <span class="italic">Bahagia</span> Anda?
            </h2>
            <p class="text-white/80 text-sm leading-relaxed max-w-lg mx-auto mb-10">
                Bergabunglah dengan ribuan pasangan lainnya yang telah berani ke cara modern merayakan cinta. Wujudkan
                undangan impian Anda yang paling berkesan hari ini.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('register') }}"
                    class="bg-secondary-800 text-white font-semibold px-8 py-3.5 rounded-full hover:bg-secondary-900 transition text-sm">
                    <i class="fa-solid fa-paper-plane mr-2"></i>Mulai Buat Undangan
                </a>
                <a href="{{ route('themes.index') }}"
                    class="border-2 border-white/60 text-white font-semibold px-8 py-3.5 rounded-full hover:bg-white/10 transition text-sm">
                    <i class="fa-solid fa-grid-2 mr-2"></i>Lihat Katalog Desain
                </a>
            </div>
        </div>
    </section>
    <x-public-footer />
</body>

</html>