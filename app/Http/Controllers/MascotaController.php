<?php

namespace App\Http\Controllers;

use App\Http\Requests\MascotaRequest;
use App\Models\Mascota;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MascotaController extends Controller
{
    public function index(Request $request): View
    {
        $buscar = $request->input('buscar');
        $orden = $request->input('orden', 'id');
        $direccion = strtolower($request->input('direccion', 'desc')) === 'asc' ? 'asc' : 'desc';

        $columnasPermitidas = ['id', 'nombre', 'especie', 'raza', 'edad', 'peso', 'nombre_dueno', 'created_at'];

        if (!in_array($orden, $columnasPermitidas)) {
            $orden = 'id';
        }

        $query = Mascota::withCount('consultas');

        if (!empty($buscar)) {
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('especie', 'like', "%{$buscar}%")
                    ->orWhere('raza', 'like', "%{$buscar}%")
                    ->orWhere('nombre_dueno', 'like', "%{$buscar}%");
            });
        }

        $mascotas = $query->orderBy($orden, $direccion)
            ->paginate(10)
            ->withQueryString();

        return view('mascotas.index', compact('mascotas', 'buscar', 'orden', 'direccion'));
    }

    public function create(): View
    {
        return view('mascotas.create');
    }

    public function store(MascotaRequest $request): RedirectResponse
    {
        Mascota::create($request->validated());

        return redirect()->route('mascotas.index')
            ->with('success', 'Mascota registrada exitosamente.');
    }

    public function show(Mascota $mascota): View
    {
        $mascota->load(['consultas' => function ($query) {
            $query->orderBy('fecha_consulta', 'desc');
        }]);

        return view('mascotas.show', compact('mascota'));
    }

    public function edit(Mascota $mascota): View
    {
        return view('mascotas.edit', compact('mascota'));
    }

    public function update(MascotaRequest $request, Mascota $mascota): RedirectResponse
    {
        $mascota->update($request->validated());

        return redirect()->route('mascotas.index')
            ->with('success', 'Datos de la mascota actualizados exitosamente.');
    }

    public function destroy(Mascota $mascota): RedirectResponse
    {
        $mascota->delete();

        return redirect()->route('mascotas.index')
            ->with('success', 'Mascota eliminada exitosamente.');
    }
}
