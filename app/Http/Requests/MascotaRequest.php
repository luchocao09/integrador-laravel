<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MascotaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:100'],
            'especie' => ['required', 'string', 'max:50'],
            'raza' => ['required', 'string', 'max:50'],
            'edad' => ['required', 'integer', 'min:0', 'max:100'],
            'peso' => ['required', 'numeric', 'min:0.01', 'max:999.99'],
            'nombre_dueno' => ['required', 'string', 'max:100'],
            'telefono_dueno' => ['required', 'string', 'max:20'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre' => 'nombre de la mascota',
            'especie' => 'especie',
            'raza' => 'raza',
            'edad' => 'edad',
            'peso' => 'peso',
            'nombre_dueno' => 'nombre del dueño',
            'telefono_dueno' => 'teléfono del dueño',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la mascota es obligatorio.',
            'especie.required' => 'La especie es obligatoria.',
            'raza.required' => 'La raza es obligatoria.',
            'edad.required' => 'La edad es obligatoria.',
            'edad.integer' => 'La edad debe ser un número entero.',
            'peso.required' => 'El peso es obligatorio.',
            'peso.numeric' => 'El peso debe ser un número válido.',
            'nombre_dueno.required' => 'El nombre del dueño es obligatorio.',
            'telefono_dueno.required' => 'El teléfono de contacto es obligatorio.',
        ];
    }
}
