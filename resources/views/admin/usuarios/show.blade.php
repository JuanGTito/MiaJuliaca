@extends('layouts.app')
@section('title', 'Usuario: ' . $user->nombre_usuario . ' — Admin MiaJuliaca')

@push('styles')
<style>
    @keyframes fadeUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
    .fade-up   { animation: fadeUp .4s ease both; }
    .fade-up-1 { animation-delay: .06s; }
    .fade-up-2 { animation-delay: .10s; }
    .fade-up-3 { animation-delay: .14s; }
    .fade-up-4 { animation-delay: .18s; }
</style>
@endpush

@section('content')

{{-- ══ HEADER ══ --}}
<div class="flex flex-wrap items-start justify-between gap-4 mb-6 fade-up">
    <div class="flex items-center gap-3 flex-wrap">
        <a href="{{ route('admin.usuarios') }}"
           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold no-underline transition-all hover:opacity-80"
           style="background:var(--surface-2);color:var(--text-2);border:1px solid var(--border)">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
            </svg>
            Volver
        </a>
        <div>
            <h1 class="font-cormorant text-2xl md:text-3xl font-bold" style="color:var(--text)">
                {{ $user->nombre_usuario }}
            </h1>
            <p class="text-sm mt-0.5" style="color:var(--text-2)">Detalle del usuario · ID #{{ $user->id }}</p>
        </div>
    </div>

    <div class="flex flex-wrap gap-2">
        <a href="{{ route('admin.promociones.create', $user) }}"
           class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-bold text-white no-underline transition-all hover:opacity-90"
           style="background:var(--rose)">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/>
            </svg>
            Registrar pago
        </a>

        <form method="POST" action="{{ route('admin.usuarios.toggle', $user) }}">
            @csrf @method('PATCH')
            <button type="submit"
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-bold cursor-pointer border-0 transition-all hover:opacity-80"
                    style="{{ $user->estado_publicidad
                        ? 'background:var(--surface-2);color:var(--text-2);border:1px solid var(--border)'
                        : 'background:rgba(0,229,160,.1);color:var(--success);border:1px solid rgba(0,229,160,.25)' }}">
                @if($user->estado_publicidad)
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
                    </svg>
                    Desactivar publicidad
                @else
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 11 12 14 22 4"/>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                    </svg>
                    Activar publicidad
                @endif
            </button>
        </form>

        <form method="POST" action="{{ route('admin.usuarios.destroy', $user) }}"
              onsubmit="return confirm('¿Eliminar definitivamente a {{ $user->nombre_usuario }}?')">
            @csrf @method('DELETE')
            <button type="submit"
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-bold cursor-pointer border-0 transition-all hover:opacity-80"
                    style="background:rgba(232,67,106,.1);color:var(--danger);border:1px solid rgba(232,67,106,.2)">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                </svg>
                Eliminar
            </button>
        </form>
    </div>
</div>

