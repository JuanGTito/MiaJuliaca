<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Promocion extends Model
{
    protected $table = 'promociones';

    protected $fillable = [
        'user_id',
        'admin_id',
        'dias_pagados',
        'monto',
        'fecha_inicio',
        'fecha_fin',
        'notas',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
        'monto'        => 'decimal:2',
        'dias_pagados' => 'integer',
    ];

    /* ─── Relaciones ─── */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /* ─── Scopes ─── */

    /** Promociones vigentes a día de hoy */
    public function scopeActiva($query)
    {
        return $query->where('fecha_fin', '>=', now()->toDateString());
    }

    /** Promociones ya vencidas */
    public function scopeVencida($query)
    {
        return $query->where('fecha_fin', '<', now()->toDateString());
    }

    /* ─── Helpers ─── */

    public function estaActiva(): bool
    {
        return $this->fecha_fin->greaterThanOrEqualTo(now()->startOfDay());
    }

    public function diasRestantes(): int
    {
        return max(0, (int) now()->startOfDay()->diffInDays($this->fecha_fin, false));
    }
}