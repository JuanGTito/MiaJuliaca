@extends('layouts.app')
@section('title', 'Registrarse — MiaJuliaca')

@push('styles')
<style>
    @keyframes fadeUp { from { opacity:0; transform:translateY(24px); } to { opacity:1; transform:translateY(0); } }
    .auth-animate { animation: fadeUp .5s ease both; }

    .field {
        width: 100%;
        padding: .55rem .85rem .55rem 2.4rem;
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
    .field:focus        { border-color: var(--rose); }
    .field.is-invalid   { border-color: var(--danger); }
    .field-error { font-size: .75rem; color: var(--danger); margin-top: .28rem; }
    .field-hint  { font-size: .73rem; color: var(--text-3); margin-top: .28rem; line-height: 1.5; }
</style>
@endpush

@section('content')
<div class="min-h-[calc(100vh-64px)] flex items-center justify-center px-4 py-10"
     style="background:radial-gradient(ellipse at top right,#0e1a1a 0%,#0a0a14 60%)">

    <div class="w-full max-w-135 auth-animate">

        {{-- Cabecera --}}
        <div class="text-center mb-7">
            <div class="w-16 h-16 rounded-[18px] flex items-center justify-center text-3xl mx-auto mb-4"
                 style="background:rgba(232,67,106,.12);border:1px solid rgba(232,67,106,.25)">
                ✨
            </div>
            <h1 class="font-cormorant text-[2rem] font-bold" style="color:var(--text)">Crear tu cuenta</h1>
            <p class="text-sm mt-1" style="color:var(--text-2)">Completa el formulario para registrarte en MiaJuliaca</p>
        </div>

        {{-- Card principal --}}
        <div class="rounded-[18px] p-6 md:p-8" style="background:var(--surface);border:1px solid var(--border)">

            {{-- Errores globales --}}
            @if($errors->any())
            <div class="flex items-start gap-3 p-3.5 rounded-xl mb-5 text-sm"
                 style="background:rgba(232,67,106,.08);border:1px solid rgba(232,67,106,.22);color:var(--danger)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="shrink-0 mt-0.5">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <div>
                    <strong>Corrige los siguientes errores:</strong>
                    <ul class="mt-1.5 ml-4 text-xs space-y-0.5 list-disc">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <p class="text-xs mb-5" style="color:var(--text-3)">
                Campos con <span style="color:var(--rose)">*</span> son obligatorios. Mínimo 18 años.
            </p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- ── Separador ── --}}
                @php
                    $sep = fn($label) => '<div class="flex items-center gap-3 my-5 text-[.7rem] font-bold uppercase tracking-widest" style="color:var(--text-3)">
                        <div class="flex-1 h-px" style="background:var(--border)"></div>'
                        . $label .
                        '<div class="flex-1 h-px" style="background:var(--border)"></div>
                    </div>';
                @endphp

                {!! $sep('Datos de acceso') !!}

                {{-- Nombre de usuario --}}
                <div class="mb-4">
                    <label for="nombre_usuario" class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">
                        Nombre de usuario <span style="color:var(--rose)">*</span>
                    </label>
                    <div class="relative">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color:var(--text-3)">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                        <input type="text" id="nombre_usuario" name="nombre_usuario"
                               class="field {{ $errors->has('nombre_usuario') ? 'is-invalid' : '' }}"
                               value="{{ old('nombre_usuario') }}"
                               placeholder="mi_usuario" required autofocus>
                    </div>
                    @error('nombre_usuario')<p class="field-error">{{ $message }}</p>@enderror
                    <p class="field-hint">Solo letras, números y guiones bajos. Así te verán los demás.</p>
                </div>

                {{-- Contraseñas --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-1">
                    <div>
                        <label for="password" class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">
                            Contraseña <span style="color:var(--rose)">*</span>
                        </label>
                        <div class="relative">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color:var(--text-3)">
                                <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            <input type="password" id="password" name="password"
                                   class="field {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                   placeholder="Mínimo 6 caracteres" required>
                        </div>
                        @error('password')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">
                            Confirmar <span style="color:var(--rose)">*</span>
                        </label>
                        <div class="relative">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color:var(--text-3)">
                                <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="field"
                                   placeholder="Repite la contraseña" required>
                        </div>
                    </div>
                </div>

                {!! $sep('Información personal') !!}

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">
                        Correo electrónico <span style="color:var(--rose)">*</span>
                    </label>
                    <div class="relative">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color:var(--text-3)">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        <input type="email" id="email" name="email"
                               class="field {{ $errors->has('email') ? 'is-invalid' : '' }}"
                               value="{{ old('email') }}"
                               placeholder="tu@correo.com" required>
                    </div>
                    @error('email')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                {{-- Edad + Celular --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                    <div>
                        <label for="edad" class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">
                            Edad <span style="color:var(--rose)">*</span>
                        </label>
                        <div class="relative">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color:var(--text-3)">
                                <rect x="3" y="4" width="18" height="18" rx="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            <input type="number" id="edad" name="edad"
                                   class="field {{ $errors->has('edad') ? 'is-invalid' : '' }}"
                                   value="{{ old('edad') }}"
                                   min="18" max="99" placeholder="18" required>
                        </div>
                        @error('edad')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="numero_celular" class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">
                            Celular <span style="color:var(--rose)">*</span>
                        </label>
                        <div class="relative">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color:var(--text-3)">
                                <rect x="5" y="2" width="14" height="20" rx="2"/>
                                <line x1="12" y1="18" x2="12.01" y2="18"/>
                            </svg>
                            <input type="tel" id="numero_celular" name="numero_celular"
                                   class="field {{ $errors->has('numero_celular') ? 'is-invalid' : '' }}"
                                   value="{{ old('numero_celular') }}"
                                   placeholder="+51 999 000 000" required>
                        </div>
                        @error('numero_celular')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Ciudad --}}
                <div class="mb-5">
                    <label for="ciudad" class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">
                        Ciudad <span style="color:var(--rose)">*</span>
                    </label>
                    <div class="relative">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color:var(--text-3)">
                            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        <input type="text" id="ciudad" name="ciudad"
                               class="field {{ $errors->has('ciudad') ? 'is-invalid' : '' }}"
                               value="{{ old('ciudad') }}"
                               placeholder="Tu ciudad" required>
                    </div>
                    @error('ciudad')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full py-3 rounded-[10px] text-base font-semibold text-white cursor-pointer border-0
                               transition-all hover:opacity-90 hover:-translate-y-0.5"
                        style="background:var(--rose);box-shadow:0 4px 18px var(--rose-glow)">
                    Crear mi cuenta gratis →
                </button>

                <p class="text-center text-xs mt-3" style="color:var(--text-3)">
                    Al registrarte aceptas los términos del servicio.
                </p>
            </form>
        </div>

        {{-- Footer --}}
        <p class="text-center text-sm mt-5" style="color:var(--text-2)">
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}"
               class="font-semibold no-underline hover:underline" style="color:var(--rose)">
                Iniciar sesión
            </a>
        </p>
    </div>
</div>
@endsection