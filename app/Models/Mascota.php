<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mascota extends Model
{
    use HasFactory;

    protected $table = 'mascotas';

    protected $fillable = [
        'nombre',
        'especie',
        'raza',
        'edad',
        'peso',
        'nombre_dueno',
        'telefono_dueno',
    ];

    protected $casts = [
        'edad' => 'integer',
        'peso' => 'decimal:2',
    ];

    public function consultas(): HasMany
    {
        return $this->hasMany(Consulta::class, 'mascota_id');
    }
}
