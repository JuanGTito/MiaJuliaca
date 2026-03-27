<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MiaJuliaca')</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Variables CSS + clases custom que Tailwind no puede generar --}}
    <style>
        :root {
            --rose:        #e8436a;
            --rose-dark:   #c2274e;
            --rose-glow:   rgba(232,67,106,.25);
            --rose-soft:   rgba(232,67,106,.08);
            --gold:        #d4a853;
            --bg:          #0e0e18;
            --surface:     #15151f;
            --surface-2:   #1c1c2a;
            --surface-3:   #232334;
            --border:      rgba(255,255,255,.07);
            --border-2:    rgba(255,255,255,.12);
            --text:        #f0f0f5;
            --text-2:      #a0a0b8;
            --text-3:      #60607a;
            --success:     #10d98a;
            --success-bg:  rgba(16,217,138,.1);
            --danger:      #f04b6a;
            --danger-bg:   rgba(240,75,106,.1);
            --warning:     #f5a623;
            --warning-bg:  rgba(245,166,35,.1);
            --radius:      14px;
            --radius-sm:   8px;
            --shadow-rose: 0 8px 32px rgba(232,67,106,.2);
        }

        /* Fuentes custom */
        body { font-family: 'Outfit', sans-serif; }
        .font-cormorant { font-family: 'Cormorant Garamond', serif; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--surface-3); border-radius: 3px; }

        /* Sidebar link active indicator */
        .sidebar-link-active::before {
            content: '';
            position: absolute;
            left: 0; top: 25%; bottom: 25%;
            width: 3px;
            background: var(--rose);
            border-radius: 0 3px 3px 0;
        }

        /* Toggle switch */
        .toggle input:checked + .toggle-track { background: var(--success); border-color: var(--success); }
        .toggle input:checked + .toggle-track::before { transform: translateX(18px); background: white; }

        /* Form focus ring */
        .form-control:focus { border-color: var(--rose); box-shadow: 0 0 0 3px var(--rose-glow); }

        /* Fade animation */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up   { animation: fadeUp .45s ease both; }
        .fade-up-1 { animation-delay: .05s; }
        .fade-up-2 { animation-delay: .10s; }
        .fade-up-3 { animation-delay: .15s; }
        .fade-up-4 { animation-delay: .20s; }
        .fade-up-5 { animation-delay: .25s; }

        /* Sidebar overlay móvil */
        #sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,.6);
            backdrop-filter: blur(4px);
            z-index: 40;
        }
        #sidebar-overlay.open { display: block; }

        /* Sidebar móvil slide */
        #sidebar {
            transform: translateX(-100%);
            transition: transform .25s ease;
        }
        #sidebar.open { transform: translateX(0); }

        /* Desktop sidebar siempre visible */
        @media (min-width: 900px) {
            #sidebar {
                transform: translateX(0) !important;
                position: sticky !important;
                top: 64px !important;
            }
            #sidebar-overlay { display: none !important; }
            #menu-toggle { display: none !important; }
        }
    </style>
    @stack('styles')
</head>

<body class="min-h-screen" style="background:var(--bg);color:var(--text)">

