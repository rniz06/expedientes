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
        Schema::create('expedientes_comentarios', function (Blueprint $table) {
            $table->id('id_expediente_comentario');
            $table->longText('expediente_comentario');
            $table->unsignedBigInteger('comentario_expediente_id')->nullable();
            $table->unsignedBigInteger('creador_usuario_id')->nullable();
            $table->unsignedBigInteger('actualizacion_usuario_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('comentario_expediente_id')->references('id_expediente')->on('expedientes')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('creador_usuario_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('actualizacion_usuario_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expedientes_comentarios');
    }
};
