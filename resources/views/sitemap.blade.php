<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Static pages -->
    @foreach([
        ['/', '1.0', 'weekly'],
        ['/jsem-tu-poprve', '0.9', 'monthly'],
        ['/kdo-jsme', '0.8', 'monthly'],
        ['/nedele', '0.8', 'monthly'],
        ['/co-delame', '0.8', 'monthly'],
        ['/co-delame/nedelni-setkani', '0.7', 'monthly'],
        ['/co-delame/wyldlife', '0.7', 'monthly'],
        ['/co-delame/kidztown', '0.7', 'monthly'],
        ['/co-delame/skupinky', '0.7', 'monthly'],
        ['/kazani', '0.9', 'weekly'],
        ['/akce', '0.9', 'daily'],
        ['/kontakt', '0.7', 'monthly'],
        ['/prispet', '0.6', 'monthly'],
    ] as [$loc, $priority, $changefreq])
    <url>
        <loc>{{ config('app.url') }}{{ $loc }}</loc>
        <changefreq>{{ $changefreq }}</changefreq>
        <priority>{{ $priority }}</priority>
    </url>
    @endforeach

    <!-- Sermons -->
    @foreach($sermons as $sermon)
    <url>
        <loc>{{ config('app.url') }}/kazani/{{ $sermon->slug }}</loc>
        <lastmod>{{ $sermon->updated_at->toAtomString() }}</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach

    <!-- Events -->
    @foreach($events as $event)
    <url>
        <loc>{{ config('app.url') }}/akce/{{ $event->slug }}</loc>
        <lastmod>{{ $event->updated_at->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach
</urlset>