{{-- ═══════════════════════════════════════
     NAVBAR
═══════════════════════════════════════ --}}
<nav class="sticky top-0 z-50 h-16 flex items-center justify-between px-4 md:px-8"
     style="background:rgba(14,14,24,.85);backdrop-filter:blur(20px);border-bottom:1px solid var(--border)">

    {{-- Izquierda: hamburger (móvil) + brand --}}
    <div class="flex items-center gap-3">
        @auth
        {{-- Botón hamburguesa solo en móvil --}}
        <button id="menu-toggle"
                onclick="toggleSidebar()"
                class="flex items-center justify-center w-9 h-9 rounded-lg transition-colors"
                style="background:var(--surface-2);border:1px solid var(--border);color:var(--text-2)">
            <svg id="icon-menu" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="3" y1="6"  x2="21" y2="6"/>
                <line x1="3" y1="12" x2="21" y2="12"/>
                <line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
        </button>
        @endauth

        <a href="{{ route('home') }}"
           class="font-cormorant text-2xl font-bold no-underline flex items-center gap-1"
           style="color:var(--text)">
            ♥ <em style="color:var(--rose);font-style:normal">Mia</em>Juliaca
        </a>
    </div>

    {{-- Derecha: usuario + logout --}}
    <div class="flex items-center gap-2 md:gap-4">
        @auth
            {{-- Badge usuario (oculto en móvil muy pequeño) --}}
            <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-full"
                 style="background:var(--surface-2);border:1px solid var(--border)">
                <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0"
                     style="background:linear-gradient(135deg,var(--rose),var(--rose-dark))">
                    {{ strtoupper(substr(Auth::user()->nombre_usuario, 0, 1)) }}
                </div>
                <span class="text-sm font-semibold hidden md:block" style="color:var(--text)">
                    {{ Auth::user()->nombre_usuario }}
                </span>
                <span class="text-xs font-bold px-2 py-0.5 rounded-full"
                      style="{{ Auth::user()->isAdmin()
                            ? 'background:rgba(212,168,83,.1);color:var(--gold)'
                            : 'background:var(--rose-soft);color:var(--rose)' }}">
                    {{ Auth::user()->isAdmin() ? 'Admin' : 'Usuario' }}
                </span>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit"
                        class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-semibold transition-all"
                        style="background:var(--surface-2);color:var(--text-2);border:1px solid var(--border)">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    <span class="hidden sm:inline">Salir</span>
                </button>
            </form>
        @else
            <a href="{{ route('login') }}"
               class="px-3 py-1.5 rounded-lg text-sm font-semibold transition-all"
               style="background:var(--surface-2);color:var(--text-2);border:1px solid var(--border)">
                Iniciar sesión
            </a>
            <a href="{{ route('register') }}"
               class="px-3 py-1.5 rounded-lg text-sm font-bold text-white transition-all"
               style="background:var(--rose)">
                Registrarse
            </a>
        @endauth
    </div>
</nav>

@auth
{{-- ═══════════════════════════════════════
     OVERLAY MÓVIL
═══════════════════════════════════════ --}}
<div id="sidebar-overlay" onclick="toggleSidebar()"></div>

{{-- ═══════════════════════════════════════
     SHELL: SIDEBAR + MAIN
═══════════════════════════════════════ --}}
<div class="flex" style="min-height:calc(100vh - 64px)">

    {{-- ── SIDEBAR ── --}}
    <aside id="sidebar"
           class="fixed top-16 left-0 z-50 w-64 h-[calc(100vh-64px)] overflow-y-auto flex flex-col"
           style="background:var(--surface);border-right:1px solid var(--border)">

        <div class="flex-1 p-4">

            @if(Auth::user()->isAdmin())
            {{-- ADMIN NAV --}}
            <div class="mb-6">
                <p class="text-xs font-bold uppercase tracking-widest px-3 mb-2"
                   style="color:var(--text-3)">Panel Admin</p>

                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium mb-1 relative transition-all no-underline
                          {{ request()->routeIs('admin.dashboard') ? 'sidebar-link-active' : '' }}"
                   style="{{ request()->routeIs('admin.dashboard')
                        ? 'background:var(--rose-soft);color:var(--rose)'
                        : 'color:var(--text-2)' }}">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                        <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.usuarios') }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium mb-1 relative transition-all no-underline
                          {{ request()->routeIs('admin.usuarios*') ? 'sidebar-link-active' : '' }}"
                   style="{{ request()->routeIs('admin.usuarios*')
                        ? 'background:var(--rose-soft);color:var(--rose)'
                        : 'color:var(--text-2)' }}">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    Usuarios
                </a>
            </div>

            @else
            {{-- USUARIO NAV --}}
            <div class="mb-6">
                <p class="text-xs font-bold uppercase tracking-widest px-3 mb-2"
                   style="color:var(--text-3)">Mi cuenta</p>

                <a href="{{ route('usuario.dashboard') }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium mb-1 relative transition-all no-underline
                          {{ request()->routeIs('usuario.dashboard') ? 'sidebar-link-active' : '' }}"
                   style="{{ request()->routeIs('usuario.dashboard')
                        ? 'background:var(--rose-soft);color:var(--rose)'
                        : 'color:var(--text-2)' }}">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                        <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('usuario.perfil') }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium mb-1 relative transition-all no-underline
                          {{ request()->routeIs('usuario.perfil') ? 'sidebar-link-active' : '' }}"
                   style="{{ request()->routeIs('usuario.perfil')
                        ? 'background:var(--rose-soft);color:var(--rose)'
                        : 'color:var(--text-2)' }}">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    Mi Perfil
                </a>
            </div>
            @endif
        </div>

        {{-- Pie del sidebar --}}
        <div class="p-4" style="border-top:1px solid var(--border)">
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all text-left"
                        style="background:none;border:none;cursor:pointer;color:var(--text-3)">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    {{-- ── MAIN ── --}}
    <main class="flex-1 min-w-0 p-4 md:p-6 lg:p-8"
          style="margin-left:0"
          id="main-content">

        {{-- Alertas de sesión --}}
        @if(session('success'))
            <div class="flex items-start gap-3 p-3 rounded-lg mb-4 text-sm fade-up"
                 style="background:var(--success-bg);border:1px solid rgba(16,217,138,.25);color:var(--success)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="shrink-0 mt-0.5">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="flex items-start gap-3 p-3 rounded-lg mb-4 text-sm fade-up"
                 style="background:var(--danger-bg);border:1px solid rgba(240,75,106,.25);color:var(--danger)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="shrink-0 mt-0.5">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</div>

