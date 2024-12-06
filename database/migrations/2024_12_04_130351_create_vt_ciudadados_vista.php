<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW `vt_ciudadanos` AS
                SELECT 
                    `ciudadanos`.`id_ciudadano` AS `id_ciudadano`,
                    `ciudadanos`.`nombre_completo` AS `nombre_completo`,
                    `ciudadanos`.`ci` AS `ci`,
                    `ciudadanos`.`ruc` AS `ruc`,    
                    `ciudadanos`.`email` AS `email`,
                    `ciudadanos`.`telefono` AS `telefono`,
                    `ciudadanos`.`direccion_particular` AS `direccion_particular`,
                    `ciudadanos`.`tipo_persona` AS `tipo_persona`,
                    `ciudades_barrios`.`barrio_nombre` AS `barrio`,
                    `ciudades`.`ciudad_nombre` AS `ciudad`,
                    `ciudadanos`.`barrio_id` AS `barrio_id`,
                    `ciudadanos`.`ciudad_id` AS `ciudad_id`
                FROM 
                    `ciudadanos`
                LEFT JOIN 
                    `ciudades_barrios` 
                    ON `ciudadanos`.`barrio_id` = `ciudades_barrios`.`id_barrio`
                LEFT JOIN 
                    `ciudades` 
                    ON `ciudadanos`.`ciudad_id` = `ciudades`.`id_ciudad`;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `vt_ciudadanos`");
    }
};
