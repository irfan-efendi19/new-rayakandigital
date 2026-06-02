<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kebijakan Privasi - Rayakan Digital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <x-public-navbar />
    <div class="h-16"></div>

    <main class="min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center mb-12">
                <h1 class="font-heading text-4xl md:text-5xl font-bold text-secondary-800">
                    Kebijakan Privasi
                </h1>
                <p class="mt-4 text-neutral-500 text-lg">
                    Kami menghargai privasi Anda dan berkomitmen melindungi data pribadi Anda.
                </p>
                <p class="mt-2 text-sm text-neutral-400">Terakhir diperbarui: Juni 2025</p>
            </div>

            <div class="bg-white rounded-2xl shadow-soft p-8 md:p-12 space-y-8">
                <section>
                    <h2 class="font-heading text-2xl font-bold text-secondary-800 mb-3">1. Informasi yang Kami Kumpulkan
                    </h2>
                    <p class="text-neutral-600 leading-relaxed mb-3">
                        Kami mengumpulkan informasi berikut saat Anda menggunakan layanan Rayakan Digital:
                    </p>
                    <ul class="space-y-2 text-neutral-600">
                        <li class="flex items-start gap-3">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0"></span>
                            <span><strong class="text-secondary-700">Informasi Akun:</strong> Nama lengkap, alamat
                                email, nomor telepon, dan kata sandi terenkripsi.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0"></span>
                            <span><strong class="text-secondary-700">Informasi Acara:</strong> Detail acara seperti nama
                                pasangan, tanggal acara, lokasi, foto, video, dan konten undangan yang Anda buat.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0"></span>
                            <span><strong class="text-secondary-700">Informasi Tamu:</strong> Data tamu yang Anda unggah
                                termasuk nama, nomor telepon, dan status kehadiran.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0"></span>
                            <span><strong class="text-secondary-700">Data Penggunaan:</strong> Informasi tentang cara
                                Anda berinteraksi dengan platform kami, termasuk alamat IP, jenis perangkat, browser,
                                dan halaman yang dikunjungi.</span>
                        </li>
                    </ul>
                </section>

                <section>
                    <h2 class="font-heading text-2xl font-bold text-secondary-800 mb-3">2. Cara Kami Menggunakan
                        Informasi</h2>
                    <p class="text-neutral-600 leading-relaxed mb-3">
                        Informasi yang kami kumpulkan digunakan untuk:
                    </p>
                    <ul class="space-y-2 text-neutral-600">
                        <li class="flex items-start gap-3">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0"></span>
                            Menyediakan, mengoperasikan, dan memelihara layanan kami
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0"></span>
                            Memproses transaksi dan pembayaran Anda
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0"></span>
                            Mengirim pemberitahuan terkait layanan, pembaruan, dan dukungan teknis
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0"></span>
                            Meningkatkan dan mengoptimalkan pengalaman pengguna
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0"></span>
                            Mendeteksi, mencegah, dan menangani aktivitas penipuan atau penyalahgunaan
                        </li>
                    </ul>
                </section>

                <section>
                    <h2 class="font-heading text-2xl font-bold text-secondary-800 mb-3">3. Perlindungan Data</h2>
                    <p class="text-neutral-600 leading-relaxed">
                        Kami menerapkan langkah-langkah keamanan teknis dan organisasi yang sesuai untuk melindungi data
                        pribadi Anda dari akses tidak sah, perubahan, pengungkapan, atau penghancuran. Data Anda
                        disimpan di server yang aman dengan enkripsi SSL/TLS dan firewall protection.
                    </p>
                </section>

                <section>
                    <h2 class="font-heading text-2xl font-bold text-secondary-800 mb-3">4. Pembagian Data dengan Pihak
                        Ketiga</h2>
                    <p class="text-neutral-600 leading-relaxed">
                        Kami tidak menjual, menyewakan, atau memperdagangkan data pribadi Anda kepada pihak ketiga.
                        Namun, kami dapat membagikan informasi Anda kepada:
                    </p>
                    <ul class="mt-3 space-y-2 text-neutral-600">
                        <li class="flex items-start gap-3">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0"></span>
                            <span><strong class="text-secondary-700">Penyedia Layanan:</strong> Pihak ketiga yang
                                membantu kami mengoperasikan platform, seperti penyedia hosting, pemroses pembayaran,
                                dan layanan pengiriman email.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0"></span>
                            <span><strong class="text-secondary-700">Kewajiban Hukum:</strong> Jika diwajibkan oleh
                                hukum, peraturan, atau proses hukum yang berlaku.</span>
                        </li>
                    </ul>
                </section>

                <section>
                    <h2 class="font-heading text-2xl font-bold text-secondary-800 mb-3">5. Cookie & Teknologi Pelacakan
                    </h2>
                    <p class="text-neutral-600 leading-relaxed">
                        Kami menggunakan cookie dan teknologi serupa untuk meningkatkan pengalaman Anda, menganalisis
                        tren, dan mengelola platform. Anda dapat mengontrol penggunaan cookie melalui pengaturan browser
                        Anda. Namun, menonaktifkan cookie dapat memengaruhi fungsionalitas layanan.
                    </p>
                </section>

                <section>
                    <h2 class="font-heading text-2xl font-bold text-secondary-800 mb-3">6. Retensi Data</h2>
                    <p class="text-neutral-600 leading-relaxed">
                        Kami menyimpan data pribadi Anda selama akun Anda aktif atau selama diperlukan untuk menyediakan
                        layanan. Setelah itu, data akan dihapus atau dianonimkan sesuai dengan kebijakan retensi kami,
                        kecuali jika diperlukan untuk memenuhi kewajiban hukum.
                    </p>
                </section>

                <section>
                    <h2 class="font-heading text-2xl font-bold text-secondary-800 mb-3">7. Hak Anda</h2>
                    <p class="text-neutral-600 leading-relaxed mb-3">
                        Anda memiliki hak-hak berikut terkait data pribadi Anda:
                    </p>
                    <ul class="space-y-2 text-neutral-600">
                        <li class="flex items-start gap-3">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0"></span>
                            Hak untuk mengakses data pribadi yang kami simpan
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0"></span>
                            Hak untuk memperbaiki data yang tidak akurat
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0"></span>
                            Hak untuk menghapus data pribadi Anda
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0"></span>
                            Hak untuk membatasi atau menolak pemrosesan data
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0"></span>
                            Hak untuk menarik persetujuan kapan saja
                        </li>
                    </ul>
                </section>

                <section>
                    <h2 class="font-heading text-2xl font-bold text-secondary-800 mb-3">8. Perubahan Kebijakan Privasi
                    </h2>
                    <p class="text-neutral-600 leading-relaxed">
                        Kami dapat memperbarui kebijakan privasi ini dari waktu ke waktu. Setiap perubahan akan
                        diumumkan melalui platform atau email. Dengan terus menggunakan layanan setelah perubahan, Anda
                        menyetujui kebijakan yang diperbarui.
                    </p>
                </section>

                <section>
                    <h2 class="font-heading text-2xl font-bold text-secondary-800 mb-3">9. Kontak</h2>
                    <p class="text-neutral-600 leading-relaxed">
                        Jika Anda memiliki pertanyaan, keluhan, atau permintaan terkait kebijakan privasi ini, silakan
                        hubungi kami:
                    </p>
                    <div class="mt-4 p-4 bg-primary-50 rounded-xl border border-primary-100">
                        <p class="text-neutral-700"><strong>Email:</strong> <a href="mailto:support@rayakandigital.com"
                                class="text-primary hover:text-primary-600 underline">support@rayakandigital.com</a></p>
                        <p class="text-neutral-700 mt-2"><strong>WhatsApp:</strong> <a href="https://wa.me/6281234567890"
                                class="text-primary hover:text-primary-600 underline">+62 812-3456-7890</a></p>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <x-public-footer />
</body>

</html>