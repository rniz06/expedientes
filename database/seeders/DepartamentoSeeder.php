<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Listado de departamentos en orden al portal archivos.cbvp.org.py
        // $departamentosEnOrderPortal = [
        //     "DIRECTORIO NACIONAL",
        //     "PRESIDENCIA NACIONAL",
        //     "SECRETARIA NACIONAL",
        //     "TESORERIA NACIONAL",
        //     "DIRECCIÓN NACIONAL",
        //     "COMANDANCIA NACIONAL",
        //     "ANB",
        //     "DPTO. LEGAL",
        //     "DPTO. RR. INTERNACIONALES",
        //     "DPTO. RR. INTERINSTITUCIONALES",
        //     "DPTO. MEDIO AMBIENTE",
        //     "DPTO. SEG. Y BIENESTAR",
        //     "DPTO. PRE-HOSPITALAR",
        //     "DPTO. MANT. DE MATERIALES",
        //     "DPTO. PERSONAL",
        //     "DPTO. BIENESTAR ANIMAL",
        //     "DPTO. COMUNICACIONES",
        //     "DPTO. PREVENCIÓN E INVESTIGACIÓN DE SINIESTROS",
        //     "DPTO. ECONOMÍA",
        //     "DPTO. PATRIMONIO",
        //     "DPTO. DESARROLLO Y FISCALIZACIÓN DE OBRAS",
        //     "DPTO. EXPANSIÓN Y DESARROLLO",
        //     "DPTO. RELACIONES INTERMUNICIPALES",
        //     "DPTO. TECNOLOGÍA E INNOVACIÓN"
        // ];

        // Listado de departamentos en minusculas
        // $departamentosEnMinusculas = [
        //     "Anb",
        //     "Comandancia Nacional",
        //     "Directorio Nacional",
        //     "Dirección Nacional",
        //     "Dpto. Bienestar Animal",
        //     "Dpto. Comunicaciones",
        //     "Dpto. Desarrollo Y Fiscalización De Obras",
        //     "Dpto. Economía",
        //     "Dpto. Expansión Y Desarrollo",
        //     "Dpto. Legal",
        //     "Dpto. Mant. De Materiales",
        //     "Dpto. Medio Ambiente",
        //     "Dpto. Patrimonio",
        //     "Dpto. Personal",
        //     "Dpto. Pre-Hospitalar",
        //     "Dpto. Prevención E Investigación De Siniestros",
        //     "Dpto. Relaciones Intermunicipales",
        //     "Dpto. Rr. Internacionales",
        //     "Dpto. Rr. Interinstitucionales",
        //     "Dpto. Seg. Y Bienestar",
        //     "Dpto. Tecnología E Innovación",
        //     "Presidencia Nacional",
        //     "Secretaria Nacional",
        //     "Tesoreria Nacional"
        // ];

        $departamentos = [
            "ANB",
            "COMANDANCIA NACIONAL",
            "DIRECTORIO NACIONAL",
            "DIRECCIÓN NACIONAL",
            "DPTO. BIENESTAR ANIMAL",
            "DPTO. COMUNICACIONES",
            "DPTO. DESARROLLO Y FISCALIZACIÓN DE OBRAS",
            "DPTO. ECONOMÍA",
            "DPTO. EXPANSIÓN Y DESARROLLO",
            "DPTO. LEGAL",
            "DPTO. MANT. DE MATERIALES",
            "DPTO. MEDIO AMBIENTE",
            "DPTO. PATRIMONIO",
            "DPTO. PERSONAL",
            "DPTO. PRE-HOSPITALAR",
            "DPTO. PREVENCIÓN E INVESTIGACIÓN DE SINIESTROS",
            "DPTO. RELACIONES INTERMUNICIPALES",
            "DPTO. RR. INTERNACIONALES",
            "DPTO. RR. INTERINSTITUCIONALES",
            "DPTO. SEG. Y BIENESTAR",
            "DPTO. TECNOLOGÍA E INNOVACIÓN",
            "PRESIDENCIA NACIONAL",
            "RECEPCIÓN DE SECRETARIA NACIONAL",
            "SECRETARIA NACIONAL",
            "TESORERIA NACIONAL"
        ];

        // Iterar sobre el array de estados y insertar cada una en la base de datos
        foreach ($departamentos as $departamento) {
            DB::table('departamentos')->insert([
                'departamento_nombre' => $departamento,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
