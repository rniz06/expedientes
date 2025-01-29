<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoTitularSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipo_titulares = [
            'CIUDADANO',
            'BOMBEROS',
            'COMPAÑIAS',
            'DEPARTAMENTOS',
        ];

        // Iterar sobre el array de estados y insertar cada una en la base de datos
        foreach ($tipo_titulares as $tipo_titular) {
            DB::table('expedientes_tipo_titulares')->insert([
                'tipo_titular' => $tipo_titular,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
