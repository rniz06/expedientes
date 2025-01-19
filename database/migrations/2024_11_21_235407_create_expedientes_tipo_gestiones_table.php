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
        Schema::create('expedientes_tipo_gestiones', function (Blueprint $table) {
            $table->id('id_tipo_gestion');
            $table->string('tipo_gestion', 50);
            $table->string('descripcion', 100)->nullable();
            $table->string('tipo_y_descripcion', 150)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expedientes_tipo_gestiones');
    }
};
