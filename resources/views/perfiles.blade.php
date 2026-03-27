<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kinesiologas en Juliaca — Directorio Completo | MiaJuliaca</title>
    <meta name="description" content="Directorio completo de kinesiologas en Juliaca. Encuentra escorts, damas de compañía y relax en Juliaca y Puno. Perfiles verificados con fotos reales. Contacto directo por WhatsApp.">
    <meta name="keywords" content="kinesiologas juliaca, escorts juliaca, relax juliaca, directorio kines juliaca, damas de compañia juliaca, servicio relax juliaca, acompañantes juliaca, chicas relax juliaca, kinesiologas puno">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="author" content="MiaJuliaca">

    <meta name="geo.region"    content="PE-PUN">
    <meta name="geo.placename" content="Juliaca, San Román, Puno, Perú">
    <meta name="geo.position"  content="-15.5000;-70.1333">
    <meta name="ICBM"          content="-15.5000, -70.1333">

    <link rel="canonical" href="{{ route('perfiles') }}">

    <meta property="og:type"        content="website">
    <meta property="og:title"       content="Kinesiologas en Juliaca — Directorio | MiaJuliaca">
    <meta property="og:description" content="Directorio completo de kinesiologas, escorts y relax en Juliaca y Puno. Perfiles verificados.">
    <meta property="og:url"         content="{{ route('perfiles') }}">
    <meta property="og:locale"      content="es_PE">
    <meta property="og:site_name"   content="MiaJuliaca">

    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="Kinesiologas en Juliaca — Directorio | MiaJuliaca">
    <meta name="twitter:description" content="Directorio de kinesiologas y escorts en Juliaca. Perfiles verificados con fotos reales.">

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .font-cormorant { font-family: 'Cormorant Garamond', serif; }
        :root {
            --rose: #e8436a; --rose-dark: #c2274e; --rose-soft: rgba(232,67,106,.08);
            --gold: #d4a853; --gold-soft: rgba(212,168,83,.10);
            --bg: #0a0a14; --surface: #111119; --surface-2: #181825; --surface-3: #202030;
            --border: rgba(255,255,255,.07); --border-2: rgba(255,255,255,.12);
            --border-gold: rgba(212,168,83,.2);
            --text: #f0f0f5; --text-2: #a0a0b8; --text-3: #55556a;
            --success: #10d98a;
        }
        .card-verificada { border-left: 3px solid var(--gold) !important; }
        .card-inactiva   { border-left: 3px solid var(--surface-3) !important; }
        .line-clamp-2 { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
        .perfil-row { transition: background .15s, transform .15s; }
        .perfil-row:hover { background: var(--surface-2) !important; transform: translateX(3px); }
        .pagination-wrap nav { display:flex; justify-content:center; }
        .pagination-wrap span[aria-current="page"] > span,
        .pagination-wrap span[aria-disabled] > span { display:inline-flex; align-items:center; justify-content:center; min-width:38px; height:38px; border-radius:8px; font-size:.83rem; font-weight:600; }
        .pagination-wrap span[aria-current="page"] > span { background:var(--rose); color:white; border:1px solid var(--rose); }
        .pagination-wrap span[aria-disabled] > span { background:var(--surface); color:var(--text-3); border:1px solid var(--border); opacity:.4; }
        .pagination-wrap a { display:inline-flex; align-items:center; justify-content:center; min-width:38px; height:38px; border-radius:8px; font-size:.83rem; font-weight:600; text-decoration:none; color:var(--text-2); background:var(--surface); border:1px solid var(--border); transition:all .15s; }
        .pagination-wrap a:hover { background:var(--surface-2); color:var(--text); border-color:var(--border-2); }
        .pagination-wrap ul { display:flex; gap:.4rem; flex-wrap:wrap; list-style:none; padding:0; margin:0; }
        @keyframes fadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
        .fade-up { animation: fadeUp .4s ease both; }
    </style>
</head>

<body class="min-h-screen" style="background:var(--bg);color:var(--text)">

<nav class="sticky top-0 z-50 h-16 flex items-center justify-between px-5 md:px-16"
     style="background:rgba(10,10,20,.85);backdrop-filter:blur(20px);border-bottom:1px solid var(--border)">
    <a href="{{ route('home') }}" class="font-cormorant text-2xl md:text-[1.7rem] font-bold no-underline" style="color:var(--text)" title="Kinesiologas Juliaca — MiaJuliaca">
        ♥ <em style="color:var(--rose);font-style:normal">Mia</em>Juliaca
    </a>
    <div class="flex items-center gap-2 md:gap-3">
        <a href="{{ route('home') }}" class="inline-flex items-center px-3 md:px-4 py-2 rounded-lg text-sm font-semibold no-underline" style="background:transparent;color:var(--text-2);border:1px solid var(--border)">← Inicio</a>
        @auth
            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-3 md:px-4 py-2 rounded-lg text-sm font-bold text-white no-underline" style="background:var(--rose)">Panel Admin</a>
            @else
                <a href="{{ route('usuario.dashboard') }}" class="inline-flex items-center px-3 md:px-4 py-2 rounded-lg text-sm font-bold text-white no-underline" style="background:var(--rose)">Mi cuenta</a>
            @endif
        @else
            <a href="{{ route('login') }}"    class="hidden sm:inline-flex items-center px-3 py-2 rounded-lg text-sm font-semibold no-underline" style="color:var(--text-2);border:1px solid var(--border)">Iniciar sesión</a>
            <a href="{{ route('register') }}" class="inline-flex items-center px-3 md:px-4 py-2 rounded-lg text-sm font-bold text-white no-underline" style="background:var(--rose)">Publicar perfil</a>
        @endauth
    </div>
</nav>

<div class="max-w-3xl mx-auto px-4 md:px-8 py-8 pb-16">

    @if($perfiles->isEmpty())
        <div class="text-center py-20 px-8" style="color:var(--text-3)">
            <div class="text-6xl mb-4">🌙</div>
            <h1 class="font-cormorant text-2xl mb-2" style="color:var(--text-2)">Sin kinesiologas activas en Juliaca</h1>
            <p class="text-sm">Próximamente habrá perfiles disponibles. Vuelve pronto.</p>
        </div>
    @else
        @php
            $activos   = $perfiles->filter(fn($p) => !is_null($p->promo_fecha_fin));
            $inactivos = $perfiles->filter(fn($p) =>  is_null($p->promo_fecha_fin));
        @endphp

        {{-- H1 visible y con keyword principal --}}
        <h1 class="font-cormorant font-bold mb-6" style="font-size:clamp(1.4rem,3vw,1.8rem);color:var(--text)">
            Kinesiologas en Juliaca
            <span class="text-sm font-normal" style="color:var(--text-3);font-family:'Outfit',sans-serif">
                — {{ $perfiles->total() }} {{ $perfiles->total() === 1 ? 'perfil' : 'perfiles' }}
            </span>
        </h1>

        @if($activos->count() > 0)
            <div class="flex items-center gap-3 mb-4 fade-up">
                <span class="text-[.7rem] font-bold uppercase tracking-[.12em]" style="color:var(--gold)">⭐ Verificadas</span>
                <div class="flex-1 h-px" style="background:var(--border-gold)"></div>
                <span class="text-[.7rem]" style="color:var(--text-3)">{{ $activos->count() }}</span>
            </div>

            <ul class="flex flex-col gap-3 mb-10 list-none p-0 m-0">
                @foreach($activos as $perfil)
                    @php
                        $dias    = max(0, (int) now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($perfil->promo_fecha_fin), false));
                        $portada = $perfil->fotos->where('es_portada', true)->first() ?? $perfil->fotos->first();
                    @endphp
                    <li itemscope itemtype="https://schema.org/Person">
                        <a href="{{ route('perfil.publico', $perfil->nombre_usuario) }}"
                           class="perfil-row card-verificada flex items-start gap-4 no-underline rounded-xl p-4"
                           style="background:var(--surface);border:1px solid var(--border-gold);color:inherit;display:flex">
                            <div class="shrink-0 w-24 h-28 md:w-28 md:h-36 rounded-[10px] overflow-hidden flex items-center justify-center text-2xl font-bold text-white"
                                 style="{{ $portada ? '' : 'background:linear-gradient(135deg,var(--rose),var(--rose-dark))' }}">
                                @if($portada)
                                    <img src="{{ asset('storage/'.$portada->ruta) }}"
                                         class="w-full h-full object-cover"
                                         alt="Kinesiologa {{ $perfil->nombre_usuario }} en {{ $perfil->ciudad ?? 'Juliaca' }}"
                                         loading="lazy" itemprop="image">
                                @else
                                    {{ strtoupper(substr($perfil->nombre_usuario, 0, 1)) }}
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap mb-1">
                                    <span class="font-cormorant text-xl font-bold leading-tight" style="color:var(--rose)" itemprop="name">{{ $perfil->nombre_usuario }}</span>
                                    @if($dias <= 2 && $dias > 0)
                                        <span class="text-[.65rem] font-bold px-1.5 py-0.5 rounded-full" style="background:var(--gold-soft);border:1px solid rgba(212,168,83,.25);color:var(--gold)">⏳ {{ $dias }}d</span>
                                    @else
                                        <span class="text-[.65rem] font-bold px-1.5 py-0.5 rounded-full" style="background:var(--gold-soft);border:1px solid rgba(212,168,83,.25);color:var(--gold)">✓ Verificada</span>
                                    @endif
                                </div>
                                @if($perfil->descripcion)
                                    <p class="line-clamp-2 text-sm leading-relaxed mb-2" style="color:var(--text-2)" itemprop="description">{{ $perfil->descripcion }}</p>
                                @endif
                                <div class="flex flex-wrap items-center gap-3 text-xs" style="color:var(--text-3)">
                                    @if($perfil->edad)<span>🗓 {{ $perfil->edad }} años</span>@endif
                                    @if($perfil->ciudad)<span itemprop="addressLocality">📍 {{ $perfil->ciudad }}</span>@endif
                                    @if($perfil->precio)<span class="font-bold text-sm" style="color:var(--success)">S/. {{ number_format($perfil->precio, 0) }}</span>@endif
                                    @if($perfil->numero_celular)<span>{{ $perfil->numero_celular }}</span>@endif
                                </div>
                            </div>
                            <div class="shrink-0 self-center text-lg" style="color:var(--gold)">→</div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif

        @if($inactivos->count() > 0)
            <div class="flex items-center gap-3 mb-4 fade-up">
                <span class="text-[.7rem] font-bold uppercase tracking-[.12em]" style="color:var(--text-3)">Sin verificación</span>
                <div class="flex-1 h-px" style="background:var(--border)"></div>
                <span class="text-[.7rem]" style="color:var(--text-3)">{{ $inactivos->count() }}</span>
            </div>

            <ul class="flex flex-col gap-3 list-none p-0 m-0">
                @foreach($inactivos as $perfil)
                    @php $portada = $perfil->fotos->where('es_portada', true)->first() ?? $perfil->fotos->first(); @endphp
                    <li>
                        <a href="{{ route('perfil.publico', $perfil->nombre_usuario) }}"
                           class="perfil-row card-inactiva flex items-start gap-4 no-underline rounded-xl p-4 opacity-70 hover:opacity-100"
                           style="background:var(--surface);border:1px solid var(--border);color:inherit;display:flex">
                            <div class="shrink-0 w-24 h-28 md:w-28 md:h-36 rounded-[10px] overflow-hidden flex items-center justify-center text-2xl font-bold"
                                 style="background:var(--surface-3);color:var(--text-3);filter:grayscale(.7)">
                                @if($portada)
                                    <img src="{{ asset('storage/'.$portada->ruta) }}" class="w-full h-full object-cover"
                                         alt="Escort {{ $perfil->nombre_usuario }} Juliaca" loading="lazy">
                                @else
                                    {{ strtoupper(substr($perfil->nombre_usuario, 0, 1)) }}
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap mb-1">
                                    <span class="font-cormorant text-xl font-bold leading-tight" style="color:var(--text)">{{ $perfil->nombre_usuario }}</span>
                                    <span class="text-[.65rem] font-bold px-1.5 py-0.5 rounded-full" style="background:var(--surface-2);border:1px solid var(--border);color:var(--text-3)">Sin publicidad</span>
                                </div>
                                @if($perfil->descripcion)
                                    <p class="line-clamp-2 text-sm leading-relaxed mb-2" style="color:var(--text-2)">{{ $perfil->descripcion }}</p>
                                @endif
                                <div class="flex flex-wrap items-center gap-3 text-xs" style="color:var(--text-3)">
                                    @if($perfil->edad)<span>🗓 {{ $perfil->edad }} años</span>@endif
                                    @if($perfil->ciudad)<span>📍 {{ $perfil->ciudad }}</span>@endif
                                    @if($perfil->precio)<span class="font-bold text-sm" style="color:var(--success)">S/. {{ number_format($perfil->precio, 0) }}</span>@endif
                                </div>
                            </div>
                            <div class="shrink-0 self-center text-lg" style="color:var(--text-3)">→</div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif

        @if($perfiles->hasPages())
            <div class="pagination-wrap mt-10 flex justify-center">{{ $perfiles->links() }}</div>
        @endif
    @endif
