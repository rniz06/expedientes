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
        Schema::create('ciudadanos', function (Blueprint $table) {
            $table->id('id_ciudadano');
            $table->string('nombres', 50);
            $table->string('apellidos', 50)->nullable();
            $table->string('nombre_completo', 100)->nullable();
            $table->string('ci', 15)->unique();
            $table->string('ruc', 20)->unique()->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('direccion_particular', 70)->nullable();
            $table->enum('tipo_persona', ['PERSONA FÍSICA', 'PERSONA JURÍDICA']);
            $table->unsignedBigInteger('barrio_id')->nullable();
            $table->unsignedBigInteger('ciudad_id')->nullable();
            $table->timestamps();

            $table->foreign('barrio_id')->references('id_barrio')->on('ciudades_barrios')->onDelete('set null');
            $table->foreign('ciudad_id')->references('id_ciudad')->on('ciudades')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ciudadanos');
    }
};
