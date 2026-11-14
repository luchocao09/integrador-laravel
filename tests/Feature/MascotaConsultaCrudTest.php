<?php

namespace Tests\Feature;

use App\Models\Consulta;
use App\Models\Mascota;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MascotaConsultaCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_listar_mascotas(): void
    {
        Mascota::create([
            'nombre' => 'Bobby',
            'especie' => 'Perro',
            'raza' => 'Labrador',
            'edad' => 4,
            'peso' => 25.5,
            'nombre_dueno' => 'Carlos Gomez',
            'telefono_dueno' => '1122334455',
        ]);

        $response = $this->get('/mascotas');

        $response->assertStatus(200);
        $response->assertSee('Bobby');
        $response->assertSee('Perro');
        $response->assertSee('Carlos Gomez');
    }

    public function test_puede_crear_mascota_con_validacion(): void
    {
        $responseError = $this->post('/mascotas', []);
        $responseError->assertSessionHasErrors([
            'nombre',
            'especie',
            'raza',
            'edad',
            'peso',
            'nombre_dueno',
            'telefono_dueno',
        ]);

        $datos = [
            'nombre' => 'Milo',
            'especie' => 'Gato',
            'raza' => 'Siames',
            'edad' => 2,
            'peso' => 4.30,
            'nombre_dueno' => 'Lucia Fernandez',
            'telefono_dueno' => '1199887766',
        ];

        $response = $this->post('/mascotas', $datos);

        $response->assertRedirect('/mascotas');
        $this->assertDatabaseHas('mascotas', [
            'nombre' => 'Milo',
            'nombre_dueno' => 'Lucia Fernandez',
        ]);
    }

    public function test_puede_ver_detalle_de_mascota(): void
    {
        $mascota = Mascota::create([
            'nombre' => 'Simba',
            'especie' => 'Felino',
            'raza' => 'Comun',
            'edad' => 1,
            'peso' => 3.5,
            'nombre_dueno' => 'Valeria Sosa',
            'telefono_dueno' => '1166778899',
        ]);

        $response = $this->get("/mascotas/{$mascota->id}");

        $response->assertStatus(200);
        $response->assertSee('Simba');
        $response->assertSee('Valeria Sosa');
    }

    public function test_puede_actualizar_mascota(): void
    {
        $mascota = Mascota::create([
            'nombre' => 'Rocky',
            'especie' => 'Perro',
            'raza' => 'Boxer',
            'edad' => 5,
            'peso' => 30.0,
            'nombre_dueno' => 'Martin Lopez',
            'telefono_dueno' => '1144556677',
        ]);

        $response = $this->put("/mascotas/{$mascota->id}", [
            'nombre' => 'Rocky Editado',
            'especie' => 'Perro',
            'raza' => 'Boxer',
            'edad' => 6,
            'peso' => 31.5,
            'nombre_dueno' => 'Martin Lopez',
            'telefono_dueno' => '1144556677',
        ]);

        $response->assertRedirect('/mascotas');
        $this->assertDatabaseHas('mascotas', [
            'id' => $mascota->id,
            'nombre' => 'Rocky Editado',
            'edad' => 6,
        ]);
    }

    public function test_puede_eliminar_mascota(): void
    {
        $mascota = Mascota::create([
            'nombre' => 'Luna',
            'especie' => 'Gato',
            'raza' => 'Persa',
            'edad' => 3,
            'peso' => 3.8,
            'nombre_dueno' => 'Ana Garcia',
            'telefono_dueno' => '1133221100',
        ]);

        $response = $this->delete("/mascotas/{$mascota->id}");

        $response->assertRedirect('/mascotas');
        $this->assertDatabaseMissing('mascotas', [
            'id' => $mascota->id,
        ]);
    }

    public function test_puede_listar_consultas(): void
    {
        $mascota = Mascota::create([
            'nombre' => 'Toby',
            'especie' => 'Canino',
            'raza' => 'Poodle',
            'edad' => 2,
            'peso' => 6.0,
            'nombre_dueno' => 'Laura Paez',
            'telefono_dueno' => '1155443322',
        ]);

        Consulta::create([
            'mascota_id' => $mascota->id,
            'fecha_consulta' => '2026-11-13',
            'motivo' => 'Chequeo general',
            'diagnostico' => 'Saludable',
            'tratamiento' => 'Ninguno requerido',
            'costo' => 8500.00,
            'veterinario' => 'Dr. Cao',
        ]);

        $response = $this->get('/consultas');

        $response->assertStatus(200);
        $response->assertSee('Chequeo general');
        $response->assertSee('Dr. Cao');
        $response->assertSee('Toby');
    }

    public function test_puede_crear_consulta_relacionada_con_mascota(): void
    {
        $mascota = Mascota::create([
            'nombre' => 'Thor',
            'especie' => 'Perro',
            'raza' => 'Golden Retriever',
            'edad' => 5,
            'peso' => 32.0,
            'nombre_dueno' => 'Pablo Ramos',
            'telefono_dueno' => '1177665544',
        ]);

        $responseError = $this->post('/consultas', []);
        $responseError->assertSessionHasErrors([
            'mascota_id',
            'fecha_consulta',
            'motivo',
            'diagnostico',
            'tratamiento',
            'costo',
            'veterinario',
        ]);

        $datosConsulta = [
            'mascota_id' => $mascota->id,
            'fecha_consulta' => '2026-11-14',
            'motivo' => 'Vacunacion anual',
            'diagnostico' => 'Paciente en optimo estado general',
            'tratamiento' => 'Se aplica vacuna antirrabica',
            'costo' => 12500.00,
            'veterinario' => 'Dra. Cortaberria',
        ];

        $response = $this->post('/consultas', $datosConsulta);

        $response->assertRedirect('/consultas');
        $this->assertDatabaseHas('consultas', [
            'mascota_id' => $mascota->id,
            'motivo' => 'Vacunacion anual',
            'veterinario' => 'Dra. Cortaberria',
        ]);

        $this->assertCount(1, $mascota->fresh()->consultas);
        $this->assertEquals($mascota->id, Consulta::first()->mascota->id);
    }

    public function test_puede_ver_y_editar_consulta(): void
    {
        $mascota = Mascota::create([
            'nombre' => 'Zeus',
            'especie' => 'Canino',
            'raza' => 'Doberman',
            'edad' => 4,
            'peso' => 35.0,
            'nombre_dueno' => 'Esteban Quito',
            'telefono_dueno' => '1122112211',
        ]);

        $consulta = Consulta::create([
            'mascota_id' => $mascota->id,
            'fecha_consulta' => '2026-11-01',
            'motivo' => 'Corte de unas',
            'diagnostico' => 'Procedimiento de rutina',
            'tratamiento' => 'Corte y lima',
            'costo' => 4000.00,
            'veterinario' => 'Dr. Cao',
        ]);

        $responseShow = $this->get("/consultas/{$consulta->id}");
        $responseShow->assertStatus(200);
        $responseShow->assertSee('Corte de unas');

        $responseUpdate = $this->put("/consultas/{$consulta->id}", [
            'mascota_id' => $mascota->id,
            'fecha_consulta' => '2026-11-01',
            'motivo' => 'Corte de unas y bano',
            'diagnostico' => 'Procedimiento de rutina e higiene',
            'tratamiento' => 'Corte, lima y bano sanitario',
            'costo' => 7500.00,
            'veterinario' => 'Dr. Cao',
        ]);

        $responseUpdate->assertRedirect('/consultas');
        $this->assertDatabaseHas('consultas', [
            'id' => $consulta->id,
            'motivo' => 'Corte de unas y bano',
            'costo' => 7500.00,
        ]);
    }

    public function test_puede_eliminar_consulta(): void
    {
        $mascota = Mascota::create([
            'nombre' => 'Kira',
            'especie' => 'Felino',
            'raza' => 'Angora',
            'edad' => 2,
            'peso' => 3.2,
            'nombre_dueno' => 'Sonia Gomez',
            'telefono_dueno' => '1133445566',
        ]);

        $consulta = Consulta::create([
            'mascota_id' => $mascota->id,
            'fecha_consulta' => '2026-11-02',
            'motivo' => 'Desparasitacion',
            'diagnostico' => 'Profilaxis',
            'tratamiento' => 'Pastilla antiparasitaria',
            'costo' => 5000.00,
            'veterinario' => 'Dra. Cortaberria',
        ]);

        $response = $this->delete("/consultas/{$consulta->id}");

        $response->assertRedirect('/consultas');
        $this->assertDatabaseMissing('consultas', [
            'id' => $consulta->id,
        ]);
    }

    public function test_buscador_y_ordenamiento(): void
    {
        $mascota1 = Mascota::create([
            'nombre' => 'Alfa',
            'especie' => 'Canino',
            'raza' => 'Beagle',
            'edad' => 1,
            'peso' => 10.0,
            'nombre_dueno' => 'Juan',
            'telefono_dueno' => '11111111',
        ]);

        $mascota2 = Mascota::create([
            'nombre' => 'Zeta',
            'especie' => 'Felino',
            'raza' => 'Siames',
            'edad' => 8,
            'peso' => 5.0,
            'nombre_dueno' => 'Pedro',
            'telefono_dueno' => '22222222',
        ]);

        $responseBuscar = $this->get('/mascotas?buscar=Alfa');
        $responseBuscar->assertStatus(200);
        $responseBuscar->assertSee('Alfa');
        $responseBuscar->assertDontSee('Zeta');

        $responseOrden = $this->get('/mascotas?orden=nombre&direccion=asc');
        $responseOrden->assertStatus(200);
        $responseOrden->assertSeeInOrder(['Alfa', 'Zeta']);
    }
}
