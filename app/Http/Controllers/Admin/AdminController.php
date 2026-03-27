<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
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
}