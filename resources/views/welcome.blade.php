<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kinesiologas en Juliaca Hoy | Escorts y Putas en Juliaca — MiaJuliaca</title>
    <meta name="description" content="Encuentra las mejores kinesiologas en Juliaca. Escorts, modelos y damas de compañía con fotos reales y contacto directo por WhatsApp. Servicio de relax en Juliaca las 24 horas.">
    <meta name="keywords" content="kinesiologas juliaca, escorts juliaca, putas juliaca, relax juliaca, kines juliaca, señoritas juliaca, damas de compañia juliaca, masajes relax juliaca">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <meta name="author" content="MiaJuliaca">

    <meta name="geo.region" content="PE-PUN">
    <meta name="geo.placename" content="Juliaca">
    <meta name="geo.position" content="-15.4967;-70.1333">
    <meta name="ICBM" content="-15.4967, -70.1333">

    <link rel="canonical" href="{{ url('/') }}">

    <meta property="og:type" content="website">
    <meta property="og:title" content="Kinesiologas y Escorts en Juliaca | Fotos Reales — MiaJuliaca">
    <meta property="og:description" content="El mejor directorio de relax en Juliaca. Kinesiologas verificadas con atención inmediata.">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:site_name" content="MiaJuliaca">
    <meta property="og:locale" content="es_PE">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Kinesiologas en Juliaca | MiaJuliaca">
    <meta name="twitter:description" content="Kinesiologas, escorts y relax en Juliaca. Perfiles verificados con fotos reales.">

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,600&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; background: #0a0a14; color: #f0f0f5; }
        .font-cormorant { font-family: 'Cormorant Garamond', serif; }
        :root {
            --rose: #e8436a; --rose-dark: #c2274e;
            --gold: #d4a853; --gold-soft: rgba(212,168,83,.10);
            --surface: #111119; --surface-2: #181825; --surface-3: #202030;
            --border: rgba(255,255,255,.07); --border-gold: rgba(212,168,83,.2);
            --text-2: #a0a0b8; --text-3: #55556a; --success: #10d98a;
        }
        .card-verificada { border-left: 3px solid var(--gold) !important; }
        .card-inactiva { border-left: 3px solid var(--surface-3) !important; }
        .line-clamp-2 { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
        .perfil-row { transition: background .15s, transform .15s; }
        .perfil-row:hover { background: var(--surface-2) !important; transform: translateX(3px); }
        @keyframes fadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
        .fade-up { animation: fadeUp .4s ease both; }
    </style>
</head>

<body class="overflow-x-hidden">

<nav class="sticky top-0 z-50 h-16 flex items-center justify-between px-5 md:px-16"
     style="background:rgba(10,10,20,.85);backdrop-filter:blur(20px);border-bottom:1px solid var(--border)">
    <a href="{{ route('home') }}" class="font-cormorant text-2xl md:text-[1.7rem] font-bold no-underline text-white" title="Kinesiologas en Juliaca — MiaJuliaca">
        ♥ <em style="color:var(--rose);font-style:normal">Mia</em>Juliaca
    </a>
    <div class="flex items-center gap-2 md:gap-3">
        @auth
            <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('usuario.dashboard') }}"
               class="inline-flex items-center px-3 md:px-4 py-2 rounded-lg text-sm font-bold text-white no-underline"
               style="background:var(--rose)">{{ Auth::user()->isAdmin() ? 'Panel Admin' : 'Mi cuenta' }}</a>
        @else
            <a href="{{ route('login') }}" class="inline-flex items-center px-3 md:px-4 py-2 rounded-lg text-sm font-semibold no-underline" style="color:var(--text-2);border:1px solid var(--border)">Iniciar sesión</a>
            <a href="{{ route('register') }}" class="inline-flex items-center px-3 md:px-4 py-2 rounded-lg text-sm font-bold text-white no-underline" style="background:var(--rose)">Publicar perfil</a>
        @endauth
    </div>
</nav>

