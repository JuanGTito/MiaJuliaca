<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promocion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PromocionController extends Controller
{
    /**
     * Formulario para registrar un pago/promoción a un usuario.
     */
    public function create(User $user)
    {
        // No se puede dar promoción a otro admin
        if ($user->isAdmin()) {
            return redirect()->route('admin.usuarios.show', $user)
                             ->with('error', 'No se puede asignar promoción a un administrador.');
        }

        $historial = $user->promociones()
                          ->orderByDesc('fecha_fin')
                          ->get();

        // Calcular la fecha fin actual activa (para mostrar cuánto lleva)
        $fechaFinActual = $user->promociones()
                               ->where('fecha_fin', '>=', now()->toDateString())
                               ->orderByDesc('fecha_fin')
                               ->value('fecha_fin');

        return view('admin.promociones.create', compact('user', 'historial', 'fechaFinActual'));
    }

    /**
     * Guardar el pago y calcular la nueva fecha_fin acumulando días.
     */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'dias_pagados' => 'required|integer|min:1|max:365',
            'monto'        => 'nullable|numeric|min:0',
            'notas'        => 'nullable|string|max:500',
        ]);

        // ── Lógica de acumulación de días ──
        // Si tiene una promoción activa, sumamos desde su fecha_fin más lejana.
        // Si no, empezamos desde hoy.
        $ultimaFechaFin = $user->promociones()
                               ->where('fecha_fin', '>=', now()->toDateString())
                               ->orderByDesc('fecha_fin')
                               ->value('fecha_fin');

        $dias = (int) $request->dias_pagados;
        if ($ultimaFechaFin) {
            // Tiene días activos → acumulamos
            $fechaInicio = Carbon::today();
            $fechaFin    = Carbon::parse($ultimaFechaFin)->addDays($dias);
        } else {
            // Sin promoción activa → comienza hoy
            $fechaInicio = Carbon::today();
            $fechaFin    = Carbon::today()->addDays($dias);
        }

        Promocion::create([
            'user_id'      => $user->id,
            'admin_id'     => Auth::id(),
            'dias_pagados' => $request->dias_pagados,
            'monto'        => $request->monto,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin'    => $fechaFin,
            'notas'        => $request->notas,
        ]);

        // También activar la publicidad del usuario si estaba inactiva
        if (!$user->estado_publicidad) {
            $user->update(['estado_publicidad' => true]);
        }

        $diasRestantes = max(0, (int) Carbon::today()->diffInDays($fechaFin, false));

        return redirect()->route('admin.usuarios.show', $user)
                         ->with('success', "Promoción registrada. {$user->nombre_usuario} tiene {$diasRestantes} días activos hasta el {$fechaFin->format('d/m/Y')}.");
    }

    /**
     * Eliminar una promoción específica (por si el admin se equivocó).
     */
    public function destroy(Promocion $promocion)
    {
        $user = $promocion->user;
        $promocion->delete();

        return redirect()->route('admin.usuarios.show', $user)
                         ->with('success', 'Promoción eliminada correctamente.');
    }
}