<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller {

    public function showLogin() { return view('auth.login'); }

    public function login(Request $request) {
        $request->validate([
            'nombre_usuario' => 'required|string',
            'password'       => 'required|string',
        ]);

        if (Auth::attempt([
            'nombre_usuario' => $request->nombre_usuario,
            'password'       => $request->password
        ], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return Auth::user()->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('usuario.dashboard');
        }

        return back()->withErrors([
            'nombre_usuario' => 'Las credenciales no son correctas.',
        ])->onlyInput('nombre_usuario');
    }

    public function showRegister() { return view('auth.register'); }

    public function register(Request $request) {
        $request->validate([
            'nombre_usuario' => 'required|string|max:50|unique:users,nombre_usuario',
            'email'          => 'required|email|unique:users,email',
            'password'       => ['required', 'confirmed', Password::min(6)],
            'edad'           => 'required|integer|min:18|max:99',
            'numero_celular' => 'required|string|max:20',
            'ciudad'         => 'required|string|max:100',
        ]);

        $user = User::create([
            'nombre_usuario'    => $request->nombre_usuario,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'edad'              => $request->edad,
            'numero_celular'    => $request->numero_celular,
            'ciudad'            => $request->ciudad,
            'rol'               => 'usuario',
            'estado_publicidad' => true,
        ]);

        Auth::login($user);
        return redirect()->route('usuario.dashboard');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}