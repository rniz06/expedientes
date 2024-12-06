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
        CREATE OR REPLACE VIEW `vt_expedientes_comentarios` AS
        SELECT 
            `expedientes_comentarios`.`id_expediente_comentario` AS `id_expediente_comentario`,
            `expedientes_comentarios`.`expediente_comentario` AS `comentario`,
            `expedientes`.`expediente_asunto` AS `expediente_asunto`,
            `expedientes`.`mesa_entrada_completa` AS `mesa_entrada_completa`,
            `expedientes_comentarios`.`comentario_expediente_id` AS `expediente_id`,
            `expedientes_comentarios`.`creador_usuario_id` AS `creador_usuario_id`,
            `expedientes_comentarios`.`actualizacion_usuario_id` AS `actualizacion_usuario_id`
        FROM
            `expedientes_comentarios`
        LEFT JOIN 
            `expedientes` 
            ON `expedientes_comentarios`.`comentario_expediente_id` = `expedientes`.`id_expediente`
        LEFT JOIN 
            `users` 
            ON `expedientes_comentarios`.`creador_usuario_id` = `users`.`id`;
    ");
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `vt_expedientes_comentarios`");
    }
};
