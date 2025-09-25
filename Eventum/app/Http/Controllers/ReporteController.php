<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReporteEvento;
use App\Models\Evento;
use Illuminate\Support\Facades\Auth;

class ReporteController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        $reportes = ReporteEvento::where('id_usuario', $usuario->id_usuario)
            ->with(['evento.anfitrion'])
            ->orderBy('fecha_reporte', 'desc')
            ->paginate(10);

        return view('reportes.index', compact('reportes'));
    }

    public function crear(Request $request)
    {
        $request->validate([
            'id_evento' => 'required|exists:eventos,id_evento',
            'motivo' => 'required|string|max:1000'
        ]);

        $reporte = new ReporteEvento();
        $reporte->id_evento = $request->id_evento;
        $reporte->id_usuario = Auth::id();
        $reporte->motivo = $request->motivo;
        $reporte->save();

        return back()->with('success', 'Reporte enviado exitosamente');
    }
}
