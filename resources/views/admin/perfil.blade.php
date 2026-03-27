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
        {{-- ── EDITAR INFORMACIÓN ── --}}
        <div class="rounded-xl p-5 fade-up fade-up-1" style="background:var(--surface);border:1px solid var(--border)">

            <div class="flex items-center gap-2 font-cormorant text-lg font-bold mb-4" style="color:var(--text)">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--rose)" stroke-width="2" class="shrink-0">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Editar información
            </div>

            <form method="POST" action="{{ route('admin.perfil.update') }}">
                @csrf @method('PUT')

                {{-- UserName --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">Nombre Usuario</label>
                        <input type="text" name="nombre_usuario"
                               class="field {{ $errors->has('ciudad') ? 'is-invalid' : '' }}"
                               value="{{ old('nombre_usuario', $user->nombre_usuario) }}"
                               placeholder="Tu Nombre">
                        @error('nombre_usuario')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- email --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">Email</label>
                        <input type="text" name="email"
                               class="field {{ $errors->has('email') ? 'is-invalid' : '' }}"
                               value="{{ old('email', $user->email) }}"
                               placeholder="Tu email">
                        @error('email')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
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
        
    </div>

    {{-- ════ COLUMNA DERECHA ════ --}}
    <div class="flex flex-col gap-5">
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