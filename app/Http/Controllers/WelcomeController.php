<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Promocion;
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
            ->where('rol', 'usuario')
            ->where('estado_publicidad', true)
            ->whereHas('promociones', function ($q) use ($hoy) {
                $q->where('fecha_fin', '>=', $hoy);
            })
            ->addSelect(['promo_fecha_fin' => Promocion::selectRaw('MAX(fecha_fin)')
                ->whereColumn('user_id', 'users.id')
                ->where('fecha_fin', '>=', $hoy)
            ])
            ->orderByDesc('promo_fecha_fin')
            ->with('fotos')
            ->get();

        return view('welcome', compact('perfiles', 'hoy'));
    }

    /**
     * PÁGINA SECUNDARIA — todos los perfiles ordenados.
     */
    public function perfiles()
    {
        $hoy = now()->toDateString();

        $perfiles = User::query()
            ->where('rol', 'usuario')
            ->addSelect(['promo_fecha_fin' => Promocion::selectRaw('MAX(fecha_fin)')
                ->whereColumn('user_id', 'users.id')
                ->where('fecha_fin', '>=', $hoy)
            ])
            ->orderByRaw('promo_fecha_fin IS NULL ASC')
            ->orderByDesc('promo_fecha_fin')
            ->orderBy('nombre_usuario')
            ->with('fotos')
            ->paginate(24);

        return view('perfiles', compact('perfiles', 'hoy'));
    }

    /**
     * PERFIL PÚBLICO INDIVIDUAL — lo que ve un cliente al hacer clic.
     */
    public function perfilPublico(string $nombre_usuario)
    {
        $hoy = now()->toDateString();

        $perfil = User::where('nombre_usuario', $nombre_usuario)
                      ->where('rol', 'usuario')
                      ->firstOrFail()
                      ->load('fotos');

        $promo = $perfil->promociones()
                        ->where('fecha_fin', '>=', $hoy)
                        ->orderByDesc('fecha_fin')
                        ->first();

        $diasRestantes = $promo
            ? max(0, (int) now()->startOfDay()->diffInDays($promo->fecha_fin, false))
            : 0;

        $sugeridos = User::query()
            ->where('rol', 'usuario')
            ->where('estado_publicidad', true)
            ->where('id', '!=', $perfil->id)
            ->whereHas('promociones', function ($q) use ($hoy) {
                $q->where('fecha_fin', '>=', $hoy);
            })
            ->addSelect(['promo_fecha_fin' => Promocion::selectRaw('MAX(fecha_fin)')
                ->whereColumn('user_id', 'users.id')
                ->where('fecha_fin', '>=', $hoy)
            ])
            ->orderByDesc('promo_fecha_fin')
            ->with('fotos')
            ->limit(4)
            ->get();

        return view('perfil-publico', compact('perfil', 'promo', 'diasRestantes', 'sugeridos'));
    }
}