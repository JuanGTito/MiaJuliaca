<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $perfil->nombre_usuario }} — Relax en {{ $perfil->ciudad ?? 'Juliaca' }}</title>
    <meta name="description" content="{{ $perfil->descripcion ? Str::limit($perfil->descripcion, 150) : 'Conoce a ' . $perfil->nombre_usuario . ', chica relax en ' . (($perfil->ciudad) ?? 'Juliaca') . ', Puno. Contacto directo por WhatsApp.' }}">
    <link rel="canonical" href="{{ route('perfil.publico', $perfil->nombre_usuario) }}">
    <meta property="og:title"       content="{{ $perfil->nombre_usuario }} en Juliaca | Puno">
    <meta property="og:description" content="{{ $perfil->descripcion ? Str::limit($perfil->descripcion,120) : 'Conoce mi perfil en SisCitas.' }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-image:
                radial-gradient(ellipse 90vw 55vh at 50% -5%,  rgba(255,77,141,.13) 0%, transparent 65%),
                radial-gradient(ellipse 50vw 40vh at 90% 100%, rgba(224,64,160,.07) 0%, transparent 60%);
            background-attachment: fixed;
        }
        .font-playfair { font-family: 'Playfair Display', serif; }

        :root {
            --pink: #ff4d8d;        --pink-2: #ff6fa3;
            --pink-dark: #d93070;   --pink-glow: rgba(255,77,141,.35);
            --pink-soft: rgba(255,77,141,.12);
            --coral: #ff7058;       --magenta: #e040a0;
            --bg: #160810;
            --bg-card: rgba(255,255,255,.04);
            --bg-card-2: rgba(255,255,255,.07);
            --border: rgba(255,255,255,.09);
            --border-pink: rgba(255,77,141,.22);
            --border-strong: rgba(255,77,141,.4);
            --text: #fff0f5;        --text-2: #c9a0b0;   --text-3: #8a5f6e;
            --success: #00e5a0;     --success-bg: rgba(0,229,160,.1);
            --gold: #ffc85a;        --gold-soft: rgba(255,200,90,.12);
            --wa: #25d366;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: rgba(255,77,141,.3); border-radius: 4px; }

        /* Grad text */
        .grad-text {
            background: linear-gradient(135deg, var(--pink), var(--coral));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }

        /* Hero name gradient */
        .hero-name-grad {
            background: linear-gradient(135deg, var(--text) 55%, var(--pink-2));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }

        /* Hero glows */
        .hero-glow-1 {
            position: absolute; width: 700px; height: 700px; border-radius: 50%;
            background: radial-gradient(circle, rgba(255,77,141,.11) 0%, transparent 70%);
            top: 50%; left: 30%; transform: translate(-50%, -50%); pointer-events: none;
        }
        .hero-glow-2 {
            position: absolute; width: 400px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle, rgba(224,64,160,.07) 0%, transparent 70%);
            top: 0; right: 0; pointer-events: none;
        }

        /* Hero divider */
        .hero-line {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--border-pink) 25%, var(--border-pink) 75%, transparent);
        }

        /* Line clamp */
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

        /* Animations */
        @keyframes fadeUp   { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
        @keyframes floatIn  { from { opacity:0; transform:scale(.97) translateY(10px); } to { opacity:1; transform:scale(1) translateY(0); } }
        .fade-up   { animation: fadeUp  .45s ease both; }
        .float-in  { animation: floatIn .45s ease both; }
        .delay-1   { animation-delay: .07s; }
        .delay-2   { animation-delay: .14s; }
        .delay-3   { animation-delay: .21s; }

        /* Gallery hover zoom */
        .gallery-img:hover { transform: scale(1.07); }
    </style>
</head>

<body class="min-h-screen overflow-x-hidden" style="background:var(--bg);color:var(--text)">

{{-- ═══════════════════════════
     NAV
═══════════════════════════ --}}
<nav class="sticky top-0 z-50 h-15 flex items-center justify-between px-5 md:px-10"
     style="background:rgba(22,8,16,.82);backdrop-filter:blur(28px);border-bottom:1px solid var(--border-pink)">

    <a href="{{ route('home') }}"
       class="font-playfair text-[1.45rem] font-bold no-underline flex items-center gap-1.5"
       style="color:var(--text)">
        <span class="grad-text">♥</span> MiaJuliaca
    </a>

    <div class="flex items-center gap-2">
        <a href="{{ route('perfiles') }}"
           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-[11px] text-sm font-bold no-underline transition-all"
           style="background:transparent;color:var(--text-2);border:1px solid var(--border)">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
            </svg>
            <span class="hidden sm:inline">Perfiles</span>
        </a>
        @auth
            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.usuarios.show', $perfil) }}"
                   class="inline-flex items-center px-3 py-1.5 rounded-[11px] text-sm font-bold no-underline transition-all"
                   style="background:transparent;color:var(--text-2);border:1px solid var(--border)">
                    Admin
                </a>
            @endif
        @endauth
        @guest
            <a href="{{ route('register') }}"
               class="inline-flex items-center px-3 py-1.5 rounded-[11px] text-sm font-bold text-white no-underline transition-all"
               style="background:linear-gradient(135deg,var(--pink),var(--pink-dark));box-shadow:0 4px 16px var(--pink-glow)">
                Publicar perfil
            </a>
        @endguest
    </div>
</nav>

{{-- ═══════════════════════════
     HERO
═══════════════════════════ --}}
<div class="relative overflow-hidden px-5 pt-10 pb-0 md:px-10 md:pt-12">
    <div class="hero-glow-1"></div>
    <div class="hero-glow-2"></div>

    {{-- Inner: avatar + info --}}
    <div class="relative z-10 max-w-230 mx-auto
                grid grid-cols-1 gap-6
                md:grid-cols-[auto_1fr] md:gap-9 md:items-end
                fade-up">

        {{-- Avatar --}}
        <div class="relative flex justify-center md:justify-start shrink-0">
            @php $portada = $perfil->fotos->where('es_portada', true)->first() ?? $perfil->fotos->first(); @endphp

            <div class="w-24 h-24 md:w-32.5 md:h-32.5 rounded-[18px] md:rounded-[26px]
                        overflow-hidden flex items-center justify-center
                        font-playfair text-4xl md:text-[3.5rem] font-bold text-white"
                 style="background:linear-gradient(145deg,var(--pink) 0%,var(--pink-dark) 55%,var(--magenta) 100%);
                        box-shadow:0 20px 56px var(--pink-glow);
                        border:2px solid rgba(255,77,141,.3)">
                @if($portada)
                    <img src="{{ asset('storage/'.$portada->ruta) }}"
                         class="w-full h-full object-cover"
                         alt="{{ $perfil->nombre_usuario }}">
                @else
                    {{ strtoupper(substr($perfil->nombre_usuario, 0, 1)) }}
                @endif
            </div>

            {{-- Status dot --}}
            <div class="absolute -bottom-1.5 -right-1.5 md:bottom-1.75 md:right-1.75
                        w-7 h-7 rounded-full flex items-center justify-center
                        text-xs font-black"
                 style="border:2.5px solid var(--bg);
                        {{ $promo ? 'background:var(--success);color:#002a1a' : 'background:rgba(255,255,255,.15);color:var(--text-3)' }}">
                {{ $promo ? '✓' : '·' }}
            </div>
        </div>

        {{-- Info --}}
        <div class="pb-0 md:pb-6 text-center md:text-left">

            {{-- Chips --}}
            <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 mb-3">
                @if($promo)
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[.7rem] font-black uppercase tracking-[.05em]"
                          style="background:var(--gold-soft);border:1px solid rgba(255,200,90,.22);color:var(--gold)">
                        ⭐ Verificada
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[.7rem] font-black uppercase tracking-[.05em]"
                          style="background:var(--bg-card-2);border:1px solid var(--border);color:var(--text-3)">
                        Sin publicidad activa
                    </span>
                @endif
                @if($perfil->ciudad)
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[.7rem] font-black uppercase tracking-[.05em]"
                          style="background:var(--bg-card-2);border:1px solid var(--border);color:var(--text-3)">
                        {{ $perfil->ciudad }}
                    </span>
                @endif
            </div>

            {{-- Nombre --}}
            <h1 class="hero-name-grad font-playfair font-bold leading-[1.05] mb-3"
                style="font-size:clamp(1.9rem,5.5vw,3.2rem)">
                {{ $perfil->nombre_usuario }}
            </h1>

            {{-- Meta --}}
            <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-sm mb-4"
                 style="color:var(--text-2)">
                @if($perfil->edad)
                    <div class="flex items-center gap-1.5">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-3)">
                            <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        {{ $perfil->edad }} años
                    </div>
                @endif
                @if($perfil->ciudad)
                    <div class="flex items-center gap-1.5">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-3)">
                            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                        </svg>
                        {{ $perfil->ciudad }}
                    </div>
                @endif
                @if($perfil->numero_celular)
                    <div class="flex items-center gap-1.5">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-3)">
                            <rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/>
                        </svg>
                        {{ $perfil->numero_celular }}
                    </div>
                @endif
            </div>

            {{-- Tarifa --}}
            @if($perfil->precio)
                <div class="inline-flex items-baseline gap-2 px-4 py-2 rounded-xl"
                     style="background:var(--success-bg);border:1px solid rgba(0,229,160,.18)">
                    <span class="text-[.68rem] font-black uppercase tracking-[.08em]" style="color:var(--text-3)">Tarifa</span>
                    <span class="font-playfair text-[1.9rem] font-bold leading-none" style="color:var(--success)">
                        S/. {{ number_format($perfil->precio, 0) }}
                    </span>
                </div>
            @endif
        </div>
    </div>

    <div class="hero-line max-w-230 mx-auto mt-7"></div>
