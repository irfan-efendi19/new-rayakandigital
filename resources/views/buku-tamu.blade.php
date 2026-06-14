<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buku Tamu Digital - Rayakan Digital</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('dark-mode') === 'true' || (!('dark-mode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="font-sans antialiased bg-neutral-50 dark:bg-secondary-900 text-secondary-800 dark:text-neutral-200">
    <x-public-navbar />
    <div class="h-16"></div>

    <!-- ───────────────── HERO ───────────────── -->
    <section
        class="relative overflow-hidden bg-gradient-to-br from-white via-primary-50/30 to-secondary-50 dark:from-secondary-900 dark:via-secondary-900 dark:to-secondary-900 min-h-[92vh] flex items-center">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-20 -right-20 w-72 h-72 bg-primary-200/20 rounded-full blur-3xl dark:bg-primary-900/20">
            </div>
            <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-secondary-200/20 rounded-full blur-3xl dark:bg-secondary-800/20">
            </div>
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-primary-100/10 rounded-full blur-3xl dark:bg-primary-900/10">
            </div>
        </div>
        <div class="relative max-w-6xl mx-auto px-6 py-20 grid md:grid-cols-2 gap-16 items-center">

            <!-- Left -->
            <div class="reveal">
                <span
                    class="inline-flex items-center gap-2 bg-primary-100 border border-primary-200 text-primary-700 text-xs font-semibold px-3 py-1.5 rounded-full mb-6 tracking-wide uppercase">
                    <i class="fa-regular fa-star text-primary-500 text-[10px]"></i>
                    Premium Event Solution
                </span>
                <h1
                    class="text-5xl md:text-6xl font-heading font-extrabold leading-tight text-secondary-900 dark:text-neutral-100 mb-6">
                    Check-in Tamu,<br />
                    <span class="text-primary-500">Lebih Berkelas.</span>
                </h1>
                <p class="text-neutral-500 text-lg leading-relaxed mb-10 max-w-md">
                    Gantikan buku tamu kertas tradisional dengan sistem registrasi digital yang cepat, aman, dan
                    terintegrasi otomatis dengan WhatsApp.
                </p>
                <!-- <div class="flex flex-wrap gap-4">
                    <a href="#"
                        class="bg-primary-500 hover:bg-primary-600 text-white font-bold px-7 py-3.5 rounded-full inline-flex items-center gap-2 shadow-soft transition-all hover:shadow-xl">
                        Coba Gratis Sekarang <i class="fa-solid fa-arrow-right text-sm"></i>
                    </a>
                    <a href="#"
                        class="border-2 border-neutral-300 hover:border-primary-500 text-secondary-700 dark:text-neutral-200 hover:text-primary-500 font-semibold px-7 py-3.5 rounded-full transition-all">
                        Lihat Demo
                    </a>
                </div> -->
            </div>

            <!-- Right – device mockup -->
            <div class="relative reveal" style="transition-delay:.15s">
                <div class="relative rounded-3xl overflow-hidden shadow-soft border border-primary-100">
                    <div
                        class="bg-gradient-to-br from-amber-50 to-primary-50 dark:from-secondary-800 dark:to-secondary-800 aspect-[4/3] flex items-center justify-center">
                        <div class="bg-white dark:bg-secondary-800 rounded-2xl p-6 shadow-soft w-56 text-center mx-auto">
                            <div class="text-3xl font-mono font-bold text-secondary-800 dark:text-neutral-200 tracking-widest mb-3">
                                09822106</div>
                            <div class="h-24 w-24 mx-auto mb-3 bg-secondary-900 rounded-xl flex items-center justify-center">
                                <div class="grid grid-cols-3 gap-1 p-2">
                                    <div class="bg-white dark:bg-secondary-800 w-4 h-4 rounded-sm"></div>
                                    <div class="bg-secondary-900 w-4 h-4 rounded-sm"></div>
                                    <div class="bg-white dark:bg-secondary-800 w-4 h-4 rounded-sm"></div>
                                    <div class="bg-secondary-900 w-4 h-4 rounded-sm"></div>
                                    <div class="bg-white dark:bg-secondary-800 w-4 h-4 rounded-sm"></div>
                                    <div class="bg-secondary-900 w-4 h-4 rounded-sm"></div>
                                    <div class="bg-white dark:bg-secondary-800 w-4 h-4 rounded-sm"></div>
                                    <div class="bg-secondary-900 w-4 h-4 rounded-sm"></div>
                                    <div class="bg-white dark:bg-secondary-800 w-4 h-4 rounded-sm"></div>
                                </div>
                            </div>
                            <p class="text-xs text-neutral-400">Tunjukkan kode ini saat check-in</p>
                        </div>
                    </div>
                </div>

                <div
                    class="absolute -bottom-4 left-1/2 -translate-x-1/2 bg-white dark:bg-secondary-800 rounded-2xl shadow-soft px-5 py-3 flex items-center gap-3 border border-primary-100 whitespace-nowrap">
                    <div class="w-9 h-9 rounded-full bg-primary-500 flex items-center justify-center text-white text-sm">
                        <i class="fa-solid fa-qrcode"></i>
                    </div>
                    <div>
                        <p class="font-bold text-secondary-900 dark:text-neutral-100 text-sm">Scan &amp; Check-in</p>
                        <p class="text-xs text-neutral-400">Kurang dari 3 detik per tamu</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ───────────────── FITUR ───────────────── -->
    <section id="fitur" class="bg-white dark:bg-secondary-800 py-24">
        <div class="max-w-6xl mx-auto px-6">

            <div class="text-center mb-16 reveal">
                <h2 class="text-4xl font-heading font-bold text-secondary-900 dark:text-neutral-100 mb-4">Fitur Cerdas
                    untuk Acara Anda</h2>
                <p class="text-neutral-500 max-w-xl mx-auto leading-relaxed">Kami menyediakan ekosistem lengkap untuk
                    mempermudah manajemen tamu dari tahap undangan hingga hari H.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-6 mb-6">

                <div
                    class="bg-white dark:bg-secondary-800 rounded-3xl p-8 shadow-soft border border-neutral-100 dark:border-secondary-700 reveal transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <h3 class="text-2xl font-heading font-bold text-secondary-900 dark:text-neutral-100 mb-3">Manajemen
                        RSVP Real-time</h3>
                    <p class="text-neutral-500 mb-5 leading-relaxed">Pantau kehadiran tamu secara langsung melalui
                        dashboard interaktif. Dapatkan laporan instan siapa yang sudah hadir, belum hadir, atau
                        terkonfirmasi berhalangan.</p>
                    <ul class="space-y-2 mb-6 text-sm text-secondary-700 dark:text-neutral-200 font-medium">
                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-primary-500"></i>
                            Sinkronisasi data otomatis</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-primary-500"></i>
                            Filter kategori tamu (VIP/Reguler)</li>
                    </ul>
                    <div
                        class="rounded-2xl overflow-hidden bg-neutral-50 h-28 flex items-end gap-2 px-4 pb-3 border border-neutral-100 dark:border-secondary-700">
                        <div class="flex-1 bg-primary-500/20 rounded-t-md h-12"></div>
                        <div class="flex-1 bg-primary-500 rounded-t-md h-20"></div>
                        <div class="flex-1 bg-primary-500/20 rounded-t-md h-10"></div>
                        <div class="flex-1 bg-primary-500 rounded-t-md h-16"></div>
                        <div class="flex-1 bg-primary-500/20 rounded-t-md h-8"></div>
                        <div class="flex-1 bg-primary-500 rounded-t-md h-24"></div>
                    </div>
                </div>

                <div class="bg-primary-500 rounded-3xl p-8 text-white reveal transition-all duration-300 hover:shadow-xl hover:-translate-y-1"
                    style="transition-delay:.1s">
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fa-brands fa-whatsapp text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-heading font-bold mb-3">Integrasi WhatsApp</h3>
                    <p class="text-primary-100 leading-relaxed">Kirim undangan digital dan pengingat RSVP langsung ke
                        nomor WhatsApp tamu Anda tanpa simpan kontak.</p>
                    <div class="mt-8 flex gap-2">
                        <div class="bg-white/20 rounded-full px-3 py-1 text-xs font-semibold">Auto-send</div>
                        <div class="bg-white/20 rounded-full px-3 py-1 text-xs font-semibold">Bulk Message</div>
                        <div class="bg-white/20 rounded-full px-3 py-1 text-xs font-semibold">Tanpa Simpan Kontak</div>
                    </div>
                </div>

            </div>

            <div class="grid md:grid-cols-2 gap-6">

                <div
                    class="bg-white dark:bg-secondary-800 rounded-3xl p-8 shadow-soft border border-neutral-100 dark:border-secondary-700 reveal transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="w-12 h-12 bg-primary-50 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fa-solid fa-shield-halved text-primary-500 text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-heading font-bold text-secondary-900 dark:text-neutral-100 mb-3">Data
                        Terenkripsi</h3>
                    <p class="text-neutral-500 leading-relaxed">Keamanan data tamu adalah prioritas kami. Semua
                        informasi
                        dienkripsi dengan standar industri terbaru.</p>
                </div>

                <div class="bg-white dark:bg-secondary-800 rounded-3xl p-8 shadow-soft border border-neutral-100 dark:border-secondary-700 reveal transition-all duration-300 hover:shadow-xl hover:-translate-y-1"
                    style="transition-delay:.1s">
                    <div class="mb-4 rounded-2xl overflow-hidden bg-secondary-800 h-28 flex items-center justify-center">
                        <div class="grid grid-cols-5 gap-1 p-3 opacity-80">
                            <div class="bg-white dark:bg-secondary-800 w-3 h-3 rounded-sm"></div>
                            <div class="bg-secondary-700 w-3 h-3 rounded-sm"></div>
                            <div class="bg-white dark:bg-secondary-800 w-3 h-3 rounded-sm"></div>
                            <div class="bg-secondary-700 w-3 h-3 rounded-sm"></div>
                            <div class="bg-white dark:bg-secondary-800 w-3 h-3 rounded-sm"></div>
                            <div class="bg-secondary-700 w-3 h-3 rounded-sm"></div>
                            <div class="bg-white dark:bg-secondary-800 w-3 h-3 rounded-sm"></div>
                            <div class="bg-secondary-700 w-3 h-3 rounded-sm"></div>
                            <div class="bg-white dark:bg-secondary-800 w-3 h-3 rounded-sm"></div>
                            <div class="bg-secondary-700 w-3 h-3 rounded-sm"></div>
                            <div class="bg-white dark:bg-secondary-800 w-3 h-3 rounded-sm"></div>
                            <div class="bg-secondary-700 w-3 h-3 rounded-sm"></div>
                            <div class="bg-white dark:bg-secondary-800 w-3 h-3 rounded-sm"></div>
                            <div class="bg-secondary-700 w-3 h-3 rounded-sm"></div>
                            <div class="bg-white dark:bg-secondary-800 w-3 h-3 rounded-sm"></div>
                        </div>
                    </div>
                    <h3 class="text-2xl font-heading font-bold text-secondary-900 dark:text-neutral-100 mb-2">Quick QR
                        Check-in</h3>
                    <p class="text-neutral-500 leading-relaxed text-sm">Lupakan antrean panjang. Tamu hanya perlu
                        menunjukkan kode QR unik di ponsel mereka untuk registrasi instan di lokasi acara.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ───────────────── WHATSAPP AUTOMATION ───────────────── -->
    <section id="whatsapp" class="py-24 bg-neutral-50">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-center">

            <div class="reveal">
                <div class="relative max-w-xs mx-auto">
                    <div class="bg-secondary-900 rounded-[3rem] p-3 shadow-2xl">
                        <div class="bg-secondary-800 rounded-[2.5rem] overflow-hidden aspect-[9/18]">
                            <div class="bg-[#075e54] p-3 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary-500 flex items-center justify-center text-white text-xs font-bold">
                                    R</div>
                                <div>
                                    <p class="text-white text-xs font-bold">Rayakan Events</p>
                                    <p class="text-green-300 text-xs">Online</p>
                                </div>
                            </div>
                            <div class="bg-[#ece5dd] p-3 space-y-3 h-full">
                                <div class="bg-white dark:bg-secondary-800 rounded-2xl rounded-tl-none p-3 max-w-[80%] shadow-sm">
                                    <p class="text-xs text-secondary-800 dark:text-neutral-200">Halo Budi! 👋 Anda
                                        terdaftar sebagai tamu VIP di
                                        pernikahan <strong>Sari & Andi</strong>.</p>
                                    <p class="text-[10px] text-neutral-400 mt-1 text-right">09:01 ✓✓</p>
                                </div>
                                <div class="bg-white dark:bg-secondary-800 rounded-2xl rounded-tl-none p-3 max-w-[80%] shadow-sm">
                                    <div class="bg-secondary-800 rounded-xl p-2 mb-2 text-center">
                                        <p class="text-white text-xs mb-1">Kode QR Anda</p>
                                        <div class="grid grid-cols-3 gap-0.5 w-10 mx-auto">
                                            <div class="bg-white dark:bg-secondary-800 w-2 h-2"></div>
                                            <div class="bg-secondary-900 w-2 h-2"></div>
                                            <div class="bg-white dark:bg-secondary-800 w-2 h-2"></div>
                                            <div class="bg-secondary-900 w-2 h-2"></div>
                                            <div class="bg-white dark:bg-secondary-800 w-2 h-2"></div>
                                            <div class="bg-secondary-900 w-2 h-2"></div>
                                        </div>
                                    </div>
                                    <p class="text-[10px] text-neutral-500">Tunjukkan QR ini saat tiba di venue ✨</p>
                                    <p class="text-[10px] text-neutral-400 mt-1 text-right">09:02 ✓✓</p>
                                </div>
                                <div class="ml-auto bg-[#dcf8c6] rounded-2xl rounded-tr-none p-3 max-w-[75%] shadow-sm">
                                    <p class="text-xs text-secondary-800 dark:text-neutral-200">Terima kasih! Siap hadir
                                        🎉</p>
                                    <p class="text-[10px] text-neutral-400 mt-1 text-right">09:05 ✓✓</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute inset-0 -z-10 bg-primary-500/10 blur-3xl rounded-full scale-110"></div>
                </div>
            </div>

            <div class="reveal" style="transition-delay:.1s">
                <h2 class="text-4xl font-heading font-bold text-secondary-900 dark:text-neutral-100 mb-8">Otomasi
                    WhatsApp yang Personal</h2>
                <div class="space-y-6">
                    <div class="flex gap-5 items-start">
                        <div
                            class="w-10 h-10 rounded-full bg-primary-500 text-white flex items-center justify-center font-bold text-sm shrink-0 shadow-soft">
                            1</div>
                        <div>
                            <h4 class="font-bold text-secondary-900 dark:text-neutral-100 mb-1">Kirim Undangan Masal
                            </h4>
                            <p class="text-neutral-500 text-sm leading-relaxed">Kirim ribuan pesan undangan personal
                                hanya
                                dengan satu klik.</p>
                        </div>
                    </div>
                    <div class="flex gap-5 items-start">
                        <div
                            class="w-10 h-10 rounded-full bg-primary-500 text-white flex items-center justify-center font-bold text-sm shrink-0 shadow-soft">
                            2</div>
                        <div>
                            <h4 class="font-bold text-secondary-900 dark:text-neutral-100 mb-1">Blast Notifikasi
                                Pengingat</h4>
                            <p class="text-neutral-500 text-sm leading-relaxed">Ingatkan tamu untuk melakukan RSVP atau
                                informasi lokasi acara secara otomatis.</p>
                        </div>
                    </div>
                    <div class="flex gap-5 items-start">
                        <div
                            class="w-10 h-10 rounded-full bg-primary-500 text-white flex items-center justify-center font-bold text-sm shrink-0 shadow-soft">
                            3</div>
                        <div>
                            <h4 class="font-bold text-secondary-900 dark:text-neutral-100 mb-1">Ucapan Terima Kasih
                                Instan</h4>
                            <p class="text-neutral-500 text-sm leading-relaxed">Pesan otomatis terkirim segera setelah
                                tamu
                                melakukan check-in di lokasi.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ───────────────── CTA ───────────────── -->
    <section id="harga" class="bg-gradient-to-br from-primary-600 to-primary-800 py-20">
        <div class="max-w-2xl mx-auto px-6 text-center reveal">
            <h2 class="text-4xl font-heading font-bold text-white mb-4">Siap Memodernisasi Acara Anda?</h2>
            <p class="text-primary-100 mb-10 leading-relaxed">Bergabunglah dengan ribuan penyelenggara acara yang telah
                beralih ke Buku Tamu Digital Rayakan.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="https://wa.me/62895349823366?text=Halo%20Rayakan%20Digital!%20Saya%20tertarik%20untuk%20konsultasi%20gratis%20tentang%20Buku%20Tamu%20Digital."
                    class="bg-white dark:bg-secondary-800 text-primary-500 font-bold px-8 py-3.5 rounded-full hover:bg-primary-50 transition-colors shadow-soft">
                    Konsultasi Gratis
                </a>
                <!-- <a href="#"
                    class="border-2 border-white text-white font-bold px-8 py-3.5 rounded-full hover:bg-white/10 transition-colors">
                    Lihat Daftar Harga
                </a> -->
            </div>
        </div>
    </section>
    <x-public-footer />
</body>

</html>