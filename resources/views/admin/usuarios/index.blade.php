@extends('layouts.app')
@section('title', 'Usuarios — Admin MiaJuliaca')

@push('styles')
<style>
    @keyframes fadeUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
    .fade-up   { animation: fadeUp .4s ease both; }
    .fade-up-1 { animation-delay: .06s; }
    .fade-up-2 { animation-delay: .12s; }

    .field {
        width: 100%; padding: .52rem .85rem .52rem 2.3rem;
        border-radius: 9px; font-size: .875rem; font-family: inherit;
        outline: none; transition: border-color .18s;
        background: var(--surface-2); border: 1px solid var(--border); color: var(--text);
    }
    .field::placeholder { color: var(--text-3); }
    .field:focus        { border-color: var(--rose); }

    .field-plain {
        width: 100%; padding: .52rem .85rem;
        border-radius: 9px; font-size: .875rem; font-family: inherit;
        outline: none; transition: border-color .18s;
        background: var(--surface-2); border: 1px solid var(--border); color: var(--text);
    }
    .field-plain:focus { border-color: var(--rose); }

    /* Paginación Laravel */
    nav[role="navigation"] { display:flex; justify-content:center; gap:.4rem; flex-wrap:wrap; }
    nav[role="navigation"] a,
    nav[role="navigation"] span {
        display:inline-flex; align-items:center; justify-content:center;
        min-width:36px; height:36px; padding:0 .5rem;
        border-radius:8px; font-size:.83rem; font-weight:600;
        text-decoration:none; color:var(--text-2);
        background:var(--surface-2); border:1px solid var(--border);
        transition:all .15s;
    }
    nav[role="navigation"] a:hover { background:var(--surface-3); color:var(--text); }
    nav[role="navigation"] span[aria-current] { background:var(--rose); color:white; border-color:var(--rose); }
    nav[role="navigation"] span[aria-disabled] { opacity:.35; cursor:not-allowed; }
</style>
@endpush

@section('content')

{{-- ══ HEADER ══ --}}
<div class="flex flex-wrap items-start justify-between gap-4 mb-6 fade-up">
    <div>
        <h1 class="font-cormorant text-3xl md:text-4xl font-bold" style="color:var(--text)">
            Gestión de Usuarios
        </h1>
        <p class="text-sm mt-1" style="color:var(--text-2)">
            {{ $usuarios->total() }} usuario(s) en total
        </p>
    </div>
</div>

{{-- ══ FILTROS ══ --}}
<div class="rounded-xl p-4 mb-4 fade-up fade-up-1" style="background:var(--surface);border:1px solid var(--border)">
    <form method="GET" action="{{ route('admin.usuarios') }}"
          class="flex flex-wrap items-end gap-3">

        {{-- Búsqueda --}}
        <div class="flex-1 min-w-50">
            <label class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">
                Buscar usuario
            </label>
            <div class="relative">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color:var(--text-3)">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="search"
                       class="field"
                       value="{{ request('search') }}"
                       placeholder="Nombre, correo o ciudad...">
            </div>
        </div>

        {{-- Estado --}}
        <div class="w-full sm:w-44">
            <label class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">
                Estado
            </label>
            <select name="estado" class="field-plain">
                <option value="">Todos</option>
                <option value="1" {{ request('estado') === '1' ? 'selected' : '' }}>Activos</option>
                <option value="0" {{ request('estado') === '0' ? 'selected' : '' }}>Inactivos</option>
            </select>
        </div>

        {{-- Botones --}}
        <div class="flex gap-2 shrink-0">
            <button type="submit"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-bold text-white cursor-pointer border-0 transition-all hover:opacity-90"
                    style="background:var(--rose)">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                Filtrar
            </button>
            @if(request('search') || request('estado') !== null)
            <a href="{{ route('admin.usuarios') }}"
               class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold no-underline transition-all hover:opacity-80"
               style="background:var(--surface-2);color:var(--text-2);border:1px solid var(--border)">
                Limpiar
            </a>
            @endif
        </div>
    </form>
</div>

{{-- ══ TABLA / CARDS ══ --}}
<div class="rounded-xl p-5 fade-up fade-up-2" style="background:var(--surface);border:1px solid var(--border)">

    @if($usuarios->isEmpty())
        <div class="text-center py-12" style="color:var(--text-3)">
            <div class="text-5xl mb-3">🔍</div>
            <p class="text-sm mb-4">No se encontraron usuarios con esos filtros.</p>
            <a href="{{ route('admin.usuarios') }}"
               class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold no-underline"
               style="background:var(--surface-2);color:var(--text-2);border:1px solid var(--border)">
                Ver todos
            </a>
        </div>

    @else

        {{-- Mobile: cards --}}
        <div class="flex flex-col gap-2 lg:hidden">
            @foreach($usuarios as $u)
            <div class="rounded-xl p-3.5" style="background:var(--surface-2);border:1px solid var(--border)">
                <div class="flex items-start justify-between gap-3 mb-3">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold text-white shrink-0"
                             style="background:linear-gradient(135deg,var(--rose),var(--rose-dark))">
                            {{ strtoupper(substr($u->nombre_usuario, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <div class="font-semibold truncate" style="color:var(--text)">{{ $u->nombre_usuario }}</div>
                            <div class="text-xs truncate" style="color:var(--text-3)">{{ $u->email }}</div>
                            <div class="text-xs mt-0.5" style="color:var(--text-3)">📱 {{ $u->numero_celular ?? 'sin celular' }}</div>
                        </div>
                    </div>
                    {{-- Toggle --}}
                    <form method="POST" action="{{ route('admin.usuarios.toggle', $u) }}" class="shrink-0">
                        @csrf @method('PATCH')
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold cursor-pointer border-0 transition-all hover:opacity-80"
                                style="{{ $u->estado_publicidad
                                    ? 'background:rgba(0,229,160,.1);color:var(--success);border:1px solid rgba(0,229,160,.25)'
                                    : 'background:rgba(232,67,106,.08);color:var(--danger);border:1px solid rgba(232,67,106,.25)' }}">
                            <span class="w-1.5 h-1.5 rounded-full"
                                  style="background:{{ $u->estado_publicidad ? 'var(--success)' : 'var(--danger)' }}"></span>
                            {{ $u->estado_publicidad ? 'Activa' : 'Inactiva' }}
                        </button>
                    </form>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex gap-3 text-xs" style="color:var(--text-3)">
                        <span>{{ $u->ciudad ?? '—' }}</span>
                        <span style="color:var(--success);font-weight:700">{{ $u->precio ? 'S/. '.number_format($u->precio, 0) : '—' }}</span>
                        <span>{{ $u->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex gap-1.5">
                        <a href="{{ route('admin.usuarios.show', $u) }}"
                           class="px-2.5 py-1 rounded-lg text-xs font-semibold no-underline"
                           style="background:var(--surface-3);color:var(--text-2);border:1px solid var(--border)">
                            Ver
                        </a>
                        <form method="POST" action="{{ route('admin.usuarios.destroy', $u) }}"
                              onsubmit="return confirm('¿Eliminar a {{ $u->nombre_usuario }}?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="px-2.5 py-1 rounded-lg text-xs font-bold cursor-pointer border-0"
                                    style="background:rgba(232,67,106,.1);color:var(--danger);border:1px solid rgba(232,67,106,.2)">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Desktop: tabla --}}
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr style="border-bottom:1px solid var(--border)">
                        @foreach(['#','Usuario','Correo','Ciudad','Edad','Tarifa','Publicidad','Registrado',''] as $th)
                        <th class="text-left pb-3 px-3 text-xs font-bold uppercase tracking-[.07em]"
                            style="color:var(--text-3)">{{ $th }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $u)
                    <tr class="transition-colors hover:bg-white/2"
                        style="border-bottom:1px solid var(--border)">
                        <td class="py-3 px-3 text-xs" style="color:var(--text-3)">{{ $u->id }}</td>
                        <td class="py-3 px-3">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0"
                                     style="background:linear-gradient(135deg,var(--rose),var(--rose-dark))">
                                    {{ strtoupper(substr($u->nombre_usuario, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-semibold" style="color:var(--text)">{{ $u->nombre_usuario }}</div>
                                    <div class="text-xs" style="color:var(--text-3)">📱 {{ $u->numero_celular ?? 'sin celular' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-3 text-xs" style="color:var(--text-2)">{{ $u->email }}</td>
                        <td class="py-3 px-3 text-xs" style="color:var(--text-2)">{{ $u->ciudad ?? '—' }}</td>
                        <td class="py-3 px-3 text-xs" style="color:var(--text-2)">{{ $u->edad ? $u->edad.' a.' : '—' }}</td>
                        <td class="py-3 px-3 font-bold text-sm" style="color:var(--success)">
                            {{ $u->precio ? 'S/. '.number_format($u->precio, 0) : '—' }}
                        </td>
                        <td class="py-3 px-3">
                            <form method="POST" action="{{ route('admin.usuarios.toggle', $u) }}">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold cursor-pointer border-0 transition-all hover:opacity-80"
                                        style="{{ $u->estado_publicidad
                                            ? 'background:rgba(0,229,160,.1);color:var(--success);border:1px solid rgba(0,229,160,.25)'
                                            : 'background:rgba(232,67,106,.08);color:var(--danger);border:1px solid rgba(232,67,106,.25)' }}">
                                    <span class="w-1.5 h-1.5 rounded-full"
                                          style="background:{{ $u->estado_publicidad ? 'var(--success)' : 'var(--danger)' }}"></span>
                                    {{ $u->estado_publicidad ? 'Activa' : 'Inactiva' }}
                                </button>
                            </form>
                        </td>
                        <td class="py-3 px-3 text-xs" style="color:var(--text-3)">{{ $u->created_at->format('d/m/Y') }}</td>
                        <td class="py-3 px-3">
                            <div class="flex gap-1.5 justify-end">
                                <a href="{{ route('admin.usuarios.show', $u) }}"
                                   class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold no-underline transition-all hover:opacity-80"
                                   style="background:var(--surface-2);color:var(--text-2);border:1px solid var(--border)">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    Ver
                                </a>
                                <form method="POST" action="{{ route('admin.usuarios.destroy', $u) }}"
                                      onsubmit="return confirm('¿Eliminar a {{ $u->nombre_usuario }}? Esta acción no se puede deshacer.')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold cursor-pointer border-0 transition-all hover:opacity-80"
                                            style="background:rgba(232,67,106,.1);color:var(--danger);border:1px solid rgba(232,67,106,.2)">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                        </svg>
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if($usuarios->hasPages())
        <div class="pt-4 mt-2" style="border-top:1px solid var(--border)">
            {{ $usuarios->links() }}
        </div>
        @endif

    @endif
</div>

@endsection