</div>

{{-- ═══════════════════════════
     BODY
═══════════════════════════ --}}
<div class="max-w-230 mx-auto px-5 md:px-10 py-6 md:py-8
            grid grid-cols-1 gap-5
            md:grid-cols-[1fr_295px] md:items-start">

    {{-- ── Columna principal (va debajo en móvil) ── --}}
    <div class="flex flex-col gap-5 order-2 md:order-1">

        {{-- Descripción --}}
        <div class="rounded-[18px] p-5 md:p-6 transition-all duration-200 fade-up delay-1"
             style="background:var(--bg-card);backdrop-filter:blur(12px);border:1px solid var(--border)">
            <div class="flex items-center gap-2 pb-3 mb-4 font-playfair text-lg font-bold"
                 style="border-bottom:1px solid var(--border);color:var(--text)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--pink);flex-shrink:0">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
                Sobre {{ $perfil->nombre_usuario }}
            </div>
            @if($perfil->descripcion)
                <p class="text-sm md:text-[.92rem] leading-[1.85] whitespace-pre-line" style="color:var(--text-2)">
                    {{ $perfil->descripcion }}
                </p>
            @else
                <p class="text-center py-4 text-sm italic" style="color:var(--text-3)">
                    Este perfil aún no tiene descripción. 💭
                </p>
            @endif
        </div>

        {{-- Galería --}}
        @if($perfil->fotos->count() > 0)
        <div class="rounded-[18px] p-5 md:p-6 transition-all duration-200 fade-up delay-2"
             style="background:var(--bg-card);backdrop-filter:blur(12px);border:1px solid var(--border)">
            <div class="flex items-center gap-2 pb-3 mb-4 font-playfair text-lg font-bold"
                 style="border-bottom:1px solid var(--border);color:var(--text)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--pink);flex-shrink:0">
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <circle cx="8.5" cy="8.5" r="1.5"/>
                    <polyline points="21 15 16 10 5 21"/>
                </svg>
                Galería
                <span class="text-xs font-normal ml-1" style="color:var(--text-3)">
                    {{ $perfil->fotos->count() }} foto{{ $perfil->fotos->count() !== 1 ? 's' : '' }}
                </span>
            </div>
            <div class="grid grid-cols-3 gap-2 md:gap-2.5">
                @foreach($perfil->fotos as $foto)
                <div class="aspect-square rounded-[10px] overflow-hidden cursor-pointer"
                     style="border:1px solid var(--border)"
                     onclick="abrirFoto('{{ asset('storage/'.$foto->ruta) }}')">
                    <img src="{{ asset('storage/'.$foto->ruta) }}"
                         class="gallery-img w-full h-full object-cover transition-transform duration-300"
                         alt="Foto {{ $loop->iteration }}">
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Info general --}}
        <div class="rounded-[18px] p-5 md:p-6 transition-all duration-200 fade-up delay-2"
             style="background:var(--bg-card);backdrop-filter:blur(12px);border:1px solid var(--border)">
            <div class="flex items-center gap-2 pb-3 mb-4 font-playfair text-lg font-bold"
                 style="border-bottom:1px solid var(--border);color:var(--text)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--pink);flex-shrink:0">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                Información
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="rounded-[11px] px-4 py-3" style="background:var(--bg-card-2);border:1px solid var(--border)">
                    <div class="text-[.65rem] font-black uppercase tracking-widest mb-1" style="color:var(--text-3)">Nombre</div>
                    <div class="text-sm font-semibold" style="color:var(--text)">{{ $perfil->nombre_usuario }}</div>
                </div>
                <div class="rounded-[11px] px-4 py-3" style="background:var(--bg-card-2);border:1px solid var(--border)">
                    <div class="text-[.65rem] font-black uppercase tracking-widest mb-1" style="color:var(--text-3)">Edad</div>
                    <div class="text-sm font-semibold" style="color:var(--text)">{{ $perfil->edad ? $perfil->edad.' años' : 'No indicada' }}</div>
                </div>
                <div class="rounded-[11px] px-4 py-3" style="background:var(--bg-card-2);border:1px solid var(--border)">
                    <div class="text-[.65rem] font-black uppercase tracking-widest mb-1" style="color:var(--text-3)">Ciudad</div>
                    <div class="text-sm font-semibold" style="color:var(--text)">{{ $perfil->ciudad ?? 'No indicada' }}</div>
                </div>
                <div class="rounded-[11px] px-4 py-3" style="background:var(--bg-card-2);border:1px solid var(--border)">
                    <div class="text-[.65rem] font-black uppercase tracking-widest mb-1" style="color:var(--text-3)">Tarifa</div>
                    <div class="text-sm font-black" style="color:var(--success)">
                        {{ $perfil->precio ? 'S/. '.number_format($perfil->precio,0) : 'Consultar' }}
                    </div>
                </div>
                @if($perfil->numero_celular)
                <div class="sm:col-span-2 rounded-[11px] px-4 py-3" style="background:var(--bg-card-2);border:1px solid var(--border)">
                    <div class="text-[.65rem] font-black uppercase tracking-widest mb-1" style="color:var(--text-3)">Contacto directo</div>
                    <div class="text-sm font-semibold" style="color:var(--text)">{{ $perfil->numero_celular }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Columna contacto (va arriba en móvil) ── --}}
    <div class="flex flex-col gap-4 order-1 md:order-2 float-in delay-1">

        {{-- Card contacto sticky en desktop --}}
        <div class="rounded-[18px] p-5 md:sticky md:top-19"
             style="background:rgba(255,77,141,.05);border:1px solid var(--border-pink)">

            <h3 class="font-playfair text-lg font-bold text-center mb-4" style="color:var(--text)">
                Contactar a {{ $perfil->nombre_usuario }}
            </h3>

            {{-- Precio --}}
            @if($perfil->precio)
            <div class="text-center rounded-xl p-3 mb-4" style="background:var(--success-bg);border:1px solid rgba(0,229,160,.15)">
                <div class="text-[.68rem] font-black uppercase tracking-[.08em] mb-0.5" style="color:var(--text-3)">Tarifa</div>
                <div class="font-playfair text-[2.4rem] md:text-[2.6rem] font-bold leading-none" style="color:var(--success)">
                    S/. {{ number_format($perfil->precio, 0) }}
                </div>
                <div class="text-[.72rem] mt-1" style="color:var(--text-3)">Por acordar</div>
            </div>
            @endif

            @if($perfil->numero_celular)
                @php
                    $tel = preg_replace('/[^0-9]/', '', $perfil->numero_celular);
                    $msg = urlencode("Hola {$perfil->nombre_usuario} 💕 Te vi en SisCitas y me gustaría contactarte.");
                    $wa  = "https://wa.me/{$tel}?text={$msg}";
                @endphp

                {{-- WhatsApp --}}
                <a href="{{ $wa }}" target="_blank" rel="noopener"
                   class="flex items-center justify-center gap-2.5 w-full py-3.5 rounded-[11px] font-black text-base text-white no-underline transition-all mb-3"
                   style="background:var(--wa);box-shadow:0 6px 22px rgba(37,211,102,.3)">
                    <svg width="21" height="21" viewBox="0 0 24 24" fill="currentColor" class="shrink-0">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Escribir por WhatsApp
                </a>

                {{-- Divider --}}
                <div class="flex items-center gap-2 my-3 text-xs" style="color:var(--text-3)">
                    <div class="flex-1 h-px" style="background:var(--border)"></div>
                    o llámame directamente
                    <div class="flex-1 h-px" style="background:var(--border)"></div>
                </div>

                {{-- Llamar --}}
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $perfil->numero_celular) }}"
                   class="flex items-center justify-center gap-2 w-full py-3 rounded-[11px] font-bold text-sm no-underline transition-all"
                   style="background:var(--bg-card-2);color:var(--text-2);border:1px solid var(--border)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.8 2.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9a16 16 0 0 0 6.91 6.91l.98-.98a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                    {{ $perfil->numero_celular }}
                </a>

                <p class="text-center text-[.74rem] leading-relaxed mt-3" style="color:var(--text-3)">
                    Al contactar confirmas que eres mayor de edad.<br>SisCitas no intermedia en los acuerdos.
                </p>

            @else
                <div class="text-center py-6" style="color:var(--text-3)">
                    <div class="text-4xl mb-2">📵</div>
                    <p class="text-sm">Sin número de contacto registrado.</p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Lightbox --}}
