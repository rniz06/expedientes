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
            CREATE VIEW `vt_expedientes` AS
            SELECT 
                `expedientes`.`id_expediente` AS `id_expediente`,
                `expedientes`.`expediente_asunto` AS `expediente_asunto`,
                `expedientes`.`mesa_entrada_completa` AS `mesa_entrada_completa`,
                `expedientes`.`mesa_entrada_anho` AS `mesa_entrada_anho`,
                `expedientes_estados`.`expediente_estado` AS `estado`,
                `expedientes_prioridades`.`expediente_prioridad` AS `prioridad`,
                `departamentos`.`departamento_nombre` AS `departamento`,
                `ciudadanos`.`nombre_completo` AS `nombre_completo`,
                `ciudadanos`.`ci` AS `ciudadano_ci`,
                `expedientes`.`expediente_ciudadano_id` AS `ciudadano_id`,
                `expedientes`.`expediente_departamento_id` AS `departamento_id`,
                `expedientes`.`expediente_prioridad_id` AS `prioridad_id`,
                `expedientes`.`expediente_estado_id` AS `estado_id`
            FROM
                `expedientes`
            LEFT JOIN `expedientes_estados` ON `expedientes`.`expediente_estado_id` = `expedientes_estados`.`id_expediente_estado`
            LEFT JOIN `departamentos` ON `expedientes`.`expediente_departamento_id` = `departamentos`.`id_departamento`
            LEFT JOIN `ciudadanos` ON `expedientes`.`expediente_ciudadano_id` = `ciudadanos`.`id_ciudadano`
            LEFT JOIN `expedientes_prioridades` ON `expedientes`.`expediente_prioridad_id` = `expedientes_prioridades`.`id_expediente_prioridad`
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `vt_expedientes`");
    }
};
