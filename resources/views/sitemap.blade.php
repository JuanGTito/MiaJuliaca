{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>{{ url('/') }}</loc>
    <changefreq>daily</changefreq>
    <priority>1.0</priority>
  </url>
  <url>
    <loc>{{ route('perfiles') }}</loc>
    <changefreq>daily</changefreq>
    <priority>0.9</priority>
  </url>
  @foreach($perfiles as $p)
  <url>
    <loc>{{ route('perfil.publico', $p->nombre_usuario) }}</loc>
    <lastmod>{{ $p->updated_at->toAtomString() }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.7</priority>
  </url>
  @endforeach
</urlset>