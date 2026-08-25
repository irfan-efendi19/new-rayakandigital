<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <x-meta title="Live Streaming Pernikahan - Rayakan Digital"
        description="Hubungkan keluarga dan sahabat dengan siaran pernikahan sinematik, multi-kamera, serta rekaman lengkap dari Rayakan Digital."
        keywords="live streaming pernikahan, siaran pernikahan online, streaming acara, kamera pernikahan, multi platform streaming" />

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
            <div class="absolute inset-0 -z-20 bg-gradient-to-br from-secondary-900 via-secondary-900 to-primary-900/50"></div>
            <div class="absolute -left-28 bottom-0 -z-10 h-80 w-80 rounded-full bg-primary-500/20 blur-3xl"></div>
            <div class="absolute -right-24 top-20 -z-10 h-96 w-96 rounded-full bg-primary-600/20 blur-3xl"></div>
            <div class="absolute inset-0 -z-10 opacity-[0.08]"
                style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 30px 30px;"></div>

            <div class="mx-auto grid max-w-7xl items-center gap-14 px-6 pb-20 lg:grid-cols-[0.9fr_1.1fr] lg:px-8 lg:pb-28">
                <div>
                    <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-primary-200 backdrop-blur">
                        <span class="relative flex h-2 w-2"><span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"></span><span class="relative inline-flex h-2 w-2 rounded-full bg-red-500"></span></span>
                        Live streaming pernikahan
                    </div>
                    <h1 class="max-w-2xl font-heading text-4xl font-bold leading-[1.08] sm:text-5xl lg:text-6xl">
                        Dekatkan mereka pada <span class="text-primary-400">setiap momen.</span>
                    </h1>
                    <p class="mt-6 max-w-xl text-base leading-8 text-white/65 sm:text-lg">
                        Siarkan prosesi pernikahan secara sinematik agar keluarga dan sahabat tetap dapat menyaksikan hari bahagia Anda dari mana saja.
                    </p>
                    <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                        <a href="https://wa.me/62895349823366?text=Halo%20Rayakan%20Digital%2C%20saya%20tertarik%20untuk%20konsultasi%20mengenai%20layanan%20live%20streaming%20pernikahan."
                            class="inline-flex items-center justify-center gap-2 rounded-full bg-primary-500 px-7 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary-500/20 transition hover:-translate-y-0.5 hover:bg-primary-400">
                            Konsultasikan acara <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                        <a href="#paket"
                            class="inline-flex items-center justify-center gap-2 rounded-full border border-white/20 bg-white/5 px-7 py-3.5 text-sm font-semibold text-white transition hover:border-white/40 hover:bg-white/10">
                            <i class="fa-solid fa-layer-group"></i> Lihat pilihan paket
                        </a>
                    </div>
                    <div class="mt-10 flex flex-wrap gap-x-6 gap-y-3 text-sm text-white/60">
                        <span class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-primary-400"></i> Multi-kamera</span>
                        <span class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-primary-400"></i> Multi-platform</span>
                        <span class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-primary-400"></i> File rekaman</span>
                    </div>
                </div>

                <div class="relative mx-auto w-full max-w-2xl">
                    <div class="absolute -inset-5 rounded-[2.25rem] bg-gradient-to-br from-primary-400/20 to-transparent blur-2xl"></div>
                    <div class="relative rounded-[1.75rem] border border-white/15 bg-white/[0.08] p-3 shadow-2xl backdrop-blur-xl sm:p-5">
                        <div class="overflow-hidden rounded-2xl bg-secondary-900 shadow-inner ring-1 ring-white/10">
                            <div class="flex items-center justify-between border-b border-white/10 px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <span class="h-2.5 w-2.5 rounded-full bg-red-400"></span><span class="h-2.5 w-2.5 rounded-full bg-amber-400"></span><span class="h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                                </div>
                                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-white/40">Wedding broadcast</p>
                                <i class="fa-solid fa-wifi text-xs text-emerald-400"></i>
                            </div>

                            <div class="grid min-h-[310px] bg-gradient-to-br from-primary-900/70 via-secondary-800 to-secondary-900 p-4 sm:min-h-[350px] sm:grid-cols-[1fr_150px]">
                                <div class="relative flex min-h-[245px] items-center justify-center overflow-hidden rounded-xl border border-white/10 bg-secondary-800">
                                    <div class="absolute inset-0 opacity-50">
                                        <div class="absolute left-[8%] top-[18%] h-48 w-48 rounded-full border border-primary-400/20"></div>
                                        <div class="absolute right-[5%] top-[5%] h-56 w-56 rounded-full border border-white/10"></div>
                                        <div class="absolute bottom-0 left-1/2 h-32 w-72 -translate-x-1/2 rounded-t-full bg-primary-500/10 blur-xl"></div>
                                    </div>
                                    <div class="relative text-center">
                                        <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full border border-white/15 bg-white/5 text-3xl text-primary-400 backdrop-blur"><i class="fa-solid fa-heart"></i></div>
                                        <p class="mt-5 font-heading text-xl font-bold">Sari &amp; Andi</p>
                                        <p class="mt-1 text-[11px] text-white/45">Akad Pernikahan · Live</p>
                                    </div>
                                    <div class="absolute left-3 top-3 flex items-center gap-2 rounded-md bg-red-600 px-2.5 py-1 text-[10px] font-bold"><span class="h-1.5 w-1.5 animate-pulse rounded-full bg-white"></span> LIVE</div>
                                    <div class="absolute right-3 top-3 rounded-md bg-black/40 px-2.5 py-1 text-[10px] text-white/80"><i class="fa-solid fa-signal mr-1"></i> HD</div>
                                    <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between rounded-lg bg-black/35 px-3 py-2 backdrop-blur">
                                        <div class="flex gap-3 text-[11px] text-white/80"><i class="fa-solid fa-pause"></i><i class="fa-solid fa-volume-high"></i><span class="hidden sm:inline">01:24:08</span></div>
                                        <div class="flex gap-3 text-[11px] text-white/80"><i class="fa-solid fa-gear"></i><i class="fa-solid fa-expand"></i></div>
                                    </div>
                                </div>

                                <div class="hidden flex-col gap-2 pl-3 sm:flex">
                                    <div class="flex items-center justify-between pb-2 text-[10px]"><span class="font-bold text-white/80">Live chat</span><i class="fa-solid fa-ellipsis text-white/30"></i></div>
                                    @foreach ([['M', 'Maya', 'Selamat untuk kalian!'], ['B', 'Budi', 'Ikut terharu dari jauh'], ['I', 'Indah', 'Prosesi yang indah ✨']] as [$initial, $name, $message])
                                        <div class="rounded-xl bg-white/5 p-2.5">
                                            <div class="flex gap-2"><span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-primary-500/20 text-[9px] font-bold text-primary-300">{{ $initial }}</span><div><p class="text-[9px] font-bold text-white/80">{{ $name }}</p><p class="mt-1 text-[9px] leading-4 text-white/45">{{ $message }}</p></div></div>
                                        </div>
                                    @endforeach
                                    <div class="mt-auto rounded-lg border border-white/10 px-2.5 py-2 text-[9px] text-white/30">Tulis ucapan...</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -bottom-5 -left-3 hidden items-center gap-3 rounded-2xl border border-white/15 bg-white px-4 py-3 text-secondary-900 shadow-xl sm:flex dark:bg-secondary-800 dark:text-white">
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-300"><i class="fa-solid fa-tower-broadcast"></i></span>
                        <div><p class="text-xs font-bold">Siaran terhubung</p><p class="text-[10px] text-neutral-500">Momen berlangsung real-time</p></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="border-b border-neutral-200 bg-white dark:border-secondary-700 dark:bg-secondary-800">
            <div class="mx-auto grid max-w-7xl grid-cols-1 divide-y divide-neutral-200 px-6 dark:divide-secondary-700 sm:grid-cols-3 sm:divide-x sm:divide-y-0 lg:px-8">
                @foreach ([['fa-video', 'Visual sinematik', 'Tampilan profesional untuk momen sakral'], ['fa-shuffle', 'Multi-platform', 'Jangkau tamu melalui kanal pilihan'], ['fa-circle-dot', 'Rekaman lengkap', 'Simpan kembali momen yang disiarkan']] as [$icon, $title, $copy])
                    <div class="flex items-center gap-4 py-6 sm:px-6">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary-50 text-primary-600 dark:bg-primary-900/30 dark:text-primary-300"><i class="fa-solid {{ $icon }}"></i></span>
                        <div><p class="text-sm font-bold text-secondary-900 dark:text-white">{{ $title }}</p><p class="mt-1 text-xs leading-5 text-neutral-500 dark:text-neutral-400">{{ $copy }}</p></div>
                    </div>
                @endforeach
            </div>
        </section>

        <section id="fitur" class="bg-neutral-50 py-20 dark:bg-secondary-900 sm:py-28">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div data-aos="fade-up" class="flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
                    <div class="max-w-2xl">
                        <p class="text-xs font-bold uppercase tracking-[0.22em] text-primary-600 dark:text-primary-400">Produksi menyeluruh</p>
                        <h2 class="mt-4 font-heading text-3xl font-bold text-secondary-900 dark:text-white sm:text-5xl">Bukan sekadar menyalakan kamera.</h2>
                    </div>
                    <p class="max-w-md text-sm leading-7 text-neutral-500 dark:text-neutral-400">Tim kami membantu menata visual, pergerakan kamera, dan distribusi siaran agar pengalaman menonton terasa utuh.</p>
                </div>

                <div class="mt-14 grid gap-5 lg:grid-cols-12">
                    <article data-aos="fade-up" class="relative overflow-hidden rounded-3xl bg-secondary-900 p-8 text-white lg:col-span-7 lg:p-10">
                        <div class="absolute -right-16 -top-16 h-64 w-64 rounded-full bg-primary-500/20 blur-3xl"></div>
                        <div class="relative">
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-500"><i class="fa-solid fa-camera-rotate"></i></span>
                            <h3 class="mt-8 font-heading text-3xl font-bold">Sudut pandang yang hidup</h3>
                            <p class="mt-4 max-w-xl leading-7 text-white/60">Perpaduan kamera statis dan bergerak membantu menangkap prosesi, ekspresi, serta detail dekorasi secara lebih menyeluruh.</p>
                            <div class="mt-8 grid grid-cols-3 gap-3">
                                @foreach ([['CAM 01', 'Wide'], ['CAM 02', 'Close-up'], ['CAM 03', 'Moving']] as $index => [$camera, $view])
                                    <div class="rounded-2xl border {{ $index === 1 ? 'border-primary-400 bg-primary-500/15' : 'border-white/10 bg-white/5' }} p-3 sm:p-4"><i class="fa-solid fa-video text-xs text-primary-400"></i><p class="mt-3 text-[10px] font-bold text-white/80">{{ $camera }}</p><p class="mt-1 text-[9px] text-white/40">{{ $view }}</p></div>
                                @endforeach
                            </div>
                        </div>
                    </article>

                    <article data-aos="fade-up" data-aos-delay="100" class="rounded-3xl bg-primary-500 p-8 text-white lg:col-span-5 lg:p-10">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20"><i class="fa-solid fa-sliders"></i></span>
                        <h3 class="mt-8 font-heading text-3xl font-bold">Bingkai yang menyatu dengan tema</h3>
                        <p class="mt-4 leading-7 text-white/80">Tampilan siaran dapat dipersonalisasi agar nama pasangan, warna, dan detail acara terasa selaras.</p>
                        <div class="mt-8 rounded-2xl border border-white/20 bg-white/10 p-4">
                            <div class="flex items-center justify-between"><span class="font-heading font-bold">Sari &amp; Andi</span><span class="rounded-full bg-white/15 px-3 py-1 text-[10px]">LIVE</span></div><div class="mt-4 h-1 rounded-full bg-white/20"><div class="h-1 w-2/3 rounded-full bg-white"></div></div>
                        </div>
                    </article>

                    @foreach ([
                        ['fa-shuffle', 'Multi-platform', 'Distribusikan siaran melalui YouTube dan platform lain sesuai kebutuhan acara.', 'lg:col-span-4'],
                        ['fa-desktop', 'Live cam venue', 'Tampilkan prosesi pada layar lokasi agar tamu dari berbagai area tetap dapat mengikuti.', 'lg:col-span-4'],
                        ['fa-circle-dot', 'Rekaman lengkap', 'Terima hasil rekaman untuk dinikmati kembali setelah acara selesai.', 'lg:col-span-4']
                    ] as $index => [$icon, $title, $copy, $span])
                        <article data-aos="fade-up" data-aos-delay="{{ $index * 100 }}" class="rounded-3xl border border-neutral-200 bg-white p-8 dark:border-secondary-700 dark:bg-secondary-800 {{ $span }}">
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-100 text-primary-600 dark:bg-primary-900/40 dark:text-primary-300"><i class="fa-solid {{ $icon }}"></i></span>
                            <h3 class="mt-6 text-xl font-bold text-secondary-900 dark:text-white">{{ $title }}</h3>
                            <p class="mt-3 text-sm leading-7 text-neutral-500 dark:text-neutral-400">{{ $copy }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="bg-white py-20 dark:bg-secondary-800 sm:py-28">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div data-aos="fade-up" class="mx-auto max-w-2xl text-center">
                    <p class="text-xs font-bold uppercase tracking-[0.22em] text-primary-600 dark:text-primary-400">Persiapan terarah</p>
                    <h2 class="mt-4 font-heading text-3xl font-bold text-secondary-900 dark:text-white sm:text-5xl">Dari rencana menjadi siaran.</h2>
                </div>
                <div class="relative mt-14 grid gap-5 lg:grid-cols-3">
                    <div class="absolute left-[16%] right-[16%] top-8 hidden border-t border-dashed border-primary-300 lg:block dark:border-primary-800"></div>
                    @foreach ([['01', 'Ceritakan acara Anda', 'Bagikan jadwal, lokasi, konsep, dan platform yang ingin digunakan.'], ['02', 'Susun kebutuhan produksi', 'Kami membantu memilih jumlah kamera, durasi, serta elemen visual yang sesuai.'], ['03', 'Siaran dimulai', 'Tim menangani produksi agar Anda dapat fokus menikmati momen pernikahan.']] as $index => [$number, $title, $copy])
                        <article data-aos="fade-up" data-aos-delay="{{ $index * 100 }}" class="relative rounded-3xl border border-neutral-200 bg-neutral-50 p-7 text-center dark:border-secondary-700 dark:bg-secondary-900">
                            <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-full border-4 border-white bg-secondary-900 text-sm font-bold text-primary-400 shadow-lg dark:border-secondary-800">{{ $number }}</span>
                            <h3 class="mt-7 text-xl font-bold text-secondary-900 dark:text-white">{{ $title }}</h3>
                            <p class="mt-3 text-sm leading-7 text-neutral-500 dark:text-neutral-400">{{ $copy }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="paket" class="bg-neutral-50 py-20 dark:bg-secondary-900 sm:py-28">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div data-aos="fade-up" class="mx-auto max-w-2xl text-center">
                    <p class="text-xs font-bold uppercase tracking-[0.22em] text-primary-600 dark:text-primary-400">Pilihan layanan</p>
                    <h2 class="mt-4 font-heading text-3xl font-bold text-secondary-900 dark:text-white sm:text-5xl">Paket untuk setiap skala momen.</h2>
                    <p class="mt-5 leading-7 text-neutral-500 dark:text-neutral-400">Detail akhir dapat disesuaikan dengan venue, durasi, dan kebutuhan distribusi siaran Anda.</p>
                </div>

                @php
                    $packages = [
                        ['Silver', 'Untuk prosesi yang ringkas', ['1 kamera statis', 'Durasi 2 jam', '1 platform (YouTube)'], false],
                        ['Gold', 'Pilihan favorit pasangan', ['2 kamera (1 bergerak)', 'Durasi 4 jam', '3 platform sekaligus', 'File rekaman lengkap'], true],
                        ['Platinum', 'Untuk pengalaman menyeluruh', ['3 kamera profesional', 'Durasi tanpa batas', 'Semua platform', 'Fitur live cam lokasi'], false],
                    ];
                @endphp

                <div class="mt-14 grid items-stretch gap-5 lg:grid-cols-3">
                    @foreach ($packages as $index => [$name, $tagline, $features, $featured])
                        <article data-aos="fade-up" data-aos-delay="{{ $index * 100 }}" class="relative flex flex-col rounded-3xl p-8 {{ $featured ? 'bg-secondary-900 text-white shadow-2xl ring-2 ring-primary-500' : 'border border-neutral-200 bg-white text-secondary-900 dark:border-secondary-700 dark:bg-secondary-800 dark:text-white' }}">
                            @if ($featured)
                                <span class="absolute -top-3 left-1/2 -translate-x-1/2 rounded-full bg-primary-500 px-4 py-1.5 text-[10px] font-bold uppercase tracking-[0.16em] text-white">Paling populer</span>
                            @endif
                            <div class="flex items-start justify-between gap-4">
                                <div><h3 class="font-heading text-3xl font-bold">{{ $name }}</h3><p class="mt-2 text-sm {{ $featured ? 'text-white/50' : 'text-neutral-500 dark:text-neutral-400' }}">{{ $tagline }}</p></div>
                                <span class="flex h-11 w-11 items-center justify-center rounded-xl {{ $featured ? 'bg-primary-500 text-white' : 'bg-primary-100 text-primary-600 dark:bg-primary-900/40 dark:text-primary-300' }}"><i class="fa-solid fa-video"></i></span>
                            </div>
                            <p class="mt-8 text-xs font-bold uppercase tracking-[0.16em] {{ $featured ? 'text-primary-300' : 'text-primary-600 dark:text-primary-400' }}">Hubungi sales</p>
                            <ul class="mt-7 flex flex-1 flex-col gap-4">
                                @foreach ($features as $feature)
                                    <li class="flex items-start gap-3 text-sm {{ $featured ? 'text-white/75' : 'text-neutral-600 dark:text-neutral-300' }}"><i class="fa-solid fa-circle-check mt-0.5 text-primary-500"></i><span>{{ $feature }}</span></li>
                                @endforeach
                            </ul>
                            <a href="https://wa.me/62895349823366?text=Halo%20Rayakan%20Digital%2C%20saya%20tertarik%20dengan%20paket%20{{ urlencode($name) }}%20live%20streaming%20pernikahan."
                                class="mt-9 inline-flex items-center justify-center gap-2 rounded-full px-6 py-3.5 text-sm font-bold transition {{ $featured ? 'bg-primary-500 text-white hover:bg-primary-400' : 'border border-neutral-300 text-secondary-900 hover:border-primary-500 hover:text-primary-600 dark:border-secondary-600 dark:text-white dark:hover:border-primary-500 dark:hover:text-primary-300' }}">
                                Tanya paket {{ $name }} <i class="fa-brands fa-whatsapp"></i>
                            </a>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="bg-white px-6 py-20 dark:bg-secondary-800 sm:py-24 lg:px-8">
            <div data-aos="zoom-in" class="relative mx-auto max-w-6xl overflow-hidden rounded-[2rem] bg-secondary-900 px-6 py-14 text-center text-white shadow-2xl sm:px-12 sm:py-16">
                <div class="absolute -left-20 top-0 h-64 w-64 rounded-full bg-primary-500/25 blur-3xl"></div>
                <div class="absolute -right-20 bottom-0 h-64 w-64 rounded-full bg-primary-600/20 blur-3xl"></div>
                <div class="relative mx-auto max-w-3xl">
                    <p class="text-xs font-bold uppercase tracking-[0.22em] text-primary-300">Tidak ada yang tertinggal</p>
                    <h2 class="mt-4 font-heading text-3xl font-bold sm:text-5xl">Mari hubungkan orang terkasih dengan hari bahagia Anda.</h2>
                    <p class="mx-auto mt-5 max-w-xl leading-7 text-white/60">Konsultasikan jadwal, lokasi, dan kebutuhan siaran agar kami dapat menyiapkan produksi yang tepat.</p>
                    <a href="https://wa.me/62895349823366?text=Halo%20Rayakan%20Digital%2C%20saya%20tertarik%20untuk%20konsultasi%20mengenai%20layanan%20live%20streaming%20pernikahan."
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
