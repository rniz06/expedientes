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
        Schema::create('expedientes_archivos', function (Blueprint $table) {
            $table->id('id_expediente_archivo');
            $table->string('archivo_nombre_original');
            $table->string('archivo_nombre_generado');
            $table->string('archivo_ruta');
            $table->string('archivo_tamano');
            $table->string('archivo_tipo');
            $table->string('archivo_descripcion')->nullable();
            $table->dateTime('archivo_fecha_subida')->nullable();
            $table->unsignedBigInteger('archivo_usuario_id')->nullable();
            $table->unsignedBigInteger('archivo_expediente_id')->nullable();
            $table->timestamps();

            $table->foreign('archivo_usuario_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('archivo_expediente_id')->references('id_expediente')->on('expedientes')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expedientes_archivos');
    }
};