<div class="max-w-3xl mx-auto px-4 md:px-8 py-8 pb-12">
    <header class="mb-8 fade-up">
        <h1 class="font-cormorant font-bold leading-[1.1]" style="font-size:clamp(1.8rem, 5vw, 2.5rem)">
            Kinesiologas y Escorts en <span style="color:var(--rose)">Juliaca</span>
        </h1>
        <p class="text-sm mt-2" style="color:var(--text-2)">
            Explora el directorio más completo de <strong>relax en Juliaca</strong>. Perfiles verificados, fotos reales y atención garantizada.
        </p>
    </header>

    @if($perfiles->isEmpty())
        <div class="text-center py-20 px-8" style="color:var(--text-3)">
            <div class="text-6xl mb-4">🌙</div>
            <h2 class="font-cormorant text-2xl mb-2" style="color:var(--text-2)">Sin kinesiologas activas por ahora</h2>
            <p class="text-sm">Próximamente habrá perfiles disponibles en Juliaca. Vuelve pronto.</p>
        </div>
    @else
        @php
            $verificados = $perfiles->filter(fn($p) => !is_null($p->promo_fecha_fin));
            $sin_promo   = $perfiles->filter(fn($p) => is_null($p->promo_fecha_fin));
            $hero_fotos  = $verificados->sortByDesc('promo_fecha_fin')->take(2);
        @endphp

        <div class="relative flex mb-8 rounded-[14px] fade-up overflow-hidden" style="background:var(--surface);border:1px solid var(--border-gold);min-height:190px">
            <div class="flex-1 min-w-0 flex flex-col justify-center p-5 md:p-7">
                <div class="text-[.68rem] font-bold uppercase tracking-[.14em] mb-2" style="color:var(--gold)">Juliaca Relax</div>
                <div class="font-cormorant font-bold leading-[1.1] mb-2 text-white" style="font-size:clamp(1.4rem,3vw,1.9rem)">Kinesiologas y Escorts<br>en Juliaca</div>
                <p class="text-xs leading-relaxed mb-4" style="color:var(--text-2);max-width:320px">Bienvenido a <strong>Juliaca Relax</strong> — anuncios de Kinesiologas, Escorts y Damas de compañía en Juliaca.</p>
                <div><a href="{{ route('perfiles') }}" class="inline-flex items-center px-4 py-2 rounded-lg text-xs font-bold text-white no-underline" style="background:var(--rose)">Ver Disponibles →</a></div>
            </div>
            @if($hero_fotos->count() > 0)
                <div class="flex shrink-0" style="gap:4px;padding:4px 4px 4px 0">
                    @foreach($hero_fotos as $hp)
                        @php $hPortada = $hp->fotos->where('es_portada', true)->first() ?? $hp->fotos->first(); @endphp
                        <a href="{{ route('perfil.publico', $hp->nombre_usuario) }}" class="relative block no-underline overflow-hidden rounded-[10px]" style="width:120px;border:1px solid rgba(212,168,83,.25)">
                            @if($hPortada)
                                <img src="{{ asset('storage/'.$hPortada->ruta) }}" class="w-full h-full object-contain" style="display:block;background:#0a0a14" alt="Kinesiologa {{ $hp->nombre_usuario }} Juliaca - Fotos Reales">
                            @else
                                <div class="w-full h-full flex items-center justify-center font-cormorant text-2xl font-bold text-white" style="background:linear-gradient(135deg,var(--rose),var(--rose-dark))">{{ strtoupper(substr($hp->nombre_usuario, 0, 1)) }}</div>
                            @endif
                            <div class="absolute bottom-0 left-0 right-0 px-1.5 py-1.5 text-center" style="background:linear-gradient(transparent,rgba(0,0,0,.82))">
                                <span class="font-cormorant text-xs font-bold text-white truncate block">{{ $hp->nombre_usuario }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        @if($verificados->count() > 0)
            <div class="flex items-center gap-3 mb-4 fade-up">
                <span class="text-[.7rem] font-bold uppercase tracking-[.12em]" style="color:var(--gold)">Kines Disponibles</span>
                <div class="flex-1 h-px" style="background:var(--border-gold)"></div>
                <span class="text-[.7rem]" style="color:var(--text-3)">{{ $verificados->count() }}</span>
            </div>
            <ul class="flex flex-col gap-3 mb-10 list-none p-0 m-0">
                @foreach($verificados as $perfil)
                    @php
                        $diasRestantes = max(0, (int) now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($perfil->promo_fecha_fin), false));
                        $portada = $perfil->fotos->where('es_portada', true)->first() ?? $perfil->fotos->first();
                    @endphp
                    <li>
                        <a href="{{ route('perfil.publico', $perfil->nombre_usuario) }}" class="perfil-row card-verificada flex items-start gap-4 no-underline rounded-xl p-4" style="background:var(--surface);border:1px solid var(--border-gold);color:inherit;display:flex">
                            <div class="shrink-0 w-24 h-28 md:w-28 md:h-36 rounded-[10px] overflow-hidden flex items-center justify-center text-2xl font-bold text-white" style="{{ $portada ? '' : 'background:linear-gradient(135deg,var(--rose),var(--rose-dark))' }}">
                                @if($portada)
                                    <img src="{{ asset('storage/'.$portada->ruta) }}" class="w-full h-full object-cover" alt="Kinesiologa {{ $perfil->nombre_usuario }} en Juliaca - Fotos Reales">
                                @else
                                    {{ strtoupper(substr($perfil->nombre_usuario, 0, 1)) }}
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap mb-1">
                                    <span class="font-cormorant text-xl font-bold leading-tight" style="color:var(--rose)">{{ $perfil->nombre_usuario }}</span>
                                    <span class="text-[.65rem] font-bold px-1.5 py-0.5 rounded-full" style="background:var(--gold-soft);border:1px solid rgba(212,168,83,.25);color:var(--gold)">
                                        {{ ($diasRestantes <= 2 && $diasRestantes > 0) ? "⏳ $diasRestantes d" : "✓ Verificada" }}
                                    </span>
                                </div>
                                @if($perfil->descripcion)<p class="line-clamp-2 text-sm leading-relaxed mb-2" style="color:var(--text-2)">{{ $perfil->descripcion }}</p>@endif
                                <div class="flex flex-wrap items-center gap-3 text-xs" style="color:var(--text-3)">
                                    @if($perfil->edad)<span>🗓 {{ $perfil->edad }} años</span>@endif
                                    @if($perfil->ciudad)<span>📍 {{ $perfil->ciudad }}</span>@endif
                                    @if($perfil->precio)<span class="font-bold text-sm" style="color:var(--success)">S/. {{ number_format($perfil->precio, 0) }}</span>@endif
                                </div>
                            </div>
                            <div class="shrink-0 self-center text-lg" style="color:var(--gold)">→</div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif

        @if($sin_promo->count() > 0)
            <div class="flex items-center gap-3 mb-4 fade-up">
                <span class="text-[.7rem] font-bold uppercase tracking-[.12em]" style="color:var(--text-3)">Sin verificación</span>
                <div class="flex-1 h-px" style="background:var(--border)"></div>
                <span class="text-[.7rem]" style="color:var(--text-3)">{{ $sin_promo->count() }}</span>
            </div>
            <ul class="flex flex-col gap-3 list-none p-0 m-0">
                @foreach($sin_promo as $perfil)
                    @php $portada = $perfil->fotos->where('es_portada', true)->first() ?? $perfil->fotos->first(); @endphp
                    <li>
                        <a href="{{ route('perfil.publico', $perfil->nombre_usuario) }}" class="perfil-row card-inactiva flex items-start gap-4 no-underline rounded-xl p-4 opacity-70 hover:opacity-100" style="background:var(--surface);border:1px solid var(--border);color:inherit;display:flex">
                            <div class="shrink-0 w-24 h-28 md:w-28 md:h-36 rounded-[10px] overflow-hidden flex items-center justify-center text-2xl font-bold" style="background:var(--surface-3);color:var(--text-3);filter:grayscale(.7)">
                                @if($portada)<img src="{{ asset('storage/'.$portada->ruta) }}" class="w-full h-full object-cover" alt="Escort {{ $perfil->nombre_usuario }} Juliaca">
                                @else {{ strtoupper(substr($perfil->nombre_usuario, 0, 1)) }} @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap mb-1">
                                    <span class="font-cormorant text-xl font-bold leading-tight" style="color:inherit">{{ $perfil->nombre_usuario }}</span>
                                    <span class="text-[.65rem] font-bold px-1.5 py-0.5 rounded-full" style="background:var(--surface-2);border:1px solid var(--border);color:var(--text-3)">Sin publicidad</span>
                                </div>
                                @if($perfil->descripcion)<p class="line-clamp-2 text-sm leading-relaxed mb-2" style="color:var(--text-2)">{{ $perfil->descripcion }}</p>@endif
                                <div class="flex flex-wrap items-center gap-3 text-xs" style="color:var(--text-3)">
                                    @if($perfil->edad)<span>🗓 {{ $perfil->edad }} años</span>@endif
                                    @if($perfil->precio)<span class="font-bold text-sm" style="color:var(--success)">S/. {{ number_format($perfil->precio, 0) }}</span>@endif
                                </div>
                            </div>
                            <div class="shrink-0 self-center text-lg" style="color:var(--text-3)">→</div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    @endif

    <section class="mt-16 pt-8 border-t border-white/5">
        <h2 class="font-cormorant text-2xl font-bold mb-4" style="color:var(--gold)">Servicio de Relax y Kinesiologas en Juliaca</h2>
        <div class="text-xs leading-relaxed space-y-4" style="color:var(--text-2)">
            <p>Bienvenido a <strong>MiaJuliaca</strong>, el portal líder en anuncios para adultos en la ciudad de los vientos. Si estás buscando <strong>kinesiologas en Juliaca</strong> o <strong>escorts de lujo</strong>, nuestro sistema de verificación te asegura fotos 100% reales.</p>
            <p>Nuestro directorio incluye una amplia variedad de servicios de <strong>relax en Juliaca</strong>, desde masajes hasta damas de compañía. Facilitamos el contacto directo vía WhatsApp para garantizar discreción en <strong>kines Juliaca</strong> y Puno.</p>
            <h3 class="text-sm font-bold text-white">¿Por qué elegir MiaJuliaca?</h3>
            <ul class="list-disc pl-5">
                <li>Privacidad absoluta en tus búsquedas de <strong>putas en Juliaca</strong>.</li>
                <li>Perfiles actualizados con precios y servicios detallados.</li>
                <li>Atención personalizada por las mejores <strong>modelos y escorts</strong> de la región.</li>
            </ul>
        </div>
    </section>
