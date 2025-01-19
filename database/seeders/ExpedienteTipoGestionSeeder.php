<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpedienteTipoGestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipo_gestiones = [
            'PASE DE COMBATIENTE A ACTIVO' => null,
            'PASE DE ACTIVO A COMBATIENTE' => 'Activo que haya jurado como Combatiente',
            'REINCORPORACIÓN' => 'Dado de baja CON PRESCRIPCIÓN',
            'COMBATIENTE PASA ACTIVO' => 'Maternidad',
            'CONSTANCIA DE BOMBERO' => null,
            'CONSOLIDADO DEL VOLUNTARIO' => null,
        ];

        // Iterar sobre el array de estados y insertar cada una en la base de datos
        foreach ($tipo_gestiones as $tipo_gestion => $descripcion) {
            $tipo_y_descripcion = $descripcion ? "{$tipo_gestion} ({$descripcion})" : $tipo_gestion;
            DB::table('expedientes_tipo_gestiones')->insert([
                'tipo_gestion' => $tipo_gestion,
                'descripcion' => $descripcion,
                'tipo_y_descripcion' => $tipo_y_descripcion,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
