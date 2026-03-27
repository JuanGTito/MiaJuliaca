@extends('layouts.app')
@section('title', 'Mi Perfil — SisCitas')

@push('styles')
<style>
    @keyframes fadeUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
    .fade-up   { animation: fadeUp .4s ease both; }
    .fade-up-1 { animation-delay: .06s; }
    .fade-up-2 { animation-delay: .12s; }
    .fade-up-3 { animation-delay: .18s; }

    /* Overlay de fotos — solo se activa en hover en desktop */
    .photo-overlay { opacity: 0; transition: opacity .2s, background .2s; background: rgba(8,8,16,0); }
    @media (hover: hover) {
        .photo-item:hover .photo-overlay { opacity: 1; background: rgba(8,8,16,.72); }
    }
    /* En touch siempre visible */
    @media (hover: none) {
        .photo-overlay { opacity: 1; background: rgba(8,8,16,.55); }
    }

    /* Inputs del formulario */
    .field {
        width: 100%;
        padding: .55rem .85rem;
        border-radius: 9px;
        font-size: .875rem;
        font-family: inherit;
        outline: none;
        transition: border-color .18s;
        background: var(--surface-2);
        border: 1px solid var(--border);
        color: var(--text);
    }
    .field::placeholder { color: var(--text-3); }
    .field:focus { border-color: var(--rose); }
    .field.is-invalid { border-color: var(--danger); }
    .field-error { font-size: .75rem; color: var(--danger); margin-top: .3rem; }
    .field-hint  { font-size: .73rem; color: var(--text-3); margin-top: .3rem; line-height: 1.5; }

    /* Descripción textarea */
    textarea.field { resize: vertical; }

    /* Drop zone active state */
    .drop-active { border-color: var(--rose) !important; background: var(--rose-soft) !important; }

    /* Line-clamp */
    .clamp-3 { display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden; }
</style>
@endpush

@section('content')
@php $fotos = $user->fotos; @endphp

{{-- ══ PAGE HEADER ══ --}}
<div class="flex flex-wrap items-start justify-between gap-3 mb-6 fade-up">
    <div>
        <h1 class="font-cormorant text-3xl md:text-4xl font-bold" style="color:var(--text)">Mi Perfil</h1>
        <p class="text-sm mt-1" style="color:var(--text-2)">Administra tu información</p>
    </div>
</div>

