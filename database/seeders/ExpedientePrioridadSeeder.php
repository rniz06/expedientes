<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpedientePrioridadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // $prioridades = [
        //     'BAJO',
        //     'MEDIO',
        //     'ALTO',
        //     'URGENTE',
        // ];

        // // Iterar sobre el array de estados y insertar cada una en la base de datos
        // foreach ($prioridades as $prioridad) {
        //     DB::table('expedientes_prioridades')->insert([
        //         'expediente_prioridad' => $prioridad,
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ]);
        // }
    }
}