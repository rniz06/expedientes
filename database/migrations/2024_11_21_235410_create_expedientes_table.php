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
            $table->unsignedBigInteger('tipo_fuente_id')->nullable();
            $table->unsignedBigInteger('tipo_titular_id')->nullable();
            $table->unsignedBigInteger('expediente_estado_id')->nullable();
            $table->unsignedBigInteger('expediente_departamento_id')->nullable();
            $table->unsignedBigInteger('expediente_ciudadano_id')->nullable();
            $table->unsignedBigInteger('personal_id')->nullable();
            $table->unsignedBigInteger('tit_compania_id')->nullable();
            $table->unsignedBigInteger('tit_departamento_id')->nullable();
            $table->unsignedBigInteger('agrego_usuario_id')->nullable();
            $table->boolean('acceso_restringido')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tipo_fuente_id')->references('id_tipo_fuente')->on('expedientes_tipo_fuentes')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tipo_titular_id')->references('id_tipo_titular')->on('expedientes_tipo_titulares')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('expediente_estado_id')->references('id_expediente_estado')->on('expedientes_estados')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('expediente_departamento_id')->references('id_departamento')->on('departamentos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('expediente_ciudadano_id')->references('id_ciudadano')->on('ciudadanos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tit_departamento_id')->references('id_departamento')->on('departamentos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('agrego_usuario_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
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
