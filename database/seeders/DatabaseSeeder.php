<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        User::create([
            'nombre_usuario'    => 'admin',
            'email'             => 'admin@siscitas.com',
            'password'          => Hash::make('admin123'),
            'edad'              => 30,
            'numero_celular'    => '5500000000',
            'ciudad'            => 'Ciudad de México',
            'rol'               => 'admin',
            'estado_publicidad' => true,
        ]);

        User::create([
            'nombre_usuario'    => 'demo_user',
            'email'             => 'demo@siscitas.com',
            'password'          => Hash::make('demo123'),
            'edad'              => 25,
            'descripcion'       => 'Usuario de prueba del sistema.',
            'precio'            => 500.00,
            'numero_celular'    => '5551234567',
            'ciudad'            => 'Guadalajara',
            'rol'               => 'usuario',
            'estado_publicidad' => true,
        ]);
    }
}