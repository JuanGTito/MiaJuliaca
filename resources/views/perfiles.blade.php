<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directorio de Perfiles — SisCitas</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .font-cormorant { font-family: 'Cormorant Garamond', serif; }

        :root {
            --rose: #e8436a; --rose-dark: #c2274e;
            --rose-soft: rgba(232,67,106,.08);
            --gold: #d4a853;
            --bg: #0a0a14; --surface: #111119; --surface-2: #181825; --surface-3: #202030;
            --border: rgba(255,255,255,.07); --border-2: rgba(255,255,255,.12);
            --text: #f0f0f5; --text-2: #a0a0b8; --text-3: #55556a;
            --success: #10d98a;
        }

        /* Accent line top en cards activos */
        .card-activo::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, var(--gold), rgba(212,168,83,.3));
            border-radius: 14px 14px 0 0;
        }

        /* Line clamp */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Paginación de Laravel */
        .pagination-wrap nav { display: flex; justify-content: center; }
        .pagination-wrap span[aria-current="page"] > span,
        .pagination-wrap span[aria-disabled] > span {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 38px; height: 38px; border-radius: 8px;
            font-size: .83rem; font-weight: 600;
        }
        .pagination-wrap span[aria-current="page"] > span {
            background: var(--rose); color: white; border: 1px solid var(--rose);
        }
        .pagination-wrap span[aria-disabled] > span {
            background: var(--surface); color: var(--text-3);
            border: 1px solid var(--border); opacity: .4;
        }
        .pagination-wrap a {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 38px; height: 38px; border-radius: 8px;
            font-size: .83rem; font-weight: 600; text-decoration: none;
            color: var(--text-2); background: var(--surface);
            border: 1px solid var(--border); transition: all .15s;
        }
        .pagination-wrap a:hover {
            background: var(--surface-2); color: var(--text);
            border-color: var(--border-2);
        }
        .pagination-wrap ul { display: flex; gap: .4rem; flex-wrap: wrap; list-style: none; padding: 0; margin: 0; }

        @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
        .fade-up { animation: fadeUp .45s ease both; }
    </style>
</head>

<body class="min-h-screen" style="background:var(--bg);color:var(--text)">

{{-- ═══════════════════════════
     NAVBAR
═══════════════════════════ --}}
<nav class="sticky top-0 z-50 h-16 md:h-17 flex items-center justify-between px-5 md:px-16"
     style="background:rgba(10,10,20,.85);backdrop-filter:blur(20px);border-bottom:1px solid var(--border)">

    <a href="{{ route('home') }}"
       class="font-cormorant text-2xl md:text-[1.7rem] font-bold no-underline"
       style="color:var(--text)">
        ♥ <em style="color:var(--rose);font-style:normal">Mia</em>Juliaca
    </a>

    <div class="flex items-center gap-2 md:gap-3">
        <a href="{{ route('home') }}"
           class="inline-flex items-center px-3 md:px-4 py-2 rounded-lg text-sm font-semibold transition-all no-underline"
           style="background:transparent;color:var(--text-2);border:1px solid var(--border)">
            ← Inicio
        </a>
        @auth
            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}"
                   class="inline-flex items-center px-3 md:px-4 py-2 rounded-lg text-sm font-bold text-white no-underline"
                   style="background:var(--rose)">Panel Admin</a>
            @else
                <a href="{{ route('usuario.dashboard') }}"
                   class="inline-flex items-center px-3 md:px-4 py-2 rounded-lg text-sm font-bold text-white no-underline"
                   style="background:var(--rose)">Mi cuenta</a>
            @endif
        @else
            <a href="{{ route('login') }}"
               class="hidden sm:inline-flex items-center px-3 py-2 rounded-lg text-sm font-semibold no-underline"
               style="color:var(--text-2);border:1px solid var(--border)">Iniciar sesión</a>
            <a href="{{ route('register') }}"
               class="inline-flex items-center px-3 md:px-4 py-2 rounded-lg text-sm font-bold text-white no-underline"
               style="background:var(--rose)">Registrarse</a>
        @endauth
    </div>
</nav>

{{-- ═══════════════════════════
     PAGE HEADER
═══════════════════════════ --}}
<div style="background:var(--surface);border-bottom:1px solid var(--border)">
    <div class="max-w-325 mx-auto px-5 md:px-16 py-8 md:py-10
                flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 flex-wrap">
        <div>
            <div class="text-xs font-bold uppercase tracking-[.12em] mb-1" style="color:var(--rose)">
                Directorio completo
            </div>
            <h1 class="font-cormorant font-bold" style="font-size:clamp(1.8rem,4vw,2.8rem)">
                Todos los perfiles
            </h1>
            <p class="text-sm mt-1" style="color:var(--text-2)">
                {{ $perfiles->total() }} perfil(es) registrados en la plataforma
            </p>
        </div>

        {{-- Leyenda --}}
        <div class="flex flex-wrap items-center gap-4 text-xs" style="color:var(--text-3)">
            <div class="flex items-center gap-1.5">
                <div class="w-2 h-2 rounded-full shrink-0" style="background:var(--gold)"></div>
                Con publicidad activa
            </div>
            <div class="flex items-center gap-1.5">
                <div class="w-2 h-2 rounded-full shrink-0" style="background:var(--surface-3);border:1px solid var(--border-2)"></div>
                Sin publicidad activa
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════
     CONTENIDO
