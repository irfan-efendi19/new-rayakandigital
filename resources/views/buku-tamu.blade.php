<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <x-meta title="Buku Tamu Digital - Rayakan Digital"
        description="Kelola RSVP, undangan WhatsApp, dan check-in QR tamu pernikahan dalam satu sistem yang praktis dan rapi."
        keywords="buku tamu digital, buku tamu pernikahan, QR code check-in, registrasi tamu digital, manajemen RSVP" />

    @stack('meta')

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

<body class="bg-neutral-50 font-sans text-secondary-800 antialiased dark:bg-secondary-900 dark:text-neutral-200">
    <x-public-navbar />

    <main class="overflow-x-hidden">
        <section class="relative isolate overflow-hidden bg-secondary-900 pt-28 text-white sm:pt-32">
            <div class="absolute inset-0 -z-20 bg-gradient-to-br from-secondary-900 via-secondary-900 to-primary-900/60"></div>
            <div class="absolute -left-28 top-20 -z-10 h-72 w-72 rounded-full bg-primary-500/20 blur-3xl"></div>
            <div class="absolute -right-20 bottom-0 -z-10 h-96 w-96 rounded-full bg-primary-600/20 blur-3xl"></div>
            <div class="absolute inset-0 -z-10 opacity-[0.08]"
                style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 30px 30px;"></div>

            <div class="mx-auto grid max-w-7xl items-center gap-14 px-6 pb-20 lg:grid-cols-[0.92fr_1.08fr] lg:px-8 lg:pb-28">
                <div>
                    <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-primary-200 backdrop-blur">
                        <span class="h-2 w-2 rounded-full bg-primary-400"></span>
                        Buku tamu pernikahan digital
                    </div>
                    <h1 class="max-w-2xl font-heading text-4xl font-bold leading-[1.08] sm:text-5xl lg:text-6xl">
                        Sambut setiap tamu dengan <span class="text-primary-400">lebih berkesan.</span>
                    </h1>
                    <p class="mt-6 max-w-xl text-base leading-8 text-white/65 sm:text-lg">
                        Dari konfirmasi kehadiran sampai check-in di hari pernikahan, semua data tamu tersusun dalam satu alur yang cepat dan mudah dipantau.
                    </p>
                    <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                        <a href="https://wa.me/62895349823366?text=Halo%20Rayakan%20Digital!%20Saya%20tertarik%20untuk%20konsultasi%20tentang%20Buku%20Tamu%20Digital."
                            class="inline-flex items-center justify-center gap-2 rounded-full bg-primary-500 px-7 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary-500/20 transition hover:-translate-y-0.5 hover:bg-primary-400">
                            Konsultasi sekarang <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                        <a href="#cara-kerja"
                            class="inline-flex items-center justify-center gap-2 rounded-full border border-white/20 bg-white/5 px-7 py-3.5 text-sm font-semibold text-white transition hover:border-white/40 hover:bg-white/10">
                            <i class="fa-regular fa-circle-play"></i> Lihat cara kerja
                        </a>
                    </div>
                    <div class="mt-10 flex flex-wrap gap-x-6 gap-y-3 text-sm text-white/60">
                        <span class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-primary-400"></i> QR check-in</span>
                        <span class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-primary-400"></i> RSVP real-time</span>
                        <span class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-primary-400"></i> WhatsApp terintegrasi</span>
                    </div>
                </div>

                <div class="relative mx-auto w-full max-w-2xl">
                    <div class="absolute -inset-5 rounded-[2.25rem] bg-gradient-to-br from-primary-400/20 to-transparent blur-2xl"></div>
                    <div class="relative overflow-hidden rounded-[1.75rem] border border-white/15 bg-white/[0.08] p-3 shadow-2xl backdrop-blur-xl sm:p-5">
                        <div class="rounded-2xl bg-neutral-50 p-4 text-secondary-800 shadow-inner dark:bg-secondary-800 dark:text-neutral-100 sm:p-5">
                            <div class="flex items-center justify-between gap-4 border-b border-neutral-200 pb-4 dark:border-secondary-700">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-secondary-900 text-primary-400 dark:bg-secondary-700">
                                        <i class="fa-solid fa-user-group"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold">Reception Desk</p>
                                        <p class="text-[11px] text-neutral-500 dark:text-neutral-400">Sari &amp; Andi · Hari ini</p>
                                    </div>
                                </div>
                                <span class="flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-[10px] font-bold text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300">
                                    <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-emerald-500"></span> ONLINE
                                </span>
                            </div>

                            <div class="mt-4 grid grid-cols-[0.88fr_1.12fr] gap-4">
                                <div class="rounded-2xl bg-secondary-900 p-5 text-center text-white dark:bg-secondary-700">
                                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/45">Kode tamu</p>
                                    <p class="mt-2 font-mono text-base font-bold tracking-[0.14em] sm:text-xl sm:tracking-[0.2em]">WD-0812</p>
                                    <div class="mx-auto mt-4 grid h-20 w-20 grid-cols-5 gap-1 rounded-xl bg-white p-2 sm:h-28 sm:w-28 sm:p-3">
                                        @foreach ([1, 0, 1, 1, 1, 0, 1, 0, 0, 1, 1, 1, 1, 0, 1, 1, 0, 0, 1, 0, 1, 1, 1, 0, 1] as $cell)
                                            <span class="rounded-[2px] {{ $cell ? 'bg-secondary-900' : 'bg-white' }}"></span>
                                        @endforeach
                                    </div>
                                    <p class="mt-3 text-[11px] text-white/50">Arahkan kamera ke kode QR</p>
                                </div>

                                <div class="flex flex-col gap-3">
                                    <div class="rounded-2xl border border-neutral-200 bg-white p-4 dark:border-secondary-700 dark:bg-secondary-900">
                                        <div class="flex items-start justify-between gap-3">
                                            <div>
                                                <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-neutral-400">Status tamu</p>
                                                <p class="mt-1 font-bold">Budi Santoso</p>
                                                <p class="mt-1 text-xs text-neutral-500">Keluarga mempelai pria · 2 pax</p>
                                            </div>
                                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-300">
                                                <i class="fa-solid fa-check"></i>
                                            </span>
                                        </div>
                                        <div class="mt-4 flex items-center justify-between rounded-xl bg-emerald-50 px-3 py-2.5 text-xs dark:bg-emerald-950/30">
                                            <span class="font-semibold text-emerald-800 dark:text-emerald-300">Check-in berhasil</span>
                                            <span class="text-emerald-600 dark:text-emerald-400">10:24</span>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="rounded-2xl border border-neutral-200 bg-white p-4 dark:border-secondary-700 dark:bg-secondary-900">
                                            <i class="fa-solid fa-chart-simple text-primary-500"></i>
                                            <p class="mt-3 text-xl font-bold">Real-time</p>
                                            <p class="text-[10px] text-neutral-500">Data kehadiran</p>
                                        </div>
                                        <div class="rounded-2xl border border-neutral-200 bg-white p-4 dark:border-secondary-700 dark:bg-secondary-900">
                                            <i class="fa-brands fa-whatsapp text-emerald-500"></i>
                                            <p class="mt-3 text-xl font-bold">Otomatis</p>
                                            <p class="text-[10px] text-neutral-500">Pesan personal</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -bottom-5 -left-3 hidden items-center gap-3 rounded-2xl border border-white/15 bg-white px-4 py-3 text-secondary-900 shadow-xl sm:flex dark:bg-secondary-800 dark:text-white">
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-primary-100 text-primary-600 dark:bg-primary-900/50 dark:text-primary-300"><i class="fa-solid fa-bolt"></i></span>
                        <div><p class="text-xs font-bold">Antrean lebih ringkas</p><p class="text-[10px] text-neutral-500">Scan, verifikasi, selesai</p></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="border-b border-neutral-200 bg-white dark:border-secondary-700 dark:bg-secondary-800">
            <div class="mx-auto grid max-w-7xl grid-cols-1 divide-y divide-neutral-200 px-6 dark:divide-secondary-700 sm:grid-cols-3 sm:divide-x sm:divide-y-0 lg:px-8">
                @foreach ([['fa-qrcode', 'Check-in praktis', 'Kode unik untuk setiap tamu'], ['fa-rotate', 'Data tersinkron', 'Pantau perubahan saat acara berlangsung'], ['fa-user-shield', 'Tamu lebih teratur', 'Kategori dan status dalam satu tampilan']] as [$icon, $title, $copy])
                    <div class="flex items-center gap-4 py-6 sm:px-6">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary-50 text-primary-600 dark:bg-primary-900/30 dark:text-primary-300"><i class="fa-solid {{ $icon }}"></i></span>
                        <div><p class="text-sm font-bold text-secondary-900 dark:text-white">{{ $title }}</p><p class="mt-1 text-xs leading-5 text-neutral-500 dark:text-neutral-400">{{ $copy }}</p></div>
                    </div>
                @endforeach
            </div>
        </section>

        <section id="cara-kerja" class="bg-neutral-50 py-20 dark:bg-secondary-900 sm:py-28">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div data-aos="fade-up" class="mx-auto max-w-2xl text-center">
                    <p class="text-xs font-bold uppercase tracking-[0.22em] text-primary-600 dark:text-primary-400">Alur sederhana</p>
                    <h2 class="mt-4 font-heading text-3xl font-bold text-secondary-900 dark:text-white sm:text-5xl">Rapi sebelum, saat, dan setelah hari H.</h2>
                    <p class="mt-5 leading-7 text-neutral-500 dark:text-neutral-400">Satu sistem yang membantu tim penerima tamu bekerja lebih percaya diri tanpa tumpukan daftar kertas.</p>
                </div>

                <div class="mt-14 grid gap-5 lg:grid-cols-3">
                    @foreach ([
                        ['01', 'Siapkan daftar tamu', 'Kelompokkan nama, jumlah pax, dan kategori tamu agar proses penerimaan lebih terarah.', 'fa-list-check'],
                        ['02', 'Kirim undangan personal', 'Bagikan informasi acara dan kode QR melalui WhatsApp langsung kepada tamu.', 'fa-paper-plane'],
                        ['03', 'Scan dan pantau', 'Verifikasi tamu di lokasi lalu lihat pembaruan kehadiran pada dashboard.', 'fa-mobile-screen-button']
                    ] as $index => [$number, $title, $copy, $icon])
                        <article data-aos="fade-up" data-aos-delay="{{ $index * 100 }}" class="group rounded-3xl border border-neutral-200 bg-white p-7 transition duration-300 hover:-translate-y-1 hover:border-primary-200 hover:shadow-xl dark:border-secondary-700 dark:bg-secondary-800 dark:hover:border-primary-700">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold tracking-[0.2em] text-neutral-400">STEP {{ $number }}</span>
                                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-secondary-900 text-primary-400 dark:bg-secondary-700"><i class="fa-solid {{ $icon }}"></i></span>
                            </div>
                            <h3 class="mt-8 text-xl font-bold text-secondary-900 dark:text-white">{{ $title }}</h3>
                            <p class="mt-3 text-sm leading-7 text-neutral-500 dark:text-neutral-400">{{ $copy }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="fitur" class="bg-white py-20 dark:bg-secondary-800 sm:py-28">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div data-aos="fade-up" class="flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
                    <div class="max-w-2xl">
                        <p class="text-xs font-bold uppercase tracking-[0.22em] text-primary-600 dark:text-primary-400">Fitur utama</p>
                        <h2 class="mt-4 font-heading text-3xl font-bold text-secondary-900 dark:text-white sm:text-5xl">Lebih dari sekadar buku kehadiran.</h2>
                    </div>
                    <p class="max-w-md text-sm leading-7 text-neutral-500 dark:text-neutral-400">Setiap fitur dirancang untuk mengurangi pekerjaan manual dan menjaga pengalaman tamu tetap hangat.</p>
                </div>

                <div class="mt-14 grid gap-5 lg:grid-cols-12">
                    <article data-aos="fade-up" class="relative overflow-hidden rounded-3xl bg-secondary-900 p-8 text-white lg:col-span-7 lg:p-10">
                        <div class="absolute right-0 top-0 h-64 w-64 rounded-full bg-primary-500/20 blur-3xl"></div>
                        <div class="relative max-w-lg">
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-500 text-white"><i class="fa-solid fa-gauge-high"></i></span>
                            <h3 class="mt-8 font-heading text-3xl font-bold">Dashboard RSVP real-time</h3>
                            <p class="mt-4 leading-7 text-white/60">Lihat tamu yang mengonfirmasi, hadir, atau berhalangan tanpa menyusun ulang data secara manual.</p>
                            <div class="mt-8 grid grid-cols-3 gap-3">
                                @foreach ([['Konfirmasi', 'bg-primary-400'], ['Hadir', 'bg-emerald-400'], ['Berhalangan', 'bg-neutral-400']] as [$label, $color])
                                    <div class="rounded-2xl border border-white/10 bg-white/5 p-3 sm:p-4"><span class="block h-1.5 w-full rounded-full {{ $color }}"></span><p class="mt-3 text-[10px] text-white/55 sm:text-xs">{{ $label }}</p></div>
                                @endforeach
                            </div>
                        </div>
                    </article>

                    <article data-aos="fade-up" data-aos-delay="100" class="rounded-3xl bg-primary-500 p-8 text-white lg:col-span-5 lg:p-10">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20"><i class="fa-brands fa-whatsapp text-xl"></i></span>
                        <h3 class="mt-8 font-heading text-3xl font-bold">WhatsApp yang terasa personal</h3>
                        <p class="mt-4 leading-7 text-white/80">Kirim undangan, pengingat RSVP, dan ucapan terima kasih melalui alur pesan yang lebih teratur.</p>
                        <div class="mt-8 flex flex-wrap gap-2 text-xs font-semibold">
                            <span class="rounded-full bg-white/15 px-3 py-2">Undangan personal</span><span class="rounded-full bg-white/15 px-3 py-2">Pengingat</span><span class="rounded-full bg-white/15 px-3 py-2">Follow-up</span>
                        </div>
                    </article>

                    <article data-aos="fade-up" class="rounded-3xl border border-neutral-200 bg-neutral-50 p-8 dark:border-secondary-700 dark:bg-secondary-900 lg:col-span-5">
                        <div class="flex items-center gap-4"><span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-100 text-primary-600 dark:bg-primary-900/40 dark:text-primary-300"><i class="fa-solid fa-qrcode"></i></span><h3 class="text-xl font-bold text-secondary-900 dark:text-white">QR unik per tamu</h3></div>
                        <p class="mt-5 text-sm leading-7 text-neutral-500 dark:text-neutral-400">Validasi identitas dan jumlah tamu langsung di meja penerima untuk membantu mengurangi kesalahan pencatatan.</p>
                    </article>
                    <article data-aos="fade-up" data-aos-delay="100" class="rounded-3xl border border-neutral-200 bg-neutral-50 p-8 dark:border-secondary-700 dark:bg-secondary-900 lg:col-span-4">
                        <div class="flex items-center gap-4"><span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-100 text-primary-600 dark:bg-primary-900/40 dark:text-primary-300"><i class="fa-solid fa-tags"></i></span><h3 class="text-xl font-bold text-secondary-900 dark:text-white">Kategori fleksibel</h3></div>
                        <p class="mt-5 text-sm leading-7 text-neutral-500 dark:text-neutral-400">Kelompokkan keluarga, sahabat, kolega, atau VIP agar tim mudah memberi layanan yang sesuai.</p>
                    </article>
                    <article data-aos="fade-up" data-aos-delay="200" class="rounded-3xl border border-neutral-200 bg-neutral-50 p-8 dark:border-secondary-700 dark:bg-secondary-900 lg:col-span-3">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-100 text-primary-600 dark:bg-primary-900/40 dark:text-primary-300"><i class="fa-solid fa-shield-halved"></i></span>
                        <h3 class="mt-6 text-xl font-bold text-secondary-900 dark:text-white">Data terpusat</h3>
                        <p class="mt-3 text-sm leading-7 text-neutral-500 dark:text-neutral-400">Informasi tamu tersimpan rapi dalam satu sistem.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="bg-neutral-50 py-20 dark:bg-secondary-900 sm:py-28">
            <div class="mx-auto grid max-w-7xl items-center gap-14 px-6 lg:grid-cols-2 lg:px-8">
                <div data-aos="fade-right" class="relative mx-auto w-full max-w-md">
                    <div class="absolute -inset-6 rounded-full bg-emerald-500/10 blur-3xl"></div>
                    <div class="relative rounded-[2rem] border border-neutral-200 bg-white p-4 shadow-2xl dark:border-secondary-700 dark:bg-secondary-800">
                        <div class="flex items-center gap-3 rounded-2xl bg-[#075e54] p-4 text-white dark:bg-[#202c33]">
                            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary-500 font-bold">R</span>
                            <div><p class="text-sm font-bold">Rayakan Digital</p><p class="text-[10px] text-emerald-200">Undangan pernikahan</p></div>
                        </div>
                        <div class="flex min-h-[300px] flex-col gap-3 rounded-b-2xl bg-[#efeae2] p-4 dark:bg-[#0b141a]">
                            <div class="max-w-[88%] rounded-2xl rounded-tl-sm bg-white p-4 text-xs leading-6 text-secondary-800 shadow-sm dark:bg-secondary-800 dark:text-neutral-200">
                                Halo Budi 👋 Anda terdaftar sebagai tamu di pernikahan <strong>Sari &amp; Andi</strong>. Silakan konfirmasi kehadiran melalui tautan undangan.
                                <p class="mt-2 text-right text-[9px] text-neutral-400">09:01 ✓✓</p>
                            </div>
                            <div class="ml-auto max-w-[75%] rounded-2xl rounded-tr-sm bg-[#d9fdd3] p-3 text-xs text-secondary-800 shadow-sm dark:bg-[#005c4b] dark:text-white">Siap hadir, terima kasih! 🎉<p class="mt-1 text-right text-[9px] text-neutral-500 dark:text-white/50">09:05 ✓✓</p></div>
                            <div class="max-w-[82%] rounded-2xl rounded-tl-sm bg-white p-4 text-xs leading-6 text-secondary-800 shadow-sm dark:bg-secondary-800 dark:text-neutral-200">Konfirmasi diterima. Simpan kode QR Anda untuk check-in di lokasi ✨<p class="mt-2 text-right text-[9px] text-neutral-400">09:05 ✓✓</p></div>
                        </div>
                    </div>
                </div>
                <div data-aos="fade-left">
                    <p class="text-xs font-bold uppercase tracking-[0.22em] text-primary-600 dark:text-primary-400">Komunikasi otomatis</p>
                    <h2 class="mt-4 font-heading text-3xl font-bold text-secondary-900 dark:text-white sm:text-5xl">Pesan tepat, di momen yang tepat.</h2>
                    <p class="mt-6 leading-8 text-neutral-500 dark:text-neutral-400">Bangun pengalaman yang personal sejak undangan diterima hingga tamu selesai menghadiri pernikahan.</p>
                    <div class="mt-9 grid gap-6">
                        @foreach ([['fa-paper-plane', 'Kirim undangan', 'Bagikan undangan dan kode tamu secara personal.'], ['fa-bell', 'Ingatkan RSVP', 'Bantu tamu mengingat konfirmasi dan detail acara.'], ['fa-heart', 'Ucapkan terima kasih', 'Lanjutkan kesan hangat setelah tamu melakukan check-in.']] as [$icon, $title, $copy])
                            <div class="flex gap-4"><span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary-100 text-primary-600 dark:bg-primary-900/40 dark:text-primary-300"><i class="fa-solid {{ $icon }}"></i></span><div><h3 class="font-bold text-secondary-900 dark:text-white">{{ $title }}</h3><p class="mt-1 text-sm leading-6 text-neutral-500 dark:text-neutral-400">{{ $copy }}</p></div></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white px-6 py-20 dark:bg-secondary-800 sm:py-24 lg:px-8">
            <div data-aos="zoom-in" class="relative mx-auto max-w-6xl overflow-hidden rounded-[2rem] bg-secondary-900 px-6 py-14 text-center text-white shadow-2xl sm:px-12 sm:py-16">
                <div class="absolute -left-20 top-0 h-64 w-64 rounded-full bg-primary-500/25 blur-3xl"></div>
                <div class="absolute -right-20 bottom-0 h-64 w-64 rounded-full bg-primary-600/20 blur-3xl"></div>
                <div class="relative mx-auto max-w-3xl">
                    <p class="text-xs font-bold uppercase tracking-[0.22em] text-primary-300">Untuk hari yang istimewa</p>
                    <h2 class="mt-4 font-heading text-3xl font-bold sm:text-5xl">Siap membuat penyambutan tamu terasa lebih modern?</h2>
                    <p class="mx-auto mt-5 max-w-xl leading-7 text-white/60">Ceritakan kebutuhan pernikahan Anda. Tim Rayakan Digital akan membantu menyiapkan alur buku tamu yang paling sesuai.</p>
                    <a href="https://wa.me/62895349823366?text=Halo%20Rayakan%20Digital!%20Saya%20tertarik%20untuk%20konsultasi%20tentang%20Buku%20Tamu%20Digital."
                        class="mt-9 inline-flex items-center justify-center gap-2 rounded-full bg-primary-500 px-8 py-4 text-sm font-bold text-white transition hover:-translate-y-0.5 hover:bg-primary-400">
                        Konsultasi gratis <i class="fa-brands fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <x-public-footer />
</body>

</html>
