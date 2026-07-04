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

<body class="font-sans antialiased bg-neutral-50 dark:bg-secondary-900 text-secondary-800 dark:text-neutral-200">
    <x-public-navbar />
    <div class="h-16"></div>
    <div class="py-16 md:py-24 bg-tertiary dark:bg-secondary-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="text-center mb-12 md:mb-16">
                <h2 class="text-base text-primary-600 font-semibold tracking-wide uppercase">Hubungi Kami</h2>
                <p
                    class="mt-2 text-3xl md:text-4xl leading-8 md:leading-10 font-extrabold tracking-tight text-secondary-900 dark:text-neutral-100 font-heading">
                    Kami Siap Membantu Anda
                </p>
                <p class="mt-4 max-w-2xl text-lg text-neutral-600 dark:text-neutral-300 mx-auto">
                    Kami di sini untuk membantu Anda merayakan momen berharga. Punya pertanyaan tentang layanan kami?
                    Tim kami siap memberikan respon hangat untuk Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                <!-- Left Column - Contact Info -->
                <div class="space-y-6">
                    <div
                        class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700 p-6 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center text-primary-600">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-secondary-800 dark:text-neutral-200 mb-1">Alamat Kantor</h3>
                                <p class="text-neutral-600 dark:text-neutral-300 text-sm leading-relaxed">Dusun Nglajur
                                    Desa Tugusumberjo Kecamatan Peterongan Kabupaten Jombang</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700 p-6 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center text-primary-600">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-secondary-800 dark:text-neutral-200 mb-1">WhatsApp Support
                                </h3>
                                <p class="text-neutral-600 dark:text-neutral-300 text-sm">+62 8953 49823 366</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700 p-6 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center text-primary-600">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-secondary-800 dark:text-neutral-200 mb-1">Email</h3>
                                <p class="text-neutral-600 dark:text-neutral-300 text-sm">admin@rayakandigital.com</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700 p-6 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center text-primary-600">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-secondary-800 dark:text-neutral-200 mb-1">Jam Operasional</h3>
                                <p class="text-neutral-600 dark:text-neutral-300 text-sm">Senin - Jumat: 09.00 - 18.00
                                    WIB</p>
                                <p class="text-neutral-600 dark:text-neutral-300 text-sm">Sabtu: 09.00 - 14.00 WIB</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gradient-to-r from-primary-50 to-primary-100 dark:from-secondary-700 dark:to-secondary-800 rounded-2xl p-5 border border-primary-200 dark:border-secondary-600">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center text-white text-lg">
                                ⚡</div>
                            <div>
                                <p class="font-bold text-secondary-800 dark:text-neutral-200 text-sm">Butuh Respon
                                    Cepat?</p>
                                <p class="text-secondary-600 dark:text-neutral-300 text-xs">Tim Customer Service kami
                                    biasanya merespon dalam waktu kurang dari 30 menit melalui WhatsApp.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Contact Form -->
                <div
                    class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700 p-6 md:p-8">
                    <h3 class="text-xl font-bold text-secondary-900 dark:text-neutral-100 mb-6 font-heading">Kirim Pesan
                        Langsung</h3>

                    <form id="contactForm" class="space-y-5" action="{{ route('hubungi-kami.submit') }}" method="POST">
                        @csrf

                        <div>
                            <label for="name"
                                class="block text-sm font-semibold text-secondary-700 dark:text-neutral-200 mb-2">Nama
                                Lengkap</label>
                            <input type="text" id="name" name="name" placeholder="Masukkan nama Anda" required
                                class="w-full px-4 py-3 border border-neutral-200 dark:border-secondary-700 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all duration-200 bg-tertiary/50">
                        </div>

                        <div>
                            <label for="email"
                                class="block text-sm font-semibold text-secondary-700 dark:text-neutral-200 mb-2">Alamat
                                Email</label>
                            <input type="email" id="email" name="email" placeholder="nama@email.com" required
                                class="w-full px-4 py-3 border border-neutral-200 dark:border-secondary-700 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all duration-200 bg-tertiary/50">
                        </div>

                        <div>
                            <label for="subject"
                                class="block text-sm font-semibold text-secondary-700 dark:text-neutral-200 mb-2">Subjek
                                Pesan</label>
                            <select id="subject" name="subject" required
                                class="w-full px-4 py-3 border border-neutral-200 dark:border-secondary-700 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all duration-200 bg-tertiary/50 text-neutral-600 dark:text-neutral-300">
                                <option value="">Pilih subjek pertanyaan</option>
                                <option value="general">Pertanyaan Umum</option>
                                <option value="order">Pemesanan Undangan</option>
                                <option value="technical">Kendala Teknis</option>
                                <option value="partnership">Kerja Sama</option>
                            </select>
                        </div>

                        <div>
                            <label for="message"
                                class="block text-sm font-semibold text-secondary-700 dark:text-neutral-200 mb-2">Pesan
                                Anda</label>
                            <textarea id="message" name="message" rows="4"
                                placeholder="Tuliskan detail pertanyaan Anda di sini..." required
                                class="w-full px-4 py-3 border border-neutral-200 dark:border-secondary-700 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all duration-200 bg-tertiary/50 resize-none"></textarea>
                        </div>

                        <button type="submit"
                            class="w-full py-3 px-4 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white rounded-xl font-bold transition-all duration-300 transform hover:scale-[1.02] shadow-soft shadow-primary-500/25">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-public-footer />
    <script>
        const contactForm = document.getElementById('contactForm');
        contactForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const submitBtn = contactForm.querySelector('button[type="submit"]');
            const formData = new FormData(contactForm);

            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Mengirim...';

            try {
                const response = await fetch(contactForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                    },
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Pesan Terkirim!',
                    timer: 4000,
                    showConfirmButton: true,
                    confirmButtonColor: '#FF7A00',
                });

                contactForm.reset();
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Mengirim',
                    text: error.message,
                    confirmButtonColor: '#FF7A00',
                });
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Kirim Pesan';
            }
        });
    </script>
</body>

</html>