@props([
    'title' => config('app.name', 'Rayakan Digital'),
    'description' => 'Rayakan Digital menyediakan undangan online, buku tamu digital, QR code, dan live streaming untuk acara modern Anda. Buat momen berkesan jadi lebih praktis!',
    'keywords' => 'rayakan digital, undangan digital, undangan online, undangan pernikahan, QR code tamu, buku tamu digital, live streaming acara, website undangan, acara modern, undangan web',
    'author' => 'Rayakan Digital',
    'themeColor' => '#fa9a00',
    'image' => null,
    'url' => url()->current(),
    'type' => 'website',
    'siteName' => config('app.name', 'Rayakan Digital'),
    'robots' => 'index, follow',
    'twitterCard' => 'summary_large_image',
])

<title>{{ $title }}</title>

<meta name="theme-color" content="{{ $themeColor }}">
<meta name="msapplication-navbutton-color" content="{{ $themeColor }}">
<meta name="apple-mobile-web-app-status-bar-style" content="{{ $themeColor }}">

<meta name="robots" content="{{ $robots }}" />
<meta name="description" content="{{ $description }}">
<meta name="author" content="{{ $author }}">
<meta name="keywords" content="{{ $keywords }}">
<meta http-equiv="Copyright" content="{{ $author }}">
<meta name="copyright" content="{{ $author }}">

<meta property="og:type" content="{{ $type }}" />
<meta property="og:title" content="{{ $title }}" />
<meta property="og:description" content="{{ $description }}" />
<meta property="og:site_name" content="{{ $siteName }}" />
<meta property="og:url" content="{{ $url }}" />
@if($image)
<meta property="og:image" content="{{ $image }}" />
@endif

<meta name="twitter:card" content="{{ $twitterCard }}" />
<meta name="twitter:title" content="{{ $title }}" />
<meta name="twitter:description" content="{{ $description }}" />
@if($image)
<meta name="twitter:image" content="{{ $image }}" />
@endif

<meta itemprop="name" content="{{ $title }}" />
<meta itemprop="description" content="{{ $description }}" />
@if($image)
<meta itemprop="image" content="{{ $image }}" />
@endif
