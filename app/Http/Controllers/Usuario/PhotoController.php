<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\UserPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PhotoController extends Controller
{
    private const MAX_FOTOS = 8;

    /* ─────────────────────────────────────
       POST /usuario/fotos — subir foto(s)
    ───────────────────────────────────── */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'fotos'   => 'required|array|max:' . self::MAX_FOTOS,
            'fotos.*' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120', // 5 MB
        ], [
            'fotos.required'   => 'Selecciona al menos una foto.',
            'fotos.*.image'    => 'Cada archivo debe ser una imagen.',
            'fotos.*.mimes'    => 'Solo se permiten imágenes JPEG, PNG o WEBP.',
            'fotos.*.max'      => 'Cada foto no puede superar los 5 MB.',
        ]);

        // Cuántas fotos tiene ya
        $totalActual = $user->fotos()->count();
        $nuevas      = count($request->file('fotos'));

        if ($totalActual + $nuevas > self::MAX_FOTOS) {
            return back()->withErrors([
                'fotos' => "Ya tienes {$totalActual} foto(s). Solo puedes tener " . self::MAX_FOTOS . " en total.",
            ]);
        }

        $orden = $totalActual;

        foreach ($request->file('fotos') as $foto) {
            $nombreArchivo = Str::uuid() . '.' . $foto->extension();
            $ruta = $foto->storeAs('photos/' . $user->id, $nombreArchivo, 'public');

            $esPortada = ($totalActual === 0 && $orden === $totalActual);

            UserPhoto::create([
                'user_id'    => $user->id,
                'ruta'       => $ruta,
                'es_portada' => $esPortada, // primera foto = portada automática
                'orden'      => $orden++,
            ]);
        }

        return back()->with('success', '¡Foto(s) subida(s) correctamente!');
    }

    /* ─────────────────────────────────────
       DELETE /usuario/fotos/{foto} — eliminar
    ───────────────────────────────────── */
    public function destroy(UserPhoto $foto)
    {
        $user = Auth::user();

        // Solo puede borrar sus propias fotos
        if ($foto->user_id !== $user->id) {
            abort(403);
        }

        $eraPortada = $foto->es_portada;

        // Borrar archivo físico
        Storage::disk('public')->delete($foto->ruta);
        $foto->delete();

        // Si era portada, asignar la siguiente
        if ($eraPortada) {
            $siguiente = $user->fotos()->first();
            if ($siguiente) {
                $siguiente->update(['es_portada' => true]);
            }
        }

        return back()->with('success', 'Foto eliminada.');
    }

    /* ─────────────────────────────────────
       PATCH /usuario/fotos/{foto}/portada — marcar como portada
    ───────────────────────────────────── */
    public function setPortada(UserPhoto $foto)
    {
        $user = Auth::user();

        if ($foto->user_id !== $user->id) {
            abort(403);
        }

        // Quitar portada anterior
        $user->fotos()->update(['es_portada' => false]);

        // Marcar nueva portada
        $foto->update(['es_portada' => true]);

        return back()->with('success', '¡Foto de portada actualizada!');
    }
}