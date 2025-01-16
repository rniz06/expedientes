<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpedienteTipoFuenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipo_fuentes = [
            'INTERNO',
            'EXTERNO',
        ];

        // Iterar sobre el array de estados y insertar cada una en la base de datos
        foreach ($tipo_fuentes as $tipo_fuente) {
            DB::table('expedientes_tipo_fuentes')->insert([
                'tipo_fuente' => $tipo_fuente,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
