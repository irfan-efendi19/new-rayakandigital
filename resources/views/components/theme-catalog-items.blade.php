@props(['themes', 'variant' => 'catalog'])

@foreach($themes as $theme)
    <x-theme-card :theme="$theme" :variant="$variant ?? 'catalog'" />
@endforeach
