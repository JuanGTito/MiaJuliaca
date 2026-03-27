<?php
namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller {

    public function dashboard() {
        return view('usuario.dashboard', ['user' => Auth::user()]);
    }

    public function perfil() {
        $user = Auth::user();
        $user->load('fotos');
        return view('usuario.perfil', compact('user'));
    }

    public function actualizarPerfil(Request $request) {
        $request->validate([
            'descripcion'    => 'nullable|string|max:1000',
            'precio'         => 'nullable|numeric|min:0',
            'numero_celular' => 'required|string|max:20',
            'ciudad'         => 'required|string|max:100',
            'edad'           => 'required|integer|min:18|max:99',
        ]);
        Auth::user()->update($request->only([
            'descripcion', 'precio', 'numero_celular', 'ciudad', 'edad'
        ]));
        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function cambiarPassword(Request $request) {
        $request->validate([
            'password_actual' => 'required',
            'password'        => 'required|confirmed|min:6',
        ]);
        if (!Hash::check($request->password_actual, Auth::user()->password)) {
            return back()->withErrors(['password_actual' => 'La contraseña actual no es correcta.']);
        }
        Auth::user()->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Contraseña actualizada correctamente.');
    }
}