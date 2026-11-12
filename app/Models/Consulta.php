<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consulta extends Model
{
    use HasFactory;

    protected $table = 'consultas';

    protected $fillable = [
        'mascota_id',
        'fecha_consulta',
        'motivo',
        'diagnostico',
        'tratamiento',
        'costo',
        'veterinario',
    ];

    protected $casts = [
        'fecha_consulta' => 'date',
        'costo' => 'decimal:2',
    ];

    /**
     * Relación: Una consulta pertenece a una mascota.
     */
    public function mascota(): BelongsTo
    {
        return $this->belongsTo(Mascota::class, 'mascota_id');
    }
}
