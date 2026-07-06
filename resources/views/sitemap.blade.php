<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($urls as $url)
    <url>
        <loc>{{ config('app.url') }}{{ $url['loc'] }}</loc>
        <priority>{{ $url['priority'] }}</priority>
        <changefreq>{{ $url['changefreq'] }}</changefreq>
@if (isset($url['lastmod']))
        <lastmod>{{ $url['lastmod'] }}</lastmod>
@endif
    </url>
@endforeach
</urlset>
