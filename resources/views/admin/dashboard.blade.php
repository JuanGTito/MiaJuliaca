@extends('layouts.app')
@section('title', 'Panel Admin — MiaJuliaca')

@push('styles')
<style>
    @keyframes fadeUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
    .fade-up   { animation: fadeUp .4s ease both; }
    .fade-up-1 { animation-delay: .06s; }
    .fade-up-2 { animation-delay: .12s; }
    .fade-up-3 { animation-delay: .18s; }
</style>
@endpush

@section('content')

{{-- ══ PAGE HEADER ══ --}}
<div class="flex flex-wrap items-start justify-between gap-4 mb-6 fade-up">
    <div>
        <h1 class="font-cormorant text-3xl md:text-4xl font-bold" style="color:var(--text)">
            Panel de Administración
        </h1>
        <p class="text-sm mt-1" style="color:var(--text-2)">
            Resumen general · {{ now()->format('d \d\e F, Y') }}
        </p>
    </div>
    <a href="{{ route('admin.usuarios') }}"
       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-bold text-white no-underline transition-all hover:opacity-90"
       style="background:var(--rose)">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
        Ver todos los usuarios
    </a>
</div>

{{-- ══ STATS ══ --}}
@php
    $statCards = [
        ['icon_color'=>'var(--rose)',   'icon_bg'=>'var(--rose-soft)',       'val'=>$stats['total'],    'lbl'=>'Usuarios registrados',
         'icon'=>'<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>'],
        ['icon_color'=>'var(--success)','icon_bg'=>'var(--success-bg)',      'val'=>$stats['activos'],  'lbl'=>'Perfiles activos',
         'icon'=>'<polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/>'],
        ['icon_color'=>'var(--danger)', 'icon_bg'=>'rgba(232,67,106,.1)',    'val'=>$stats['inactivos'],'lbl'=>'Perfiles inactivos',
         'icon'=>'<polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/><polyline points="17 18 23 18 23 12"/>'],
        ['icon_color'=>'var(--gold)',   'icon_bg'=>'rgba(212,168,83,.1)',    'val'=>$stats['nuevos'],   'lbl'=>'Nuevos este mes',
         'icon'=>'<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>'],
    ];
@endphp

<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-5 fade-up fade-up-1">
    @foreach($statCards as $s)
    <div class="flex items-center gap-3 p-4 rounded-xl transition-all hover:-translate-y-0.5"
         style="background:var(--surface);border:1px solid var(--border)">
        <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0"
             style="background:{{ $s['icon_bg'] }}">
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="{{ $s['icon_color'] }}" stroke-width="2">
                {!! $s['icon'] !!}
            </svg>
        </div>
        <div>
            <div class="text-2xl font-bold leading-none" style="color:var(--text)">{{ $s['val'] }}</div>
            <div class="text-xs mt-1" style="color:var(--text-2)">{{ $s['lbl'] }}</div>
        </div>
    </div>
    @endforeach
</div>

{{-- ══ DISTRIBUCIÓN + ACCIONES ══ --}}
@php
    $total       = max($stats['total'], 1);
    $pctActivos  = round(($stats['activos'] / $total) * 100);
    $pctInactivos = 100 - $pctActivos;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5 fade-up fade-up-2">

    {{-- Estado de publicidad --}}
    <div class="rounded-xl p-5" style="background:var(--surface);border:1px solid var(--border)">
        <div class="flex items-center gap-2 font-cormorant text-lg font-bold mb-5" style="color:var(--text)">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--rose)" stroke-width="2" class="shrink-0">
                <line x1="18" y1="20" x2="18" y2="10"/>
                <line x1="12" y1="20" x2="12" y2="4"/>
                <line x1="6" y1="20" x2="6" y2="14"/>
            </svg>
            Estado de publicidad
        </div>

        @foreach([['Activos', $pctActivos, 'var(--success)'], ['Inactivos', $pctInactivos, 'var(--danger)']] as [$lbl, $pct, $color])
        <div class="mb-4">
            <div class="flex justify-between text-xs mb-1.5" style="color:var(--text-3)">
                <span>{{ $lbl }}</span><span>{{ $pct }}%</span>
            </div>
            <div class="h-2 rounded-full overflow-hidden" style="background:var(--surface-3)">
                <div class="h-full rounded-full transition-all duration-1000"
                     style="width:{{ $pct }}%;background:{{ $color }}"></div>
            </div>
        </div>
        @endforeach

        <div class="flex gap-5 mt-4">
            <div class="flex items-center gap-2 text-sm">
                <div class="w-2.5 h-2.5 rounded-full shrink-0" style="background:var(--success)"></div>
                <span style="color:var(--text-2)">{{ $stats['activos'] }} activos</span>
            </div>
            <div class="flex items-center gap-2 text-sm">
                <div class="w-2.5 h-2.5 rounded-full shrink-0" style="background:var(--danger)"></div>
                <span style="color:var(--text-2)">{{ $stats['inactivos'] }} inactivos</span>
            </div>
        </div>
    </div>

    {{-- Acciones rápidas --}}
    <div class="rounded-xl p-5" style="background:var(--surface);border:1px solid var(--border)">
        <div class="flex items-center gap-2 font-cormorant text-lg font-bold mb-4" style="color:var(--text)">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--rose)" stroke-width="2" class="shrink-0">
                <circle cx="12" cy="12" r="3"/>
                <path d="M19.07 4.93l-1.41 1.41M5.34 5.34L3.93 3.93M21 12h-2M5 12H3M19.07 19.07l-1.41-1.41M5.34 18.66l-1.41 1.41M12 5V3m0 18v-2"/>
            </svg>
            Acciones rápidas
        </div>
        <div class="flex flex-col gap-2">
            @foreach([
                ['href'=>route('admin.usuarios'),                            'icon'=>'<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>','lbl'=>'Gestionar usuarios'],
                ['href'=>route('admin.usuarios', ['estado'=>'0']),           'icon'=>'<circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>','lbl'=>'Ver perfiles inactivos'],
                ['href'=>route('admin.usuarios', ['estado'=>'1']),           'icon'=>'<polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>','lbl'=>'Ver perfiles activos'],
            ] as $link)
            <a href="{{ $link['href'] }}"
               class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-semibold no-underline transition-all hover:opacity-80"
               style="background:var(--surface-2);color:var(--text-2);border:1px solid var(--border)">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="shrink-0">
                    {!! $link['icon'] !!}
                </svg>
                {{ $link['lbl'] }}
            </a>
            @endforeach
        </div>
    </div>
