<footer class="bg-footer-bg dark:bg-secondary-900 px-16 pt-14 max-w-screen-xl mx-auto rounded-2xl">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 pb-12">

        <div>
            <p class="font-heading text-primary dark:text-primary-400 text-2xl font-semibold tracking-tight mb-3">
                Rayakan Digital</p>
            <p class="text-footer-muted dark:text-neutral-400 text-sm leading-relaxed mb-7 max-w-[210px]">
                Platform pembuatan undangan digital terdepan di Indonesia. Mudah, elegan, dan penuh fitur modern.
            </p>
            <div class="flex gap-2.5">
                <a href="https://www.instagram.com/rayakan_digital/" target="_blank" aria-label="Instagram"
                    class="w-9 h-9 rounded-full bg-footer-pill dark:bg-secondary-800 flex items-center justify-center text-footer-muted dark:text-neutral-400 hover:bg-primary hover:text-white transition-all duration-200 hover:-translate-y-0.5">
                    <i class="fa-brands fa-instagram text-sm"></i>
                </a>
                <a href="https://www.facebook.com/rayakan.digital" target="_blank" aria-label="Facebook"
                    class="w-9 h-9 rounded-full bg-footer-pill dark:bg-secondary-800 flex items-center justify-center text-footer-muted dark:text-neutral-400 hover:bg-primary hover:text-white transition-all duration-200 hover:-translate-y-0.5">
                    <i class="fa-brands fa-facebook text-sm"></i>
                </a>
                <a href="https://www.youtube.com/@rayakandigital" target="_blank" aria-label="Youtube"
                    class="w-9 h-9 rounded-full bg-footer-pill dark:bg-secondary-800 flex items-center justify-center text-footer-muted dark:text-neutral-400 hover:bg-primary hover:text-white transition-all duration-200 hover:-translate-y-0.5">
                    <i class="fa-brands fa-youtube text-sm"></i>
                </a>
                <a href="https://www.tiktok.com/@rayakan.digital" target="_blank" aria-label="TikTok"
                    class="w-9 h-9 rounded-full bg-footer-pill dark:bg-secondary-800 flex items-center justify-center text-footer-muted dark:text-neutral-400 hover:bg-primary hover:text-white transition-all duration-200 hover:-translate-y-0.5">
                    <i class="fa-brands fa-tiktok text-sm"></i>
                </a>
            </div>
            </div>
            
            <nav aria-label="Layanan">
                <p class="text-[11px] font-semibold tracking-widest uppercase text-footer-subtle dark:text-neutral-500 mb-5">
                    Layanan</p>
                <ul class="flex flex-col gap-3.5">
                    <li>
                        <a href="{{ route('undangan-web') }}"
                            class="nav-link text-sm text-footer-link dark:text-neutral-300 hover:text-brand transition-colors duration-150 inline-flex items-center gap-1.5">
                            Undangan Web
                            <span class="arrow text-xs">→</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('buku-tamu') }}"
                            class="nav-link text-sm text-footer-link dark:text-neutral-300 hover:text-brand transition-colors duration-150 inline-flex items-center gap-1.5">
                            Buku Tamu Digital
                            <span class="arrow text-xs">→</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('live-streaming') }}"
                            class="nav-link text-sm text-footer-link dark:text-neutral-300 hover:text-brand transition-colors duration-150 inline-flex items-center gap-1.5">
                            Live Streaming
                            <span class="arrow text-xs">→</span>
                        </a>
                    </li>
                </ul>
            </nav>
            
            <nav aria-label="Perusahaan">
                <p class="text-[11px] font-semibold tracking-widest uppercase text-footer-subtle dark:text-neutral-500 mb-5">
                    Perusahaan</p>
                <ul class="flex flex-col gap-3.5">
                    <li>
                        <a href="{{ route('tentang-kami') }}"
                            class="nav-link text-sm text-footer-link dark:text-neutral-300 hover:text-brand transition-colors duration-150 inline-flex items-center gap-1.5">
                            Tentang Kami
                            <span class="arrow text-xs">→</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('syarat-ketentuan') }}"
                            class="nav-link text-sm text-footer-link dark:text-neutral-300 hover:text-brand transition-colors duration-150 inline-flex items-center gap-1.5">
                            Syarat &amp; Ketentuan
                            <span class="arrow text-xs">→</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kebijakan-privasi') }}"
                            class="nav-link text-sm text-footer-link dark:text-neutral-300 hover:text-brand transition-colors duration-150 inline-flex items-center gap-1.5">
                            Kebijakan Privasi
                            <span class="arrow text-xs">→</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('hubungi-kami') }}"
                            class="nav-link text-sm text-footer-link dark:text-neutral-300 hover:text-brand transition-colors duration-150 inline-flex items-center gap-1.5">
                            Hubungi Kami
                            <span class="arrow text-xs">→</span>
                        </a>
                    </li>
                </ul>
            </nav>
            
            @php
                $logoPath = public_path('logobank');
                $logos = glob($logoPath . '/*.{png,jpg,jpeg,svg,webp}', GLOB_BRACE);
                $logos = array_map(function ($path) {
                    return 'logobank/' . basename($path);
                }, $logos);
                sort($logos);
            @endphp
            <div>
                <p class="text-[11px] font-semibold tracking-widest uppercase text-footer-subtle dark:text-neutral-500 mb-5">
                    Metode Pembayaran
                </p>
                <div class="grid grid-cols-3 lg:grid-cols-4 gap-2 lg:gap-3">
                    @foreach($logos as $logo)
                        <div
                            class="bg-white dark:bg-secondary-800 border border-footer-border dark:border-secondary-700 rounded-lg h-12 overflow-hidden flex items-center justify-center p-2">
                            <img src="{{ asset($logo) }}" alt="{{ pathinfo($logo, PATHINFO_FILENAME) }}"
                                class="max-w-[90%] max-h-[90%] object-contain">
                        </div>
                    @endforeach
                </div>
            </div>
            
            </div>
            
            <hr class="border-footer-border dark:border-secondary-700" />
            
            <div class="py-5 flex flex-col sm:flex-row items-center justify-between gap-2">
                <p class="text-[13px] text-footer-subtle dark:text-neutral-500">&copy; {{ date('Y') }} Rayakan Digital. All
                    rights reserved.</p>
        <p class="text-[13px] text-footer-subtle dark:text-neutral-500 flex items-center gap-1.5">
            Rayakan Cinta dengan Sentuhan Digital
        </p>
    </div>
</footer>