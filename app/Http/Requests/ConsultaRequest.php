<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsultaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mascota_id' => ['required', 'exists:mascotas,id'],
            'fecha_consulta' => ['required', 'date'],
            'motivo' => ['required', 'string', 'max:255'],
            'diagnostico' => ['required', 'string'],
            'tratamiento' => ['required', 'string'],
            'costo' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'veterinario' => ['required', 'string', 'max:100'],
        ];
    }

    public function attributes(): array
    {
        return [
            'mascota_id' => 'mascota',
            'fecha_consulta' => 'fecha de consulta',
            'motivo' => 'motivo',
            'diagnostico' => 'diagnóstico',
            'tratamiento' => 'tratamiento',
            'costo' => 'costo',
            'veterinario' => 'veterinario',
        ];
    }

    public function messages(): array
    {
        return [
            'mascota_id.required' => 'Debe seleccionar una mascota.',
            'mascota_id.exists' => 'La mascota seleccionada no es válida.',
            'fecha_consulta.required' => 'La fecha de la consulta es obligatoria.',
            'fecha_consulta.date' => 'La fecha de la consulta debe tener un formato válido.',
            'motivo.required' => 'El motivo de la consulta es obligatorio.',
            'diagnostico.required' => 'El diagnóstico es obligatorio.',
            'tratamiento.required' => 'El tratamiento es obligatorio.',
            'costo.required' => 'El costo es obligatorio.',
            'costo.numeric' => 'El costo debe ser un valor numérico.',
            'veterinario.required' => 'El nombre del veterinario es obligatorio.',
        ];
    }
}
