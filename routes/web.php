<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PromocionController;
use App\Http\Controllers\Usuario\UsuarioController;
use App\Http\Controllers\Usuario\PhotoController;

/* ══════════════════════════════════════════
   PÁGINAS PÚBLICAS
══════════════════════════════════════════ */
Route::get('/', [WelcomeController::class, 'index'])->name('home');
Route::get('/perfiles', [WelcomeController::class, 'perfiles'])->name('perfiles');

/* ══════════════════════════════════════════
   AUTH
══════════════════════════════════════════ */
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/* ══════════════════════════════════════════
   USUARIO
══════════════════════════════════════════ */
Route::middleware('auth')->prefix('usuario')->name('usuario.')->group(function () {
    Route::get('/',         [UsuarioController::class, 'dashboard'])->name('dashboard');
    Route::get('/perfil',   [UsuarioController::class, 'perfil'])->name('perfil');
    Route::put('/perfil',   [UsuarioController::class, 'actualizarPerfil'])->name('perfil.update');
    Route::put('/password', [UsuarioController::class, 'cambiarPassword'])->name('password.update');

    // ── Fotos ──
    Route::post('/fotos',                    [PhotoController::class, 'store'])->name('fotos.store');
    Route::delete('/fotos/{foto}',           [PhotoController::class, 'destroy'])->name('fotos.destroy');
    Route::patch('/fotos/{foto}/portada',    [PhotoController::class, 'setPortada'])->name('fotos.portada');
});

/* ══════════════════════════════════════════
   ADMIN
══════════════════════════════════════════ */
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/usuarios',                   [AdminController::class, 'usuarios'])->name('usuarios');
    Route::get('/usuarios/{user}',            [AdminController::class, 'showUsuario'])->name('usuarios.show');
    Route::patch('/usuarios/{user}/toggle',   [AdminController::class, 'toggleEstado'])->name('usuarios.toggle');
    Route::delete('/usuarios/{user}',         [AdminController::class, 'destroyUsuario'])->name('usuarios.destroy');

    Route::get('/usuarios/{user}/promocion',  [PromocionController::class, 'create'])->name('promociones.create');
    Route::post('/usuarios/{user}/promocion', [PromocionController::class, 'store'])->name('promociones.store');
    Route::delete('/promociones/{promocion}', [PromocionController::class, 'destroy'])->name('promociones.destroy');
});

/* ══════════════════════════════════════════
   PERFIL PÚBLICO
══════════════════════════════════════════ */
Route::get('/perfil/{nombre_usuario}', [WelcomeController::class, 'perfilPublico'])->name('perfil.publico');

Route::get('/sitemap.xml', function () {
    $perfiles = \App\Models\User::where('estado_publicidad', true)->get();
    return response()->view('sitemap', compact('perfiles'))
        ->header('Content-Type', 'application/xml');
});