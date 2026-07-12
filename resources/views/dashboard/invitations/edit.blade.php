<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-heading text-2xl font-bold text-secondary-800 dark:text-neutral-100">
                    Edit Undangan
                </h2>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">
                    {{ $invitation->title }}
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <a href="{{ route('dashboard.invitations.show', $invitation) }}"
                    class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-4 py-2 text-sm font-semibold text-neutral-600 dark:text-neutral-400 bg-white dark:bg-secondary-800 border border-neutral-300 dark:border-neutral-600 rounded-xl hover:bg-neutral-50 dark:hover:bg-secondary-700 hover:border-primary-300 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <style>
    #crop-container {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    #crop-container cropper-canvas {
        flex: 1;
        min-height: 0;
    }

    .scrollbar-thin::-webkit-scrollbar {
        height: 6px;
    }

    .scrollbar-thin::-webkit-scrollbar-track {
        background: transparent;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb {
        background-color: rgb(226, 232, 240);
        border-radius: 10px;
    }

    .dark .scrollbar-thin::-webkit-scrollbar-thumb {
        background-color: rgb(51, 65, 85);
    }

    [x-cloak] {
        display: none !important;
    }
    </style>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-secondary-800 rounded-2xl shadow-soft border border-neutral-100 dark:border-secondary-700 overflow-hidden">
                <div class="p-6 md:p-8">
                    <form id="invitation-form" action="{{ route('dashboard.invitations.update', $invitation) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="title" value="{{ old('title', $invitation->title) }}">

                        <div class="space-y-8">

                            {{-- Package Status --}}
                            @php
                                $tierCode = $invitation->currentTier();
                                $tierBadgeColor = match ($tierCode) {
                                    'bronze' => 'bg-orange-100 dark:bg-orange-900/50 text-orange-700
                                                            dark:text-orange-300
                                                            border-orange-200 dark:border-orange-800',
                                    'silver' => 'bg-neutral-100 dark:bg-neutral-700 text-neutral-700
                                                            dark:text-neutral-300
                                                            border-neutral-200 dark:border-neutral-600',
                                    'gold' => 'bg-amber-100 dark:bg-amber-900/50 text-amber-700
                                                            dark:text-amber-300
                                                            border-amber-200 dark:border-amber-800',
                                    'platinum' => 'bg-primary-100 dark:bg-primary-900/50
                                                            text-primary-700 dark:text-primary-300
                                                            border-primary-200 dark:border-primary-800',
                                    default => 'bg-neutral-100 dark:bg-neutral-700 text-neutral-500
                                                            dark:text-neutral-400
                                                            border-neutral-200 dark:border-neutral-600'
                                };
                                $isExpired = $invitation->isTrialExpired();
                                $isTrial = $invitation->expires_at !== null &&
                                    !$invitation->hasPremiumFeatures();
                                $daysLeft = $invitation->expires_at ? (int) 
                                    max(
                                        0,
                                        now()->diffInDays(
                                            $invitation->expires_at,
                                            false
                                        )
                                    ) : null;
                            @endphp
                            <div
                                class="bg-white dark:bg-secondary-800 border rounded-2xl p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 {{ $isExpired ? 'border-red-200 dark:border-red-800 bg-red-50/50 dark:bg-red-900/10' : ($isTrial ? 'border-amber-200 dark:border-amber-800 bg-amber-50/50 dark:bg-amber-900/10' : 'border-neutral-200 dark:border-neutral-700') }}">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center
                                        {{ $isExpired ? 'bg-red-100 dark:bg-red-900/50 text-red-500' : ($isTrial ? 'bg-amber-100 dark:bg-amber-900/50 text-amber-500' : 'bg-primary-100 dark:bg-primary-900/50 text-primary') }}">
                                        @if($isExpired)
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="font-heading text-base font-bold text-secondary-800 dark:text-neutral-100">Paket</span>
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold uppercase tracking-wider {{ $tierBadgeColor }}">
                                                {{ $tierCode === 'free' ? 'Gratis' : $tierCode }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">
                                            @if($isExpired)
                                                Undangan telah kedaluwarsa.
                                            @elseif($invitation->expires_at)
                                                @if($isTrial)
                                                    Masa percobaan tersisa
                                                    <strong>{{ $daysLeft }}
                                                        hari</strong>.
                                                @else
                                                    Aktif hingga
                                                    <strong>{{ $invitation->expires_at->format('d F Y') }}</strong>
                                                    @if(
                                                            $daysLeft !== null &&
                                                            $daysLeft > 0
                                                        )
                                                        ({{ $daysLeft }} hari lagi)
                                                    @endif
                                                @endif
                                            @else
                                                Paket aktif tanpa batas
                                                waktu.
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                @if(!$isExpired && $tierCode === 'free')
                                    <a href="{{ route('dashboard.checkout', ['invitation_id' => $invitation->id]) }}"
                                        class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-primary to-primary-600 rounded-xl hover:shadow-md hover:scale-[1.02] active:scale-[0.98] transition-all flex-shrink-0">
                                        Upgrade
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </a>
                                @endif
                            </div>

                            {{-- ======================================== --}}
                            {{-- Section 1: Informasi Dasar & Identitas --}}
                            {{-- ======================================== --}}
                            <div class="border-b border-neutral-200 dark:border-secondary-700 pb-8">
                                <div class="flex items-center gap-3 mb-1">
                                    <span
                                        class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary-100 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 text-sm font-bold">1</span>
                                    <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">
                                        Informasi Dasar & Identitas</h3>
                                </div>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">
                                    Data lengkap kedua
                                    mempelai untuk ditampilkan di
                                    undangan.</p>

                                <div x-data="{
                                    order: '{{ $invitation->bride_groom_order ?? 'male_first' }}',
                                    toggleOrder() { this.order = this.order === 'male_first' ? 'female_first' : 'male_first'; }
                                }" class="flex flex-col gap-6">

                                    <input type="hidden" name="bride_groom_order" :value="order">

                                    {{-- Swap Button --}}
                                    <div class="flex justify-center -mb-2">
                                        <button @click="toggleOrder" type="button"
                                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-xl text-primary-700 dark:text-primary-300 bg-primary-50 dark:bg-primary-900/50 hover:bg-primary-100 dark:hover:bg-primary-900/70 transition">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                            </svg>
                                            Tukar Posisi
                                        </button>
                                    </div>

                                    {{-- Bride --}}
                                    <div :style="order === 'female_first' ? { order: 1 } : { order: 2 }"
                                        class="bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 space-y-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary dark:text-primary-400">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <h4 class="font-semibold text-sm text-primary-700 dark:text-primary-300">
                                                Mempelai Wanita</h4>
                                        </div>
                                        <div class="grid grid-cols-1 gap-y-5 gap-x-4 sm:grid-cols-6">
                                            <div class="sm:col-span-3">
                                                <label for="bride_name"
                                                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama
                                                    Lengkap Mempelai
                                                    Wanita</label>
                                                <input type="text" name="bride_name" id="bride_name"
                                                    value="{{ old('bride_name', $invitation->bride_name) }}"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    required>
                                                @error('bride_name')
                                                    <span
                                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="bride_nickname"
                                                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama
                                                    Panggilan</label>
                                                <input type="text" name="bride_nickname" id="bride_nickname"
                                                    value="{{ old('bride_nickname', $invitation->bride_nickname) }}"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200">
                                                @error('bride_nickname')
                                                    <span
                                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="bride_father_name"
                                                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama
                                                    Ayah</label>
                                                <input type="text" name="bride_father_name" id="bride_father_name"
                                                    value="{{ old('bride_father_name', $invitation->bride_father_name) }}"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="Nama Ayah Mempelai Wanita">
                                                @error('bride_father_name')
                                                    <span
                                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="bride_mother_name"
                                                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama
                                                    Ibu</label>
                                                <input type="text" name="bride_mother_name" id="bride_mother_name"
                                                    value="{{ old('bride_mother_name', $invitation->bride_mother_name) }}"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="Nama Ibu Mempelai Wanita">
                                                @error('bride_mother_name')
                                                    <span
                                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-6">
                                                <label
                                                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Foto
                                                    Mempelai
                                                    Wanita</label>
                                                <div class="mt-2 flex items-center gap-4">
                                                    <div class="relative flex-shrink-0">
                                                        <img id="bride-preview"
                                                            src="{{ $invitation->bride_photo ? asset('storage/' . $invitation->bride_photo) : '' }}"
                                                            alt="Bride photo"
                                                            class="w-16 h-16 object-cover rounded-full border-2 border-neutral-200 dark:border-neutral-600 {{ $invitation->bride_photo ? '' : 'hidden' }}">
                                                        <div id="bride-preview-placeholder"
                                                            class="w-16 h-16 bg-neutral-200 dark:bg-secondary-700 rounded-full flex items-center justify-center text-neutral-500 dark:text-neutral-400 text-xs font-semibold {{ $invitation->bride_photo ? 'hidden' : '' }}">
                                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="1.5"
                                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <input type="file" name="bride_photo" id="bride_photo_input"
                                                            class="crop-file-input hidden" accept="image/*"
                                                            data-preview="bride-preview">
                                                        <button type="button" data-crop-target="bride_photo_input"
                                                            class="px-4 py-2 bg-primary-50 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 rounded-xl text-sm font-semibold hover:bg-primary-100 dark:hover:bg-primary-900/70 transition">
                                                            Pilih & Crop
                                                            Foto
                                                        </button>
                                                        <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">
                                                            Format
                                                            gambar apa
                                                            pun. Hasil
                                                            potongan
                                                            berbentuk
                                                            persegi.</p>
                                                    </div>
                                                </div>
                                                @error('bride_photo')
                                                    <span
                                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Groom --}}
                                    <div :style="order === 'male_first' ? { order: 1 } : { order: 2 }"
                                        class="bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 space-y-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary dark:text-primary-400">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <h4 class="font-semibold text-sm text-primary-700 dark:text-primary-300">
                                                Mempelai Pria</h4>
                                        </div>
                                        <div class="grid grid-cols-1 gap-y-5 gap-x-4 sm:grid-cols-6">
                                            <div class="sm:col-span-3">
                                                <label for="groom_name"
                                                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama
                                                    Lengkap Mempelai
                                                    Pria</label>
                                                <input type="text" name="groom_name" id="groom_name"
                                                    value="{{ old('groom_name', $invitation->groom_name) }}"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    required>
                                                @error('groom_name')
                                                    <span
                                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="groom_nickname"
                                                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama
                                                    Panggilan</label>
                                                <input type="text" name="groom_nickname" id="groom_nickname"
                                                    value="{{ old('groom_nickname', $invitation->groom_nickname) }}"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200">
                                                @error('groom_nickname')
                                                    <span
                                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="groom_father_name"
                                                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama
                                                    Ayah</label>
                                                <input type="text" name="groom_father_name" id="groom_father_name"
                                                    value="{{ old('groom_father_name', $invitation->groom_father_name) }}"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="Nama Ayah Mempelai Pria">
                                                @error('groom_father_name')
                                                    <span
                                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="groom_mother_name"
                                                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama
                                                    Ibu</label>
                                                <input type="text" name="groom_mother_name" id="groom_mother_name"
                                                    value="{{ old('groom_mother_name', $invitation->groom_mother_name) }}"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="Nama Ibu Mempelai Pria">
                                                @error('groom_mother_name')
                                                    <span
                                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-6">
                                                <label
                                                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Foto
                                                    Mempelai
                                                    Pria</label>
                                                <div class="mt-2 flex items-center gap-4">
                                                    <div class="relative flex-shrink-0">
                                                        <img id="groom-preview"
                                                            src="{{ $invitation->groom_photo ? asset('storage/' . $invitation->groom_photo) : '' }}"
                                                            alt="Groom photo"
                                                            class="w-16 h-16 object-cover rounded-full border-2 border-neutral-200 dark:border-neutral-600 {{ $invitation->groom_photo ? '' : 'hidden' }}">
                                                        <div id="groom-preview-placeholder"
                                                            class="w-16 h-16 bg-neutral-200 dark:bg-secondary-700 rounded-full flex items-center justify-center text-neutral-500 dark:text-neutral-400 text-xs font-semibold {{ $invitation->groom_photo ? 'hidden' : '' }}">
                                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="1.5"
                                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <input type="file" name="groom_photo" id="groom_photo_input"
                                                            class="crop-file-input hidden" accept="image/*"
                                                            data-preview="groom-preview">
                                                        <button type="button" data-crop-target="groom_photo_input"
                                                            class="px-4 py-2 bg-primary-50 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 rounded-xl text-sm font-semibold hover:bg-primary-100 dark:hover:bg-primary-900/70 transition">
                                                            Pilih & Crop
                                                            Foto
                                                        </button>
                                                        <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">
                                                            Format
                                                            gambar apa
                                                            pun. Hasil
                                                            potongan
                                                            berbentuk
                                                            persegi.</p>
                                                    </div>
                                                </div>
                                                @error('groom_photo')
                                                    <span
                                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ======================================== --}}
                            {{-- Section 2: Waktu Tempat & Akses Undangan --}}
                            {{-- ======================================== --}}
                            <div class="border-b border-neutral-200 dark:border-secondary-700 pb-8">
                                <div class="flex items-center gap-3 mb-1">
                                    <span
                                        class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary-100 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 text-sm font-bold">2</span>
                                    <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">
                                        Waktu Tempat & Akses Undangan
                                    </h3>
                                </div>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">
                                    Atur jadwal acara,
                                    lokasi, dan tautan undangan.</p>

                                {{-- Event Details --}}
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
                                    <h4
                                        class="font-heading text-base font-bold text-secondary-800 dark:text-neutral-100">
                                        Waktu & Tempat</h4>
                                </div>

                                @error('events') <span
                                    class="text-red-500 dark:text-red-400 text-xs block mb-3">{{ $message }}</span>
                                @enderror

                                <input type="hidden" name="events_enabled" value="1">

                                <div id="events-container" class="space-y-4">
                                    @php
                                        $eventCollection = old('events') ?
                                            array_values(old('events')) :
                                            $invitation->events;
                                    @endphp
                                    @foreach($eventCollection as $eventIdx => $event)
                                        @php
                                            if (is_array($event)) {
                                                $event = (object) $event;
                                            }
                                        @endphp
                                        <div
                                            class="event-card bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700">
                                            <input type="hidden" name="events[{{ $eventIdx }}][id]"
                                                value="{{ $event->id ?? '' }}">
                                            <div class="flex items-center justify-between flex-wrap gap-2 mb-4">
                                                <div class="flex items-center gap-2">
                                                    <div
                                                        class="w-7 h-7 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                    <h4
                                                        class="font-semibold text-sm text-primary-700 dark:text-primary-300">
                                                        Acara
                                                        #{{ $loop->iteration }}
                                                    </h4>
                                                </div>
                                                <div class="flex items-center gap-1">
                                                    <button type="button"
                                                        class="move-up p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-600 dark:hover:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-secondary-600 rounded-lg transition"
                                                        title="Pindah ke atas">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 15l7-7 7 7" />
                                                        </svg>
                                                    </button>
                                                    <button type="button"
                                                        class="move-down p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-600 dark:hover:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-secondary-600 rounded-lg transition"
                                                        title="Pindah ke bawah">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M19 9l-7 7-7-7" />
                                                        </svg>
                                                    </button>
                                                    <button type="button"
                                                        class="remove-event ml-1 p-1.5 text-red-400 dark:text-red-400 hover:text-red-600 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition"
                                                        title="Hapus acara">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6">
                                                <div class="sm:col-span-6">
                                                    <label
                                                        class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama
                                                        Acara</label>
                                                    <input type="text" name="events[{{ $eventIdx }}][event_title]"
                                                        value="{{ old('events.' . $eventIdx . '.event_title', $event->event_title ?? '') }}"
                                                        list="event-titles-{{ $eventIdx }}"
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                        placeholder="Pilih atau ketik nama acara" required>
                                                    <datalist id="event-titles-{{ $eventIdx }}">
                                                        <option value="Akad Nikah">
                                                        <option value="Resepsi">
                                                        <option value="Pengajian">
                                                        <option value="Unduh Mantu">
                                                    </datalist>
                                                </div>
                                                <div class="sm:col-span-2">
                                                    <label
                                                        class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Tanggal
                                                        Acara</label>
                                                    <input type="date" name="events[{{ $eventIdx }}][event_date]"
                                                        value="{{ old('events.' . $eventIdx . '.event_date', $event->event_date instanceof \Carbon\Carbon ? $event->event_date->format('Y-m-d') : ($event->event_date ?? '')) }}"
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                        required>
                                                </div>
                                                <div class="sm:col-span-2">
                                                    <label
                                                        class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Jam
                                                        Mulai</label>
                                                    <input type="time" name="events[{{ $eventIdx }}][start_time]"
                                                        value="{{ old('events.' . $eventIdx . '.start_time', $event->start_time ?? '') }}"
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                        required>
                                                </div>
                                                <div class="sm:col-span-2">
                                                    <label
                                                        class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Jam
                                                        Selesai</label>
                                                    <input type="time" name="events[{{ $eventIdx }}][end_time]"
                                                        value="{{ old('events.' . $eventIdx . '.end_time', $event->end_time ?? '') }}"
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200">
                                                    <div class="mt-1.5 flex items-center">
                                                        <input type="hidden"
                                                            name="events[{{ $eventIdx }}][is_until_finished]" value="0">
                                                        <input type="checkbox"
                                                            name="events[{{ $eventIdx }}][is_until_finished]" value="1"
                                                            {{ old('events.' . $eventIdx . '.is_until_finished', $event->is_until_finished ?? false) ? 'checked' : '' }}
                                                            class="h-4 w-4 rounded border-neutral-300 dark:border-neutral-600 text-primary-600 dark:text-primary-400 focus:ring-primary-500">
                                                        <label
                                                            class="ml-2 text-xs text-neutral-500 dark:text-neutral-400">Sampai
                                                            Selesai</label>
                                                    </div>
                                                </div>
                                                <div class="sm:col-span-6">
                                                    <label
                                                        class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama
                                                        Tempat /
                                                        Lokasi</label>
                                                    <input type="text" name="events[{{ $eventIdx }}][place_name]"
                                                        value="{{ old('events.' . $eventIdx . '.place_name', $event->place_name ?? '') }}"
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                        placeholder="Nama gedung atau lokasi" required>
                                                </div>
                                                <div class="sm:col-span-6">
                                                    <label
                                                        class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Alamat
                                                        Lengkap</label>
                                                    <textarea name="events[{{ $eventIdx }}][place_address]" rows="2"
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                        placeholder="Alamat lengkap lokasi"
                                                        required>{{ old('events.' . $eventIdx . '.place_address', $event->place_address ?? '') }}</textarea>
                                                </div>
                                                <div class="sm:col-span-6">
                                                    <label
                                                        class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Link
                                                        Google Maps</label>
                                                    <input type="url" name="events[{{ $eventIdx }}][google_maps_url]"
                                                        value="{{ old('events.' . $eventIdx . '.google_maps_url', $event->google_maps_url ?? '') }}"
                                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                        placeholder="https://goo.gl/maps/...">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                 </div>

                                <button type="button" id="add-event-btn"
                                    class="inline-flex items-center justify-center gap-1.5 w-full sm:w-auto px-4 py-2 mt-5 text-sm font-semibold rounded-xl text-primary-700 dark:text-primary-300 bg-primary-50 dark:bg-primary-900/50 hover:bg-primary-100 dark:hover:bg-primary-900/70 transition">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Tambah Acara
                                </button>

                                {{-- Template for new event card (hidden, cloned by JS) --}}
                                <template id="event-card-template">
                                    <div
                                        class="event-card bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700">
                                        <input type="hidden" name="events[__INDEX__][id]" value="">
                                        <div class="flex items-center justify-between flex-wrap gap-2 mb-4">
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class="w-7 h-7 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                <h4
                                                    class="font-semibold text-sm text-primary-700 dark:text-primary-300">
                                                    Acara Baru</h4>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <button type="button"
                                                    class="move-up p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-600 dark:hover:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-secondary-600 rounded-lg transition"
                                                    title="Pindah ke atas">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 15l7-7 7 7" />
                                                    </svg>
                                                </button>
                                                <button type="button"
                                                    class="move-down p-1.5 text-neutral-400 dark:text-neutral-500 hover:text-neutral-600 dark:hover:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-secondary-600 rounded-lg transition"
                                                    title="Pindah ke bawah">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </button>
                                                <button type="button"
                                                    class="remove-event ml-1 p-1.5 text-red-400 dark:text-red-400 hover:text-red-600 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition"
                                                    title="Hapus acara">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6">
                                            <div class="sm:col-span-6">
                                                <label
                                                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama
                                                    Acara</label>
                                                <input type="text" name="events[__INDEX__][event_title]" value=""
                                                    list="event-titles-__INDEX__"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="Pilih atau ketik nama acara" required>
                                                <datalist id="event-titles-__INDEX__">
                                                    <option value="Akad Nikah">
                                                    <option value="Resepsi">
                                                    <option value="Pengajian">
                                                    <option value="Unduh Mantu">
                                                </datalist>
                                            </div>
                                            <div class="sm:col-span-2">
                                                <label
                                                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Tanggal
                                                    Acara</label>
                                                <input type="date" name="events[__INDEX__][event_date]" value=""
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    required>
                                            </div>
                                            <div class="sm:col-span-2">
                                                <label
                                                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Jam
                                                    Mulai</label>
                                                <input type="time" name="events[__INDEX__][start_time]" value=""
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    required>
                                            </div>
                                            <div class="sm:col-span-2">
                                                <label
                                                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Jam
                                                    Selesai</label>
                                                <input type="time" name="events[__INDEX__][end_time]" value=""
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200">
                                                <div class="mt-1.5 flex items-center">
                                                    <input type="hidden" name="events[__INDEX__][is_until_finished]"
                                                        value="0">
                                                    <input type="checkbox" name="events[__INDEX__][is_until_finished]"
                                                        value="1"
                                                        class="h-4 w-4 rounded border-neutral-300 dark:border-neutral-600 text-primary-600 dark:text-primary-400 focus:ring-primary-500">
                                                    <label
                                                        class="ml-2 text-xs text-neutral-500 dark:text-neutral-400">Sampai
                                                        Selesai</label>
                                                </div>
                                            </div>
                                            <div class="sm:col-span-6">
                                                <label
                                                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama
                                                    Tempat /
                                                    Lokasi</label>
                                                <input type="text" name="events[__INDEX__][place_name]" value=""
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="Nama gedung atau lokasi" required>
                                            </div>
                                            <div class="sm:col-span-6">
                                                <label
                                                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Alamat
                                                    Lengkap</label>
                                                <textarea name="events[__INDEX__][place_address]" rows="2"
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="Alamat lengkap lokasi" required></textarea>
                                            </div>
                                            <div class="sm:col-span-6">
                                                <label
                                                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Link
                                                    Google Maps</label>
                                                <input type="url" name="events[__INDEX__][google_maps_url]" value=""
                                                    class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="https://goo.gl/maps/...">
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <div class="mt-6">
                                    <label for="timezone"
                                        class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Zona
                                        Waktu</label>
                                    <select name="timezone" id="timezone"
                                        class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200">
                                        <option value="Asia/Jakarta"
                                            {{ old('timezone', $invitation->timezone) == 'Asia/Jakarta' ? 'selected' : '' }}>
                                            WIB (Waktu Indonesia Barat)
                                        </option>
                                        <option value="Asia/Makassar"
                                            {{ old('timezone', $invitation->timezone) == 'Asia/Makassar' ? 'selected' : '' }}>
                                            WITA (Waktu Indonesia
                                            Tengah)
                                        </option>
                                        <option value="Asia/Jayapura"
                                            {{ old('timezone', $invitation->timezone) == 'Asia/Jayapura' ? 'selected' : '' }}>
                                            WIT (Waktu Indonesia Timur)
                                        </option>
                                    </select>
                                    @error('timezone') <span
                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Custom URL / Slug --}}
                                <div class="mt-6">
                                    <h4
                                        class="font-heading text-base font-bold text-secondary-800 dark:text-neutral-100 mb-1">
                                        Tautan Undangan</h4>
                                    <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">
                                        Sesuaikan tautan
                                        undangan Anda.</p>

                                    <div
                                        class="bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 space-y-4">
                                        <div>
                                            <label for="slug-input"
                                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Tautan
                                                Kustom</label>
                                            <div class="mt-1.5 flex items-stretch gap-0">
                                                <span
                                                    class="inline-flex items-center px-3 rounded-l-xl border border-r-0 border-neutral-300 dark:border-neutral-600 bg-neutral-100 dark:bg-secondary-700 text-sm text-neutral-500 dark:text-neutral-400 whitespace-nowrap">{{ parse_url(config('app.url'), PHP_URL_HOST) }}/</span>
                                                <input type="text" name="slug" id="slug-input"
                                                    value="{{ old('slug', $invitation->slug) }}"
                                                    data-original="{{ $invitation->slug }}"
                                                    data-id="{{ $invitation->id }}"
                                                    class="block w-full rounded-r-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm font-mono dark:bg-secondary-700 dark:text-neutral-200"
                                                    placeholder="nama-undangan-anda" maxlength="100"
                                                    pattern="^[a-z0-9\-]+$">
                                            </div>
                                            <div id="slug-indicator"
                                                class="mt-1.5 text-xs flex items-center gap-1.5 text-neutral-400 dark:text-neutral-500">
                                                <span class="slug-icon text-base">🔗</span>
                                                <span class="slug-text">Masukkan
                                                    tautan
                                                    kustom</span>
                                            </div>
                                            @error('slug') <span
                                                class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                            @enderror
                                            <p class="mt-1.5 text-xs text-neutral-400 dark:text-neutral-500">
                                                Huruf
                                                kecil,
                                                angka, dan tanda hubung
                                                (-)</p>
                                        </div>

                                        <div
                                            class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-4">
                                            <div class="flex items-start gap-3">
                                                <span
                                                    class="text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5">⚠</span>
                                                <div>
                                                    <p class="text-xs font-semibold text-amber-800 dark:text-amber-300">
                                                        Perhatian</p>
                                                    <p class="text-xs text-amber-700 dark:text-amber-400 mt-0.5">
                                                        Mengubah
                                                        tautan akan
                                                        membuat tautan
                                                        lama tidak
                                                        bisa diakses.
                                                        Pastikan
                                                        Anda
                                                        belum
                                                        menyebarkan
                                                        tautan lama ke
                                                        tamu
                                                        undangan.</p>
                                                    @if(
                                                            $invitation->slug_change_count
                                                            > 0
                                                        )
                                                        <p class="text-xs text-amber-700 dark:text-amber-400 mt-1">
                                                            Tautan
                                                            telah
                                                            diubah
                                                            {{ $invitation->slug_change_count }}
                                                            kali.
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ======================================== --}}
                            {{-- Section 3: Visual & Estetika --}}
                            {{-- ======================================== --}}
                            <div class="border-b border-neutral-200 dark:border-secondary-700 pb-8">
                                <div class="flex items-center gap-3 mb-1">
                                    <span
                                        class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary-100 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 text-sm font-bold">3</span>
                                    <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">
                                        Visual & Estetika</h3>
                                </div>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">
                                    Atur tampilan visual
                                    undangan, foto sampul, tema, dan
                                    musik latar.</p>

                                {{-- Cover Photo --}}
                                <h4
                                    class="font-heading text-base font-bold text-secondary-800 dark:text-neutral-100 mb-1">
                                    Foto Sampul</h4>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">
                                    Foto sampul akan
                                    ditampilkan di kartu undangan
                                    dashboard. Rasio 9:16
                                    (portrait).</p>

                                <div
                                    class="bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 space-y-4">
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Foto
                                            Sampul</label>
                                        <div class="mt-2 flex flex-col sm:flex-row items-start gap-4">
                                            <div class="relative flex-shrink-0 w-full sm:w-48 max-w-[180px] sm:max-w-none">
                                                <div class="rounded-xl overflow-hidden border-2 border-neutral-200 dark:border-neutral-600"
                                                    style="aspect-ratio:9/16">
                                                    <img id="cover-preview"
                                                        src="{{ $invitation->cover_photo ? asset('storage/' . $invitation->cover_photo) : '' }}"
                                                        alt="Cover photo"
                                                        class="w-full h-full object-cover {{ $invitation->cover_photo ? '' : 'hidden' }}">
                                                    <div id="cover-preview-placeholder"
                                                        class="w-full h-full bg-neutral-200 dark:bg-secondary-700 flex flex-col items-center justify-center text-neutral-500 dark:text-neutral-400 text-xs font-semibold {{ $invitation->cover_photo ? 'hidden' : '' }}">
                                                        <svg class="w-8 h-8 mb-1" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1.5"
                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        <span>Belum
                                                            ada</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <input type="file" name="cover_photo" id="cover_photo_input"
                                                    class="crop-file-input hidden" accept="image/*"
                                                    data-preview="cover-preview" data-aspect-ratio="9/16"
                                                    data-width="360" data-height="640">
                                                <button type="button" data-crop-target="cover_photo_input"
                                                    class="px-4 py-2 bg-primary-50 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 rounded-xl text-sm font-semibold hover:bg-primary-100 dark:hover:bg-primary-900/70 transition">
                                                    Pilih & Crop Foto
                                                </button>
                                                <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">
                                                    Format
                                                    gambar apa pun.
                                                    Hasil potongan rasio
                                                    9:16
                                                    portrait.</p>
                                                @error('cover_photo')
                                                    <span
                                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($invitation->hasFeature('youtube_video'))
                                    <div
                                        class="mt-4 bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 space-y-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <h4 class="font-semibold text-sm text-primary-700 dark:text-primary-300">
                                                Video
                                                YouTube & Live Streaming
                                            </h4>
                                        </div>
                                        <div>
                                            <label for="youtube_url"
                                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Tautan
                                                Video YouTube</label>
                                            <input type="url" name="youtube_url" id="youtube_url"
                                                value="{{ old('youtube_url', $invitation->youtube_url) }}"
                                                class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                placeholder="https://youtube.com/watch?v=... atau https://youtu.be/...">
                                            <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1.5">
                                                Masukkan URL
                                                video YouTube atau siaran
                                                langsung (live streaming).
                                                Mendukung format <span class="font-mono">youtube.com/watch?v=</span>,
                                                <span class="font-mono">youtu.be/</span>,
                                                <span class="font-mono">youtube.com/live/</span>.
                                            </p>
                                            @error('youtube_url') <span
                                                class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        @if($invitation->youtube_video_id)
                                            <div
                                                class="bg-primary-50 dark:bg-primary-900/50 border border-primary-100 dark:border-primary-800/50 rounded-xl p-3 flex items-center gap-3">
                                                <span class="text-primary text-lg">▶</span>
                                                <div>
                                                    <p class="text-xs font-semibold text-primary-700 dark:text-primary-300">
                                                        Video Terdeteksi</p>
                                                    <p class="text-xs text-primary-600 dark:text-primary-400">
                                                        ID:
                                                        {{ $invitation->youtube_video_id }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                     <div
                                         class="mt-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-2xl p-5 flex flex-col sm:flex-row sm:items-center gap-3">
                                         <span class="text-xl flex-shrink-0">✨</span>
                                         <div>
                                             <p class="text-sm font-semibold text-amber-800 dark:text-amber-300">
                                                 Fitur Video
                                                 YouTube & Live Streaming
                                                 Terkunci</p>
                                             <p class="text-xs text-amber-700 dark:text-amber-400">
                                                 Silakan upgrade ke paket
                                                 Gold atau Platinum untuk
                                                 menyematkan video YouTube
                                                 dan siaran langsung di
                                                 halaman undangan Anda.</p>
                                         </div>
                                     </div>
                                 @endif

                                 {{-- Galeri Foto --}}
                                @php $galleryLocked =
                                    !$invitation->hasFeature('gallery_photos');
                                @endphp
                                <div
                                    class="mt-4 bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 space-y-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <h4 class="font-semibold text-sm text-primary-700 dark:text-primary-300">
                                            Galeri
                                            Foto</h4>
                                        @if(!$galleryLocked)
                                            <span
                                                class="ml-auto text-xs text-neutral-500 dark:text-neutral-400 font-semibold">{{ count($invitation->gallery_photos ?? []) }}
                                                /
                                                {{ $invitation->maxGalleryPhotos() }}
                                                Foto</span>
                                        @endif
                                    </div>

                                    @if(!$galleryLocked)
                                        <div class="space-y-6">
                                            <div id="gallery-upload-form" class="space-y-4">
                                                <div id="gallery-dropzone"
                                                    class="relative border-2 border-dashed border-primary-300 dark:border-primary-700 rounded-2xl p-6 text-center cursor-pointer hover:border-primary-400 dark:hover:border-primary-500 hover:bg-primary-50/50 dark:hover:bg-primary-900/20 transition-all duration-200">
                                                    <input type="file" name="photos[]" id="gallery-file-input" multiple
                                                        accept="image/*" class="hidden">
                                                    <div id="dropzone-empty" class="space-y-2">
                                                        <div
                                                            class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-primary-100 dark:bg-primary-900/50 text-primary-600 dark:text-primary-400">
                                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                            </svg>
                                                        </div>
                                                        <p
                                                            class="text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                                            Seret foto ke
                                                            sini atau <span
                                                                class="text-primary-600 dark:text-primary-400 underline">klik
                                                                untuk
                                                                memilih</span>
                                                        </p>
                                                        <p class="text-xs text-neutral-400 dark:text-neutral-500">
                                                            Format
                                                            gambar apa pun.
                                                            Akan dikonversi
                                                            ke WebP
                                                            otomatis.</p>
                                                    </div>
                                                    <div id="dropzone-preview" class="hidden space-y-3">
                                                        <div id="preview-thumbnails"
                                                            class="flex flex-wrap gap-2 justify-center max-h-48 overflow-y-auto">
                                                        </div>
                                                        <div
                                                            class="flex items-center justify-center gap-2 text-sm text-neutral-500 dark:text-neutral-400">
                                                            <span id="file-count"></span>
                                                            <button type="button" id="gallery-change-files"
                                                                class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 underline text-xs">Ganti
                                                                pilihan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center justify-end gap-3">
                                                    <span id="dropzone-error"
                                                        class="text-xs text-red-500 dark:text-red-400 hidden"></span>
                                                    <button type="button" id="gallery-submit-btn"
                                                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl text-sm font-semibold shadow-sm hover:shadow-md transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                                        Unggah <span id="upload-count"></span>
                                                    </button>
                                                </div>
                                            </div>

                                            @if(empty($invitation->gallery_photos))
                                                <p class="text-neutral-500 dark:text-neutral-400 text-center py-4 text-sm">
                                                    Belum
                                                    ada foto galeri.</p>
                                            @else
                                                <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                                                    @foreach($invitation->gallery_photos as $index => $photo)
                                                        <div
                                                            class="relative group aspect-square rounded-xl overflow-hidden border border-neutral-100 dark:border-secondary-700 bg-neutral-50 dark:bg-secondary-700">
                                                            <img src="{{ asset('storage/' . $photo) }}" alt="Gallery photo"
                                                                class="w-full h-full object-cover">
                                                            <div
                                                                class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                                <button type="button"
                                                                    class="delete-photo-btn bg-red-600 hover:bg-red-700 text-white rounded-full p-1.5 shadow-md transition-all"
                                                                    data-index="{{ $index }}">
                                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-center py-6">
                                            <div
                                                class="w-12 h-12 mx-auto rounded-2xl bg-amber-100 dark:bg-amber-900/20 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-amber-500 dark:text-amber-400" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                            </div>
                                            <p class="mt-2 text-sm font-semibold text-amber-800 dark:text-amber-300">
                                                Fitur
                                                Galeri Foto Terkunci</p>
                                            <p class="mt-1 text-xs text-amber-700 dark:text-amber-400">
                                                Upgrade paket Anda
                                                untuk menampilkan galeri
                                                foto.</p>
                                        </div>
                                    @endif
                                </div>

                                {{-- Music --}}
                                <div class="mt-6">
                                    <label
                                        class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Musik
                                        Latar Belakang</label>
                                    @if($invitation->canUseCustomMusic())
                                        <div class="mt-2 space-y-2">
                                            @if($invitation->music_url)
                                                <div
                                                    class="flex items-center gap-3 bg-primary-50 dark:bg-primary-900/50 p-3 rounded-xl border border-primary-100 dark:border-primary-800/50">
                                                    <span
                                                        class="text-xs font-semibold text-primary-700 dark:text-primary-300">🎵
                                                        Musik Aktif:</span>
                                                    <audio src="{{ asset('storage/' . $invitation->music_url) }}" controls
                                                        class="h-8 max-w-xs"></audio>
                                                </div>
                                            @endif
                                            <input type="file" name="music_file" id="music_file"
                                                class="text-sm text-neutral-500 dark:text-neutral-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 dark:file:bg-primary-900/50 file:text-primary-700 dark:file:text-primary-300 hover:file:bg-primary-100 dark:hover:file:bg-primary-900/70">
                                            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                                Mendukung format
                                                MP3, WAV, OGG.</p>
                                        </div>
                                    @else
                                        <div
                                            class="mt-2 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center gap-3">
                                            <span class="text-xl flex-shrink-0">✨</span>
                                            <div>
                                                <p class="text-sm font-semibold text-amber-800 dark:text-amber-300">
                                                    Fitur Kustom Musik
                                                    Terkunci</p>
                                                <p class="text-xs text-amber-700 dark:text-amber-400">
                                                    Silakan upgrade ke
                                                    paket Gold atau Platinum
                                                    untuk mengunggah musik
                                                    latar belakang
                                                    favorit Anda.</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                {{-- Theme Selection --}}
                                @php $currentTheme = old(
                                    'theme',
                                    $invitation->theme
                                ); @endphp
                                <div x-data="{ selectedTheme: '{{ $currentTheme }}' }" class="mt-6 space-y-3">

                                    <input type="hidden" name="theme" :value="selectedTheme" required>

                                    <div class="flex flex-col">
                                        <label
                                            class="text-xs font-bold text-neutral-700 dark:text-neutral-300 uppercase tracking-wider">
                                            Pilihan Tema Visual Undangan
                                        </label>
                                        <span class="text-[11px] text-neutral-400 mt-0.5">
                                            Geser horizontal untuk
                                            melihat koleksi desain
                                            premium. Klik pada kartu
                                            gambar untuk memilih tema
                                            aktif.
                                        </span>
                                    </div>

                                    <div
                                        class="flex gap-4 overflow-x-auto py-3 px-1 scrollbar-thin scrollbar-thumb-neutral-200 dark:scrollbar-thumb-neutral-700 snap-x items-stretch">

                                        @foreach($themes as $tema)
                                            @php $themeKey = str_replace(
                                                'themes.',
                                                '',
                                                $tema->view_path
                                            ); @endphp
                                            <div @click="selectedTheme = '{{ $themeKey }}'" :class="{
                                                                                                                             'border-primary ring-2 ring-primary/20 shadow-md bg-primary-50 dark:bg-primary-900/20': selectedTheme === '{{ $themeKey }}',
                                                                                                                             'border-neutral-200 dark:border-neutral-600 hover:border-neutral-300 dark:hover:border-neutral-500 bg-white dark:bg-secondary-800': selectedTheme !== '{{ $themeKey }}'
                                                                                                                         }"
                                                class="w-40 sm:w-48 flex-shrink-0 border rounded-2xl p-2.5 transition-all duration-200 cursor-pointer snap-start relative flex flex-col justify-between select-none">
                                                <div x-show="selectedTheme === '{{ $themeKey }}'"
                                                    class="absolute top-4 right-4 bg-primary text-white rounded-full p-1 z-10 shadow-sm"
                                                    x-cloak>
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor" stroke-width="3">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>

                                                <div
                                                    class="w-full aspect-[9/16] rounded-xl overflow-hidden bg-neutral-100 dark:bg-secondary-900 relative">
                                                    @if($tema->thumbnail_portrait)
                                                        <img src="{{ asset('storage/' . $tema->thumbnail_portrait) }}"
                                                            class="w-full h-full object-cover"
                                                            alt="Pratinjau {{ $tema->name }}">
                                                    @else
                                                        <div
                                                            class="w-full h-full flex items-center justify-center text-neutral-400 text-xs">
                                                            No Preview</div>
                                                    @endif
                                                </div>

                                                <div class="mt-3 space-y-1">
                                                    <span
                                                        class="inline-block text-[9px] font-bold uppercase tracking-wider bg-neutral-100 dark:bg-neutral-700 text-neutral-500 dark:text-neutral-400 px-1.5 py-0.5 rounded-md">
                                                        {{ $tema->themeCategory?->name ?? 'Umum' }}
                                                    </span>

                                                    <h4
                                                        class="text-xs font-bold text-neutral-800 dark:text-neutral-100 truncate block">
                                                        {{ $tema->name }}
                                                    </h4>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>

                                    @error('theme') <span
                                        class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- ======================================== --}}
                            {{-- Section 4: Konten Tambahan & Personalisasi --}}
                            {{-- ======================================== --}}
                            <div class="border-b border-neutral-200 dark:border-secondary-700 pb-8">
                                <div class="flex items-center gap-3 mb-1">
                                    <span
                                        class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary-100 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 text-sm font-bold">4</span>
                                    <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">
                                        Konten Tambahan & Personalisasi
                                    </h3>
                                </div>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">
                                    Personalisasi undangan
                                    dengan cerita cinta dan kutipan
                                    bermakna.</p>

                                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                    {{-- Love Story --}}
                                    <div class="sm:col-span-6">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
                                            <label
                                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Cerita
                                                Cinta (Love
                                                Story)</label>
                                            <button type="button" id="add-story-btn"
                                                class="text-xs text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-semibold">+
                                                Tambah Momen</button>
                                        </div>
                                        <div id="stories-container" class="space-y-3">
                                            @php $storyCollection = old(
                                                    'stories',
                                                    $invitation->stories->toArray()
                                                );
                                            @endphp
                                            @foreach($storyCollection as $storyIdx => $story)
                                                @php $story = (object) 
                                                $story; @endphp
                                                <div
                                                    class="story-card bg-neutral-50 dark:bg-secondary-700 p-4 rounded-xl border border-neutral-200 dark:border-secondary-700 space-y-3">
                                                    <div class="flex items-center justify-between flex-wrap gap-1">
                                                        <div class="flex items-center gap-1">
                                                            <span
                                                                class="text-xs font-semibold text-neutral-500 dark:text-neutral-400">Momen
                                                                #{{ $loop->iteration }}</span>
                                                            <button type="button"
                                                                class="story-move-up p-1 text-neutral-400 dark:text-neutral-500 hover:text-neutral-600 dark:hover:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-secondary-600 rounded-lg transition"
                                                                title="Pindah ke atas">
                                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M5 15l7-7 7 7" />
                                                                </svg>
                                                            </button>
                                                            <button type="button"
                                                                class="story-move-down p-1 text-neutral-400 dark:text-neutral-500 hover:text-neutral-600 dark:hover:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-secondary-600 rounded-lg transition"
                                                                title="Pindah ke bawah">
                                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M19 9l-7 7-7-7" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <button type="button"
                                                            class="remove-story text-red-400 dark:text-red-400 hover:text-red-600 dark:hover:text-red-300 text-xs font-semibold">Hapus</button>
                                                    </div>
                                                    @if(!empty($story->id))<input type="hidden"
                                                    name="stories[{{ $storyIdx }}][id]" value="{{ $story->id }}">@endif
                                                    <div>
                                                        <input type="text" name="stories[{{ $storyIdx }}][story_date]"
                                                            value="{{ old('stories.' . $storyIdx . '.story_date', $story->story_date ?? '') }}"
                                                            class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                            placeholder="Waktu (contoh: Tahun 2022, Maret 2024, 12 Desember 2025)">
                                                        @error('stories.' .
                                                                $storyIdx .
                                                            '.story_date') <span
                                                                class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div>
                                                        <input type="text" name="stories[{{ $storyIdx }}][story_title]"
                                                            value="{{ old('stories.' . $storyIdx . '.story_title', $story->story_title ?? '') }}"
                                                            class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                            placeholder="Judul momen (opsional)">
                                                        @error('stories.' .
                                                                $storyIdx .
                                                            '.story_title')
                                                            <span
                                                                class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div>
                                                        <textarea name="stories[{{ $storyIdx }}][story_description]"
                                                            rows="2"
                                                            class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                            placeholder="Ceritakan momen indah Anda...">{{ old('stories.' . $storyIdx . '.story_description', $story->story_description ?? '') }}</textarea>
                                                        @error('stories.' .
                                                                $storyIdx .
                                                            '.story_description')
                                                            <span
                                                                class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <template id="story-card-template">
                                            <div
                                                class="story-card bg-neutral-50 dark:bg-secondary-700 p-4 rounded-xl border border-neutral-200 dark:border-secondary-700 space-y-3">
                                                <div class="flex items-center justify-between flex-wrap gap-1">
                                                    <div class="flex items-center gap-1">
                                                        <span
                                                            class="text-xs font-semibold text-neutral-500 dark:text-neutral-400">Momen
                                                            Baru</span>
                                                        <button type="button"
                                                            class="story-move-up p-1 text-neutral-400 dark:text-neutral-500 hover:text-neutral-600 dark:hover:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-secondary-600 rounded-lg transition"
                                                            title="Pindah ke atas">
                                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M5 15l7-7 7 7" />
                                                            </svg>
                                                        </button>
                                                        <button type="button"
                                                            class="story-move-down p-1 text-neutral-400 dark:text-neutral-500 hover:text-neutral-600 dark:hover:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-secondary-600 rounded-lg transition"
                                                            title="Pindah ke bawah">
                                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M19 9l-7 7-7-7" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <button type="button"
                                                        class="remove-story text-red-400 dark:text-red-400 hover:text-red-600 dark:hover:text-red-300 text-xs font-semibold">Hapus</button>
                                                </div>
                                                <div>
                                                    <input type="text" name="stories[__INDEX__][story_date]"
                                                        class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                        placeholder="Waktu (contoh: Tahun 2022, Maret 2024, 12 Desember 2025)">
                                                </div>
                                                <div>
                                                    <input type="text" name="stories[__INDEX__][story_title]"
                                                        class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                        placeholder="Judul momen (opsional)">
                                                </div>
                                                <div>
                                                    <textarea name="stories[__INDEX__][story_description]" rows="2"
                                                        class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                        placeholder="Ceritakan momen indah Anda..."></textarea>
                                                </div>
                                            </div>
                                        </template>
                                        <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-2">
                                            Bagikan
                                            momen-momen berharga
                                            perjalanan cinta Anda kepada
                                            para tamu.</p>
                                    </div>

                                    {{-- Quote --}}
                                    @php
                                        $quoteTemplates = \App\Models\QuoteTemplate::active()->ordered()->get();
                                    @endphp

                                    <div class="sm:col-span-6">
                                        <label for="quote_content"
                                            class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Kutipan
                                            / Ayat Suci</label>

                                        <div class="mt-2 mb-3 flex flex-wrap gap-1.5">
                                            @foreach($quoteTemplates as $qt)
                                                <button type="button" data-quote-content="{{ e($qt->content) }}"
                                                    data-quote-source="{{ e($qt->source) }}"
                                                    class="quote-template-btn px-2.5 py-1 rounded-lg border border-neutral-200 dark:border-neutral-600 text-xs font-medium text-neutral-600 dark:text-neutral-400 bg-white dark:bg-secondary-700 hover:bg-primary-50 dark:hover:bg-primary-900/30 hover:border-primary-300 dark:hover:border-primary-600 hover:text-primary-700 dark:hover:text-primary-300 transition-all active:scale-95">
                                                    {{ $qt->label }}
                                                </button>
                                            @endforeach
                                        </div>

                                        <textarea name="quote_content" id="quote_content" rows="4"
                                            class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                            placeholder="Tulis kutipan ayat suci atau kutipan romantis...">{{ old('quote_content', $invitation->quote_content) }}</textarea>
                                        <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">
                                            Isi kutipan, ayat
                                            suci, atau pesan romantis.
                                        </p>
                                        @error('quote_content') <span
                                            class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="sm:col-span-6">
                                        <label for="quote_source"
                                            class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Sumber
                                            Kutipan</label>
                                        <input type="text" name="quote_source" id="quote_source"
                                            value="{{ old('quote_source', $invitation->quote_source) }}"
                                            class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                            placeholder="Contoh: Ar-Rum: 21, Kahlil Gibran, QS. Al-Baqarah: 45">
                                        <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">
                                            Nama tokoh, buku,
                                            atau pasal ayat sebagai
                                            sumber kutipan.</p>
                                        @error('quote_source') <span
                                            class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="border-b border-neutral-200 dark:border-secondary-700 pb-8">
                                <div class="flex items-center gap-3 mb-1">
                                    <span
                                        class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary-100 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 text-sm font-bold">5</span>
                                    <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">
                                        Keuangan</h3>
                                </div>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">
                                    Atur kado digital</p>



                                {{-- Kado Digital --}}
                                <div
                                    class="mt-6 bg-neutral-50 dark:bg-secondary-700 p-5 rounded-2xl border border-neutral-200 dark:border-secondary-700 space-y-4 pb-8">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                        <h4 class="font-semibold text-sm text-primary-700 dark:text-primary-300">
                                            Kado
                                            Digital</h4>
                                    </div>

                                    @if($invitation->canUseGift())
                                        @php
                                            $maxGift =
                                                $invitation->maxGiftAccounts();
                                            $oldBanks = old(
                                                'gift_banks',
                                                $invitation->gift_banks ??
                                                []
                                            );
                                            $oldEwallets = old(
                                                'gift_ewallets',
                                                $invitation->gift_ewallets ?? []
                                            );

                                            if (
                                                empty($oldBanks) &&
                                                ($invitation->gift_bank_name ||
                                                    $invitation->gift_bank_account)
                                            ) {
                                                $oldBanks = [
                                                    [
                                                        'bank_name' =>
                                                            $invitation->gift_bank_name,
                                                        'account_number' =>
                                                            $invitation->gift_bank_account,
                                                        'account_holder' =>
                                                            $invitation->gift_bank_holder
                                                    ]
                                                ];
                                            }
                                            if (
                                                empty($oldEwallets) &&
                                                ($invitation->gift_ewallet_name ||
                                                    $invitation->gift_ewallet_number)
                                            ) {
                                                $oldEwallets = [
                                                    [
                                                        'wallet_name' =>
                                                            $invitation->gift_ewallet_name,
                                                        'wallet_number' =>
                                                            $invitation->gift_ewallet_number
                                                    ]
                                                ];
                                            }
                                        @endphp
                                        <div id="gift-form" class="space-y-4">
                                            <div class="flex items-center justify-between flex-wrap gap-1">
                                                <span
                                                    class="text-xs text-neutral-500 dark:text-neutral-400 font-semibold">Maksimal
                                                    {{ $maxGift }}
                                                    akun</span>
                                                <span id="gift-account-count"
                                                    class="text-xs text-neutral-400 dark:text-neutral-500">0
                                                    /
                                                    {{ $maxGift }}</span>
                                            </div>

                                            <div id="gift-banks-container" class="space-y-3">
                                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                                    <label
                                                        class="text-xs font-semibold text-neutral-700 dark:text-neutral-300">Transfer
                                                        Bank</label>
                                                    <button type="button" id="add-bank-btn"
                                                        class="text-xs text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-semibold">+
                                                        Tambah Bank</button>
                                                </div>
                                                @foreach($oldBanks as $bankIdx => $bank)
                                                    @php $bank = (object) $bank;
                                                    @endphp
                                                    <div
                                                        class="gift-bank-card bg-neutral-50 dark:bg-secondary-700 p-3 rounded-xl border border-neutral-200 dark:border-secondary-700 space-y-2">
                                                        <div class="flex items-center justify-between flex-wrap gap-1">
                                                            <span
                                                                class="text-xs font-semibold text-neutral-500 dark:text-neutral-400">Bank
                                                                #{{ $loop->iteration }}</span>
                                                            <button type="button"
                                                                class="remove-bank text-red-400 dark:text-red-400 hover:text-red-600 dark:hover:text-red-400 text-xs font-semibold">Hapus</button>
                                                        </div>
                                                        <div class="grid grid-cols-2 gap-2">
                                                            <div>
                                                                <input type="text" name="gift_banks[{{ $bankIdx }}][bank_name]"
                                                                    value="{{ old('gift_banks.' . $bankIdx . '.bank_name', $bank->bank_name ?? '') }}"
                                                                    class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                                    placeholder="Nama Bank">
                                                                @error('gift_banks.'
                                                                        . $bankIdx .
                                                                    '.bank_name')
                                                                    <span
                                                                        class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div>
                                                                <input type="text"
                                                                    name="gift_banks[{{ $bankIdx }}][account_number]"
                                                                    value="{{ old('gift_banks.' . $bankIdx . '.account_number', $bank->account_number ?? '') }}"
                                                                    class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                                    placeholder="No. Rekening">
                                                                @error('gift_banks.'
                                                                        . $bankIdx .
                                                                    '.account_number')
                                                                    <span
                                                                        class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-span-2">
                                                                <input type="text"
                                                                    name="gift_banks[{{ $bankIdx }}][account_holder]"
                                                                    value="{{ old('gift_banks.' . $bankIdx . '.account_holder', $bank->account_holder ?? '') }}"
                                                                    class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                                    placeholder="Atas Nama">
                                                                @error('gift_banks.'
                                                                        . $bankIdx .
                                                                    '.account_holder')
                                                                    <span
                                                                        class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div id="gift-ewallets-container" class="space-y-3">
                                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                                    <label
                                                        class="text-xs font-semibold text-neutral-700 dark:text-neutral-300">Dompet
                                                        Digital</label>
                                                    <button type="button" id="add-ewallet-btn"
                                                        class="text-xs text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-semibold">+
                                                        Tambah
                                                        E-Wallet</button>
                                                </div>
                                                @foreach($oldEwallets as $ewalletIdx => $ewallet)
                                                    @php $ewallet = (object) 
                                                    $ewallet; @endphp
                                                    <div
                                                        class="gift-ewallet-card bg-neutral-50 dark:bg-secondary-700 p-3 rounded-xl border border-neutral-200 dark:border-secondary-700 space-y-2">
                                                        <div class="flex items-center justify-between flex-wrap gap-1">
                                                            <span
                                                                class="text-xs font-semibold text-neutral-500 dark:text-neutral-400">E-Wallet
                                                                #{{ $loop->iteration }}</span>
                                                            <button type="button"
                                                                class="remove-ewallet text-red-400 dark:text-red-400 hover:text-red-600 dark:hover:text-red-400 text-xs font-semibold">Hapus</button>
                                                        </div>
                                                        <div class="grid grid-cols-2 gap-2">
                                                            <div>
                                                                <input type="text"
                                                                    name="gift_ewallets[{{ $ewalletIdx }}][wallet_name]"
                                                                    value="{{ old('gift_ewallets.' . $ewalletIdx . '.wallet_name', $ewallet->wallet_name ?? '') }}"
                                                                    class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                                    placeholder="Nama E-Wallet">
                                                                @error('gift_ewallets.'
                                                                        . $ewalletIdx .
                                                                    '.wallet_name')
                                                                    <span
                                                                        class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div>
                                                                <input type="text"
                                                                    name="gift_ewallets[{{ $ewalletIdx }}][wallet_number]"
                                                                    value="{{ old('gift_ewallets.' . $ewalletIdx . '.wallet_number', $ewallet->wallet_number ?? '') }}"
                                                                    class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                                    placeholder="Nomor E-Wallet">
                                                                @error('gift_ewallets.'
                                                                        . $ewalletIdx .
                                                                    '.wallet_number')
                                                                    <span
                                                                        class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <hr class="border-neutral-100 dark:border-secondary-700">

                                            <div>
                                                <label
                                                    class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300">Barcode
                                                    QRIS</label>
                                                <div class="mt-1 flex items-center gap-4">
                                                    @if($invitation->gift_qris_image)
                                                        <img src="{{ asset('storage/' . $invitation->gift_qris_image) }}"
                                                            alt="QRIS"
                                                            class="w-16 h-16 object-contain border border-neutral-200 dark:border-secondary-700 rounded-xl">
                                                    @endif
                                                    <input type="file" name="gift_qris_image" id="gift_qris_image"
                                                        class="text-xs text-neutral-500 dark:text-neutral-400 file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-primary-50 dark:file:bg-primary-900/50 file:text-primary-700 dark:file:text-primary-300 hover:file:bg-primary-100 dark:hover:file:bg-primary-900/80">
                                                </div>
                                                @error('gift_qris_image')
                                                    <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="pt-2 flex justify-end">
                                                <button type="button" id="gift-save-btn"
                                                    class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl text-xs font-semibold shadow-sm hover:shadow-md transition-all">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Simpan Kado Digital
                                                </button>
                                            </div>
                                        </div>

                                        <script>
                                        document.addEventListener(
                                            'DOMContentLoaded',
                                            function() {
                                                const maxAccounts = {{ $maxGift }};
                                                const banksContainer =
                                                    document
                                                    .getElementById(
                                                        'gift-banks-container'
                                                    );
                                                const
                                                    ewalletsContainer =
                                                    document
                                                    .getElementById(
                                                        'gift-ewallets-container'
                                                    );
                                                const bankTemplate =
                                                    document
                                                    .getElementById(
                                                        'gift-bank-template'
                                                    );
                                                const ewalletTemplate =
                                                    document
                                                    .getElementById(
                                                        'gift-ewallet-template'
                                                    );
                                                const accountCountEl =
                                                    document
                                                    .getElementById(
                                                        'gift-account-count'
                                                    );

                                                function updateAccountCount() {
                                                    const total =
                                                        banksContainer
                                                        .querySelectorAll(
                                                            '.gift-bank-card'
                                                        )
                                                        .length +
                                                        ewalletsContainer
                                                        .querySelectorAll(
                                                            '.gift-ewallet-card'
                                                        ).length;
                                                    accountCountEl
                                                        .textContent =
                                                        total + ' / ' +
                                                        maxAccounts;
                                                    document
                                                        .getElementById(
                                                            'add-bank-btn'
                                                        )
                                                        .style.display =
                                                        total >=
                                                        maxAccounts ?
                                                        'none' : '';
                                                    document
                                                        .getElementById(
                                                            'add-ewallet-btn'
                                                        )
                                                        .style.display =
                                                        total >=
                                                        maxAccounts ?
                                                        'none' : '';
                                                }

                                                function reindexItems(
                                                    container, prefix) {
                                                    const cards =
                                                        container
                                                        .querySelectorAll(
                                                            '[class*="gift-' +
                                                            prefix +
                                                            '-card"]');
                                                    cards.forEach(
                                                        function(
                                                            card,
                                                            idx) {
                                                            const
                                                                inputs =
                                                                card
                                                                .querySelectorAll(
                                                                    '[name]'
                                                                );
                                                            inputs
                                                                .forEach(
                                                                    function(
                                                                        input
                                                                    ) {
                                                                        const
                                                                            name =
                                                                            input
                                                                            .getAttribute(
                                                                                'name'
                                                                            );
                                                                        if (
                                                                            name) {
                                                                            input
                                                                                .setAttribute(
                                                                                    'name',
                                                                                    name
                                                                                    .replace(
                                                                                        new RegExp(
                                                                                            prefix +
                                                                                            's\\[\\d+\\]'
                                                                                        ),
                                                                                        prefix +
                                                                                        's[' +
                                                                                        idx +
                                                                                        ']'
                                                                                    )
                                                                                );
                                                                        }
                                                                    }
                                                                );
                                                            const
                                                                label =
                                                                card
                                                                .querySelector(
                                                                    'span.text-xs.font-semibold.text-neutral-500'
                                                                );
                                                            if (
                                                                label) {
                                                                const
                                                                    prefixLabel =
                                                                    prefix ===
                                                                    'bank' ?
                                                                    'Bank' :
                                                                    'E-Wallet';
                                                                label
                                                                    .textContent =
                                                                    prefixLabel +
                                                                    ' #' +
                                                                    (
                                                                        idx +
                                                                        1
                                                                    );
                                                            }
                                                        });
                                                }

                                                function addItem(
                                                    container,
                                                    templateId,
                                                    prefix) {
                                                    const total =
                                                        banksContainer
                                                        .querySelectorAll(
                                                            '.gift-bank-card'
                                                        )
                                                        .length +
                                                        ewalletsContainer
                                                        .querySelectorAll(
                                                            '.gift-ewallet-card'
                                                        ).length;
                                                    if (total >=
                                                        maxAccounts)
                                                        return;

                                                    const template =
                                                        document
                                                        .getElementById(
                                                            templateId);
                                                    const clone =
                                                        template.content
                                                        .cloneNode(
                                                            true);
                                                    const card = clone
                                                        .querySelector(
                                                            '[class*="gift-' +
                                                            prefix +
                                                            '-card"]');
                                                    container
                                                        .appendChild(
                                                            card);
                                                    reindexItems(
                                                        container,
                                                        prefix);
                                                    updateAccountCount
                                                        ();
                                                }

                                                banksContainer
                                                    .addEventListener(
                                                        'click',
                                                        function(e) {
                                                            if (e.target
                                                                .closest(
                                                                    '.remove-bank'
                                                                )) {
                                                                e.target
                                                                    .closest(
                                                                        '.gift-bank-card'
                                                                    )
                                                                    .remove();
                                                                reindexItems
                                                                    (banksContainer,
                                                                        'bank'
                                                                    );
                                                                updateAccountCount
                                                                    ();
                                                            }
                                                        });

                                                ewalletsContainer
                                                    .addEventListener(
                                                        'click',
                                                        function(e) {
                                                            if (e.target
                                                                .closest(
                                                                    '.remove-ewallet'
                                                                )) {
                                                                e.target
                                                                    .closest(
                                                                        '.gift-ewallet-card'
                                                                    )
                                                                    .remove();
                                                                reindexItems
                                                                    (ewalletsContainer,
                                                                        'ewallet'
                                                                    );
                                                                updateAccountCount
                                                                    ();
                                                            }
                                                        });

                                                document.getElementById(
                                                        'add-bank-btn')
                                                    .addEventListener(
                                                        'click',
                                                        function() {
                                                            addItem(banksContainer,
                                                                'gift-bank-template',
                                                                'bank'
                                                            );
                                                        });

                                                document.getElementById(
                                                        'add-ewallet-btn'
                                                    )
                                                    .addEventListener(
                                                        'click',
                                                        function() {
                                                            addItem(ewalletsContainer,
                                                                'gift-ewallet-template',
                                                                'ewallet'
                                                            );
                                                        });

                                                updateAccountCount();
                                            });
                                        </script>

                                        <template id="gift-bank-template">
                                            <div
                                                class="gift-bank-card bg-neutral-50 dark:bg-secondary-700 p-3 rounded-xl border border-neutral-200 dark:border-secondary-700 space-y-2">
                                                <div class="flex items-center justify-between flex-wrap gap-1">
                                                    <span
                                                        class="text-xs font-semibold text-neutral-500 dark:text-neutral-400">Bank
                                                        Baru</span>
                                                    <button type="button"
                                                        class="remove-bank text-red-400 dark:text-red-400 hover:text-red-600 dark:hover:text-red-400 text-xs font-semibold">Hapus</button>
                                                </div>
                                                <div class="grid grid-cols-2 gap-2">
                                                    <div>
                                                        <input type="text" name="gift_banks[999][bank_name]"
                                                            class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                            placeholder="Nama Bank">
                                                    </div>
                                                    <div>
                                                        <input type="text" name="gift_banks[999][account_number]"
                                                            class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                            placeholder="No. Rekening">
                                                    </div>
                                                    <div class="col-span-2">
                                                        <input type="text" name="gift_banks[999][account_holder]"
                                                            class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                            placeholder="Atas Nama">
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                        <template id="gift-ewallet-template">
                                            <div
                                                class="gift-ewallet-card bg-neutral-50 dark:bg-secondary-700 p-3 rounded-xl border border-neutral-200 dark:border-secondary-700 space-y-2">
                                                <div class="flex items-center justify-between flex-wrap gap-1">
                                                    <span
                                                        class="text-xs font-semibold text-neutral-500 dark:text-neutral-400">E-Wallet
                                                        Baru</span>
                                                    <button type="button"
                                                        class="remove-ewallet text-red-400 dark:text-red-400 hover:text-red-600 dark:hover:text-red-400 text-xs font-semibold">Hapus</button>
                                                </div>
                                                <div class="grid grid-cols-2 gap-2">
                                                    <div>
                                                        <input type="text" name="gift_ewallets[999][wallet_name]"
                                                            class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                            placeholder="Nama E-Wallet">
                                                    </div>
                                                    <div>
                                                        <input type="text" name="gift_ewallets[999][wallet_number]"
                                                            class="block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-xs dark:bg-secondary-700 dark:text-neutral-200"
                                                            placeholder="Nomor E-Wallet">
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    @else
                                        <div class="text-center py-6">
                                            <div
                                                class="w-12 h-12 mx-auto rounded-2xl bg-amber-100 dark:bg-amber-900/20 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-amber-500 dark:text-amber-400" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                            </div>
                                            <p class="mt-2 text-sm font-semibold text-amber-800 dark:text-amber-300">
                                                Fitur
                                                Kado Digital Terkunci</p>
                                            <p class="mt-1 text-xs text-amber-700 dark:text-amber-400">
                                                Silakan upgrade paket
                                                Anda untuk menerima kado
                                                digital.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        {{-- ======================================== --}}
                        {{-- Section 6: Kontrol RSVP --}}
                        {{-- ======================================== --}}
                        <div class="border-b border-neutral-200 dark:border-secondary-700 pb-8">
                            <div class="flex items-center gap-3 mb-1">
                                <span
                                    class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary-100 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 text-sm font-bold">6</span>
                                <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">
                                    Kontrol RSVP</h3>
                            </div>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">
                                Atur batasan kuota kehadiran tamu undangan.</p>

                            <div
                                class="bg-primary-50/50 dark:bg-primary-900/10 border border-primary-100 dark:border-primary-800/30 rounded-xl p-5 space-y-4">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                                    <div>
                                        <h4 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100">
                                            Batasi Pax RSVP</h4>
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                                            Batasi jumlah maksimal pax/rombongan per tamu dan total kuota global.
                                        </p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                                        <input type="hidden" name="is_rsvp_pax_limited" value="0">
                                        <input type="checkbox" name="is_rsvp_pax_limited" id="is_rsvp_pax_limited"
                                            value="1"
                                            {{ old('is_rsvp_pax_limited', $invitation->is_rsvp_pax_limited) ? 'checked' : '' }}
                                            class="sr-only peer">
                                        <div
                                            class="w-9 h-5 bg-neutral-200 dark:bg-secondary-700 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-neutral-300 dark:after:border-neutral-600 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500">
                                        </div>
                                    </label>
                                </div>

                                <div id="rsvp-pax-settings"
                                    class="space-y-4 {{ old('is_rsvp_pax_limited', $invitation->is_rsvp_pax_limited) ? '' : 'hidden' }}">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label for="max_global_pax_quota"
                                                class="block text-xs font-medium text-neutral-700 dark:text-neutral-300">
                                                Total Kuota Global (Maksimal Pax)
                                            </label>
                                            <input type="number" name="max_global_pax_quota" id="max_global_pax_quota"
                                                value="{{ old('max_global_pax_quota', $invitation->max_global_pax_quota) }}"
                                                min="1"
                                                class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                placeholder="Contoh: 500">
                                            <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">
                                                Total maksimal seluruh pax yang hadir (misal: kapasitas gedung).
                                            </p>
                                            @error('max_global_pax_quota')
                                                <span
                                                    class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="max_pax_per_guest"
                                                class="block text-xs font-medium text-neutral-700 dark:text-neutral-300">
                                                Maksimal Pax per Tamu
                                            </label>
                                            <input type="number" name="max_pax_per_guest" id="max_pax_per_guest"
                                                value="{{ old('max_pax_per_guest', $invitation->max_pax_per_guest ?? 2) }}"
                                                min="1" max="50"
                                                class="mt-1 block w-full rounded-xl border-neutral-300 dark:border-neutral-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm dark:bg-secondary-700 dark:text-neutral-200"
                                                placeholder="2">
                                            <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-1">
                                                Jumlah rombongan maksimal yang bisa dibawa setiap tamu.
                                            </p>
                                            @error('max_pax_per_guest')
                                                <span
                                                    class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    @if($invitation->isRsvpPaxLimited())
                                        <div
                                            class="bg-white dark:bg-secondary-700 border border-neutral-200 dark:border-neutral-600 rounded-xl p-3">
                                            <p class="text-xs text-neutral-600 dark:text-neutral-400">
                                                Saat ini:
                                                <span
                                                    class="font-semibold text-primary-600 dark:text-primary-400">{{ $invitation->totalAcceptedPax() }}</span>
                                                dari
                                                <span class="font-semibold">{{ $invitation->max_global_pax_quota }}</span>
                                                pax terpakai
                                                (sisa <span
                                                    class="font-semibold text-emerald-600 dark:text-emerald-400">{{ $invitation->remainingGlobalQuota() }}</span>).
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- ======================================== --}}
                        {{-- Section 7: Kategori Tamu (Guest Categories) --}}
                        {{-- ======================================== --}}
                        <div class="border-b border-neutral-200 dark:border-secondary-700 pb-8">
                            <div class="flex items-center gap-3 mb-1">
                                <span
                                    class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary-100 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 text-sm font-bold">7</span>
                                <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">
                                    Kategori Tamu</h3>
                            </div>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">
                                Kelola label kategori untuk mengelompokkan tamu (misal: VIP, Keluarga, Teman Kantor).
                            </p>

                            <div x-data="guestCategories()" x-init="init()" class="space-y-4">
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <template x-for="category in categories" :key="category.id">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium"
                                            :style="'background-color: ' + category.color_code + '20; color: ' + category.color_code + '; border: 1px solid ' + category.color_code + '40'">
                                            <span x-text="category.name"></span>
                                            <button type="button" @click="editCategory(category)"
                                                class="hover:opacity-70 transition-opacity" title="Edit">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button type="button" @click="deleteCategory(category)"
                                                class="hover:opacity-70 transition-opacity" title="Hapus">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>
                                </div>

                                <div
                                    class="bg-neutral-50 dark:bg-secondary-700 rounded-2xl border border-neutral-200 dark:border-secondary-700 p-5">
                                    <h4 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100 mb-3"
                                        x-text="editing ? 'Edit Kategori' : 'Tambah Kategori Baru'"></h4>
                                    <div class="flex flex-col sm:flex-row gap-3">
                                        <div class="flex-1">
                                            <input type="text" x-model="form.name"
                                                placeholder="Nama kategori (misal: VIP, Keluarga)"
                                                class="block w-full rounded-xl border-neutral-300 dark:border-secondary-600 dark:bg-secondary-800 dark:text-neutral-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                                        </div>
                                        <div class="w-full sm:w-32">
                                            <div class="flex items-center gap-2">
                                                <input type="color" x-model="form.color_code"
                                                    class="h-10 w-10 rounded-lg border border-neutral-300 dark:border-secondary-600 cursor-pointer p-0.5">
                                                <input type="text" x-model="form.color_code" placeholder="#6b7280"
                                                    class="block w-full rounded-xl border-neutral-300 dark:border-secondary-600 dark:bg-secondary-800 dark:text-neutral-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="button" @click="saveCategory"
                                                class="inline-flex items-center gap-1.5 bg-gradient-to-r from-primary to-primary-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:shadow-lg transition-all whitespace-nowrap">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                <span x-text="editing ? 'Update' : 'Tambah'"></span>
                                            </button>
                                            <button type="button" @click="cancelEdit" x-show="editing"
                                                class="inline-flex items-center gap-1.5 bg-neutral-200 dark:bg-secondary-600 text-neutral-700 dark:text-neutral-300 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-neutral-300 dark:hover:bg-secondary-500 transition-all">
                                                Batal
                                            </button>
                                        </div>
                                    </div>
                                    <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-2">
                                        Warna akan tampil sebagai badge di daftar tamu dan menjadi filter pada fitur
                                        WhatsApp blast.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- ======================================== --}}
                        {{-- Section 8: Kontrol Visibilitas & Finalisasi --}}
                        {{-- ======================================== --}}
                        <div class="border-b border-neutral-200 dark:border-secondary-700 pb-8">
                            <div class="flex items-center gap-3 mb-1">
                                <span
                                    class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary-100 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 text-sm font-bold">8</span>
                                <h3 class="font-heading text-lg font-bold text-secondary-800 dark:text-neutral-100">
                                    Kontrol Visibilitas & Finalisasi
                                </h3>
                            </div>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">
                                Atur visibilitas dan
                                tampilan fitur di halaman undangan
                                publik.</p>

                            <div
                                class="bg-neutral-50 dark:bg-secondary-700 rounded-2xl border border-neutral-200 dark:border-secondary-700 p-5">
                                <h4 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100 mb-3">
                                    Fitur Interaktif</h4>
                                <div class="space-y-4">
                                    @php
                                        $interactiveToggles = [
                                            [
                                                'id' => 'show_rsvp',
                                                'label' => 'RSVP',
                                                'desc' => 'Tampilkan form konfirmasi
                                                                            kehadiran'
                                            ],
                                            [
                                                'id' => 'show_gallery',
                                                'label' => 'Galeri Foto',
                                                'desc' => 'Tampilkan galeri foto
                                                                            momen indah'
                                            ],
                                            [
                                                'id' => 'show_gift',
                                                'label' => 'Kado Digital',
                                                'desc' => 'Tampilkan informasi
                                                                            transfer bank & e-wallet'
                                            ],
                                            [
                                                'id' => 'show_comments',
                                                'label' => 'Buku Tamu / Komentar',
                                                'desc' => 'Tampilkan kolom ucapan
                                                                            dan doa'
                                            ],
                                            [
                                                'id' => 'show_qr_checkin',
                                                'label' => 'QR Check-In',
                                                'desc' => 'Tampilkan kode QR unik
                                                                            tamu'
                                            ],
                                        ];
                                    @endphp
                                    @foreach($interactiveToggles as $toggle)
                                        <div class="flex items-start gap-3 py-1">
                                            <div class="text-sm flex-1">
                                                <label for="{{ $toggle['id'] }}"
                                                    class="font-medium text-neutral-700 dark:text-neutral-300">{{ $toggle['label'] }}</label>
                                                <p class="text-neutral-500 dark:text-neutral-400 text-xs">
                                                    {{ $toggle['desc'] }}
                                                </p>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer flex-shrink-0 mt-0.5">
                                                <input type="hidden" name="{{ $toggle['id'] }}" value="0">
                                                <input type="checkbox" name="{{ $toggle['id'] }}" id="{{ $toggle['id'] }}"
                                                    value="1"
                                                    {{ old($toggle['id'], $invitation->{$toggle['id']}) ? 'checked' : '' }}
                                                    class="sr-only peer">
                                                <div
                                                    class="w-9 h-5 bg-neutral-200 dark:bg-secondary-700 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-neutral-300 dark:after:border-neutral-600 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500">
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                <h4 class="text-sm font-semibold text-secondary-800 dark:text-neutral-100 mb-3">
                                    Visibilitas Fitur</h4>
                                <div class="space-y-4">
                                    @php
                                        $visibilityToggles = [
                                            [
                                                'id' => 'show_stories',
                                                'label' => 'Cerita Cinta',
                                                'desc' => 'Tampilkan timeline
                                                                            perjalanan cinta'
                                            ],
                                            [
                                                'id' => 'show_countdown',
                                                'label' => 'Hitung Mundur',
                                                'desc' => 'Tampilkan timer hitung
                                                                            mundur ke acara'
                                            ],
                                            [
                                                'id' => 'show_event_detail',
                                                'label' => 'Detail Acara',
                                                'desc' => 'Tampilkan informasi waktu
                                                                            & tempat'
                                            ],
                                            [
                                                'id' => 'show_quote',
                                                'label' => 'Kutipan',
                                                'desc' => 'Tampilkan kutipan atau
                                                                            ayat suci'
                                            ],
                                            [
                                                'id' => 'show_video',
                                                'label' => 'Video YouTube',
                                                'desc' => 'Tampilkan video YouTube &
                                                                            live streaming'
                                            ],
                                        ];
                                    @endphp
                                    @foreach($visibilityToggles as $toggle)
                                        <div class="flex items-start gap-3 py-1">
                                            <div class="text-sm flex-1">
                                                <label for="{{ $toggle['id'] }}"
                                                    class="font-medium text-neutral-700 dark:text-neutral-300">{{ $toggle['label'] }}</label>
                                                <p class="text-neutral-500 dark:text-neutral-400 text-xs">
                                                    {{ $toggle['desc'] }}
                                                </p>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer flex-shrink-0 mt-0.5">
                                                <input type="hidden" name="{{ $toggle['id'] }}" value="0">
                                                <input type="checkbox" name="{{ $toggle['id'] }}" id="{{ $toggle['id'] }}"
                                                    value="1"
                                                    {{ old($toggle['id'], $invitation->{$toggle['id']}) ? 'checked' : '' }}
                                                    class="sr-only peer">
                                                <div
                                                    class="w-9 h-5 bg-neutral-200 dark:bg-secondary-700 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-neutral-300 dark:after:border-neutral-600 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500">
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Active toggle --}}
                            @php $isActive = old('is_active', $invitation->is_active); @endphp
                            <div class="mt-6">
                                <input type="hidden" name="is_active" value="0">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-3 p-4 bg-neutral-50 dark:bg-secondary-700 rounded-xl border border-neutral-200 dark:border-secondary-700">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Status Undangan</p>
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Undangan yang tidak aktif tidak dapat diakses oleh tamu.</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="button" id="activate-btn"
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ $isActive ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800' : 'bg-white dark:bg-secondary-800 border border-neutral-300 dark:border-neutral-600 text-neutral-600 dark:text-neutral-400 hover:border-emerald-300 hover:text-emerald-600' }}">
                                            <span class="w-2 h-2 rounded-full {{ $isActive ? 'bg-emerald-500' : 'bg-neutral-300 dark:bg-neutral-500' }}"></span>
                                            Aktif
                                        </button>
                                        <button type="button" id="deactivate-btn"
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ !$isActive ? 'bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-800' : 'bg-white dark:bg-secondary-800 border border-neutral-300 dark:border-neutral-600 text-neutral-600 dark:text-neutral-400 hover:border-red-300 hover:text-red-600' }}">
                                            <span class="w-2 h-2 rounded-full {{ !$isActive ? 'bg-red-500' : 'bg-neutral-300 dark:bg-neutral-500' }}"></span>
                                            Nonaktif
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                </div>
                </form>
            </div>
        </div>

        {{-- Fixed bottom bar --}}
        <div
            class="fixed bottom-0 left-0 right-0 bg-white/95 dark:bg-secondary-800/95 backdrop-blur-sm border-t border-neutral-200 dark:border-secondary-700 shadow-soft z-40">
            <div class="max-w-4xl mx-auto px-6 py-3.5 flex flex-col-reverse sm:flex-row justify-end items-center gap-2">
                <a href="{{ route('dashboard.invitations.show', $invitation) }}"
                    class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-5 py-2.5 bg-white dark:bg-secondary-800 border border-neutral-300 dark:border-neutral-600 rounded-xl shadow-sm text-sm font-semibold text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-secondary-700 hover:border-primary-300 transition-all">
                    Batal
                </a>
                <button type="button" id="save-invitation-btn"
                    class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-6 py-2.5 bg-gradient-to-r from-primary to-primary-600 rounded-xl shadow-sm text-sm font-semibold text-white hover:shadow-md hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
    </div>

    {{-- Spacer for fixed bottom bar --}}
    <div class="h-16"></div>

    {{-- Crop Modal --}}
    <div id="crop-modal" class="hidden fixed inset-0 z-50 bg-black/60 items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white dark:bg-secondary-800 rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden my-8">
            <div class="p-4 border-b border-neutral-100 dark:border-secondary-700 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-secondary-800 dark:text-neutral-100">
                    Crop
                    Foto</h3>
                <button type="button"
                    class="crop-close text-neutral-400 dark:text-neutral-500 hover:text-neutral-600 dark:hover:text-neutral-400 transition">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-4 bg-secondary-900" style="height:400px">
                <div id="crop-container" class="w-full mx-auto" style="max-width:500px;overflow:hidden">
                </div>
            </div>
            <div class="p-4 border-t border-neutral-100 dark:border-secondary-700">
                <div class="flex items-center justify-center gap-3 mb-4">
                    <button type="button" id="crop-zoom-out"
                        class="p-2 rounded-xl bg-neutral-100 dark:bg-secondary-700 hover:bg-neutral-200 dark:hover:bg-secondary-600 text-neutral-700 dark:text-neutral-300 transition"
                        title="Perkecil">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                        </svg>
                    </button>
                    <button type="button" id="crop-zoom-in"
                        class="p-2 rounded-xl bg-neutral-100 dark:bg-secondary-700 hover:bg-neutral-200 dark:hover:bg-secondary-600 text-neutral-700 dark:text-neutral-300 transition"
                        title="Perbesar">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                    <button type="button" id="crop-rotate"
                        class="p-2 rounded-xl bg-neutral-100 dark:bg-secondary-700 hover:bg-neutral-200 dark:hover:bg-secondary-600 text-neutral-700 dark:text-neutral-300 transition"
                        title="Rotate">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                </div>
                <div class="flex gap-3">
                    <button type="button"
                        class="crop-close flex-1 px-4 py-2.5 border border-neutral-300 dark:border-neutral-600 rounded-xl text-sm font-semibold text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-secondary-700 transition">
                        Batal
                    </button>
                    <button type="button" id="crop-save"
                        class="flex-1 px-4 py-2.5 bg-gradient-to-r from-primary to-primary-600 text-white rounded-xl text-sm font-semibold hover:shadow-md transition-all">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById(
            'events-container');
        const template = document.getElementById(
            'event-card-template');
        const addBtn = document.getElementById('add-event-btn');
        let eventIndex = container ? container.children.length :
            0;

        function reindexEvents() {
            const cards = container.querySelectorAll(
                '.event-card');
            cards.forEach(function(card, idx) {
                const inputs = card.querySelectorAll(
                    '[name]');
                inputs.forEach(function(input) {
                    const name = input
                        .getAttribute('name');
                    if (name) {
                        input.setAttribute(
                            'name', name
                            .replace(
                                /events\[\d+\]/,
                                'events[' +
                                idx + ']'));
                    }
                });
                const datalists = card.querySelectorAll(
                    '[id^="event-titles-"]');
                datalists.forEach(function(dl) {
                    dl.id = 'event-titles-' +
                        idx;
                });
                const inputsWithList = card
                    .querySelectorAll(
                        '[list^="event-titles-"]');
                inputsWithList.forEach(function(inp) {
                    inp.setAttribute('list',
                        'event-titles-' +
                        idx);
                });
                const title = card.querySelector(
                    'h4.font-semibold');
                if (title) {
                    title.textContent = 'Acara #' + (
                        idx + 1);
                }
            });
        }

        function addEventCard() {
            const clone = template.content.cloneNode(true);
            const html = clone.querySelector('.event-card')
                .outerHTML.replace(
                    /__INDEX__/g, eventIndex);
            const wrapper = document.createElement('div');
            wrapper.innerHTML = html;
            const card = wrapper.firstElementChild;
            container.appendChild(card);
            eventIndex++;
            bindCardEvents(card);
            reindexEvents();
        }

        function removeEventCard(btn) {
            const card = btn.closest('.event-card');
            if (!card) return;
            Swal.fire({
                title: 'Hapus Acara?',
                text: 'Acara ini akan dihapus dari undangan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    card.remove();
                    reindexEvents();
                }
            });
        }

        function moveUp(btn) {
            const card = btn.closest('.event-card');
            const prev = card ? card.previousElementSibling :
                null;
            if (prev) {
                card.parentNode.insertBefore(card, prev);
                reindexEvents();
            }
        }

        function moveDown(btn) {
            const card = btn.closest('.event-card');
            const next = card ? card.nextElementSibling : null;
            if (next) {
                card.parentNode.insertBefore(next, card);
                reindexEvents();
            }
        }

        function bindCardEvents(card) {
            card.querySelector('.remove-event')
                ?.addEventListener('click', function() {
                    removeEventCard(this);
                });
            card.querySelector('.move-up')?.addEventListener(
                'click',
                function() {
                    moveUp(this);
                });
            card.querySelector('.move-down')?.addEventListener(
                'click',
                function() {
                    moveDown(this);
                });
        }

        container.querySelectorAll('.event-card').forEach(
            function(card) {
                bindCardEvents(card);
            });

        addBtn.addEventListener('click', addEventCard);

        const storiesContainer = document.getElementById(
            'stories-container');
        const storyTemplate = document.getElementById(
            'story-card-template');
        const addStoryBtn = document.getElementById(
            'add-story-btn');

        function reindexStories() {
            const cards = storiesContainer.querySelectorAll(
                '.story-card');
            cards.forEach(function(card, idx) {
                const inputs = card.querySelectorAll(
                    '[name]');
                inputs.forEach(function(input) {
                    const name = input
                        .getAttribute('name');
                    if (name) {
                        input.setAttribute(
                            'name', name
                            .replace(
                                /stories\[\d+\]/,
                                'stories[' +
                                idx + ']'));
                    }
                });
                const label = card.querySelector(
                    'span.text-xs.font-semibold');
                if (label) {
                    label.textContent = 'Momen #' + (
                        idx + 1);
                }
            });
        }

        function addStoryCard() {
            const clone = storyTemplate.content.cloneNode(true);
            const html = clone.querySelector('.story-card')
                .outerHTML.replace(
                    /__INDEX__/g, storiesContainer
                    .children.length);
            const wrapper = document.createElement('div');
            wrapper.innerHTML = html;
            const card = wrapper.firstElementChild;
            storiesContainer.appendChild(card);
            reindexStories();
        }

        function storyMoveUp(btn) {
            const card = btn.closest('.story-card');
            const prev = card ? card.previousElementSibling : null;
            if (prev) {
                card.parentNode.insertBefore(card, prev);
                reindexStories();
            }
        }

        function storyMoveDown(btn) {
            const card = btn.closest('.story-card');
            const next = card ? card.nextElementSibling : null;
            if (next) {
                card.parentNode.insertBefore(next, card);
                reindexStories();
            }
        }

        storiesContainer.addEventListener('click', function(e) {
            if (e.target.closest('.remove-story')) {
                e.target.closest('.story-card')
                    .remove();
                reindexStories();
            }
            if (e.target.closest('.story-move-up')) {
                storyMoveUp(e.target.closest('.story-move-up'));
            }
            if (e.target.closest('.story-move-down')) {
                storyMoveDown(e.target.closest('.story-move-down'));
            }
        });

        if (addStoryBtn) {
            addStoryBtn.addEventListener('click', addStoryCard);
        }
    });
    </script>

    <script>
    // Guest Categories Alpine Component (defined before DOMContentLoaded so Alpine can find it)
    window.guestCategories = function() {
        return {
            categories: @json($invitation->guestCategories()->get()),
            editing: false,
            form: {
                id: null,
                name: '',
                color_code: '#6b7280'
            },
            init() {},
            saveCategory() {
                if (!this.form.name.trim()) return;
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                const url = this.editing ?
                    '{{ route("dashboard.invitations.guest-categories.update", [
    $invitation,
    '
                CATEGORY_ID '
]) }}'.replace('CATEGORY_ID', this.form.id):
                    '{{ route("dashboard.invitations.guest-categories.store", $invitation) }}';
                const method = this.editing ? 'PUT' : 'POST';

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            _method: method,
                            name: this.form.name,
                            color_code: this.form.color_code
                        }),
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (this.editing) {
                            const idx = this.categories.findIndex(c => c.id === data.id);
                            if (idx !== -1) this.categories.splice(idx, 1, data);
                        } else {
                            this.categories.push(data);
                        }
                        this.cancelEdit();
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal menyimpan kategori.'
                        });
                    });
            },
            editCategory(category) {
                this.editing = true;
                this.form = {
                    id: category.id,
                    name: category.name,
                    color_code: category.color_code
                };
            },
            cancelEdit() {
                this.editing = false;
                this.form = {
                    id: null,
                    name: '',
                    color_code: '#6b7280'
                };
            },
            deleteCategory(category) {
                Swal.fire({
                    title: 'Hapus Kategori?',
                    text: 'Tamu dengan kategori ini tidak akan terhapus, hanya kategorinya yang hilang.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (!result.isConfirmed) return;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                    fetch('{{ route("dashboard.invitations.guest-categories.destroy", [
    $invitation,
    '
                            CATEGORY_ID '
]) }}'.replace('CATEGORY_ID', category.id), {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({
                                    _method: 'DELETE'
                                }),
                            })
                        .then(() => {
                            this.categories = this.categories.filter(c => c.id !== category.id);
                        })
                        .catch(() => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal menghapus kategori.'
                            });
                        });
                });
            },
        };
    };
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        // Gallery upload
        const galleryBtn = document.getElementById('gallery-submit-btn');
        const galleryFileInput = document.getElementById('gallery-file-input');
        const uploadCount = document.getElementById('upload-count');

        if (galleryFileInput) {
            galleryFileInput.addEventListener('change', function() {
                const count = this.files.length;
                if (uploadCount) uploadCount.textContent = count ? '(' + count + ')' : '';
                if (galleryBtn) galleryBtn.disabled = !count;
            });
        }

        if (galleryBtn && galleryFileInput) {
            galleryBtn.addEventListener('click', function() {
                const files = galleryFileInput.files;
                if (!files.length) return;

                galleryBtn.disabled = true;
                galleryBtn.textContent = 'Mengunggah...';

                const formData = new FormData();
                for (const file of files) {
                    formData.append('photos[]', file);
                }
                if (csrfToken) formData.append('_token', csrfToken);

                fetch('{{ route("dashboard.invitations.gallery.update", $invitation) }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json'
                    },
                }).then(() => {
                    window.location.reload();
                }).catch(() => {
                    galleryBtn.disabled = false;
                    galleryBtn.textContent = 'Unggah';
                });
            });
        }

        // Click on dropzone to open file picker
        const dropzone = document.getElementById('gallery-dropzone');
        if (dropzone && galleryFileInput) {
            dropzone.addEventListener('click', function(e) {
                if (e.target === dropzone || e.target.closest('#dropzone-empty')) {
                    galleryFileInput.click();
                }
            });
        }

        // Gallery photo delete
        document.querySelectorAll('.delete-photo-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const index = this.dataset.index;
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Hapus foto ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (!result.isConfirmed) return;

                    const formData = new FormData();
                    formData.append('_token', csrfToken);
                    formData.append('_method', 'DELETE');
                    formData.append('photo_index', index);

                    fetch('{{ route("dashboard.invitations.gallery.destroy", $invitation) }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Accept': 'application/json'
                        },
                    }).then(() => {
                        window.location.reload();
                    });
                });
            });
        });

        // Gift save
        const giftBtn = document.getElementById('gift-save-btn');
        if (giftBtn) {
            giftBtn.addEventListener('click', function() {
                const form = document.getElementById('gift-form');
                const formData = new FormData();
                formData.append('_token', csrfToken);

                const inputs = form.querySelectorAll('input, select, textarea');
                inputs.forEach(function(input) {
                    if (input.type === 'file') {
                        if (input.files.length) {
                            formData.append(input.name, input.files[0]);
                        }
                    } else if (input.name) {
                        formData.append(input.name, input.value);
                    }
                });

                fetch('{{ route("dashboard.invitations.gift.update", $invitation) }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json'
                    },
                }).then(() => {
                    window.location.reload();
                });
            });
        }

        // RSVP Pax Limit toggle
        const rsvpPaxToggle = document.getElementById('is_rsvp_pax_limited');
        const rsvpPaxSettings = document.getElementById('rsvp-pax-settings');
        if (rsvpPaxToggle && rsvpPaxSettings) {
            rsvpPaxToggle.addEventListener('change', function() {
                rsvpPaxSettings.classList.toggle('hidden', !this.checked);
            });
        }

        // Quote template picker
        document.querySelectorAll('.quote-template-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.getElementById('quote_content').value = this.dataset.quoteContent;
                document.getElementById('quote_source').value = this.dataset.quoteSource;

                document.querySelectorAll('.quote-template-btn').forEach(function(b) {
                    b.classList.remove('bg-primary-50', 'dark:bg-primary-900/30',
                        'border-primary-300', 'dark:border-primary-600',
                        'text-primary-700', 'dark:text-primary-300');
                    b.classList.add('border-neutral-200', 'dark:border-neutral-600',
                        'text-neutral-600', 'dark:text-neutral-400');
                });
                this.classList.remove('border-neutral-200', 'dark:border-neutral-600',
                    'text-neutral-600', 'dark:text-neutral-400');
                this.classList.add('bg-primary-50', 'dark:bg-primary-900/30',
                    'border-primary-300', 'dark:border-primary-600',
                    'text-primary-700', 'dark:text-primary-300');
            });
        });

        // Activate / Deactivate toggle
        const activateBtn = document.getElementById('activate-btn');
        const deactivateBtn = document.getElementById('deactivate-btn');
        const activeInput = document.querySelector('input[name="is_active"]');

        function setActiveState(active) {
            activeInput.value = active ? '1' : '0';
            activateBtn.className = `inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all ${active ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800' : 'bg-white dark:bg-secondary-800 border border-neutral-300 dark:border-neutral-600 text-neutral-600 dark:text-neutral-400 hover:border-emerald-300 hover:text-emerald-600'}`;
            deactivateBtn.className = `inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all ${!active ? 'bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-800' : 'bg-white dark:bg-secondary-800 border border-neutral-300 dark:border-neutral-600 text-neutral-600 dark:text-neutral-400 hover:border-red-300 hover:text-red-600'}`;
            const dot1 = activateBtn.querySelector('span');
            const dot2 = deactivateBtn.querySelector('span');
            if (dot1) dot1.className = `w-2 h-2 rounded-full ${active ? 'bg-emerald-500' : 'bg-neutral-300 dark:bg-neutral-500'}`;
            if (dot2) dot2.className = `w-2 h-2 rounded-full ${!active ? 'bg-red-500' : 'bg-neutral-300 dark:bg-neutral-500'}`;
        }

        if (activateBtn && deactivateBtn) {
            activateBtn.addEventListener('click', function() { setActiveState(true); });
            deactivateBtn.addEventListener('click', function() { setActiveState(false); });
        }

        // Save confirmation
        const saveBtn = document.getElementById('save-invitation-btn');
        if (saveBtn) {
            saveBtn.addEventListener('click', function(e) {
                Swal.fire({
                    title: 'Simpan Perubahan?',
                    text: 'Pastikan semua data sudah diisi dengan benar.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#6366f1',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, simpan!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('invitation-form').submit();
                    }
                });
            });
        }
    });
    </script>
</x-app-layout>