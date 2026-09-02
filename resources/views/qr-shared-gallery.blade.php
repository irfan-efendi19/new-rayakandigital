<x-qr-page-layout
    :title="'Galeri Bersama — '.$invitation->couple_name"
    :description="'Bagikan foto yang Anda ambil di acara '.$invitation->couple_name.'.'"
    section="Galeri Momen Acara"
    heading="Satu acara, banyak sudut pandang."
    intro="Punya foto bagus, candid, atau momen yang mungkin terlewat oleh fotografer? Titipkan di album bersama."
    :couple="$invitation->couple_name"
    :back-url="route('invitation.show', $invitation->slug)"
    wide
>
    <div class="qr-content">
        @if ($officialGalleryUrl)
            <aside class="qr-drive" aria-labelledby="official-gallery-title">
                <div>
                    <p class="qr-label">Dokumentasi resmi</p>
                    <h2 id="official-gallery-title" class="qr-drive__title">Album dari fotografer</h2>
                    <p class="qr-drive__copy">Foto pilihan dan hasil akhir dari tim dokumentasi tersedia di tautan terpisah.</p>
                </div>
                <a href="{{ $officialGalleryUrl }}" target="_blank" rel="noopener noreferrer"
                    class="qr-button qr-button--primary">
                    Buka album
                </a>
            </aside>
        @endif

        <div class="qr-split mt-10">
            <section aria-labelledby="upload-title">
                <div class="qr-section__heading">
                    <div>
                        <p class="qr-label">Kontribusi Anda</p>
                        <h2 id="upload-title" class="qr-section-title">Tambahkan satu foto</h2>
                    </div>
                </div>

                @if (session('success'))
                    <div class="mb-5 border-l-[3px] border-emerald-500 bg-emerald-50 px-4 py-3 text-xs text-emerald-800 dark:bg-emerald-950/20 dark:text-emerald-300" role="status">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="qr-feedback qr-feedback--error is-visible mb-5" role="alert">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('qr-shared-gallery.upload', $invitation->slug) }}" method="POST"
                    enctype="multipart/form-data" class="qr-form" data-gallery-form>
                    @csrf

                    <label for="shared-photo" class="qr-dropzone">
                        <input id="shared-photo" type="file" name="photo"
                            accept="image/jpeg,image/png,image/webp" class="sr-only" required data-photo-input>

                        <span class="qr-dropzone__prompt" data-dropzone-prompt>
                            <strong>Pilih foto dari perangkat</strong>
                            <span>JPG, PNG, atau WEBP · maksimum 10 MB</span>
                        </span>

                        <span class="hidden qr-dropzone__preview" data-dropzone-preview>
                            <img src="" alt="Pratinjau foto yang dipilih" data-preview-image>
                            <p data-file-name></p>
                        </span>
                    </label>

                    <div class="qr-form__row">
                        <div class="qr-field">
                            <label for="gallery-name" class="qr-field__label">
                                Nama <span class="qr-field__optional">· opsional</span>
                            </label>
                            <input id="gallery-name" type="text" name="guest_name" maxlength="255"
                                value="{{ old('guest_name') }}" placeholder="Contoh: Andi & keluarga" class="qr-input">
                        </div>
                        <div class="qr-field">
                            <label for="gallery-caption" class="qr-field__label">
                                Cerita singkat <span class="qr-field__optional">· opsional</span>
                            </label>
                            <input id="gallery-caption" type="text" name="caption" maxlength="500"
                                value="{{ old('caption') }}" placeholder="Apa yang terjadi di foto ini?" class="qr-input">
                        </div>
                    </div>

                    <button type="submit" class="qr-button qr-button--primary" data-gallery-submit>
                        Unggah foto
                    </button>
                    <p class="text-[10px] leading-4 text-neutral-400 dark:text-neutral-500">
                        Unggah hanya foto yang pantas dilihat oleh kedua mempelai dan tamu lain.
                    </p>
                </form>
            </section>

            <section aria-labelledby="shared-photos-title">
                <div class="qr-section__heading">
                    <div>
                        <p class="qr-label">Dari para tamu</p>
                        <h2 id="shared-photos-title" class="qr-section-title">Foto yang sudah terkumpul</h2>
                    </div>
                    <span class="qr-count">{{ $photos->count() }}</span>
                </div>

                @if ($photos->isNotEmpty())
                    <div class="qr-photo-grid">
                        @foreach ($photos as $photo)
                            <figure class="qr-photo">
                                <a href="{{ $photo->url }}" target="_blank" rel="noopener noreferrer">
                                    <img src="{{ $photo->url }}"
                                        alt="{{ $photo->caption ?: 'Foto dari '.($photo->guest_name ?: 'tamu undangan') }}"
                                        loading="lazy">
                                </a>
                                <figcaption>
                                    <p class="qr-photo__name">{{ $photo->guest_name ?: 'Tamu undangan' }}</p>
                                    @if ($photo->caption)
                                        <p class="qr-photo__caption">{{ $photo->caption }}</p>
                                    @endif
                                </figcaption>
                            </figure>
                        @endforeach
                    </div>
                @else
                    <div class="qr-empty">
                        <h3 class="qr-empty__title">Albumnya masih kosong.</h3>
                        <p class="qr-empty__copy">Kalau Anda punya fotonya, mulai album bersama ini.</p>
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-qr-page-layout>
