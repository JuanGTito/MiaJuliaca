<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- SEO primario -->
    <title>Chicas Relax en Juliaca y Puno</title>
    <meta name="description" content="Encuentra chicas relax en Juliaca, Puno y toda la región. Perfiles verificados con fotos, tarifas y contacto directo por WhatsApp. SisCitas.">
    <meta name="keywords" content="relax juliaca, chicas relax juliaca, servicio relax puno, relax puno, damas de compañia juliaca, acompañantes puno">

    <!-- Geo-targeting explícito -->
    <meta name="geo.region" content="PE-PUN">
    <meta name="geo.placename" content="Juliaca, Puno, Perú">
    <meta name="geo.position" content="-15.5000;-70.1333">
    <meta name="ICBM" content="-15.5000, -70.1333">

    <!-- Open Graph -->
    <meta property="og:title" content="Chicas Relax Juliaca y Puno | SisCitas">
    <meta property="og:description" content="Perfiles verificados de chicas relax en Juliaca y Puno. Contacto directo, fotos reales.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:locale" content="es_PE">

    <!-- Canonical -->
    <link rel="canonical" href="{{ url('/') }}">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .font-cormorant { font-family: 'Cormorant Garamond', serif; }

        :root {
            --rose: #e8436a; --rose-dark: #c2274e;
            --rose-glow: rgba(232,67,106,.3); --rose-soft: rgba(232,67,106,.08);
            --gold: #d4a853;
            --bg: #0a0a14; --surface: #111119; --surface-2: #181825;
            --border: rgba(255,255,255,.07); --border-2: rgba(255,255,255,.12);
            --text: #f0f0f5; --text-2: #a0a0b8; --text-3: #55556a;
            --success: #10d98a;
        }

        /* Hero glow */
        .hero-glow::before {
            content: '';
            position: absolute;
            width: 700px; height: 700px; border-radius: 50%;
            background: radial-gradient(circle, rgba(232,67,106,.1) 0%, transparent 70%);
            top: 50%; left: 50%; transform: translate(-50%, -50%);
            pointer-events: none;
        }

        /* Card top accent */
        .perfil-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--rose), var(--rose-dark));
            opacity: 0; transition: opacity .2s; border-radius: 14px 14px 0 0;
        }
        .perfil-card:hover::before { opacity: 1; }

        /* Line clamp */
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        @keyframes fadeUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
        .fade-up { animation: fadeUp .5s ease both; }
    </style>
</head>

<body class="overflow-x-hidden" style="background:var(--bg);color:var(--text)">

{{-- ═══════════════════════════════
     NAVBAR
═══════════════════════════════ --}}
<nav class="sticky top-0 z-50 h-16 md:h-17 flex items-center justify-between px-5 md:px-16"
     style="background:rgba(10,10,20,.85);backdrop-filter:blur(20px);border-bottom:1px solid var(--border)">

    <a href="{{ route('home') }}"
       class="font-cormorant text-2xl md:text-[1.7rem] font-bold no-underline"
       style="color:var(--text)">
        ♥ <em style="color:var(--rose);font-style:normal">Mia</em>Juliaca
    </a>

    <div class="flex items-center gap-2 md:gap-3">
        <a href="{{ route('perfiles') }}"
           class="hidden sm:inline-flex items-center px-3 md:px-4 py-2 rounded-lg text-sm font-semibold transition-all no-underline"
           style="background:transparent;color:var(--text-2);border:1px solid var(--border)">
            Ver perfiles
        </a>
        @auth
            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}"
                   class="inline-flex items-center px-3 md:px-4 py-2 rounded-lg text-sm font-bold text-white transition-all no-underline"
                   style="background:var(--rose)">
                    Panel Admin
                </a>
            @else
                <a href="{{ route('usuario.dashboard') }}"
                   class="inline-flex items-center px-3 md:px-4 py-2 rounded-lg text-sm font-bold text-white transition-all no-underline"
                   style="background:var(--rose)">
                    Mi cuenta
                </a>
            @endif
        @else
            <a href="{{ route('login') }}"
               class="inline-flex items-center px-3 md:px-4 py-2 rounded-lg text-sm font-semibold transition-all no-underline"
               style="background:transparent;color:var(--text-2);border:1px solid var(--border)">
                Iniciar sesión
            </a>
            <a href="{{ route('register') }}"
               class="inline-flex items-center px-3 md:px-4 py-2 rounded-lg text-sm font-bold text-white transition-all no-underline"
               style="background:var(--rose)">
                Registrarse
            </a>
        @endauth
    </div>
