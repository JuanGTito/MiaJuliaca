<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ExpirarPublicidades extends Command
{
    protected $signature   = 'publicidad:expirar';
    protected $description = 'Desactiva perfiles cuya publicidad ha expirado';

    public function handle(): void
    {
        $count = User::where('estado_publicidad', true)
            ->whereNotNull('publicidad_expira_at')
            ->where('publicidad_expira_at', '<=', now())
            ->update([
                'estado_publicidad' => false,
            ]);

        $this->info("$count publicidad(es) desactivada(s).");
    }
}
