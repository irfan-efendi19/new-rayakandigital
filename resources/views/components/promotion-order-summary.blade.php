@props(['order'])

@if($order->discount_amount > 0)
    <dl class="my-4 space-y-2 rounded-xl bg-emerald-50 p-4 text-sm text-emerald-900 dark:bg-emerald-900/20 dark:text-emerald-200">
        <div class="flex justify-between gap-3"><dt>Harga sebelum diskon</dt><dd>Rp {{ number_format($order->original_amount, 0, ',', '.') }}</dd></div>
        <div class="flex justify-between gap-3"><dt>{{ $order->promotion_title }} @if($order->promotion_code)({{ $order->promotion_code }})@endif</dt><dd class="whitespace-nowrap">− Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</dd></div>
        <div class="flex justify-between gap-3 font-bold"><dt>Harga setelah diskon</dt><dd>Rp {{ number_format($order->gross_amount, 0, ',', '.') }}</dd></div>
    </dl>
@endif