</div>

@guest
<div class="max-w-3xl mx-auto px-4 md:px-8 mb-12">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5 p-6 md:p-8 rounded-[14px]" style="background:linear-gradient(135deg,rgba(232,67,106,.12),rgba(200,40,80,.06));border:1px solid rgba(232,67,106,.2)">
        <div>
            <h2 class="font-cormorant text-xl md:text-2xl font-bold mb-1">¿Eres kinesiologa en Juliaca?</h2>
            <p class="text-sm" style="color:var(--text-2)">Publica tu perfil y aparece en las búsquedas. Contacto directo con clientes.</p>
        </div>
        <a href="{{ route('register') }}" class="inline-flex items-center whitespace-nowrap px-5 py-2.5 rounded-lg text-sm font-bold text-white no-underline shrink-0" style="background:var(--rose)">Publicar mi anuncio →</a>
    </div>
</div>
@endguest

<footer style="border-top:1px solid var(--border)">
    <div class="max-w-3xl mx-auto px-4 md:px-8 py-6 flex flex-wrap items-center justify-between gap-4">
        <a href="{{ route('home') }}" class="font-cormorant text-xl font-bold no-underline text-white">♥ <em style="color:var(--rose);font-style:normal">Mia</em>Juliaca</a>
        <nav class="flex flex-wrap gap-5">
            <a href="{{ route('perfiles') }}" class="text-xs no-underline hover:opacity-80" style="color:var(--text-3)">Kinesiologas en Juliaca</a>
            @guest <a href="{{ route('register') }}" class="text-xs font-bold no-underline" style="color:var(--rose)">Publicar anuncio →</a> @endguest
        </nav>
        <span class="text-xs" style="color:var(--text-3)">© {{ date('Y') }} MiaJuliaca — Kinesiologas y Escorts en Juliaca</span>
    </div>
</footer>

@verbatim
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "WebSite",
      "@id": "{{ url('/') }}/#website",
      "url": "{{ url('/') }}",
      "name": "MiaJuliaca",
      "description": "Directorio de kinesiologas, escorts y relax en Juliaca y Puno, Perú.",
      "inLanguage": "es-PE"
    },
    {
      "@type": "LocalBusiness",
      "name": "MiaJuliaca",
      "description": "Kinesiologas, escorts y relax en Juliaca.",
      "url": "{{ url('/') }}",
      "priceRange": "S/. 50 - S/. 300",
      "areaServed": [{ "@type": "City", "name": "Juliaca" }, { "@type": "City", "name": "Puno" }],
      "address": { "@type": "PostalAddress", "addressLocality": "Juliaca", "addressRegion": "Puno", "addressCountry": "PE" },
      "geo": { "@type": "GeoCoordinates", "latitude": -15.4967, "longitude": -70.1333 }
    }
  ]
}
</script>
@endverbatim
</body>
</html>