<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsultaRequest;
use App\Models\Consulta;
use App\Models\Mascota;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConsultaController extends Controller
{
    public function index(Request $request): View
    {
        $buscar = $request->input('buscar');
        $orden = $request->input('orden', 'fecha_consulta');
        $direccion = strtolower($request->input('direccion', 'desc')) === 'asc' ? 'asc' : 'desc';

        $columnasPermitidas = ['id', 'fecha_consulta', 'costo', 'veterinario', 'created_at'];

        if (!in_array($orden, $columnasPermitidas)) {
            $orden = 'fecha_consulta';
        }

        $query = Consulta::with('mascota');

        if (!empty($buscar)) {
            $query->where(function ($q) use ($buscar) {
                $q->where('motivo', 'like', "%{$buscar}%")
                    ->orWhere('veterinario', 'like', "%{$buscar}%")
                    ->orWhereHas('mascota', function ($sub) use ($buscar) {
                        $sub->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('nombre_dueno', 'like', "%{$buscar}%");
                    });
            });
        }

        $consultas = $query->orderBy($orden, $direccion)
            ->paginate(10)
            ->withQueryString();

        return view('consultas.index', compact('consultas', 'buscar', 'orden', 'direccion'));
    }

    public function create(Request $request): View
    {
        $mascotas = Mascota::orderBy('nombre', 'asc')->get();
        $mascotaIdSeleccionada = $request->input('mascota_id');

        return view('consultas.create', compact('mascotas', 'mascotaIdSeleccionada'));
    }

    public function store(ConsultaRequest $request): RedirectResponse
    {
        Consulta::create($request->validated());

        return redirect()->route('consultas.index')
            ->with('success', 'Consulta médica registrada exitosamente.');
    }

    public function show(Consulta $consulta): View
    {
        $consulta->load('mascota');

        return view('consultas.show', compact('consulta'));
    }

    public function edit(Consulta $consulta): View
    {
        $mascotas = Mascota::orderBy('nombre', 'asc')->get();

        return view('consultas.edit', compact('consulta', 'mascotas'));
    }

    public function update(ConsultaRequest $request, Consulta $consulta): RedirectResponse
    {
        $consulta->update($request->validated());

        return redirect()->route('consultas.index')
            ->with('success', 'Consulta médica actualizada exitosamente.');
    }

    public function destroy(Consulta $consulta): RedirectResponse
    {
        $consulta->delete();

        return redirect()->route('consultas.index')
            ->with('success', 'Consulta médica eliminada exitosamente.');
    }
}