@else
    @yield('content')
@endauth

{{-- ═══════════════════════════════════════
     ESTILOS GLOBALES COMPATIBLES
     (para vistas que aún usan clases custom)
═══════════════════════════════════════ --}}
<style>
/* Cards */
.card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 1.5rem;
}
.card-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.3rem; font-weight: 600;
    color: var(--text); margin-bottom: 1.25rem;
}

/* Buttons */
.btn {
    display: inline-flex; align-items: center; justify-content: center;
    gap: .5rem; padding: .6rem 1.25rem;
    border-radius: var(--radius-sm); font-size: .875rem; font-weight: 600;
    font-family: 'Outfit', sans-serif; cursor: pointer; border: none;
    text-decoration: none; transition: all .18s ease; white-space: nowrap;
}
.btn svg { width: 15px; height: 15px; }
.btn-primary { background: var(--rose); color: white; }
.btn-primary:hover { background: var(--rose-dark); box-shadow: var(--shadow-rose); transform: translateY(-1px); }
.btn-ghost { background: var(--surface-2); color: var(--text-2); border: 1px solid var(--border); }
.btn-ghost:hover { background: var(--surface-3); color: var(--text); border-color: var(--border-2); }
.btn-danger { background: var(--danger); color: white; }
.btn-success { background: var(--success); color: #0a1a12; }
.btn-sm { padding: .38rem .85rem; font-size: .8rem; }
.btn-lg { padding: .85rem 2rem; font-size: 1rem; }
.btn-outline-rose { background: transparent; color: var(--rose); border: 1.5px solid var(--rose); }
.btn-outline-rose:hover { background: var(--rose-soft); }

/* Stats */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem; margin-bottom: 1.75rem;
}
@media (min-width: 640px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
@media (min-width: 900px) { .stats-grid { grid-template-columns: repeat(4, 1fr); } }

.stat-card {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--radius); padding: 1rem 1.25rem;
    display: flex; align-items: center; gap: .85rem;
    transition: border-color .2s, transform .2s;
}
.stat-card:hover { border-color: var(--border-2); transform: translateY(-2px); }
.stat-icon { width: 42px; height: 42px; border-radius: 11px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.stat-icon svg { width: 20px; height: 20px; }
.stat-icon.rose  { background: var(--rose-soft); color: var(--rose); }
.stat-icon.green { background: var(--success-bg); color: var(--success); }
.stat-icon.red   { background: var(--danger-bg); color: var(--danger); }
.stat-icon.gold  { background: rgba(212,168,83,.1); color: var(--gold); }
.stat-num   { font-size: 1.6rem; font-weight: 700; line-height: 1; color: var(--text); }
.stat-label { font-size: .75rem; color: var(--text-2); margin-top: .2rem; }

/* Forms */
.form-group { margin-bottom: 1rem; }
.form-label {
    display: block; font-size: .82rem; font-weight: 600;
    color: var(--text-2); margin-bottom: .45rem;
    text-transform: uppercase; letter-spacing: .05em;
}
.form-control {
    width: 100%; padding: .7rem 1rem;
    background: var(--surface-2); border: 1.5px solid var(--border);
    border-radius: var(--radius-sm); color: var(--text);
    font-family: 'Outfit', sans-serif; font-size: .9rem;
    outline: none; transition: border-color .2s, box-shadow .2s;
}
.form-control::placeholder { color: var(--text-3); }
.form-control.is-invalid { border-color: var(--danger); }
textarea.form-control { resize: vertical; min-height: 100px; }
.invalid-feedback { color: var(--danger); font-size: .8rem; margin-top: .3rem; }
.form-hint { color: var(--text-3); font-size: .78rem; margin-top: .3rem; }
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
@media (max-width: 600px) { .form-grid { grid-template-columns: 1fr; } }

/* Badges */
.badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .2rem .65rem; border-radius: 999px;
    font-size: .72rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .06em;
}
.badge-rose  { background: var(--rose-soft); color: var(--rose); }
.badge-green { background: var(--success-bg); color: var(--success); }
.badge-red   { background: var(--danger-bg); color: var(--danger); }
.badge-gold  { background: rgba(212,168,83,.1); color: var(--gold); }
.badge-muted { background: var(--surface-3); color: var(--text-2); }
.badge-dot::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