═══════════════════════════ --}}
<div class="max-w-325 mx-auto px-5 md:px-16 py-8 pb-16">

    @if($perfiles->isEmpty())
        <div class="text-center py-16 px-8" style="color:var(--text-3)">
            <div class="text-6xl mb-4">👥</div>
            <p class="text-base" style="color:var(--text-2)">Aún no hay perfiles registrados.</p>
        </div>

    @else
        @php
            $activos   = $perfiles->filter(fn($p) => !is_null($p->promo_fecha_fin));
            $inactivos = $perfiles->filter(fn($p) =>  is_null($p->promo_fecha_fin));
        @endphp

        {{-- ══ PERFILES CON PUBLICIDAD ACTIVA ══ --}}
        @if($activos->count() > 0)
            <div class="flex items-center gap-4 mb-5 fade-up">
                <span class="text-xs font-bold uppercase tracking-[.12em] whitespace-nowrap" style="color:var(--gold)">
                    ⭐ Verificadas
                </span>
                <div class="flex-1 h-px" style="background:var(--border)"></div>
                <span class="text-xs whitespace-nowrap" style="color:var(--text-3)">
                    {{ $activos->count() }} {{ $activos->count() === 1 ? 'perfil' : 'perfiles' }}
                </span>
            </div>

            <div class="grid gap-4 mb-10"
                 style="grid-template-columns:repeat(auto-fill,minmax(240px,1fr))">
                @foreach($activos as $perfil)
                    @php
                        $dias = max(0, (int) now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($perfil->promo_fecha_fin), false));
                        $portada = $perfil->fotos->where('es_portada', true)->first() ?? $perfil->fotos->first();
                    @endphp

                    {{-- Card completo es clickeable --}}
                    <a href="{{ route('perfil.publico', $perfil->nombre_usuario) }}"
                       class="card-activo relative block no-underline rounded-[14px] p-5 transition-all duration-200
                              hover:-translate-y-1 group"
                       style="background:var(--surface);border:1px solid rgba(212,168,83,.2);color:inherit">

                        {{-- Cabecera: avatar + info --}}
                        <div class="flex items-start gap-3 mb-3">

                            {{-- Avatar --}}
                            <div class="w-13 h-13 rounded-full shrink-0 overflow-hidden flex items-center justify-center text-xl font-bold text-white"
                                 style="{{ $portada ? '' : 'background:linear-gradient(135deg,var(--rose),var(--rose-dark))' }}">
                                @if($portada)
                                    <img src="{{ asset('storage/'.$portada->ruta) }}"
                                         class="w-full h-full object-cover"
                                         alt="{{ $perfil->nombre_usuario }}">
                                @else
                                    {{ strtoupper(substr($perfil->nombre_usuario, 0, 1)) }}
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="font-cormorant text-lg font-bold truncate" style="color:var(--text)">
                                    {{ $perfil->nombre_usuario }}
                                </div>
                                <div class="text-xs mt-0.5" style="color:var(--text-3)">
                                    @if($perfil->ciudad) {{ $perfil->ciudad }} @endif
                                    @if($perfil->edad) · {{ $perfil->edad }} años @endif
                                </div>
                            </div>
                        </div>

                        {{-- Descripción --}}
                        @if($perfil->descripcion)
                            <p class="line-clamp-2 text-[.82rem] leading-relaxed mb-3" style="color:var(--text-2)">
                                {{ $perfil->descripcion }}
                            </p>
                        @else
                            <p class="text-[.82rem] italic mb-3" style="color:var(--text-3)">Sin descripción.</p>
                        @endif

                        {{-- Footer: precio + contacto + CTA --}}
                        <div class="flex items-center justify-between pt-3"
                             style="border-top:1px solid var(--border)">
                            <span class="font-bold" style="color:var(--success)">
                                {{ $perfil->precio ? 'S/. '.number_format($perfil->precio, 0) : 'Consultar' }}
                            </span>
                            <span class="text-xs" style="color:var(--text-3)">
                                {{ $perfil->numero_celular ?? '—' }}
                            </span>
                        </div>

                        {{-- CTA hover --}}
                        <div class="mt-3 w-full py-2 rounded-lg text-center text-xs font-bold transition-all duration-200
                                    opacity-0 group-hover:opacity-100 -translate-y-1 group-hover:translate-y-0"
                             style="background:rgba(212,168,83,.12);color:var(--gold);border:1px solid rgba(212,168,83,.25)">
                            Ver perfil completo →
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- ══ PERFILES SIN PUBLICIDAD ══ --}}
        @if($inactivos->count() > 0)
            <div class="flex items-center gap-4 mb-5 fade-up">
                <span class="text-xs font-bold uppercase tracking-[.12em] whitespace-nowrap" style="color:var(--text-3)">
                    Sin verificacion
                </span>
                <div class="flex-1 h-px" style="background:var(--border)"></div>
                <span class="text-xs whitespace-nowrap" style="color:var(--text-3)">
                    {{ $inactivos->count() }} {{ $inactivos->count() === 1 ? 'perfil' : 'perfiles' }}
                </span>
            </div>

            <div class="grid gap-4"
                 style="grid-template-columns:repeat(auto-fill,minmax(240px,1fr))">
                @foreach($inactivos as $perfil)
                    @php
                        $portada = $perfil->fotos->where('es_portada', true)->first() ?? $perfil->fotos->first();
                    @endphp

                    <a href="{{ route('perfil.publico', $perfil->nombre_usuario) }}"
                       class="relative block no-underline rounded-[14px] p-5 transition-all duration-200
                              opacity-70 hover:opacity-100 hover:-translate-y-0.5 group"
                       style="background:var(--surface);border:1px solid var(--border);color:inherit">

                        <div class="flex items-start gap-3 mb-3">

                            {{-- Avatar gris --}}
                            <div class="w-13 h-13 rounded-full shrink-0 overflow-hidden flex items-center justify-center text-xl font-bold"
                                 style="background:var(--surface-3);color:var(--text-3);filter:grayscale(.8)">
                                @if($portada)
                                    <img src="{{ asset('storage/'.$portada->ruta) }}"
                                         class="w-full h-full object-cover"
                                         alt="{{ $perfil->nombre_usuario }}">
                                @else
                                    {{ strtoupper(substr($perfil->nombre_usuario, 0, 1)) }}
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="font-cormorant text-lg font-bold truncate" style="color:var(--text)">
                                    {{ $perfil->nombre_usuario }}
                                </div>
                                <div class="text-xs mt-0.5" style="color:var(--text-3)">
                                    @if($perfil->ciudad) {{ $perfil->ciudad }} @endif
                                    @if($perfil->edad) · {{ $perfil->edad }} a. @endif
                                </div>
                                <span class="inline-flex items-center mt-1.5 px-2 py-0.5 rounded-full text-[.68rem] font-bold"
                                      style="background:var(--surface-2);border:1px solid var(--border);color:var(--text-3)">
                                    Sin publicidad
                                </span>
                            </div>
                        </div>

                        @if($perfil->descripcion)
                            <p class="line-clamp-2 text-[.82rem] leading-relaxed mb-3" style="color:var(--text-2)">
                                {{ $perfil->descripcion }}
                            </p>
                        @else
                            <p class="text-[.82rem] italic mb-3" style="color:var(--text-3)">Sin descripción.</p>
                        @endif

                        <div class="flex items-center justify-between pt-3"
                             style="border-top:1px solid var(--border)">
                            <span class="font-bold" style="color:var(--success)">
                                {{ $perfil->precio ? 'S/. '.number_format($perfil->precio, 0) : 'Consultar' }}
                            </span>
                            <span class="text-base" style="color:var(--text-3)">
                                {{ $perfil->numero_celular ?? '—' }}
                            </span>
                        </div>

                        {{-- CTA hover --}}
                        <div class="mt-3 w-full py-2 rounded-lg text-center text-xs font-bold transition-all duration-200
                                    opacity-0 group-hover:opacity-100 -translate-y-1 group-hover:translate-y-0"
                             style="background:var(--surface-2);color:var(--text-2);border:1px solid var(--border)">
                            Ver perfil →
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Paginación --}}
        @if($perfiles->hasPages())
            <div class="pagination-wrap mt-10 flex justify-center">
                {{ $perfiles->links() }}
            </div>
        @endif
    @endif
</div>

{{-- ═══════════════════════════
     FOOTER
═══════════════════════════ --}}
<footer class="flex flex-wrap items-center justify-between gap-4 px-5 md:px-16 py-6"
        style="border-top:1px solid var(--border)">
    <a href="{{ route('home') }}"
       class="font-cormorant text-xl font-bold no-underline"
       style="color:var(--text)">
        ♥ <em style="color:var(--rose);font-style:normal">Mia</em>Juliaca
    </a>
    <span class="text-xs" style="color:var(--text-3)">© {{ date('Y') }} MiaJuliaca</span>
</footer>

</body>
</html>