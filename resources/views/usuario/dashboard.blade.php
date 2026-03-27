@extends('layouts.app')
@section('title', 'Mi Dashboard — SisCitas')

@push('styles')
<style>
    @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
    .fade-up   { animation: fadeUp .45s ease both; }
    .fade-up-1 { animation-delay: .05s; }
    .fade-up-2 { animation-delay: .10s; }
    .fade-up-3 { animation-delay: .15s; }
    .fade-up-4 { animation-delay: .20s; }
    .fade-up-5 { animation-delay: .25s; }
</style>
@endpush

@section('content')

{{-- ══ PAGE HEADER ══ --}}
<div class="flex flex-wrap items-start justify-between gap-4 mb-6 fade-up">
    <div>
        <h1 class="font-cormorant text-3xl md:text-4xl font-bold" style="color:var(--text)">Mi Dashboard</h1>
        <p class="text-sm mt-1" style="color:var(--text-2)">
            Bienvenida de vuelta, <strong style="color:var(--rose)">{{ $user->nombre_usuario }}</strong>
        </p>
    </div>
    <a href="{{ route('usuario.perfil') }}"
       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-bold text-white no-underline transition-all hover:opacity-90"
       style="background:var(--rose)">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
        </svg>
        Editar perfil
    </a>
</div>

{{-- ══ BANNER PUBLICIDAD ══ --}}
@php
    $tienePromo  = $user->estado_publicidad && $user->tienePromocionActiva();
    $vencida     = $user->estado_publicidad && !$user->tienePromocionActiva();
    $diasRestantes = $tienePromo ? $user->diasRestantesPromocion() : 0;
    $fechaFin      = $tienePromo ? $user->fechaFinPromocion() : null;

    $bannerBg  = $tienePromo && $diasRestantes <= 3 ? 'background:rgba(212,168,83,.08);border-color:rgba(212,168,83,.3)'
               : ($tienePromo                       ? 'background:rgba(16,217,138,.07);border-color:rgba(16,217,138,.2)'
               : ($vencida                          ? 'background:rgba(232,67,106,.07);border-color:rgba(232,67,106,.25)'
               :                                      'background:var(--surface-2);border-color:var(--border)'));

    $btnBg     = $tienePromo && $diasRestantes <= 3 ? 'background:var(--gold);color:#1a1000'
               : ($tienePromo                       ? 'background:rgba(16,217,138,.15);color:var(--success)'
               : ($vencida                          ? 'background:var(--rose);color:white'
               :                                      'background:var(--surface-3,#202030);color:var(--text-2);border:1px solid var(--border)'));

    $bannerIcon = $tienePromo && $diasRestantes <= 3 ? '⏳' : ($tienePromo ? '✅' : ($vencida ? '⚠️' : '🔒'));
    $btnHref    = $tienePromo ? route('perfil.publico', $user) : '#renovar';
    $btnLabel   = $tienePromo ? 'Ver mi perfil →' : ($vencida ? 'Renovar →' : 'Contactar admin →');
@endphp

<div class="flex flex-wrap items-center gap-3 p-4 rounded-xl mb-6 text-sm leading-relaxed border fade-up fade-up-1"
     style="{{ $bannerBg }}">
    <span class="text-2xl shrink-0">{{ $bannerIcon }}</span>
    <div class="flex-1 min-w-40" style="color:var(--text)">
        @if($tienePromo && $diasRestantes <= 3)
            <strong>¡Tu publicidad vence pronto!</strong>
            Quedan <strong>{{ $diasRestantes }} {{ $diasRestantes === 1 ? 'día' : 'días' }}</strong>
            (hasta el {{ $fechaFin->format('d/m/Y') }}). Renueva para seguir apareciendo.
        @elseif($tienePromo)
            <strong>Publicidad activa</strong> — Visible hasta el
            <strong>{{ $fechaFin->format('d \d\e F, Y') }}</strong>.
            Quedan <strong>{{ $diasRestantes }} días</strong>.
        @elseif($vencida)
            <strong>Tu publicidad ha vencido</strong> — Ya no apareces en el directorio. Contáctanos para renovar.
        @else
            <strong>Perfil desactivado</strong> — Tu cuenta está inactiva. Contacta al administrador.
        @endif
    </div>
    <a href="{{ $btnHref }}" @if($tienePromo) target="_blank" @endif
       class="inline-flex items-center whitespace-nowrap px-3 py-1.5 rounded-lg text-xs font-bold no-underline shrink-0"
       style="{{ $btnBg }}">
        {{ $btnLabel }}
    </a>
