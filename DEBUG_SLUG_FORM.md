# Debug Guide: Invitation Custom Link Update

## Penyebab Masalah (Sudah Diperbaiki)

1. **JavaScript Syntax Error** di `slug-editor.js` - sudah diperbaiki
2. **Logika Update Slug** di controller - sudah diperbaiki dan di-test
3. **Form Submission Blocking** - sekarang sudah lebih clear dengan logging

## Testing Steps

### Step 1: Clear Browser Cache & Reload
```bash
# Force refresh dengan cache clear (Ctrl+F5 atau Cmd+Shift+R)
# Atau di DevTools > Application > Clear site data
```

### Step 2: Open Developer Console
- Buka halaman edit undangan
- Tekan `F12` atau `Ctrl+Shift+I`
- Buka tab "Console"

### Step 3: Test Form Submission Manually

Di DevTools Console, copy & paste ini:
```javascript
// Test 1: Check slug form element
const slugInput = document.getElementById('slug-input');
console.log('Slug input found:', !!slugInput);
console.log('Current slug:', slugInput?.value);
console.log('Original slug:', slugInput?.dataset.original);

// Test 2: Manually change slug value
slugInput.value = 'test-link-' + Date.now();
slugInput.dispatchEvent(new Event('input', { bubbles: true }));
console.log('Changed slug to:', slugInput.value);

// Wait 1 second for availability check
setTimeout(() => {
  const form = document.querySelector('form');
  console.log('Form element:', !!form);
  console.log('Form action:', form?.action);
  console.log('Form method:', form?.method);
}, 1000);
```

### Step 4: Monitor Console Output
- Lihatlah output dari console
- Seharusnya ada log messages seperti:
  - "Changed slug to: test-link-..."
  - "Form element: true"
  - "Form action: http://..."

### Step 5: Try Submitting Form Through Browser
1. Di halaman edit, ubah slug menjadi nilai baru (misal: `my-new-link`)
2. Tunggu 1 detik hingga indikator menunjukkan "✓ Tersedia"
3. Klik "Simpan Perubahan"
4. Lihat di Console tab apakah ada:
   - "Form submitted: ..."
   - "Confirmation accepted, submitting form"
5. Lihat di Network tab apakah ada POST request ke `/dashboard/invitations/{id}`

## Troubleshooting

### Jika console kosong saat submit:
- Kemungkinan form tidak intercept submit event
- Check apakah `slug-editor.js` terbuild dengan benar
- Try hard refresh: `Ctrl+Shift+Delete` untuk buka cache clear

### Jika ada validation error:
- Check console untuk error message
- Pastikan field wajib (bride_name, groom_name) sudah terisi
- Check Network tab untuk melihat response error dari server

### Jika "Form submission blocked":
- Mungkin ada field validation yang gagal
- Try fill semua field dengan data valid sebelum submit
- Check `theme` field juga harus dipilih

## Quick Test - Copy This Entire Code

Buka DevTools Console dan paste ini:

```javascript
console.clear();
console.log('=== SLUG FORM DEBUG TEST ===');

const slugInput = document.getElementById('slug-input');
const form = document.querySelector('form');

if (!slugInput || !form) {
  console.error('❌ Form elements not found!');
  console.log('slug-input found:', !!slugInput);
  console.log('form found:', !!form);
} else {
  console.log('✓ Form elements found');
  console.log('Current slug:', slugInput.value);
  console.log('Original slug:', slugInput.dataset.original);
  
  // Test form submission
  console.log('\n=== Testing Form Submission ===');
  
  const testHandler = (e) => {
    console.log('✓ Form submit event triggered');
    console.log('Event type:', e.type);
    console.log('Is prevented:', e.defaultPrevented);
  };
  
  form.addEventListener('submit', testHandler, true);
  
  console.log('Event listener attached. Try clicking "Simpan Perubahan"');
  
  // Show this after 10 seconds
  setTimeout(() => {
    console.log('If no "Form submit event triggered" appeared above, there may be an issue.');
    form.removeEventListener('submit', testHandler, true);
  }, 10000);
}
```

## Pesan untuk User

Jika masih gagal setelah perbaikan ini, mohon:
1. Screenshot DevTools Console output
2. Screenshot Network tab saat submit
3. Pastikan sudah hard refresh (Ctrl+Shift+F5)
4. Share informasi di atas untuk debugging lebih lanjut