</nav>

{{-- ═══════════════════════════════
     HERO
═══════════════════════════════ --}}
<section class="hero-glow relative overflow-hidden text-center px-5 pt-12 pb-10 md:px-16 md:pt-16 md:pb-12">
    <div class="relative z-10 max-w-xl mx-auto fade-up">

        {{-- Badge --}}
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-5"
             style="background:rgba(232,67,106,.1);border:1px solid rgba(232,67,106,.3);color:var(--rose)">
            ✨ Perfiles destacados
        </div>

        {{-- Título --}}
        <h1 class="font-cormorant font-bold leading-[1.08] mb-4"
            style="font-size:clamp(2.4rem,6vw,4.5rem)">
            Encuentra tu<br>
            <em style="font-style:italic;color:var(--rose)">conexión perfecta</em>
        </h1>

        {{-- Subtítulo --}}
        <p class="max-w-md mx-auto mb-8 leading-relaxed text-sm md:text-base"
           style="color:var(--text-2)">
            Descubre perfiles exclusivos disponibles ahora mismo en SisCitas.
        </p>

        {{-- CTAs --}}
        <div class="flex flex-wrap gap-3 justify-center">
            <a href="{{ route('perfiles') }}"
               class="inline-flex items-center px-5 py-2.5 rounded-lg text-sm md:text-base font-semibold transition-all no-underline"
               style="background:transparent;color:var(--text-2);border:1px solid var(--border)">
                Ver todos los perfiles →
            </a>
            @guest
                <a href="{{ route('register') }}"
                   class="inline-flex items-center px-5 py-2.5 rounded-lg text-sm md:text-base font-bold text-white transition-all no-underline"
                   style="background:var(--rose)">
                    Publicar mi perfil
                </a>
            @endguest
        </div>
    </div>
</section>

{{-- ═══════════════════════════════
     PERFILES ACTIVOS
═══════════════════════════════ --}}
<section class="px-5 md:px-16 pb-12 md:pb-16">

    {{-- Header sección --}}
    <div class="flex items-end justify-between flex-wrap gap-4 mb-6 md:mb-7">
        <div>
            <div class="text-xs font-bold uppercase tracking-[.12em] mb-1" style="color:var(--rose)">
                Disponibles ahora
            </div>
            <h2 class="font-cormorant font-bold" style="font-size:clamp(1.5rem,3vw,2.2rem)">
                Perfiles activos
                @if($perfiles->count() > 0)
                    <span class="text-sm font-normal" style="color:var(--text-3);font-family:'Outfit',sans-serif">
                        — {{ $perfiles->count() }} {{ $perfiles->count() === 1 ? 'perfil' : 'perfiles' }}
                    </span>
                @endif
            </h2>
        </div>
        <a href="{{ route('perfiles') }}"
           class="text-sm no-underline whitespace-nowrap transition-colors"
           style="color:var(--text-2)">
            Ver directorio completo →
        </a>
    </div>

    {{-- Grid o empty state --}}
    @if($perfiles->isEmpty())
        <div class="text-center py-16 px-8" style="color:var(--text-3)">
            <div class="text-6xl mb-4">🌙</div>
            <h3 class="font-cormorant text-2xl mb-2" style="color:var(--text-2)">Sin perfiles activos por ahora</h3>
            <p class="text-sm">Próximamente habrá perfiles disponibles. Vuelve pronto.</p>
        </div>
    @else
        <div class="grid gap-4 md:gap-5"
             style="grid-template-columns:repeat(auto-fill,minmax(200px,1fr))">
            @foreach($perfiles as $perfil)
                @php
                    $diasRestantes = max(0, (int) now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($perfil->promo_fecha_fin), false));
                    $portada = $perfil->fotos->where('es_portada', true)->first() ?? $perfil->fotos->first();
                @endphp

                <a href="{{ route('perfil.publico', $perfil->nombre_usuario) }}"
                   class="perfil-card relative block no-underline rounded-[14px] p-5 transition-all duration-200 hover:-translate-y-1"
                   style="background:var(--surface);border:1px solid var(--border);color:inherit">

                    {{-- Badge promo --}}
                    @if($diasRestantes <= 2 && $diasRestantes > 0)
                        <span class="absolute top-3 right-3 flex items-center gap-1 px-2 py-0.5 rounded-full text-[.68rem] font-bold"
                              style="background:rgba(212,168,83,.15);border:1px solid rgba(212,168,83,.3);color:var(--gold)">
                            ⏳ {{ $diasRestantes }}d
                        </span>
                    @elseif($diasRestantes > 2)
                        <span class="absolute top-3 right-3 flex items-center gap-1 px-2 py-0.5 rounded-full text-[.68rem] font-bold"
                              style="background:rgba(212,168,83,.15);border:1px solid rgba(212,168,83,.3);color:var(--gold)">
                            Verificado
                        </span>
                    @endif

                    {{-- Avatar --}}
                    <div class="w-35 h-35 rounded-full mx-auto mb-4 overflow-hidden flex items-center justify-center text-2xl font-bold text-white shrink-0"
                         style="{{ $portada ? '' : 'background:linear-gradient(135deg,var(--rose),var(--rose-dark))' }}">
                        @if($portada)
                            <img src="{{ asset('storage/'.$portada->ruta) }}"
                                 class="w-full h-full object-cover"
                                 alt="{{ $perfil->nombre_usuario }}">
                        @else
                            {{ strtoupper(substr($perfil->nombre_usuario, 0, 1)) }}
                        @endif
                    </div>

                    {{-- Nombre --}}
                    <div class="font-cormorant text-xl font-bold text-center mb-1" style="color:var(--text)">
                        {{ $perfil->nombre_usuario }}
                    </div>

                    {{-- Ciudad / edad --}}
                    <div class="text-center text-xs mb-3" style="color:var(--text-3)">
                        @if($perfil->ciudad) {{ $perfil->ciudad }} @endif
                        @if($perfil->edad) · {{ $perfil->edad }} años @endif
                    </div>

                    {{-- Descripción --}}
                    @if($perfil->descripcion)
                        <p class="line-clamp-3 text-sm leading-relaxed mb-3" style="color:var(--text-2);min-height:3.8em">
                            {{ $perfil->descripcion }}
                        </p>
                    @else
                        <p class="text-sm italic mb-3" style="color:var(--text-3);min-height:3.8em">
                            Sin descripción aún.
                        </p>
                    @endif

                    {{-- Footer --}}
                    <div class="flex items-center justify-between pt-3"
                         style="border-top:1px solid var(--border)">
                        <span class="font-bold text-base" style="color:var(--success)">
                            {{ $perfil->precio ? 'S/. '.number_format($perfil->precio, 0) : 'Consultar' }}
                        </span>
                        <span class="text-base" style="color:var(--text-3)">
                            {{ $perfil->numero_celular ?? 'Sin contacto' }}
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</section>

{{-- ═══════════════════════════════
     BANNER CTA (solo guests)
═══════════════════════════════ --}}
@guest
<div class="mx-5 md:mx-16 mb-12 md:mb-16 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5 p-6 md:p-8 rounded-[14px]"
     style="background:linear-gradient(135deg,rgba(232,67,106,.12),rgba(200,40,80,.06));border:1px solid rgba(232,67,106,.2)">
    <div>
        <h3 class="font-cormorant text-xl md:text-2xl font-bold mb-1">¿Quieres aparecer aquí?</h3>
        <p class="text-sm" style="color:var(--text-2)">Regístrate, crea tu perfil y contáctanos para activar tu publicidad.</p>
    </div>
    <a href="{{ route('register') }}"
       class="inline-flex items-center whitespace-nowrap px-5 py-2.5 rounded-lg text-sm font-bold text-white transition-all no-underline shrink-0"
       style="background:var(--rose)">
        Crear mi perfil →
    </a>
</div>
@endguest

{{-- ═══════════════════════════════
     FOOTER
═══════════════════════════════ --}}
<footer class="flex flex-wrap items-center justify-between gap-4 px-5 md:px-16 py-6"
        style="border-top:1px solid var(--border)">
    <a href="{{ route('home') }}"
       class="font-cormorant text-xl font-bold no-underline"
       style="color:var(--text)">
        ♥ <em style="color:var(--rose);font-style:normal">Mia</em>Juliaca
    </a>
    <span class="text-xs" style="color:var(--text-3)">
        © {{ date('Y') }} MiaJuliaca. Todos los derechos reservados.
    </span>
</footer>
@verbatim
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "MiaJuliaca",
  "description": "Directorio de chicas relax en Juliaca y Puno, Perú.",
  "url": "URL_DE_TU_SITIO",
  "areaServed": [
    { "@type": "City", "name": "Juliaca" },
    { "@type": "City", "name": "Puno" }
  ],
  "address": {
    "@type": "PostalAddress",
    "addressLocality": "Juliaca",
    "addressRegion": "Puno",
    "addressCountry": "PE"
  }
}
</script>
@endverbatim
</body>
</html>