</div>

{{-- ══ STATS ══ --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-5 fade-up fade-up-2">

    @php
        $stats = [
            ['icon_color'=>'var(--rose)','icon_bg'=>'var(--rose-soft)','val'=>$user->edad ?? '—','lbl'=>'Años de edad','icon'=>'<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>'],
            ['icon_color'=>'var(--success)','icon_bg'=>'var(--success-bg)','val'=>'S/. '.number_format($user->precio ?? 0, 0),'lbl'=>'Mi tarifa','icon'=>'<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>'],
            ['icon_color'=>'var(--gold)','icon_bg'=>'rgba(212,168,83,.1)','val'=>$user->ciudad ?? '—','lbl'=>'Mi ciudad','icon'=>'<path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>','truncate'=>true],
        ];
    @endphp

    @foreach($stats as $s)
    <div class="flex items-center gap-3 p-4 rounded-xl transition-all hover:-translate-y-0.5"
         style="background:var(--surface);border:1px solid var(--border)">
        <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0"
             style="background:{{ $s['icon_bg'] }}">
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="{{ $s['icon_color'] }}" stroke-width="2">
                {!! $s['icon'] !!}
            </svg>
        </div>
        <div class="min-w-0">
            <div class="font-bold leading-none {{ isset($s['truncate']) ? 'text-base truncate' : 'text-xl' }}" style="color:var(--text)">
                {{ $s['val'] }}
            </div>
            <div class="text-xs mt-1" style="color:var(--text-2)">{{ $s['lbl'] }}</div>
        </div>
    </div>
    @endforeach

    {{-- Días promo --}}
    <div class="flex items-center gap-3 p-4 rounded-xl transition-all hover:-translate-y-0.5"
         style="background:var(--surface);border:1px solid var(--border)">
        <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0"
             style="background:{{ $user->tienePromocionActiva() ? 'var(--success-bg)' : 'var(--danger-bg)' }}">
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none"
                 stroke="{{ $user->tienePromocionActiva() ? 'var(--success)' : 'var(--danger)' }}" stroke-width="2">
                <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>
            </svg>
        </div>
        <div>
            <div class="text-xl font-bold leading-none" style="color:var(--text)">
                @if($user->tienePromocionActiva()) {{ $user->diasRestantesPromocion() }}d @else — @endif
            </div>
            <div class="text-xs mt-1" style="color:var(--text-2)">Días de promo</div>
        </div>
    </div>
</div>

{{-- ══ INFO + DESCRIPCIÓN ══ --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 fade-up fade-up-3">

    {{-- Info personal --}}
    <div class="rounded-xl p-5" style="background:var(--surface);border:1px solid var(--border)">
        <div class="flex items-center gap-2 font-cormorant text-lg font-bold mb-4" style="color:var(--text)">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--rose)" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
            Información personal
        </div>
        <div class="flex flex-col gap-3">
            @foreach([
                ['lbl'=>'Usuario',  'val'=>$user->nombre_usuario,                'bold'=>true],
                ['lbl'=>'Correo',   'val'=>$user->email],
                ['lbl'=>'Celular',  'val'=>$user->numero_celular ?? 'No registrado'],
                ['lbl'=>'Ciudad',   'val'=>$user->ciudad ?? 'No registrada'],
            ] as $row)
            <div>
                <div class="text-[.7rem] font-bold uppercase tracking-[.08em] mb-0.5" style="color:var(--text-3)">{{ $row['lbl'] }}</div>
                <div class="text-sm {{ isset($row['bold']) ? 'font-semibold' : '' }}"
                     style="color:{{ isset($row['bold']) ? 'var(--text)' : 'var(--text-2)' }}">
                    {{ $row['val'] }}
                </div>
            </div>
            @endforeach
            <div>
                <div class="text-[.7rem] font-bold uppercase tracking-[.08em] mb-0.5" style="color:var(--text-3)">Tarifa</div>
                <div class="text-lg font-bold" style="color:var(--success)">
                    {{ $user->precio ? 'S/. '.number_format($user->precio, 2) : 'No establecida' }}
                </div>
            </div>
        </div>
    </div>

    {{-- Descripción --}}
    <div class="rounded-xl p-5" style="background:var(--surface);border:1px solid var(--border)">
        <div class="flex items-center gap-2 font-cormorant text-lg font-bold mb-4" style="color:var(--text)">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--rose)" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
            </svg>
            Mi descripción
        </div>
        @if($user->descripcion)
            <p class="text-sm leading-relaxed" style="color:var(--text-2)">{{ $user->descripcion }}</p>
            <div class="mt-4 pt-4" style="border-top:1px solid var(--border)">
                <a href="{{ route('usuario.perfil') }}"
                   class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold no-underline transition-all"
                   style="background:var(--surface-2);color:var(--text-2);border:1px solid var(--border)">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Editar descripción
                </a>
            </div>
        @else
            <div class="text-center py-8">
                <div class="text-4xl mb-3">✍️</div>
                <p class="text-sm mb-4" style="color:var(--text-3)">
                    Aún no tienes descripción.<br>¡Cuéntale a los demás quién eres!
                </p>
                <a href="{{ route('usuario.perfil') }}"
                   class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold text-white no-underline"
                   style="background:var(--rose)">
                    Agregar descripción
                </a>
            </div>
        @endif
    </div>
</div>

{{-- ══ CÓMO APARECER / RENOVAR ══ --}}
<div id="renovar"
     class="rounded-xl p-5 md:p-6 mb-4 fade-up fade-up-4"
     style="background:linear-gradient(135deg,rgba(212,168,83,.04),transparent);border:1px solid rgba(212,168,83,.25)">

    <div class="flex items-center gap-2 font-cormorant text-lg font-bold mb-5" style="color:var(--gold)">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2">
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
        </svg>
        ¿Quieres aparecer en el directorio?
    </div>

    {{-- 3 pasos --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6">
        @foreach([
            ['n'=>'1','t'=>'Completa tu perfil','d'=>'Agrega fotos, descripción, ciudad y tarifa para que los clientes te encuentren.'],
            ['n'=>'2','t'=>'Contacta al admin','d'=>'Escríbenos por WhatsApp o al correo para solicitar tu activación o renovación.'],
            ['n'=>'3','t'=>'¡Listo! Apareces','d'=>'Una vez activado, tu perfil aparecerá en el inicio y en el directorio completo.'],
        ] as $p)
        <div class="rounded-xl p-4" style="background:var(--surface-2);border:1px solid var(--border)">
            <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-black mb-3"
                 style="background:rgba(212,168,83,.15);border:1px solid rgba(212,168,83,.3);color:var(--gold)">
                {{ $p['n'] }}
            </div>
            <div class="font-bold text-sm mb-1" style="color:var(--text)">{{ $p['t'] }}</div>
            <div class="text-xs leading-relaxed" style="color:var(--text-3)">{{ $p['d'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- Planes --}}
    <div class="mb-5">
        <div class="text-xs font-bold uppercase tracking-widest mb-3" style="color:var(--text-3)">Planes disponibles</div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            @foreach([
                ['name'=>'Básico',   'price'=>'S/. 10','period'=>'7 días', 'desc'=>'Apareces en el directorio completo.','highlight'=>false],
                ['name'=>'Estándar', 'price'=>'S/. 18','period'=>'15 días','desc'=>'Directorio + destacado en inicio.','highlight'=>true,'badge'=>'⭐ Popular'],
                ['name'=>'Premium',  'price'=>'S/. 35','period'=>'30 días','desc'=>'Máxima visibilidad todo el mes.','highlight'=>false],
            ] as $plan)
            <div class="rounded-xl p-4 transition-all"
                 style="{{ $plan['highlight']
                    ? 'background:rgba(212,168,83,.05);border:1px solid rgba(212,168,83,.35)'
                    : 'background:var(--surface-2);border:1px solid var(--border)' }}">
                @if(isset($plan['badge']))
                    <div class="text-[.65rem] font-black uppercase tracking-[.08em] mb-1" style="color:var(--gold)">
                        {{ $plan['badge'] }}
                    </div>
                @endif
                <div class="font-bold text-sm mb-0.5" style="color:var(--text)">{{ $plan['name'] }}</div>
                <div class="text-2xl font-black leading-none mb-0.5" style="color:var(--gold)">{{ $plan['price'] }}</div>
                <div class="text-xs mb-2" style="color:var(--text-3)">{{ $plan['period'] }}</div>
                <div class="text-xs leading-relaxed" style="color:var(--text-2)">{{ $plan['desc'] }}</div>
            </div>
            @endforeach
        </div>
        <p class="text-xs mt-2" style="color:var(--text-3)">
            * Los precios pueden variar. Consulta con el administrador para tarifas actualizadas.
        </p>
    </div>

    {{-- CTA admin --}}
    @php
        $adminTel     = '51974536918'; // ← cambia por el número real
        $adminEmail   = 'admin@siscitas.com'; // ← cambia por el correo real
        $adminMsg     = urlencode("Hola, soy {$user->nombre_usuario} y quiero activar/renovar mi publicidad en SisCitas.");
        $adminWa      = "https://wa.me/{$adminTel}?text={$adminMsg}";
        $emailSubject = urlencode("Solicitud de publicidad — {$user->nombre_usuario}");
        $emailBody    = urlencode("Hola,\n\nSoy {$user->nombre_usuario} y me gustaría activar mi publicidad en SisCitas.\n\nQuedo en espera.");
    @endphp

    <div id="contacto-admin"
         class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-4 rounded-xl"
         style="background:var(--surface-2);border:1px solid var(--border)">
        <div>
            <div class="font-bold text-sm mb-0.5" style="color:var(--text)">
                Contacta al administrador para activar tu publicidad
            </div>
            <div class="text-xs" style="color:var(--text-3)">Responderemos en menos de 24 horas hábiles.</div>
        </div>
        <div class="flex flex-wrap gap-2 shrink-0">
            <a href="{{ $adminWa }}" target="_blank" rel="noopener"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-bold text-white no-underline transition-all hover:opacity-90"
               style="background:#25d366">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                WhatsApp
            </a>
            <a href="mailto:{{ $adminEmail }}?subject={{ $emailSubject }}&body={{ $emailBody }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-bold no-underline transition-all hover:opacity-80"
               style="background:var(--surface-3,#202030);color:var(--text-2);border:1px solid var(--border)">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
                Correo
            </a>
        </div>
    </div>
</div>

{{-- ══ ACCESOS RÁPIDOS ══ --}}
<div class="rounded-xl p-5 fade-up fade-up-5" style="background:var(--surface);border:1px solid var(--border)">
    <div class="font-cormorant text-lg font-bold mb-4" style="color:var(--text)">Accesos rápidos</div>
    <div class="flex flex-wrap gap-2">
        @foreach([
            ['href'=>route('usuario.perfil'),           'label'=>'Editar mi perfil',     'icon'=>'<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>'],
            ['href'=>route('perfil.publico', $user),    'label'=>'Ver perfil público',    'icon'=>'<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>','target'=>'_blank'],
            ['href'=>route('usuario.perfil').'#password','label'=>'Cambiar contraseña',   'icon'=>'<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>'],
        ] as $link)
        <a href="{{ $link['href'] }}" @if(isset($link['target'])) target="{{ $link['target'] }}" @endif
           class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-semibold no-underline transition-all hover:opacity-80"
           style="background:var(--surface-2);color:var(--text-2);border:1px solid var(--border)">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                {!! $link['icon'] !!}
            </svg>
            {{ $link['label'] }}
        </a>
        @endforeach
    </div>
</div>

@endsection