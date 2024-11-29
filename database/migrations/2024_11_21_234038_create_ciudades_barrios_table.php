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
        Schema::create('ciudades_barrios', function (Blueprint $table) {
            $table->id('id_barrio');
            $table->string('barrio_nombre', 50);
            $table->unsignedBigInteger('barrio_ciudad_id')->nullable();
            $table->timestamps();

            $table->foreign('barrio_ciudad_id')->references('id_ciudad')->on('ciudades')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ciudades_barrios');
    }
};
