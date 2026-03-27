<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller {

    public function dashboard() {
        $stats = [
            'total'    => User::where('rol', 'usuario')->count(),
            'activos'  => User::where('rol', 'usuario')->where('estado_publicidad', true)->count(),
            'inactivos'=> User::where('rol', 'usuario')->where('estado_publicidad', false)->count(),
            'nuevos'   => User::where('rol', 'usuario')->whereMonth('created_at', now()->month)->count(),
        ];
        $recientes = User::where('rol', 'usuario')->latest()->take(6)->get();
        return view('admin.dashboard', compact('stats', 'recientes'));
    }

    public function usuarios(Request $request) {
        $query = User::where('rol', 'usuario');
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) =>
                $q->where('nombre_usuario', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%")
                  ->orWhere('ciudad', 'like', "%$s%")
            );
        }
        if ($request->filled('estado')) {
            $query->where('estado_publicidad', $request->estado);
        }
        $usuarios = $query->latest()->paginate(15)->withQueryString();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function showUsuario(User $user) {
        return view('admin.usuarios.show', compact('user'));
    }

    public function toggleEstado(User $user) {
        $user->update(['estado_publicidad' => !$user->estado_publicidad]);
        $msg = $user->estado_publicidad ? 'activado' : 'desactivado';
        return back()->with('success', "Usuario {$user->nombre_usuario} ha sido {$msg}.");
    }

    public function destroyUsuario(User $user) {
        if ($user->isAdmin()) return back()->with('error', 'No puedes eliminar un admin.');
        $user->delete();
        return redirect()->route('admin.usuarios')->with('success', 'Usuario eliminado.');
    }

    public function perfil() {
        $user = Auth::user();
        return view('admin.perfil', compact('user'));
    }

    public function actualizarPerfil(Request $request) {
        $request->validate([
            'nombre_usuario'    => 'nullable|string|max:1000',
            'email'         => 'required|string|max:100',
        ]);
        Auth::user()->update($request->only([
            'nombre_usuario', 'email'
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