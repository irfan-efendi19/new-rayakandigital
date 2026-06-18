# PRODUCT REQUIREMENT DOCUMENT (PRD)
## MODUL: INTEGRATION OF PRESET WHATSAPP TEMPLATES GALLERY
**Versi:** 3.1 (Spesifikasi Preset Template Siap Pakai - Laravel 13, Filament v3, & Alpine.js)  
**Tanggal:** 18 Juni 2026  
**Status:** Approved  
**Author:** Mochammad Irfan Efendi  

---

## 1. DESKRIPSI FITUR & ATURAN BISNIS (BUSINESS RULES)

### 1.1 Deskripsi Fitur
Untuk menghemat waktu pengguna yang merasa kesulitan atau enggan menyusun draf pesan dari awal (*custom*), sistem menyediakan **Galeri Pilihan Template Siap Pakai (*Preset Templates Gallery*)**. Fitur ini berbentuk pustaka mini yang berisi beberapa variasi gaya bahasa penulisan pesan undangan WhatsApp. User dapat meninjau variasi tersebut dan menerapkannya langsung ke kolom input utama dengan sekali klik.

### 1.2 Aturan Bisnis (Business Rules)
1. **Pilihan Variasi Gaya Bahasa:** Sistem wajib menyediakan minimal 4 kategori *preset* bawaan yang umum digunakan:
   * **Formal/Umum:** Bahasa baku standar resmi dan sopan.
   * **Islami/Religius:** Memuat salam pembuka, kutipan ayat suci (Ar-Rum), dan doa berkah.
   * **Kasual/Santai:** Bahasa semi-formal yang cocok untuk teman sebaya atau kerabat dekat.
   * **Singkat/Minimalis:** Pesan padat poin *to-the-point* yang langsung mengarah pada link undangan.
2. **Mekanisme Timpa Teks (*Overwrite Confirmation*):** Apabila kolom input teks utama sudah terisi tulisan oleh user, sistem wajib memunculkan peringatan konfirmasi (*alert dialog*) sebelum menimpa teks lama dengan *preset* baru guna mencegah hilangnya data ketikan yang tidak sengaja.
3. **Pemuatan Sisi Klien Instan:** Seluruh koleksi teks *preset* dimuat secara statis di sisi klien (*client-side array*) menggunakan Alpine.js untuk menjamin kecepatan performa perpindahan antar template tanpa *loading* jeda memori server.

---

## 2. REKAYASA COMPONENT UI DASHBOARD USER (COMPREHENSIVE IMPLEMENTATION)

Perbarui struktur layout komponen form WhatsApp sebelumnya pada halaman depan Dashboard User dengan menyisipkan tombol pemicu galeri modal template bawaan berikut:

```html
<div 
    x-data="{ 
        templateText: `Halo {{nama_tamu}},\n\nTanpa mengurangi rasa hormat, kami mengundang Anda...`,
        openPresetModal: false,
        // KOLEKSI DATA PRESET TEMPLATE SIAP PAKAI
        presets: [
            {
                name: '💼 Gaya Formal / Umum',
                text: 'Kepada Yth.\nBapak/Ibu/Saudara/i {{nama_tamu}}\n\nSalam hormat,\nDengan memohon rahmat dan ridho Allah SWT, kami bermaksud mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara resepsi pernikahan kami, yang detail undangannya dapat diakses via tautan di bawah ini:\n\n{{link_undangan}}\n\nMerupakan suatu kebahagiaan dan kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu kepada kedua mempelai.\n\nTerima kasih.\nKami yang berbahagia,\n{{nama_pengantin}}'
            },
            {
                name: '🌙 Gaya Islami / Religius',
                text: 'Assalamu\'alaikum Warahmatullahi Wabarakatuh\n\nTanpa mengurangi rasa hormat, izinkan kami mengundang Bapak/Ibu/Saudara/i {{nama_tamu}} untuk menghadiri acara pernikahan kami.\n\nDan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya (QS. Ar-Rum: 21).\n\nInformasi lengkap mengenai waktu dan lokasi acara dapat dilihat melalui link undangan digital berikut:\n{{link_undangan}}\n\nUngkapan terima kasih yang tulus kami haturkan atas kehadiran dan doa restu Anda.\n\nWassalamu\'alaikum Warahmatullahi Wabarakatuh\n\nKami yang berbahagia,\n{{nama_pengantin}}'
            },
            {
                name: '🎉 Gaya Kasual / Teman',
                text: 'Halo {{nama_tamu}}! 👋\n\nKabar bahagia nih, kami mau melangsungkan pernikahan! Tanpa mengurangi rasa hormat, lewat pesan ini kami ingin mengundang kamu untuk hadir di hari bahagia kami.\n\nYuk, intip detail acara, lokasi map, dan isi buku tamu lewat link undangan digital di bawah ini:\n{{link_undangan}}\n\nDatang ya! Kehadiran dan doa restu dari kamu berharga banget buat kami berdua.\n\nSampai jumpa di lokasi!\nWarm regards,\n{{nama_pengantin}}'
            },
            {
                name: '⚡ Gaya Singkat / Minimalis',
                text: 'Halo {{nama_tamu}},\n\nKami mengundang Anda untuk menghadiri acara pernikahan {{nama_pengantin}}.\n\nDetail informasi acara (Waktu, Tempat, & Protokol) dapat diakses langsung melalui tautan undangan digital resmi berikut:\n{{link_undangan}}\n\nTerima kasih atas perhatian dan doa restu terbaik Anda.'
            }
        ],
        selectPreset(presetText) {
            if (this.templateText.trim().length > 0) {
                if (confirm('Memilih template ini akan menghapus teks draf yang sudah Anda tulis. Apakah Anda yakin?')) {
                    this.templateText = presetText;
                    this.openPresetModal = false;
                }
            } else {
                this.templateText = presetText;
                this.openPresetModal = false;
            }
        }
    }" 
    class="space-y-4"
>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div class="flex flex-col">
            <label for="whatsapp_template" class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                Template Teks Pesan WhatsApp Undangan
            </label>
            <span class="text-[11px] text-gray-400 mt-0.5">
                Tuliskan format pesan pembuka atau gunakan koleksi template bawaan siap pakai di bawah ini.
            </span>
        </div>
        
        <button 
            type="button"
            @click="openPresetModal = true"
            class="inline-flex items-center justify-center px-3 py-1.5 bg-brand/10 hover:bg-brand/20 text-brand text-xs font-bold rounded-xl border border-brand/20 transition-all cursor-pointer shadow-sm"
        >
            📋 Pilih dari Template Contoh
        </button>
    </div>

    <div class="relative">
        <textarea 
            id="whatsapp_template"
            name="whatsapp_template"
            rows="8"
            x-ref="messageField"
            x-model="templateText"
            class="w-full text-xs p-4 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-brand font-sans leading-relaxed shadow-sm resize-y"
            placeholder="Tulis draf pesan WhatsApp Anda di sini..."
            required
        ></textarea>
    </div>

    <div class="flex flex-wrap gap-2 items-center bg-gray-50 dark:bg-gray-800/50 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
        <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mr-1">Sisipkan:</span>
        <button type="button" @click="const el = $refs.messageField; const start = el.selectionStart; const end = el.selectionEnd; templateText = templateText.substring(0, start) + '{{nama_tamu}}' + templateText.substring(end); $nextTick(() => { el.focus(); el.setSelectionRange(start + 13, start + 13); });" class="text-[11px] font-semibold bg-white dark:bg-gray-800 border px-2 py-1 rounded-lg shadow-sm hover:text-brand cursor-pointer">👤 Nama Tamu</button>
        <button type="button" @click="const el = $refs.messageField; const start = el.selectionStart; const end = el.selectionEnd; templateText = templateText.substring(0, start) + '{{nama_pengantin}}' + templateText.substring(end); $nextTick(() => { el.focus(); el.setSelectionRange(start + 18, start + 18); });" class="text-[11px] font-semibold bg-white dark:bg-gray-800 border px-2 py-1 rounded-lg shadow-sm hover:text-brand cursor-pointer">💍 Nama Pengantin</button>
        <button type="button" @click="const el = $refs.messageField; const start = el.selectionStart; const end = el.selectionEnd; templateText = templateText.substring(0, start) + '{{link_undangan}}' + templateText.substring(end); $nextTick(() => { el.focus(); el.setSelectionRange(start + 17, start + 17); });" class="text-[11px] font-semibold bg-white dark:bg-gray-800 border px-2 py-1 rounded-lg shadow-sm hover:text-brand cursor-pointer">🔗 Link Undangan</button>
    </div>

    <div x-show="openPresetModal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4" x-transition x-cloak>
        <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 max-w-2xl w-full max-h-[80vh] flex flex-col justify-between shadow-2xl space-y-4" @click.away="openPresetModal = false">
            
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Koleksi Template Contoh Pesan WA</h3>
                <p class="text-[11px] text-gray-400 mt-0.5">Pilih salah satu template siap pakai di bawah ini. Kode penanda variabel otomatis menyesuaikan data undangan.</p>
            </div>

            <div class="flex-1 overflow-y-auto pr-1 space-y-3 max-h-[50vh] scrollbar-thin">
                <template x-for="preset in presets" :key="preset.name">
                    <div class="border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 p-4 rounded-2xl flex flex-col justify-between hover:border-brand/50 transition-all">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-extrabold text-gray-700 dark:text-gray-300" x-text="preset.name"></span>
                            <button 
                                type="button"
                                @click="selectPreset(preset.text)"
                                class="text-[10px] font-bold bg-brand text-white px-3 py-1 rounded-lg hover:bg-brand-dark transition-all cursor-pointer shadow-sm"
                            >
                                Use Template
                            </button>
                        </div>
                        <pre class="mt-2 text-[11px] text-gray-500 dark:text-gray-400 font-sans leading-relaxed whitespace-pre-line bg-white dark:bg-gray-800 p-3 rounded-xl border border-gray-100 dark:border-gray-700 select-all" x-text="preset.text"></pre>
                    </div>
                </template>
            </div>

            <div class="pt-2 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                <button 
                    type="button" 
                    @click="openPresetModal = false" 
                    class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-xs font-bold rounded-xl hover:bg-gray-200 transition-all cursor-pointer"
                >
                    Tutup Pustaka
                </button>
            </div>

        </div>
    </div>
</div>