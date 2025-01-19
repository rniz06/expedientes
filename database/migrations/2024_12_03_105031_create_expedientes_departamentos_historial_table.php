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
        Schema::create('expedientes_departamentos_historial', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expediente_id')->nullable();
            $table->unsignedBigInteger('departamento_origen_id')->nullable();
            $table->unsignedBigInteger('departamento_destino_id')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('expediente_id')->references('id_expediente')->on('expedientes')->onDelete('cascade');
            $table->foreign('departamento_origen_id', 'fk_origen_departamento')->references('id_departamento')->on('departamentos')->onDelete('cascade');
            $table->foreign('departamento_destino_id', 'fk_destino_departamento')->references('id_departamento')->on('departamentos')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expedientes_departamentos_historial');
    }
};