{{-- ══ GRID PRINCIPAL ══ --}}
<div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-5 items-start fade-up fade-up-1">

    {{-- ── Columna izquierda ── --}}
    <div class="flex flex-col gap-4">

        {{-- Avatar + estado --}}
        <div class="rounded-xl p-5 text-center" style="background:var(--surface);border:1px solid var(--border)">
            <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-3 text-3xl font-bold text-white"
                 style="background:linear-gradient(135deg,var(--rose),var(--rose-dark))">
                {{ strtoupper(substr($user->nombre_usuario, 0, 1)) }}
            </div>
            <div class="font-cormorant text-2xl font-bold" style="color:var(--text)">{{ $user->nombre_usuario }}</div>
            <div class="text-xs mt-1 mb-3" style="color:var(--text-3)">{{ $user->email }}</div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold"
                  style="{{ $user->estado_publicidad
                    ? 'background:rgba(0,229,160,.1);border:1px solid rgba(0,229,160,.25);color:var(--success)'
                    : 'background:rgba(232,67,106,.08);border:1px solid rgba(232,67,106,.25);color:var(--danger)' }}">
                <span class="w-1.5 h-1.5 rounded-full"
                      style="background:{{ $user->estado_publicidad ? 'var(--success)' : 'var(--danger)' }}"></span>
                Publicidad {{ $user->estado_publicidad ? 'Activa' : 'Inactiva' }}
            </span>
        </div>

        {{-- Datos rápidos --}}
        <div class="rounded-xl p-5" style="background:var(--surface);border:1px solid var(--border)">
            <div class="text-xs font-bold uppercase tracking-widest mb-4" style="color:var(--text-3)">Datos rápidos</div>
            @php $rows = [
                ['Edad',                $user->edad ? $user->edad.' años' : '—'],
                ['Ciudad',              $user->ciudad ?? '—'],
                ['Celular',             $user->numero_celular ?? '—'],
                ['Tarifa',              $user->precio ? 'S/. '.number_format($user->precio, 2) : '—'],
                ['Registrado',          $user->created_at->format('d/m/Y H:i')],
                ['Última actualización',$user->updated_at->diffForHumans()],
            ]; @endphp
            <div class="flex flex-col gap-3">
                @foreach($rows as [$lbl, $val])
                <div class="flex justify-between items-start gap-2 text-sm
                             {{ !$loop->last ? 'pb-3' : '' }}"
                     style="{{ !$loop->last ? 'border-bottom:1px solid var(--border)' : '' }}">
                    <span class="shrink-0" style="color:var(--text-3)">{{ $lbl }}</span>
                    <span class="font-semibold text-right" style="color:var(--text)">{{ $val }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ── Columna derecha ── --}}
    <div class="flex flex-col gap-4">

        {{-- Descripción --}}
        <div class="rounded-xl p-5 fade-up fade-up-2" style="background:var(--surface);border:1px solid var(--border)">
            <div class="flex items-center gap-2 font-cormorant text-lg font-bold mb-3" style="color:var(--text)">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--rose)" stroke-width="2" class="shrink-0">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
                Descripción del perfil
            </div>
            @if($user->descripcion)
                <p class="text-sm leading-relaxed" style="color:var(--text-2)">{{ $user->descripcion }}</p>
            @else
                <p class="text-sm italic" style="color:var(--text-3)">El usuario no ha agregado descripción.</p>
            @endif
        </div>

        {{-- Contacto --}}
        <div class="rounded-xl p-5 fade-up fade-up-3" style="background:var(--surface);border:1px solid var(--border)">
            <div class="flex items-center gap-2 font-cormorant text-lg font-bold mb-4" style="color:var(--text)">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--rose)" stroke-width="2" class="shrink-0">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.39 18 19.5 19.5 0 0 1 5 11.61 19.79 19.79 0 0 1 2.12 2.18 2 2 0 0 1 4.11 0h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9a16 16 0 0 0 6.91 6.91l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                </svg>
                Información de contacto
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach([
                    ['Correo electrónico', $user->email,                               false],
                    ['Número celular',     $user->numero_celular ?? 'No registrado',   false],
                    ['Ciudad',             $user->ciudad ?? 'No registrada',           false],
                    ['Tarifa',             $user->precio ? 'S/. '.number_format($user->precio, 2) : 'No definida', true],
                ] as [$lbl, $val, $highlight])
                <div class="rounded-xl px-4 py-3" style="background:var(--surface-2);border:1px solid var(--border)">
                    <div class="text-[.68rem] font-bold uppercase tracking-[.08em] mb-1" style="color:var(--text-3)">{{ $lbl }}</div>
                    <div class="font-semibold text-sm {{ $highlight ? 'text-xl font-bold' : '' }} break-all"
                         style="color:{{ $highlight ? 'var(--success)' : 'var(--text)' }}">
                        {{ $val }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Actividad --}}
        <div class="rounded-xl p-5 fade-up fade-up-4" style="background:var(--surface);border:1px solid var(--border)">
            <div class="flex items-center gap-2 font-cormorant text-lg font-bold mb-4" style="color:var(--text)">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--rose)" stroke-width="2" class="shrink-0">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
                Actividad
            </div>
            <div class="flex flex-col gap-2">
                @foreach([
                    ['color'=>'var(--success)', 'text'=>'Cuenta creada el',       'strong'=>$user->created_at->format('d \d\e F, Y \a \l\a\s H:i')],
                    ['color'=>'var(--gold)',    'text'=>'Última actualización',    'strong'=>$user->updated_at->diffForHumans()],
                    ['color'=>$user->estado_publicidad ? 'var(--success)' : 'var(--danger)',
                     'text'=>'Publicidad',  'strong'=>$user->estado_publicidad ? 'activa' : 'inactiva'],
                ] as $item)
                <div class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm"
                     style="background:var(--surface-2);border:1px solid var(--border)">
                    <div class="w-2 h-2 rounded-full shrink-0" style="background:{{ $item['color'] }}"></div>
                    <span style="color:var(--text-2)">
                        {{ $item['text'] }} <strong style="color:var(--text)">{{ $item['strong'] }}</strong>
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection