<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>https://topnganhang.net/</loc>
        <lastmod>{{date('Y-m-d')}}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>
    @foreach($banks as $bankItem)
        @foreach($districts as $districItem)
            <url>
                <loc>{{route('district-bank', ['bank_name' => $bankItem->slug, 'province' => $districItem->province->slug, 'district' => $districItem->slug])}}</loc>
                <lastmod>{{date('Y-m-d', strtotime($districItem->created_at))}}</lastmod>
                <changefreq>daily</changefreq>
                <priority>0.9</priority>
            </url>
        @endforeach
    @endforeach
</urlset>