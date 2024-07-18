<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Clinica;


class ClinicasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Eliminar todos los registros de la tabla
        Clinica::query()->delete();

        // Generar 30 registros de prueba para clínicas
        Clinica::factory()->count(30)->create();
    }
}
