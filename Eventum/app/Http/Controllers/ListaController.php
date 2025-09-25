<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CosaPorLlevar;
use App\Models\Evento;
use Illuminate\Support\Facades\Auth;

class ListaController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        $cosas = CosaPorLlevar::whereHas('evento', function($query) use ($usuario) {
            $query->where('id_anfitrion', $usuario->id_usuario);
        })->with(['evento', 'usuario'])->paginate(15);

        return view('lista.index', compact('cosas'));
    }

    public function crear(Request $request)
    {
        $request->validate([
            'id_evento' => 'required|exists:eventos,id_evento',
            'nombre' => 'required|string|max:100',
            'cantidad' => 'nullable|string|max:50',
            'observaciones' => 'nullable|string'
        ]);

        $cosa = new CosaPorLlevar();
        $cosa->id_evento = $request->id_evento;
        $cosa->nombre = $request->nombre;
        $cosa->cantidad = $request->cantidad;
        $cosa->observaciones = $request->observaciones;
        $cosa->save();

        return back()->with('success', 'Elemento agregado a la lista exitosamente');
    }

    public function actualizar(Request $request, $id)
    {
        $cosa = CosaPorLlevar::findOrFail($id);
        
        $request->validate([
            'estado' => 'required|in:pendiente,comprado,cancelado',
            'id_usuario' => 'nullable|exists:usuarios,id_usuario'
        ]);

        $cosa->estado = $request->estado;
        $cosa->id_usuario = $request->id_usuario;
        $cosa->save();

        return back()->with('success', 'Estado actualizado exitosamente');
    }

    public function eliminar($id)
    {
        $cosa = CosaPorLlevar::findOrFail($id);
        $cosa->delete();

        return back()->with('success', 'Elemento eliminado exitosamente');
    }
}