/* Alerts */
.alert {
    padding: .85rem 1.1rem; border-radius: var(--radius-sm);
    font-size: .88rem; margin-bottom: 1rem; border: 1px solid transparent;
    display: flex; align-items: flex-start; gap: .75rem;
}
.alert-success { background: var(--success-bg); border-color: rgba(16,217,138,.25); color: var(--success); }
.alert-danger  { background: var(--danger-bg);  border-color: rgba(240,75,106,.25);  color: var(--danger); }
.alert-warning { background: var(--warning-bg); border-color: rgba(245,166,35,.25);  color: var(--warning); }

/* Table */
.table-wrap { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; }
thead th {
    font-size: .72rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .08em; color: var(--text-3);
    padding: .75rem 1rem; text-align: left;
    border-bottom: 1px solid var(--border);
}
tbody td {
    padding: .9rem 1rem; border-bottom: 1px solid var(--border);
    font-size: .875rem; color: var(--text-2); vertical-align: middle;
}
tbody tr:last-child td { border-bottom: none; }
tbody tr:hover td { background: var(--surface-2); color: var(--text); }
tbody tr { transition: background .15s; }

/* Page header */
.page-header {
    display: flex; align-items: flex-start; justify-content: space-between;
    margin-bottom: 1.75rem; gap: 1rem; flex-wrap: wrap;
}
.page-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(1.5rem, 4vw, 2rem);
    font-weight: 700; color: var(--text); line-height: 1.2;
}
.page-subtitle { color: var(--text-2); font-size: .88rem; margin-top: .3rem; }

/* Toggle */
.toggle { position: relative; display: inline-block; width: 42px; height: 24px; }
.toggle input { opacity: 0; width: 0; height: 0; }
.toggle-track {
    position: absolute; inset: 0; background: var(--surface-3);
    border-radius: 999px; cursor: pointer; transition: .25s;
    border: 1px solid var(--border);
}
.toggle-track::before {
    content: ''; position: absolute;
    width: 18px; height: 18px; border-radius: 50%;
    background: var(--text-3); left: 2px; top: 2px; transition: .25s;
}

/* Desktop sidebar margin compensation */
@media (min-width: 900px) {
    #main-content { margin-left: 256px; }
}
</style>

<script>
function toggleSidebar() {
    const sidebar  = document.getElementById('sidebar');
    const overlay  = document.getElementById('sidebar-overlay');
    const isOpen   = sidebar.classList.contains('open');

    sidebar.classList.toggle('open', !isOpen);
    overlay.classList.toggle('open', !isOpen);
    document.body.style.overflow = isOpen ? '' : 'hidden';
}

// Cerrar sidebar al cambiar a desktop
window.addEventListener('resize', () => {
    if (window.innerWidth >= 900) {
        document.getElementById('sidebar')?.classList.remove('open');
        document.getElementById('sidebar-overlay')?.classList.remove('open');
        document.body.style.overflow = '';
    }
});
</script>

@stack('scripts')
</body>
</html>