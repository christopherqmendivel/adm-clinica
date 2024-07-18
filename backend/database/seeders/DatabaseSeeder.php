<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Clinica;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Llamar a los seeders de clínicas y empleados en el orden correcto
        $this->call([
            AdminUserSeeder::class,
            ClinicasTableSeeder::class,
            EmpleadosTableSeeder::class,
        ]);
    }
}
