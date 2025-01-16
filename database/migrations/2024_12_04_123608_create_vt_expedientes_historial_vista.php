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
        DB::statement("DROP VIEW IF EXISTS `vt_expedientes_historial`");
        DB::statement("
                CREATE OR REPLACE VIEW `vt_expedientes_historial` AS
                    SELECT 
                        `expedientes_departamentos_historial`.`id` AS `historial_id`,
                        `expedientes`.`mesa_entrada_completa` AS `mesa_entrada_completa`,
                        `expedientes`.`expediente_asunto` AS `expediente_asunto`,
                        `departamentos_origen`.`departamento_nombre` AS `departamento_origen`,    
                        `departamentos_destino`.`departamento_nombre` AS `departamento_destino`,
                        `users`.`name` AS `usuario_nombre`,
                        `expedientes_departamentos_historial`.`expediente_id` AS `expediente_id`,
                        `expedientes_departamentos_historial`.`departamento_origen_id` AS `departamento_origen_id`,
                        `expedientes_departamentos_historial`.`departamento_destino_id` AS `departamento_destino_id`,
                        `expedientes_departamentos_historial`.`usuario_id` AS `usuario_id`
                    FROM 
                        `expedientes_departamentos_historial`
                    LEFT JOIN 
                        `expedientes` 
                        ON `expedientes_departamentos_historial`.`expediente_id` = `expedientes`.`id_expediente`
                    LEFT JOIN 
                        `departamentos` AS `departamentos_origen` 
                        ON `expedientes_departamentos_historial`.`departamento_origen_id` = `departamentos_origen`.`id_departamento`
                    LEFT JOIN 
                        `departamentos` AS `departamentos_destino` 
                        ON `expedientes_departamentos_historial`.`departamento_destino_id` = `departamentos_destino`.`id_departamento`
                    LEFT JOIN 
                        `users` 
                        ON `expedientes_departamentos_historial`.`usuario_id` = `users`.`id`;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //DB::statement("DROP VIEW IF EXISTS `vt_expedientes_historial`");
    }
};
