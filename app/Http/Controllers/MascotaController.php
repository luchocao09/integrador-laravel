<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Mascota;
use Illuminate\Http\Request;

class MascotaController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');
        $orden = $request->input('orden', 'id');
        $direccion = $request->input('direccion', 'desc');

        $query = Mascota::withCount('consultas');

        if ($buscar) {
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'LIKE', '%' . $buscar . '%')
                    ->orWhere('especie', 'LIKE', '%' . $buscar . '%')
                    ->orWhere('raza', 'LIKE', '%' . $buscar . '%')
                    ->orWhere('nombre_dueno', 'LIKE', '%' . $buscar . '%');
            });
        }

        $columnas = ['id', 'nombre', 'especie', 'raza', 'edad', 'peso', 'nombre_dueno', 'created_at'];
        if (!in_array($orden, $columnas)) {
            $orden = 'id';
        }
        $direccion = ($direccion === 'asc') ? 'asc' : 'desc';

        $mascotas = $query->orderBy($orden, $direccion)
            ->paginate(10)
            ->withQueryString();

        return view('mascotas.index', compact('mascotas', 'buscar', 'orden', 'direccion'));
    }

    public function create()
    {
        return view('mascotas.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'especie' => 'required|string|max:50',
            'raza' => 'required|string|max:50',
            'edad' => 'required|integer|min:0|max:100',
            'peso' => 'required|numeric|min:0.01|max:999.99',
            'nombre_dueno' => 'required|string|max:100',
            'telefono_dueno' => 'required|string|max:20',
        ]);

        Mascota::create($datos);

        return redirect()->route('mascotas.index')
            ->with('success', 'Mascota registrada exitosamente.');
    }

    public function show($id)
    {
        $mascota = Mascota::findOrFail($id);

        $consultas = Consulta::join('mascotas', 'consultas.mascota_id', '=', 'mascotas.id')
            ->where('consultas.mascota_id', $mascota->id)
            ->select('consultas.*')
            ->orderBy('consultas.fecha_consulta', 'desc')
            ->get();

        $mascota->setRelation('consultas', $consultas);

        return view('mascotas.show', compact('mascota'));
    }

    public function edit($id)
    {
        $mascota = Mascota::findOrFail($id);

        return view('mascotas.edit', compact('mascota'));
    }

    public function update(Request $request, $id)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'especie' => 'required|string|max:50',
            'raza' => 'required|string|max:50',
            'edad' => 'required|integer|min:0|max:100',
            'peso' => 'required|numeric|min:0.01|max:999.99',
            'nombre_dueno' => 'required|string|max:100',
            'telefono_dueno' => 'required|string|max:20',
        ]);

        $mascota = Mascota::findOrFail($id);
        $mascota->update($datos);

        return redirect()->route('mascotas.index')
            ->with('success', 'Datos de la mascota actualizados exitosamente.');
    }

    public function destroy($id)
    {
        $mascota = Mascota::findOrFail($id);
        $mascota->delete();

        return redirect()->route('mascotas.index')
            ->with('success', 'Mascota eliminada exitosamente.');
    }
}
