<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nombre_usuario',
        'email',
        'password',
        'edad',
        'descripcion',
        'precio',
        'numero_celular',
        'ciudad',
        'rol',
        'estado_publicidad',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password'          => 'hashed',
        'estado_publicidad' => 'boolean',
        'precio'            => 'decimal:2',
    ];

    /* ─── Relaciones ─── */

    public function promociones(): HasMany
    {
        return $this->hasMany(Promocion::class, 'user_id');
    }

    public function promocionActiva(): HasMany
    {
        return $this->hasMany(Promocion::class, 'user_id')
                    ->where('fecha_fin', '>=', now()->toDateString())
                    ->orderByDesc('fecha_fin');
    }

    /* ─── Helpers de rol ─── */

    public function isAdmin(): bool { return $this->rol === 'admin'; }
    public function isUsuario(): bool { return $this->rol === 'usuario'; }

    /* ─── Helpers de promoción ─── */

    public function tienePromocionActiva(): bool
    {
        return $this->promociones()
                    ->where('fecha_fin', '>=', now()->toDateString())
                    ->exists();
    }

    public function diasRestantesPromocion(): int
    {
        $ultima = $this->promociones()
                       ->where('fecha_fin', '>=', now()->toDateString())
                       ->orderByDesc('fecha_fin')
                       ->first();
        if (!$ultima) return 0;
        return max(0, (int) now()->startOfDay()->diffInDays($ultima->fecha_fin, false));
    }

    public function fechaFinPromocion(): ?\Carbon\Carbon
    {
        $ultima = $this->promociones()
                       ->where('fecha_fin', '>=', now()->toDateString())
                       ->orderByDesc('fecha_fin')
                       ->first();
        return $ultima?->fecha_fin;
    }

    /* ─── Helper: obtener URL de portada o placeholder ─── */
    public function getPortadaUrlAttribute(): string
    {
        $portada = $this->fotoportada;
        if ($portada) {
            return asset('storage/' . $portada->ruta);
        }
        // Primera foto si no hay portada marcada
        $primera = $this->fotos()->first();
        if ($primera) {
            return asset('storage/' . $primera->ruta);
        }
        return ''; // sin foto
    }
    public function fotos(): HasMany
{
    return $this->hasMany(UserPhoto::class, 'user_id')->orderBy('orden');
}

public function fotoportada(): HasOne  // también falta esta
{
    return $this->hasOne(UserPhoto::class, 'user_id')->where('es_portada', true);
}
}