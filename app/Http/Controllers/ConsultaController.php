<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Mascota;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');
        $orden = $request->input('orden', 'fecha_consulta');
        $direccion = $request->input('direccion', 'desc');

        $query = Consulta::join('mascotas', 'consultas.mascota_id', '=', 'mascotas.id')
            ->select(
                'consultas.*',
                'mascotas.nombre as nombre_mascota',
                'mascotas.especie as especie_mascota',
                'mascotas.nombre_dueno as dueno_mascota'
            )
            ->with('mascota');

        if ($buscar) {
            $query->where(function ($q) use ($buscar) {
                $q->where('consultas.motivo', 'LIKE', '%' . $buscar . '%')
                    ->orWhere('consultas.veterinario', 'LIKE', '%' . $buscar . '%')
                    ->orWhere('mascotas.nombre', 'LIKE', '%' . $buscar . '%')
                    ->orWhere('mascotas.nombre_dueno', 'LIKE', '%' . $buscar . '%');
            });
        }

        $columnas = [
            'id' => 'consultas.id',
            'fecha_consulta' => 'consultas.fecha_consulta',
            'costo' => 'consultas.costo',
            'veterinario' => 'consultas.veterinario',
            'created_at' => 'consultas.created_at',
        ];

        $columnaOrden = $columnas[$orden] ?? 'consultas.fecha_consulta';
        $direccion = ($direccion === 'asc') ? 'asc' : 'desc';

        $consultas = $query->orderBy($columnaOrden, $direccion)
            ->paginate(10)
            ->withQueryString();

        return view('consultas.index', compact('consultas', 'buscar', 'orden', 'direccion'));
    }

    public function create(Request $request)
    {
        $mascotas = Mascota::orderBy('nombre', 'asc')->get();
        $mascotaIdSeleccionada = $request->input('mascota_id');

        return view('consultas.create', compact('mascotas', 'mascotaIdSeleccionada'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'mascota_id' => 'required|exists:mascotas,id',
            'fecha_consulta' => 'required|date',
            'motivo' => 'required|string|max:255',
            'diagnostico' => 'required|string',
            'tratamiento' => 'required|string',
            'costo' => 'required|numeric|min:0',
            'veterinario' => 'required|string|max:100',
        ]);

        Consulta::create($datos);

        return redirect()->route('consultas.index')
            ->with('success', 'Consulta médica registrada exitosamente.');
    }

    public function show($id)
    {
        $consulta = Consulta::join('mascotas', 'consultas.mascota_id', '=', 'mascotas.id')
            ->select('consultas.*')
            ->with('mascota')
            ->findOrFail($id);

        return view('consultas.show', compact('consulta'));
    }

    public function edit($id)
    {
        $consulta = Consulta::findOrFail($id);
        $mascotas = Mascota::orderBy('nombre', 'asc')->get();

        return view('consultas.edit', compact('consulta', 'mascotas'));
    }

    public function update(Request $request, $id)
    {
        $datos = $request->validate([
            'mascota_id' => 'required|exists:mascotas,id',
            'fecha_consulta' => 'required|date',
            'motivo' => 'required|string|max:255',
            'diagnostico' => 'required|string',
            'tratamiento' => 'required|string',
            'costo' => 'required|numeric|min:0',
            'veterinario' => 'required|string|max:100',
        ]);

        $consulta = Consulta::findOrFail($id);
        $consulta->update($datos);

        return redirect()->route('consultas.index')
            ->with('success', 'Consulta médica actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $consulta = Consulta::findOrFail($id);
        $consulta->delete();

        return redirect()->route('consultas.index')
            ->with('success', 'Consulta médica eliminada exitosamente.');
    }
}
