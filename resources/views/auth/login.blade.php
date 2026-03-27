@extends('layouts.app')
@section('title', 'Iniciar Sesión — MiaJuliaca')

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
</style>
@endpush

@section('content')
<div class="min-h-[calc(100vh-64px)] flex items-center justify-center px-4 py-10"
     style="background:radial-gradient(ellipse at top,#18091a 0%,#0a0a14 60%)">

    <div class="w-full max-w-105 auth-animate">

        {{-- Cabecera --}}
        <div class="text-center mb-7">
            <div class="w-16 h-16 rounded-[18px] flex items-center justify-center text-3xl mx-auto mb-4"
                 style="background:rgba(232,67,106,.12);border:1px solid rgba(232,67,106,.25)">
                ♥
            </div>
            <h1 class="font-cormorant text-[2rem] font-bold" style="color:var(--text)">
                Bienvenida de vuelta
            </h1>
            <p class="text-sm mt-1" style="color:var(--text-2)">Ingresa con tu usuario y contraseña</p>
        </div>

        {{-- Card --}}
        <div class="rounded-[18px] p-6 md:p-8" style="background:var(--surface);border:1px solid var(--border);backdrop-filter:blur(10px)">

            {{-- Error --}}
            @if($errors->any())
            <div class="flex items-center gap-2.5 p-3.5 rounded-xl mb-5 text-sm"
                 style="background:rgba(232,67,106,.08);border:1px solid rgba(232,67,106,.22);color:var(--danger)">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="shrink-0">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Usuario --}}
                <div class="mb-4">
                    <label for="nombre_usuario" class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">
                        Usuario
                    </label>
                    <div class="relative">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color:var(--text-3)">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <input type="text" id="nombre_usuario" name="nombre_usuario"
                               class="field {{ $errors->has('nombre_usuario') ? 'is-invalid' : '' }}"
                               value="{{ old('nombre_usuario') }}"
                               placeholder="Tu nombre de usuario"
                               autocomplete="username"
                               required autofocus>
                    </div>
                    @error('nombre_usuario')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                {{-- Contraseña --}}
                <div class="mb-5">
                    <label for="password" class="block text-xs font-bold uppercase tracking-[.08em] mb-1.5" style="color:var(--text-3)">
                        Contraseña
                    </label>
                    <div class="relative">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color:var(--text-3)">
                            <rect x="3" y="11" width="18" height="11" rx="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input type="password" id="password" name="password"
                               class="field {{ $errors->has('password') ? 'is-invalid' : '' }}"
                               placeholder="••••••••"
                               autocomplete="current-password"
                               required>
                    </div>
                    @error('password')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                {{-- Recordarme --}}
                <div class="flex items-center justify-between mb-5 text-sm">
                    <label class="flex items-center gap-2 cursor-pointer select-none" style="color:var(--text-2)">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}
                               class="w-4 h-4 rounded cursor-pointer" style="accent-color:var(--rose)">
                        Recordarme
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full py-3 rounded-[10px] text-base font-semibold text-white cursor-pointer border-0
                               transition-all hover:opacity-90 hover:-translate-y-0.5"
                        style="background:var(--rose);box-shadow:0 4px 18px var(--rose-glow)">
                    Iniciar sesión
                </button>
            </form>
        </div>

        {{-- Footer --}}
        <p class="text-center text-sm mt-5" style="color:var(--text-2)">
            ¿No tienes cuenta?
            <a href="{{ route('register') }}"
               class="font-semibold no-underline hover:underline" style="color:var(--rose)">
                Regístrate gratis
            </a>
        </p>
    </div>
</div>
@endsection