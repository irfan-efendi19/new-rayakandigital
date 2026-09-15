<div>
    <x-input-label for="bank_name" value="Nama bank" />
    <x-text-input id="bank_name" name="bank_name" class="mt-1 w-full text-sm" :value="old('bank_name', $bank?->bank_name)" placeholder="Contoh: BCA, Mandiri, BNI" maxlength="100" required />
</div>
<div>
    <x-input-label for="bank_account_number" value="Nomor rekening" />
    <x-text-input id="bank_account_number" name="bank_account_number" inputmode="numeric" class="mt-1 w-full text-sm" :value="old('bank_account_number', $bank?->bank_account_number)" placeholder="Contoh: 1234567890" pattern="[0-9]{5,30}" required />
</div>
<div>
    <x-input-label for="bank_account_holder" value="Atas nama rekening" />
    <x-text-input id="bank_account_holder" name="bank_account_holder" class="mt-1 w-full text-sm" :value="old('bank_account_holder', $bank?->bank_account_holder)" placeholder="Nama sesuai rekening bank" maxlength="150" required />
</div>
