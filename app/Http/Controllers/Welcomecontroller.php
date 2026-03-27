<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * PÁGINA PRINCIPAL — solo perfiles con promoción activa.
     */
    public function index()
    {
        $hoy = now()->toDateString();

        $perfiles = User::query()
            ->where('users.rol', 'usuario')
            ->where('users.estado_publicidad', true)
            ->join('promociones', function ($join) use ($hoy) {
                $join->on('promociones.user_id', '=', 'users.id')
                     ->where('promociones.fecha_fin', '>=', $hoy);
            })
            ->selectRaw('users.*, MAX(promociones.fecha_fin) as promo_fecha_fin')
            ->groupBy('users.id')
            ->orderByDesc('promo_fecha_fin')
            ->get()
            ->each->load('fotos');

        return view('welcome', compact('perfiles', 'hoy'));
    }

    /**
     * PÁGINA SECUNDARIA — todos los perfiles ordenados.
     */
    public function perfiles()
    {
        $hoy = now()->toDateString();

        $perfiles = User::query()
            ->where('users.rol', 'usuario')
            ->leftJoin('promociones as p', function ($join) use ($hoy) {
                $join->on('p.user_id', '=', 'users.id')
                     ->where('p.fecha_fin', '>=', $hoy);
            })
            ->selectRaw("users.*, MAX(p.fecha_fin) as promo_fecha_fin,
                CASE WHEN MAX(p.fecha_fin) IS NOT NULL THEN 1 ELSE 0 END as tiene_promo")
            ->groupBy('users.id')
            ->orderByRaw('tiene_promo DESC')
            ->orderByRaw('promo_fecha_fin DESC')
            ->orderBy('users.nombre_usuario')
            ->paginate(24);
            foreach ($perfiles as $perfil) {
                $perfil->load('fotos');
            }

        return view('perfiles', compact('perfiles', 'hoy'));
    }

    /**
     * PERFIL PÚBLICO INDIVIDUAL — lo que ve un cliente al hacer clic.
     */
    public function perfilPublico(string $nombre_usuario)
    {
        $hoy = now()->toDateString();

        // Buscamos al usuario por nombre (solo tipo 'usuario', no admins)
        $perfil = User::where('nombre_usuario', $nombre_usuario)
                      ->where('rol', 'usuario')
                      ->firstOrFail()
                      ->load('fotos');

        // Promo activa más reciente
        $promo = $perfil->promociones()
                        ->where('fecha_fin', '>=', $hoy)
                        ->orderByDesc('fecha_fin')
                        ->first();

        $diasRestantes = $promo
            ? max(0, (int) now()->startOfDay()->diffInDays($promo->fecha_fin, false))
            : 0;

        // Otros perfiles activos para sugerir (excluye al actual)
        $sugeridos = User::query()
            ->where('users.rol', 'usuario')
            ->where('users.estado_publicidad', true)
            ->where('users.id', '!=', $perfil->id)
            ->join('promociones as p2', function ($join) use ($hoy) {
                $join->on('p2.user_id', '=', 'users.id')
                     ->where('p2.fecha_fin', '>=', $hoy);
            })
            ->selectRaw('users.*, MAX(p2.fecha_fin) as promo_fecha_fin')
            ->groupBy('users.id')
            ->orderByDesc('promo_fecha_fin')
            ->limit(4)
            ->get()
            ->each->load('fotos');

        return view('perfil-publico', compact('perfil', 'promo', 'diasRestantes', 'sugeridos'));
    }
}