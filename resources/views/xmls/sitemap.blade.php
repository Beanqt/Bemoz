<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    @foreach($urls as $url)
        @if(!in_array($url, $fail))
            <url>
                <loc>{{$domain}}{{$url}}</loc>
                <lastmod>{{date('c', strtotime(date('Y-m-d H:i:s')))}}</lastmod>
                <changefreq>monthly</changefreq>
                <priority>0.5</priority>
            </url>
        @endif
    @endforeach
</urlset>