{{-- ══ GRID PRINCIPAL ══ --}}
{{-- En móvil: col única. En desktop: 2 columnas iguales --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 items-start">

    {{-- ════ COLUMNA IZQUIERDA ════ --}}
    <div class="flex flex-col gap-5">

        {{-- ── GESTOR DE FOTOS ── --}}
        <div class="rounded-xl p-5 fade-up" style="background:var(--surface);border:1px solid var(--border)">

            {{-- Título + contador --}}
            <div class="flex items-center gap-2 font-cormorant text-lg font-bold mb-4" style="color:var(--text)">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--rose)" stroke-width="2" class="shrink-0">
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <circle cx="8.5" cy="8.5" r="1.5"/>
                    <polyline points="21 15 16 10 5 21"/>
                </svg>
                Mis fotos
                <span class="text-xs font-normal ml-1" style="color:var(--text-3)">{{ $fotos->count() }}/8</span>
            </div>

            {{-- Barra de progreso --}}
            <div class="mb-5">
                <div class="flex justify-between text-xs mb-1.5" style="color:var(--text-3)">
                    <span>Fotos subidas</span>
                    <span>{{ $fotos->count() }}/8</span>
                </div>
                <div class="h-1.5 rounded-full overflow-hidden" style="background:var(--surface-3)">
                    <div class="h-full rounded-full transition-all duration-1000"
                         style="width:{{ ($fotos->count()/8)*100 }}%;background:var(--rose)"></div>
                </div>
            </div>

            {{-- Grid de fotos --}}
            @if($fotos->count() > 0)
            <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-3 gap-2 mb-5">
                @foreach($fotos as $foto)
                <div class="photo-item relative aspect-square rounded-[10px] overflow-hidden"
                     style="border:2px solid {{ $foto->es_portada ? 'var(--rose)' : 'var(--border)' }};background:var(--surface-2)">
                    <img src="{{ asset('storage/'.$foto->ruta) }}"
                         alt="Foto perfil"
                         class="w-full h-full object-cover">

                    {{-- Badge portada --}}
                    @if($foto->es_portada)
                    <div class="absolute top-1 left-1 px-1.5 py-0.5 rounded-full text-white font-black uppercase tracking-wide"
                         style="font-size:.55rem;background:var(--rose)">
                        ★ Portada
                    </div>
                    @endif

                    {{-- Overlay acciones --}}
                    <div class="photo-overlay absolute inset-0 flex items-center justify-center gap-1.5">
                        @if(!$foto->es_portada)
                        <form method="POST" action="{{ route('usuario.fotos.portada', $foto) }}">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    title="Hacer portada"
                                    class="w-8 h-8 rounded-lg flex items-center justify-center text-white cursor-pointer border-0"
                                    style="background:var(--rose)">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                </svg>
                            </button>
                        </form>
                        @endif
                        <form method="POST" action="{{ route('usuario.fotos.destroy', $foto) }}"
                              onsubmit="return confirm('¿Eliminar esta foto?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    title="Eliminar"
                                    class="w-8 h-8 rounded-lg flex items-center justify-center text-white cursor-pointer border-0"
                                    style="background:var(--danger)">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-6 rounded-xl mb-5" style="background:var(--surface-2);border:2px dashed var(--border)">
                <div class="text-4xl mb-2">📷</div>
                <p class="text-sm" style="color:var(--text-3)">Aún no tienes fotos. ¡Sube al menos una para aparecer en el inicio!</p>
            </div>
            @endif

            {{-- Formulario de subida --}}
            @if($fotos->count() < 8)
            <form method="POST" action="{{ route('usuario.fotos.store') }}" enctype="multipart/form-data">
                @csrf

                <div id="drop-zone"
                     class="rounded-xl text-center cursor-pointer transition-all p-5"
                     style="border:2px dashed var(--border);background:var(--surface-2)"
                     onclick="document.getElementById('file-input').click()"
                     ondragover="event.preventDefault();this.classList.add('drop-active')"
                     ondragleave="this.classList.remove('drop-active')"
                     ondrop="handleDrop(event)">
                    <div class="text-3xl mb-2">⬆️</div>
                    <p class="text-sm font-semibold mb-1" style="color:var(--text-2)">
                        Haz click o arrastra tus fotos aquí
                    </p>
                    <p class="text-xs" style="color:var(--text-3)">
                        JPG, PNG o WEBP · Máx 5MB · Puedes subir hasta {{ 8 - $fotos->count() }} más
                    </p>
                    <input type="file" id="file-input" name="fotos[]"
                           multiple accept="image/jpeg,image/png,image/webp"
                           class="hidden"
                           onchange="previewFiles(this)">
                </div>

                {{-- Preview --}}
                <div id="file-preview" class="hidden mt-3">
                    <p class="text-xs mb-2" style="color:var(--text-3)">Archivos seleccionados:</p>
                    <div id="preview-grid" class="flex flex-wrap gap-2"></div>
                </div>

                @error('fotos')
                <div class="flex items-center gap-2 mt-3 p-3 rounded-lg text-sm"
                     style="background:rgba(232,67,106,.08);border:1px solid rgba(232,67,106,.2);color:var(--danger)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="shrink-0">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    {{ $message }}
                </div>
                @enderror
                @foreach($errors->get('fotos.*') as $msg)
                <div class="mt-1 text-xs p-2 rounded-lg"
                     style="background:rgba(232,67,106,.08);color:var(--danger)">{{ $msg[0] }}</div>
                @endforeach

                <button type="submit" id="upload-btn"
                        class="hidden w-full mt-3 py-2.5 rounded-lg text-sm font-bold text-white items-center justify-center gap-2 transition-all hover:opacity-90"
                        style="background:var(--rose)">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="16 16 12 12 8 16"/>
                        <line x1="12" y1="12" x2="12" y2="21"/>
                        <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
                    </svg>
                    Subir fotos seleccionadas
                </button>
            </form>

            @else
            <div class="flex items-center gap-2 p-3 rounded-lg text-sm"
                 style="background:rgba(212,168,83,.08);border:1px solid rgba(212,168,83,.2);color:var(--gold)">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="shrink-0">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                Alcanzaste el límite de 8 fotos. Elimina alguna para subir nuevas.
            </div>
            @endif
        </div>

        {{-- ── CAMBIAR CONTRASEÑA ── --}}
        <div class="rounded-xl p-5 fade-up fade-up-2" id="password"
             style="background:var(--surface);border:1px solid var(--border)">

            <div class="flex items-center gap-2 font-cormorant text-lg font-bold mb-4" style="color:var(--text)">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--rose)" stroke-width="2" class="shrink-0">
                    <rect x="3" y="11" width="18" height="11" rx="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                Cambiar contraseña
            </div>

            <form method="POST" action="{{ route('usuario.password.update') }}">
                @csrf @method('PUT')

                <div class="mb-4">
                    <label class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">
                        Contraseña actual
                    </label>
                    <input type="password" name="password_actual"
                           class="field {{ $errors->has('password_actual') ? 'is-invalid' : '' }}"
                           placeholder="••••••••">
                    @error('password_actual')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">
                            Nueva contraseña
                        </label>
                        <input type="password" name="password"
                               class="field {{ $errors->has('password') ? 'is-invalid' : '' }}"
                               placeholder="Mínimo 6 caracteres">
                        @error('password')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">
                            Confirmar contraseña
                        </label>
                        <input type="password" name="password_confirmation"
                               class="field"
                               placeholder="Repite la contraseña">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-bold no-underline transition-all hover:opacity-80 cursor-pointer border-0"
                            style="background:var(--surface-2);color:var(--text-2);border:1px solid var(--border)">
                        Actualizar contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ════ COLUMNA DERECHA ════ --}}
    <div class="flex flex-col gap-5">

        {{-- ── EDITAR INFORMACIÓN ── --}}
        <div class="rounded-xl p-5 fade-up fade-up-1" style="background:var(--surface);border:1px solid var(--border)">

            <div class="flex items-center gap-2 font-cormorant text-lg font-bold mb-4" style="color:var(--text)">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--rose)" stroke-width="2" class="shrink-0">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Editar información
            </div>

            <form method="POST" action="{{ route('usuario.perfil.update') }}">
                @csrf @method('PUT')

                {{-- Edad + Tarifa --}}
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">Edad</label>
                        <input type="number" name="edad"
                               class="field {{ $errors->has('edad') ? 'is-invalid' : '' }}"
                               value="{{ old('edad', $user->edad) }}"
                               min="18" max="99" placeholder="25">
                        @error('edad')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">
                            Tarifa <span class="normal-case tracking-normal font-normal" style="color:var(--text-3)">(S/.)</span>
                        </label>
                        <input type="number" name="precio"
                               class="field {{ $errors->has('precio') ? 'is-invalid' : '' }}"
                               value="{{ old('precio', $user->precio) }}"
                               min="0" step="10" placeholder="100">
                        @error('precio')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Celular + Ciudad --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">Número celular</label>
                        <input type="tel" name="numero_celular"
                               class="field {{ $errors->has('numero_celular') ? 'is-invalid' : '' }}"
                               value="{{ old('numero_celular', $user->numero_celular) }}"
                               placeholder="+51 999 000 000">
                        @error('numero_celular')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">Ciudad</label>
                        <input type="text" name="ciudad"
                               class="field {{ $errors->has('ciudad') ? 'is-invalid' : '' }}"
                               value="{{ old('ciudad', $user->ciudad) }}"
                               placeholder="Tu ciudad">
                        @error('ciudad')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Descripción --}}
                <div class="mb-4">
                    <label class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">
                        Descripción <span class="normal-case tracking-normal font-normal" style="color:var(--text-3)">(Opcional)</span>
                    </label>
                    <textarea name="descripcion" rows="5"
                              class="field {{ $errors->has('descripcion') ? 'is-invalid' : '' }}"
                              placeholder="Cuéntales quién eres, qué ofreces, tus intereses...">{{ old('descripcion', $user->descripcion) }}</textarea>
                    @error('descripcion')<p class="field-error">{{ $message }}</p>@enderror
                    <p class="field-hint">Esta descripción aparecerá en tu perfil público. Sé auténtica y atractiva.</p>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-bold text-white cursor-pointer border-0 transition-all hover:opacity-90"
                            style="background:var(--rose)">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>

        {{-- ── MINI PREVIEW ── --}}
        <div class="rounded-xl p-5 fade-up fade-up-3" style="background:var(--surface);border:1px solid var(--border)">
            <div class="font-cormorant text-lg font-bold mb-4" style="color:var(--text)">
                Vista previa del perfil público
            </div>

            <div class="rounded-xl overflow-hidden" style="border:1px solid var(--border)">
                {{-- Header imagen --}}
                <div class="relative h-30" style="background:linear-gradient(135deg,#1e1e30,#2a1428)">
                    @if($user->portada_url)
                        <img src="{{ $user->portada_url }}" alt="portada"
                             class="w-full h-full object-cover object-top">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-5xl">💫</div>
                    @endif
                    {{-- Degradado inferior --}}
                    <div class="absolute inset-0"
                         style="background:linear-gradient(to top,rgba(8,8,16,.9) 0%,transparent 60%)"></div>
                    {{-- Nombre y ciudad --}}
                    <div class="absolute bottom-3 left-3">
                        <div class="font-cormorant text-[1.1rem] font-bold text-white">{{ $user->nombre_usuario }}</div>
                        <div class="text-[.72rem]" style="color:rgba(255,255,255,.5)">
                            {{ $user->ciudad ?? 'Sin ciudad' }}
                            @if($user->edad) · {{ $user->edad }} años @endif
                        </div>
                    </div>
                    @if($user->precio)
                    <div class="absolute bottom-3 right-3 font-bold text-[.95rem]" style="color:var(--gold)">
                        S/. {{ number_format($user->precio, 0) }}
                    </div>
                    @endif
                </div>

                {{-- Mini bio --}}
                <div class="p-3" style="background:var(--surface-2)">
                    @if($user->descripcion)
                        <p class="clamp-3 text-xs leading-relaxed" style="color:var(--text-2)">
                            {{ $user->descripcion }}
                        </p>
                    @else
                        <p class="text-xs italic" style="color:var(--text-3)">Sin descripción aún...</p>
                    @endif
                </div>
            </div>

            <a href="{{ route('perfil.publico', $user) }}" target="_blank"
               class="flex items-center justify-center gap-2 w-full mt-3 py-2 rounded-lg text-sm font-semibold no-underline transition-all hover:opacity-80"
               style="background:var(--surface-2);color:var(--text-2);border:1px solid var(--border)">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                    <polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>
                </svg>
                Ver página completa
            </a>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
function previewFiles(input) {
    const files = Array.from(input.files);
    if (!files.length) return;

    const grid = document.getElementById('preview-grid');
    grid.innerHTML = '';

    files.forEach(file => {
        if (!file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.style.cssText = 'width:64px;height:64px;border-radius:8px;overflow:hidden;border:1px solid var(--border);flex-shrink:0';
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.cssText = 'width:100%;height:100%;object-fit:cover';
            div.appendChild(img);
            grid.appendChild(div);
        };
        reader.readAsDataURL(file);
    });

    document.getElementById('file-preview').classList.remove('hidden');
    const btn = document.getElementById('upload-btn');
    btn.classList.remove('hidden');
    btn.classList.add('flex');
}

function handleDrop(e) {
    e.preventDefault();
    const zone  = e.currentTarget;
    const input = document.getElementById('file-input');
    const dt    = new DataTransfer();

    Array.from(e.dataTransfer.files)
        .filter(f => f.type.startsWith('image/'))
        .forEach(f => dt.items.add(f));

    input.files = dt.files;
    previewFiles(input);
    zone.classList.remove('drop-active');
}
</script>
@endpush