</div>

<footer style="border-top:1px solid var(--border)">
    <div class="max-w-3xl mx-auto px-4 md:px-8 py-6 flex flex-wrap items-center justify-between gap-4">
        <a href="{{ route('home') }}" class="font-cormorant text-xl font-bold no-underline" style="color:var(--text)">
            ♥ <em style="color:var(--rose);font-style:normal">Mia</em>Juliaca
        </a>
        <nav aria-label="Footer links" class="flex flex-wrap gap-5">
            <a href="{{ route('home') }}"     class="text-xs no-underline hover:opacity-80" style="color:var(--text-3)">Inicio</a>
            <a href="{{ route('perfiles') }}" class="text-xs no-underline hover:opacity-80" style="color:var(--text-3)">Kinesiologas Juliaca</a>
            @guest<a href="{{ route('register') }}" class="text-xs font-bold no-underline" style="color:var(--rose)">Publicar anuncio →</a>@endguest
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
      "@type": "BreadcrumbList",
      "itemListElement": [
        { "@type": "ListItem", "position": 1, "name": "Inicio", "item": "{{ url('/') }}" },
        { "@type": "ListItem", "position": 2, "name": "Kinesiologas en Juliaca", "item": "{{ route('perfiles') }}" }
      ]
    },
    {
      "@type": "CollectionPage",
      "name": "Kinesiologas en Juliaca — Directorio Completo",
      "description": "Directorio de kinesiologas, escorts y damas de compañía en Juliaca y Puno, Perú.",
      "url": "{{ route('perfiles') }}",
      "inLanguage": "es-PE"
    }
  ]
}
</script>
@endverbatim
</body>
</html>