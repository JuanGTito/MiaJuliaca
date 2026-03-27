<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPhoto extends Model
{
    protected $table = 'user_photos';

    protected $fillable = [
        'user_id',
        'ruta',
        'es_portada',
        'orden',
    ];

    protected $casts = [
        'es_portada' => 'boolean',
    ];

    /* ── Relación ── */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* ── URL pública ── */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->ruta);
    }
}