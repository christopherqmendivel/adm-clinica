<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empleado;
use App\Models\Clinica;

class EmpleadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Eliminar todos los registros de la tabla
        Empleado::query()->delete();

        // Obtener todas las clínicas
        $clinicas = Clinica::all();

        // Generar empleados para cada clínica
        foreach ($clinicas as $clinica) {
            Empleado::factory()->count(30)->create([
                'clinica_id' => $clinica->id,
            ]);
        }
    }
}
