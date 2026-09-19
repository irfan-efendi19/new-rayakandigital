<x-app-layout>
    <div class="min-h-screen bg-neutral-50/70 dark:bg-secondary-900">
        <header class="relative overflow-hidden border-b border-neutral-200/80 bg-white dark:border-secondary-700 dark:bg-secondary-900">
            <div class="absolute inset-0 bg-gradient-to-br from-primary-50 via-white to-amber-50/60 dark:from-primary-900/10 dark:via-secondary-900 dark:to-amber-950/10"></div>
            <div class="absolute -right-20 -top-24 h-72 w-72 rounded-full bg-primary-200/30 blur-3xl dark:bg-primary-800/10"></div>

            <div class="relative mx-auto max-w-6xl px-4 py-7 sm:px-6 sm:py-9 lg:px-8">
                <nav aria-label="Breadcrumb" class="flex items-center gap-2 overflow-hidden text-xs text-neutral-500 dark:text-neutral-400">
                    <a href="{{ route('dashboard') }}" class="shrink-0 transition-colors hover:text-primary dark:hover:text-primary-400">Dashboard</a>
                    <svg class="h-3 w-3 shrink-0 text-neutral-300 dark:text-secondary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m9 5 7 7-7 7" />
                    </svg>
                    <a href="{{ route('dashboard.invitations.guests.index', $invitation) }}" class="truncate transition-colors hover:text-primary dark:hover:text-primary-400">Tamu undangan</a>
                    <svg class="h-3 w-3 shrink-0 text-neutral-300 dark:text-secondary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m9 5 7 7-7 7" />
                    </svg>
                    <span class="shrink-0 font-semibold text-secondary-700 dark:text-neutral-200">Tambah tamu</span>
                </nav>

                <div class="mt-5 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 text-white shadow-lg shadow-primary-500/20">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 18.72a9.094 9.094 0 0 0 3.742-.479 3 3 0 0 0-4.682-2.72m.94 3.198v.001c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.203-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.94-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.06 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197A5.971 5.971 0 0 0 6 18.719m6-8.969a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm6-1.5a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Zm-12 0a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary-600 dark:text-primary-400">Daftar tamu</p>
                            <h1 class="mt-1 font-heading text-2xl font-bold text-secondary-900 dark:text-white sm:text-3xl">Tambah tamu baru</h1>
                            <p class="mt-1.5 text-sm leading-6 text-neutral-500 dark:text-neutral-400">Siapkan nama penerima dan tujuan undangannya.</p>
                        </div>
                    </div>

                    <a href="{{ route('dashboard.invitations.guests.index', $invitation) }}" class="inline-flex w-fit items-center gap-2 rounded-xl border border-neutral-200 bg-white/80 px-4 py-2.5 text-xs font-bold text-secondary-700 shadow-sm transition hover:bg-white dark:border-secondary-700 dark:bg-secondary-800/80 dark:text-neutral-200 dark:hover:bg-secondary-800">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10 19-7-7m0 0 7-7m-7 7h18" />
                        </svg>
                        Kembali ke daftar tamu
                    </a>
                </div>
            </div>
        </header>

        <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
            <form action="{{ route('dashboard.invitations.guests.store', $invitation) }}" method="POST" class="grid gap-6 lg:grid-cols-12 lg:items-start">
                @csrf

                <div class="space-y-6 lg:col-span-8">
                    <section aria-labelledby="identity-heading" class="overflow-hidden rounded-3xl border border-neutral-200 bg-white shadow-sm dark:border-secondary-700 dark:bg-secondary-800">
                        <div class="flex items-start gap-3 border-b border-neutral-100 px-5 py-4 dark:border-secondary-700 sm:px-6">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-primary-50 text-primary dark:bg-primary-900/30 dark:text-primary-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                            <div>
                                <h2 id="identity-heading" class="text-sm font-bold text-secondary-900 dark:text-white">Informasi utama</h2>
                                <p class="mt-0.5 text-xs leading-5 text-neutral-500 dark:text-neutral-400">Nama akan ditampilkan sebagai sapaan pada halaman undangan.</p>
                            </div>
                        </div>

                        <div class="grid gap-5 p-5 sm:p-6 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <div class="flex items-center justify-between gap-3">
                                    <label for="name" class="text-xs font-bold text-secondary-700 dark:text-neutral-200">Nama tamu</label>
                                    <span class="rounded-full bg-red-50 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-red-600 dark:bg-red-950/30 dark:text-red-400">Wajib</span>
                                </div>
                                <div class="relative mt-2">
                                    <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Contoh: Bapak Budi Santoso" class="block w-full rounded-2xl border-neutral-300 bg-white py-3.5 pl-12 pr-4 text-sm text-secondary-900 shadow-sm transition placeholder:text-neutral-300 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 dark:border-secondary-600 dark:bg-secondary-900 dark:text-white dark:placeholder:text-secondary-600" />
                                </div>
                                <p class="mt-2 text-xs leading-5 text-neutral-500 dark:text-neutral-400">Sertakan sapaan seperti Bapak, Ibu, Saudara, atau Saudari bila diperlukan.</p>
                                @error('name')
                                    <p class="mt-2 flex items-center gap-1.5 text-xs font-medium text-red-600 dark:text-red-400">
                                        <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <div class="flex items-center justify-between gap-3">
                                    <label for="whatsapp_number" class="text-xs font-bold text-secondary-700 dark:text-neutral-200">Nomor WhatsApp</label>
                                    <span class="text-[11px] font-medium text-neutral-400 dark:text-neutral-500">Opsional</span>
                                </div>
                                <div class="relative mt-2">
                                    <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-emerald-500" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z" />
                                    </svg>
                                    <input type="tel" inputmode="tel" autocomplete="tel" name="whatsapp_number" id="whatsapp_number" value="{{ old('whatsapp_number') }}" placeholder="Contoh: 0812 3456 7890" class="block w-full rounded-2xl border-neutral-300 bg-white py-3.5 pl-12 pr-4 text-sm text-secondary-900 shadow-sm transition placeholder:text-neutral-300 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 dark:border-secondary-600 dark:bg-secondary-900 dark:text-white dark:placeholder:text-secondary-600" />
                                </div>
                                <p class="mt-2 text-xs leading-5 text-neutral-500 dark:text-neutral-400">Dipakai untuk mengirim tautan undangan langsung dari daftar tamu.</p>
                                @error('whatsapp_number')
                                    <p class="mt-2 text-xs font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <section aria-labelledby="group-heading" class="overflow-hidden rounded-3xl border border-neutral-200 bg-white shadow-sm dark:border-secondary-700 dark:bg-secondary-800">
                        <div class="flex items-start gap-3 border-b border-neutral-100 px-5 py-4 dark:border-secondary-700 sm:px-6">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600 dark:bg-violet-900/30 dark:text-violet-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.568 3.75h4.864c.71 0 1.374.355 1.768.946l3.18 4.77c.273.41.418.89.418 1.382v5.902A3.25 3.25 0 0 1 16.548 20H7.452a3.25 3.25 0 0 1-3.25-3.25v-5.902c0-.493.145-.972.418-1.382l3.18-4.77a2.125 2.125 0 0 1 1.768-.946Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 10.5h15M8.25 14.25h7.5" />
                                </svg>
                            </div>
                            <div>
                                <h2 id="group-heading" class="text-sm font-bold text-secondary-900 dark:text-white">Pengelompokan tamu</h2>
                                <p class="mt-0.5 text-xs leading-5 text-neutral-500 dark:text-neutral-400">Kategori membantu menyaring dan mengelola daftar tamu.</p>
                            </div>
                        </div>

                        <div class="p-5 sm:p-6">
                            <div class="flex items-center justify-between gap-3">
                                <label for="guest_category_id" class="text-xs font-bold text-secondary-700 dark:text-neutral-200">Kategori tamu</label>
                                <span class="text-[11px] font-medium text-neutral-400 dark:text-neutral-500">Opsional</span>
                            </div>
                            <div class="relative mt-2">
                                <select name="guest_category_id" id="guest_category_id" class="block w-full rounded-2xl border-neutral-300 bg-white px-4 py-3.5 text-sm text-secondary-900 shadow-sm transition focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 dark:border-secondary-600 dark:bg-secondary-900 dark:text-white">
                                    <option value="">Tanpa kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (string) old('guest_category_id') === (string) $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('guest_category_id')
                                <p class="mt-2 text-xs font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </section>

                    @if($events->isNotEmpty())
                        <fieldset class="overflow-hidden rounded-3xl border border-neutral-200 bg-white shadow-sm dark:border-secondary-700 dark:bg-secondary-800">
                            <div class="flex items-start gap-3 border-b border-neutral-100 px-5 py-4 dark:border-secondary-700 sm:px-6">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5a1.5 1.5 0 0 1 1.5 1.5v12.75a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z" />
                                    </svg>
                                </div>
                                <div>
                                    <legend class="text-sm font-bold text-secondary-900 dark:text-white">Alokasi acara</legend>
                                    <p class="mt-0.5 text-xs leading-5 text-neutral-500 dark:text-neutral-400">Kosongkan pilihan jika tamu diundang ke semua rangkaian acara.</p>
                                </div>
                            </div>

                            <input type="hidden" name="event_ids" value="">
                            <div class="grid gap-3 p-5 sm:grid-cols-2 sm:p-6">
                                @foreach($events as $event)
                                    <label class="group relative flex cursor-pointer items-start gap-3 rounded-2xl border border-neutral-200 bg-neutral-50/70 p-4 transition hover:border-primary-300 hover:bg-primary-50/40 has-[:checked]:border-primary-400 has-[:checked]:bg-primary-50 dark:border-secondary-700 dark:bg-secondary-900/50 dark:hover:border-primary-700 dark:hover:bg-primary-900/10 dark:has-[:checked]:border-primary-700 dark:has-[:checked]:bg-primary-900/20">
                                        <input type="checkbox" name="event_ids[]" value="{{ $event->id }}" {{ in_array($event->id, old('event_ids', [])) ? 'checked' : '' }} class="mt-0.5 rounded-md border-neutral-300 bg-white text-primary shadow-sm focus:ring-primary-500 dark:border-secondary-600 dark:bg-secondary-800" />
                                        <span class="min-w-0">
                                            <span class="block truncate text-sm font-bold text-secondary-800 dark:text-neutral-100">{{ $event->event_title }}</span>
                                            <span class="mt-1 flex items-center gap-1.5 text-xs leading-5 text-neutral-500 dark:text-neutral-400">
                                                <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5a1.5 1.5 0 0 1 1.5 1.5v12.75a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z" /></svg>
                                                {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('d M Y') }}
                                                @if($event->start_time)
                                                    · {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                                                @endif
                                            </span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            @error('event_ids')
                                <p class="px-5 pb-5 text-xs font-medium text-red-600 dark:text-red-400 sm:px-6">{{ $message }}</p>
                            @enderror
                        </fieldset>
                    @endif
                </div>

                <aside class="space-y-6 lg:sticky lg:top-6 lg:col-span-4">
                    <section class="overflow-hidden rounded-3xl border border-neutral-200 bg-white shadow-sm dark:border-secondary-700 dark:bg-secondary-800">
                        <div class="border-b border-neutral-100 p-5 dark:border-secondary-700">
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-primary dark:text-primary-400">Undangan tujuan</p>
                            <h2 class="mt-2 text-lg font-bold text-secondary-900 dark:text-white">{{ $invitation->title }}</h2>
                            <p class="mt-1 text-xs leading-5 text-neutral-500 dark:text-neutral-400">Tamu baru akan langsung masuk ke daftar undangan ini.</p>
                        </div>
                        <div class="space-y-3 p-5 text-xs leading-5 text-neutral-600 dark:text-neutral-300">
                            <div class="flex items-start gap-3">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m5 13 4 4L19 7" /></svg>
                                </span>
                                <p>Link personal tamu dibuat otomatis setelah data disimpan.</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m5 13 4 4L19 7" /></svg>
                                </span>
                                <p>Nomor WhatsApp dapat ditambahkan nanti melalui halaman edit.</p>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-3xl border border-primary-200/80 bg-primary-50/70 p-5 dark:border-primary-800/60 dark:bg-primary-900/15">
                        <div class="flex items-start gap-3">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-primary-100 text-primary-700 dark:bg-primary-900/40 dark:text-primary-300">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 5.25a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0ZM12 2.25v.75m6.364 1.886-.53.53M21 11.25h-.75m-2.416 5.834.53.53M3.75 11.25H3m3.166-5.834-.53-.53m12.728 12.728.53.53M5.636 17.084l-.53.53" /></svg>
                            </div>
                            <div>
                                <h2 class="text-sm font-bold text-primary-900 dark:text-primary-200">Tips penulisan nama</h2>
                                <p class="mt-1 text-xs leading-5 text-primary-800/80 dark:text-primary-300/80">Gunakan nama yang nyaman dibaca dalam sapaan, misalnya “Bapak Budi &amp; Keluarga”.</p>
                            </div>
                        </div>
                    </section>

                    <div class="rounded-3xl border border-neutral-200 bg-white p-5 shadow-sm dark:border-secondary-700 dark:bg-secondary-800">
                        <p class="text-sm font-bold text-secondary-900 dark:text-white">Simpan data tamu?</p>
                        <p class="mt-1 text-xs leading-5 text-neutral-500 dark:text-neutral-400">Pastikan nama sudah sesuai sebelum membuat tautan personal.</p>
                        <div class="mt-4 grid grid-cols-2 gap-3">
                            <a href="{{ route('dashboard.invitations.guests.index', $invitation) }}" class="inline-flex items-center justify-center rounded-xl border border-neutral-200 px-4 py-2.5 text-sm font-bold text-neutral-600 transition hover:bg-neutral-50 dark:border-secondary-600 dark:text-neutral-300 dark:hover:bg-secondary-700">Batal</a>
                            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary-500 to-primary-700 px-4 py-2.5 text-sm font-bold text-white shadow-md shadow-primary-500/15 transition hover:-translate-y-0.5 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m5 13 4 4L19 7" /></svg>
                                Simpan
                            </button>
                        </div>
                    </div>
                </aside>
            </form>
        </div>
    </div>
</x-app-layout>
