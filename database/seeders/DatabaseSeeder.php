<?php

namespace Database\Seeders;

use App\Models\Consulta;
use App\Models\Mascota;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $m1 = Mascota::create([
            'nombre' => 'Milo',
            'especie' => 'Canino',
            'raza' => 'Golden Retriever',
            'edad' => 3,
            'peso' => 28.50,
            'nombre_dueno' => 'Lucía Fernández',
            'telefono_dueno' => '11-4455-6677',
        ]);

        $m2 = Mascota::create([
            'nombre' => 'Luna',
            'especie' => 'Felino',
            'raza' => 'Siamés',
            'edad' => 2,
            'peso' => 4.20,
            'nombre_dueno' => 'Carlos Benítez',
            'telefono_dueno' => '11-3322-1144',
        ]);

        $m3 = Mascota::create([
            'nombre' => 'Rocky',
            'especie' => 'Canino',
            'raza' => 'Bulldog Francés',
            'edad' => 5,
            'peso' => 12.00,
            'nombre_dueno' => 'Mariana Ruiz',
            'telefono_dueno' => '11-9988-7711',
        ]);

        Consulta::create([
            'mascota_id' => $m1->id,
            'fecha_consulta' => '2026-11-10',
            'motivo' => 'Control anual y vacunación séxtuple',
            'diagnostico' => 'Paciente en excelente condición física y estado nutricional.',
            'tratamiento' => 'Se aplica refuerzo séxtuple y antiparasitario interno.',
            'costo' => 14000.00,
            'veterinario' => 'Dra. Cortaberria',
        ]);

        Consulta::create([
            'mascota_id' => $m1->id,
            'fecha_consulta' => '2026-11-12',
            'motivo' => 'Revisión por otitis leve en oído derecho',
            'diagnostico' => 'Eritema moderado en conducto auditivo externo derecho.',
            'tratamiento' => 'Gotas óticas antiinflamatorias y antibióticas cada 12 horas por 7 días.',
            'costo' => 9500.00,
            'veterinario' => 'Dr. Cao',
        ]);

        Consulta::create([
            'mascota_id' => $m2->id,
            'fecha_consulta' => '2026-11-05',
            'motivo' => 'Control de peso y desparasitación',
            'diagnostico' => 'Evolución favorable de peso tras cambio de alimento.',
            'tratamiento' => 'Comprimido antiparasitario de amplio espectro.',
            'costo' => 8000.00,
            'veterinario' => 'Dra. Cortaberria',
        ]);

        Consulta::create([
            'mascota_id' => $m3->id,
            'fecha_consulta' => '2026-11-08',
            'motivo' => 'Dermatitis alérgica en pliegues nasales',
            'diagnostico' => 'Dermatitis superficial por humedad y acumulación de secreciones.',
            'tratamiento' => 'Limpieza diaria con solución antiséptica y crema dérmica cicatrizante.',
            'costo' => 11200.00,
            'veterinario' => 'Dr. Cao',
        ]);
    }
}