<div id="lightbox"
     onclick="this.style.display='none'"
     class="fixed inset-0 z-999 hidden items-center justify-center cursor-zoom-out"
     style="background:rgba(0,0,0,.92)">
    <img id="lightbox-img"
         class="max-w-[90vw] max-h-[90vh] rounded-xl"
         style="box-shadow:0 20px 60px rgba(0,0,0,.5)"
         alt="Foto ampliada">
</div>

{{-- ═══════════════════════════
     SUGERIDOS
═══════════════════════════ --}}
@if($sugeridos->count() > 0)
<div class="max-w-230 mx-auto px-5 md:px-10 pb-12 md:pb-16">
    <h2 class="font-playfair text-[1.35rem] font-bold flex items-center gap-4 mb-5" style="color:var(--text)">
        También disponibles
        <span class="flex-1 h-px" style="background:var(--border)"></span>
    </h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 md:gap-4">
        @foreach($sugeridos as $s)
            @php $sPortada = $s->fotos->where('es_portada', true)->first() ?? $s->fotos->first(); @endphp
            <a href="{{ route('perfil.publico', $s->nombre_usuario) }}"
               class="block no-underline rounded-[18px] p-4 transition-all duration-200
                      hover:-translate-y-1"
               style="background:var(--bg-card);border:1px solid var(--border);color:inherit">

                <div class="w-12 h-12 rounded-[13px] overflow-hidden mx-auto mb-3
                            flex items-center justify-center text-xl font-black text-white"
                     style="background:linear-gradient(135deg,var(--pink),var(--magenta))">
                    @if($sPortada)
                        <img src="{{ asset('storage/'.$sPortada->ruta) }}"
                             class="w-full h-full object-cover"
                             alt="{{ $s->nombre_usuario }}">
                    @else
                        {{ strtoupper(substr($s->nombre_usuario, 0, 1)) }}
                    @endif
                </div>

                <div class="font-playfair text-base font-bold text-center truncate" style="color:var(--text)">
                    {{ $s->nombre_usuario }}
                </div>
                <div class="text-center text-xs mt-0.5" style="color:var(--text-3)">
                    @if($s->ciudad)📍 {{ $s->ciudad }}@endif
                    @if($s->edad) · {{ $s->edad }}a.@endif
                </div>
                <div class="text-center font-black text-sm mt-2" style="color:var(--success)">
                    {{ $s->precio ? 'S/. '.number_format($s->precio, 0) : 'Consultar' }}
                </div>
            </a>
        @endforeach
    </div>
