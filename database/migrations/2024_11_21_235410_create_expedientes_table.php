<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expedientes', function (Blueprint $table) {
            $table->id('id_expediente');
            $table->string('expediente_asunto');
            $table->string('mesa_entrada_completa')->unique();
            $table->string('mesa_entrada_prefix_anho', 20)->nullable();
            $table->string('nro_mesa_entrada');
            $table->string('nro_mesa_entrada_anho')->unique();
            $table->string('mesa_entrada_anho');
            $table->unsignedBigInteger('expediente_estado_id')->nullable();
            $table->unsignedBigInteger('expediente_prioridad_id')->nullable();
            $table->unsignedBigInteger('expediente_departamento_id')->nullable();
            $table->unsignedBigInteger('expediente_ciudadano_id')->nullable();
            //$table->boolean('acceso_restringido')->default(false);
            $table->timestamps();

            $table->foreign('expediente_estado_id')->references('id_expediente_estado')->on('expedientes_estados')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('expediente_prioridad_id')->references('id_expediente_prioridad')->on('expedientes_prioridades')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('expediente_departamento_id')->references('id_departamento')->on('departamentos')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('expediente_ciudadano_id')->references('id_ciudadano')->on('ciudadanos')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expedientes');
    }
};