</div>

{{-- ══ TABLA RECIENTES ══ --}}
<div class="rounded-xl p-5 fade-up fade-up-3" style="background:var(--surface);border:1px solid var(--border)">
    <div class="flex items-center justify-between mb-4">
        <div class="font-cormorant text-lg font-bold" style="color:var(--text)">Usuarios recientes</div>
        <a href="{{ route('admin.usuarios') }}"
           class="text-xs font-semibold no-underline transition-all hover:opacity-70"
           style="color:var(--rose)">
            Ver todos →
        </a>
    </div>

    @if($recientes->isEmpty())
        <div class="text-center py-10" style="color:var(--text-3)">
            <div class="text-4xl mb-3">👤</div>
            <p class="text-sm">No hay usuarios registrados aún.</p>
        </div>
    @else
        {{-- Mobile: cards --}}
        <div class="flex flex-col gap-2 md:hidden">
            @foreach($recientes as $u)
            <div class="flex items-center justify-between p-3 rounded-xl gap-3"
                 style="background:var(--surface-2);border:1px solid var(--border)">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold text-white shrink-0"
                         style="background:linear-gradient(135deg,var(--rose),var(--rose-dark))">
                        {{ strtoupper(substr($u->nombre_usuario, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <div class="font-semibold text-sm truncate" style="color:var(--text)">{{ $u->nombre_usuario }}</div>
                        <div class="text-xs truncate" style="color:var(--text-3)">{{ $u->ciudad ?? '—' }} · {{ $u->created_at->format('d/m/Y') }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold"
                          style="{{ $u->estado_publicidad
                            ? 'background:rgba(0,229,160,.1);border:1px solid rgba(0,229,160,.25);color:var(--success)'
                            : 'background:rgba(232,67,106,.08);border:1px solid rgba(232,67,106,.25);color:var(--danger)' }}">
                        <span class="w-1.5 h-1.5 rounded-full" style="background:{{ $u->estado_publicidad ? 'var(--success)' : 'var(--danger)' }}"></span>
                        {{ $u->estado_publicidad ? 'Activa' : 'Inactiva' }}
                    </span>
                    <a href="{{ route('admin.usuarios.show', $u) }}"
                       class="px-2.5 py-1 rounded-lg text-xs font-semibold no-underline"
                       style="background:var(--surface-3);color:var(--text-2);border:1px solid var(--border)">
                        Ver
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Desktop: tabla --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr style="border-bottom:1px solid var(--border)">
                        @foreach(['Usuario','Ciudad','Tarifa','Edad','Publicidad','Registrado',''] as $th)
                        <th class="text-left pb-2.5 px-3 text-xs font-bold uppercase tracking-[.07em]"
                            style="color:var(--text-3)">{{ $th }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($recientes as $u)
                    <tr class="transition-colors hover:bg-white/3"
                        style="border-bottom:1px solid var(--border)">
                        <td class="py-3 px-3">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0"
                                     style="background:linear-gradient(135deg,var(--rose),var(--rose-dark))">
                                    {{ strtoupper(substr($u->nombre_usuario, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-semibold" style="color:var(--text)">{{ $u->nombre_usuario }}</div>
                                    <div class="text-xs" style="color:var(--text-3)">{{ $u->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-3" style="color:var(--text-2)">{{ $u->ciudad ?? '—' }}</td>
                        <td class="py-3 px-3 font-bold" style="color:var(--success)">
                            {{ $u->precio ? 'S/. '.number_format($u->precio, 0) : '—' }}
                        </td>
                        <td class="py-3 px-3" style="color:var(--text-2)">{{ $u->edad ? $u->edad.' a.' : '—' }}</td>
                        <td class="py-3 px-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold"
                                  style="{{ $u->estado_publicidad
                                    ? 'background:rgba(0,229,160,.1);border:1px solid rgba(0,229,160,.25);color:var(--success)'
                                    : 'background:rgba(232,67,106,.08);border:1px solid rgba(232,67,106,.25);color:var(--danger)' }}">
                                <span class="w-1.5 h-1.5 rounded-full"
                                      style="background:{{ $u->estado_publicidad ? 'var(--success)' : 'var(--danger)' }}"></span>
                                {{ $u->estado_publicidad ? 'Activa' : 'Inactiva' }}
                            </span>
                        </td>
                        <td class="py-3 px-3 text-xs" style="color:var(--text-3)">{{ $u->created_at->format('d/m/Y') }}</td>
                        <td class="py-3 px-3">
                            <a href="{{ route('admin.usuarios.show', $u) }}"
                               class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold no-underline transition-all hover:opacity-80"
                               style="background:var(--surface-2);color:var(--text-2);border:1px solid var(--border)">
                                Ver
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection