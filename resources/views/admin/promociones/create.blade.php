@extends('layouts.app')
@section('title', 'Registrar Promoción — ' . $user->nombre_usuario)

@push('styles')
<style>
    @keyframes fadeUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
    .fade-up   { animation: fadeUp .4s ease both; }
    .fade-up-1 { animation-delay: .06s; }

    .field {
        width: 100%; padding: .55rem .85rem;
        border-radius: 9px; font-size: .875rem; font-family: inherit;
        outline: none; transition: border-color .18s;
        background: var(--surface-2); border: 1px solid var(--border); color: var(--text);
    }
    .field::placeholder { color: var(--text-3); }
    .field:focus        { border-color: var(--rose); }
    .field.is-invalid   { border-color: var(--danger); }
    .field-error { font-size: .75rem; color: var(--danger); margin-top: .28rem; }
    .field-hint  { font-size: .73rem; color: var(--text-3); margin-top: .28rem; line-height: 1.5; }
    textarea.field { resize: vertical; }
</style>
@endpush

@section('content')

{{-- ══ HEADER ══ --}}
<div class="flex flex-wrap items-start justify-between gap-4 mb-6 fade-up">
    <div class="flex items-center gap-3 flex-wrap">
        <a href="{{ route('admin.usuarios.show', $user) }}"
           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold no-underline transition-all hover:opacity-80"
           style="background:var(--surface-2);color:var(--text-2);border:1px solid var(--border)">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
            </svg>
            Volver
        </a>
        <div>
            <h1 class="font-cormorant text-2xl md:text-3xl font-bold" style="color:var(--text)">Registrar pago</h1>
            <p class="text-sm mt-0.5" style="color:var(--text-2)">
                Asignar días de publicidad a <strong style="color:var(--rose)">{{ $user->nombre_usuario }}</strong>
            </p>
        </div>
    </div>
</div>

{{-- ══ GRID ══ --}}
<div class="grid grid-cols-1 lg:grid-cols-[1fr_340px] gap-5 items-start fade-up fade-up-1">

    {{-- ── Formulario ── --}}
    <div class="rounded-xl p-5 md:p-6" style="background:var(--surface);border:1px solid var(--border)">

        <div class="flex items-center gap-2 font-cormorant text-lg font-bold mb-5" style="color:var(--text)">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2" class="shrink-0">
                <rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/>
            </svg>
            Datos del pago
        </div>

        {{-- Errores --}}
        @if($errors->any())
        <div class="flex items-start gap-2.5 p-3.5 rounded-xl mb-5 text-sm"
             style="background:rgba(232,67,106,.08);border:1px solid rgba(232,67,106,.22);color:var(--danger)">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="shrink-0 mt-0.5">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <ul class="ml-1 text-xs space-y-0.5 list-disc">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.promociones.store', $user) }}">
            @csrf

            {{-- Días pagados --}}
            <div class="mb-4">
                <label for="dias_pagados" class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">
                    Días de publicidad pagados <span style="color:var(--rose)">*</span>
                </label>
                <input type="number" id="dias_pagados" name="dias_pagados"
                       class="field {{ $errors->has('dias_pagados') ? 'is-invalid' : '' }}"
                       value="{{ old('dias_pagados') }}"
                       min="1" max="365"
                       placeholder="Ej: 5, 9, 30..."
                       required>
                @error('dias_pagados')<p class="field-error">{{ $message }}</p>@enderror

                @if($fechaFinActual)
                    <p class="field-hint" style="color:var(--gold)">
                        ⚡ Tiene días activos hasta el <strong>{{ \Carbon\Carbon::parse($fechaFinActual)->format('d/m/Y') }}</strong>.
                        Los días nuevos se sumarán desde esa fecha.
                    </p>
                @else
                    <p class="field-hint">
                        Los días empezarán a contar desde hoy <strong>{{ now()->format('d/m/Y') }}</strong>.
                    </p>
                @endif
            </div>

            {{-- Monto + preview fecha --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="monto" class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">
                        Monto cobrado <span class="normal-case tracking-normal font-normal">(opcional)</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm pointer-events-none"
                              style="color:var(--text-3)">S/.</span>
                        <input type="number" id="monto" name="monto"
                               class="field {{ $errors->has('monto') ? 'is-invalid' : '' }}"
                               style="padding-left:2.2rem"
                               value="{{ old('monto') }}"
                               min="0" step="0.01"
                               placeholder="0.00">
                    </div>
                    @error('monto')<p class="field-error">{{ $message }}</p>@enderror
                    <p class="field-hint">Para registro interno del cobro.</p>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">
                        Nueva fecha fin estimada
                    </label>
                    <div id="preview-fecha"
                         class="px-4 py-2.5 rounded-[9px] text-sm"
                         style="background:var(--surface-2);border:1.5px solid var(--border);color:var(--text-3)">
                        Ingresa los días para calcular
                    </div>
                </div>
            </div>

            {{-- Notas --}}
            <div class="mb-5">
                <label for="notas" class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">
                    Notas internas <span class="normal-case tracking-normal font-normal">(opcional)</span>
                </label>
                <textarea id="notas" name="notas" rows="3"
                          class="field"
                          placeholder="Ej: Pagó por WhatsApp, transferencia #1234...">{{ old('notas') }}</textarea>
                <p class="field-hint">Solo el admin puede ver estas notas.</p>
            </div>

            {{-- Acciones --}}
            <div class="flex items-center justify-end gap-2 pt-4" style="border-top:1px solid var(--border)">
                <a href="{{ route('admin.usuarios.show', $user) }}"
                   class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold no-underline transition-all hover:opacity-80"
                   style="background:var(--surface-2);color:var(--text-2);border:1px solid var(--border)">
                    Cancelar
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-bold text-white cursor-pointer border-0 transition-all hover:opacity-90"
                        style="background:var(--rose)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Registrar pago
                </button>
            </div>
        </form>
    </div>

    {{-- ── Panel lateral ── --}}
    <div class="flex flex-col gap-4">

        {{-- Resumen usuario --}}
        <div class="rounded-xl p-5 text-center" style="background:var(--surface);border:1px solid var(--border)">
            <div class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-2.5 text-2xl font-bold text-white"
                 style="background:linear-gradient(135deg,var(--rose),var(--rose-dark))">
                {{ strtoupper(substr($user->nombre_usuario, 0, 1)) }}
            </div>
            <div class="font-cormorant text-xl font-bold mb-0.5" style="color:var(--text)">{{ $user->nombre_usuario }}</div>
            <div class="text-xs mb-3" style="color:var(--text-3)">{{ $user->email }}</div>

            @if($fechaFinActual)
                <div class="text-left rounded-xl p-3.5 mb-2"
                     style="background:rgba(212,168,83,.08);border:1px solid rgba(212,168,83,.2)">
                    <div class="text-[.68rem] font-bold uppercase tracking-[.08em] mb-1" style="color:var(--gold)">⭐ Publicidad activa</div>
                    <div class="text-sm" style="color:var(--text-2)">
                        Vence el <strong style="color:var(--text)">{{ \Carbon\Carbon::parse($fechaFinActual)->format('d \d\e F, Y') }}</strong>
                    </div>
                    <div class="text-xs mt-1" style="color:var(--text-3)">
                        {{ max(0, (int) now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($fechaFinActual), false)) }} días restantes
                    </div>
                </div>
            @else
                <div class="text-left rounded-xl p-3.5 mb-2"
                     style="background:var(--surface-2);border:1px solid var(--border)">
                    <div class="text-xs" style="color:var(--text-3)">Sin publicidad activa actualmente.</div>
                </div>
            @endif
        </div>

        {{-- Historial --}}
        <div class="rounded-xl p-5" style="background:var(--surface);border:1px solid var(--border)">
            <div class="flex items-center gap-2 font-cormorant text-base font-bold mb-4" style="color:var(--text)">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--rose)" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
                Historial de pagos
            </div>

            @if($historial->isEmpty())
                <p class="text-xs text-center py-3" style="color:var(--text-3)">Sin pagos registrados aún.</p>
            @else
                <div class="flex flex-col gap-2 max-h-80 overflow-y-auto pr-0.5">
                    @foreach($historial as $promo)
                        @php $activa = \Carbon\Carbon::parse($promo->fecha_fin)->greaterThanOrEqualTo(now()->startOfDay()); @endphp
                        <div class="rounded-xl p-3"
                             style="background:var(--surface-2);border:1px solid {{ $activa ? 'rgba(212,168,83,.2)' : 'var(--border)' }}">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <div class="text-sm font-semibold" style="color:var(--text)">
                                        {{ $promo->dias_pagados }} días
                                        @if($promo->monto)
                                            <span class="font-normal text-xs" style="color:var(--text-3)">
                                                · S/. {{ number_format($promo->monto, 2) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-xs mt-0.5" style="color:var(--text-3)">
                                        {{ $promo->fecha_inicio->format('d/m/Y') }} → {{ $promo->fecha_fin->format('d/m/Y') }}
                                    </div>
                                    @if($promo->notas)
                                        <div class="text-xs mt-1 italic truncate" style="color:var(--text-3)">
                                            "{{ Str::limit($promo->notas, 50) }}"
                                        </div>
                                    @endif
                                </div>
                                <div class="flex flex-col items-end gap-1.5 shrink-0">
                                    <span class="text-[.65rem] font-bold px-2 py-0.5 rounded-full"
                                          style="background:{{ $activa ? 'rgba(212,168,83,.12)' : 'var(--surface-3)' }};color:{{ $activa ? 'var(--gold)' : 'var(--text-3)' }}">
                                        {{ $activa ? 'Activa' : 'Vencida' }}
                                    </span>
                                    <form method="POST" action="{{ route('admin.promociones.destroy', $promo) }}"
                                          onsubmit="return confirm('¿Eliminar esta promoción?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="text-xs cursor-pointer border-0 bg-transparent transition-all hover:opacity-60"
                                                style="color:var(--text-3)">
                                            ✕ Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const inputDias    = document.getElementById('dias_pagados');
const previewFecha = document.getElementById('preview-fecha');
const fechaFinActual = @json($fechaFinActual);

function calcularFecha(dias) {
    if (!dias || dias < 1) {
        previewFecha.textContent = 'Ingresa los días para calcular';
        previewFecha.style.color = 'var(--text-3)';
        return;
    }
    let base = fechaFinActual
        ? new Date(fechaFinActual + 'T00:00:00')
        : (() => { const d = new Date(); d.setHours(0,0,0,0); return d; })();

    base.setDate(base.getDate() + parseInt(dias));
    previewFecha.textContent = '📅 ' + base.toLocaleDateString('es-PE', { weekday:'long', year:'numeric', month:'long', day:'numeric' });
    previewFecha.style.color = 'var(--gold)';
}

inputDias.addEventListener('input', () => calcularFecha(inputDias.value));
if (inputDias.value) calcularFecha(inputDias.value);
</script>
@endpush