</div>
@endif

{{-- ═══════════════════════════
     FOOTER
═══════════════════════════ --}}
<footer class="flex flex-wrap items-center justify-between gap-4 px-5 md:px-10 py-6"
        style="border-top:1px solid var(--border-pink)">
    <a href="{{ route('home') }}"
       class="font-playfair text-[1.45rem] font-bold no-underline flex items-center gap-1.5"
       style="color:var(--text)">
        <span class="grad-text">♥</span> MiaJuliaca
    </a>
    <div class="flex flex-wrap gap-5">
        <a href="{{ route('home') }}"
           class="text-xs no-underline transition-colors hover:opacity-80"
           style="color:var(--text-3)">Inicio</a>
        <a href="{{ route('perfiles') }}"
           class="text-xs no-underline transition-colors hover:opacity-80"
           style="color:var(--text-3)">Ver todos los perfiles</a>
        @guest
            <a href="{{ route('register') }}"
               class="text-xs font-bold no-underline"
               style="color:var(--pink)">Publicar mi perfil →</a>
        @endguest
    </div>
</footer>

<script>
function copiarLink() {
    const url = '{{ route('perfil.publico', $perfil->nombre_usuario) }}';
    const btn = document.getElementById('btn-copiar');
    const done = () => {
        btn.textContent = '✓ ¡Copiado!';
        btn.style.color = 'var(--success)';
        btn.style.borderColor = 'rgba(0,229,160,.3)';
        setTimeout(() => {
            btn.textContent = '📋 Copiar enlace';
            btn.style.color = '';
            btn.style.borderColor = '';
        }, 2200);
    };
    navigator.clipboard
        ? navigator.clipboard.writeText(url).then(done)
        : (() => {
            const t = document.createElement('textarea');
            t.value = url;
            document.body.appendChild(t);
            t.select();
            document.execCommand('copy');
            document.body.removeChild(t);
            done();
        })();
}

function abrirFoto(src) {
    const lb = document.getElementById('lightbox');
    document.getElementById('lightbox-img').src = src;
    lb.style.display = 'flex';
}
</script>

</body>
</html>