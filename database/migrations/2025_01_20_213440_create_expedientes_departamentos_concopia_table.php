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
        Schema::create('expedientes_departamentos_concopia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expediente_id');
            $table->unsignedBigInteger('departamento_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('expediente_id')->references('id_expediente')->on('expedientes')->onUpdate('cascade')->onDelete('cascade');                                                    
            $table->foreign('departamento_id')->references('id_departamento')->on('departamentos')->onUpdate('cascade')->onDelete('cascade');                                                    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expedientes_departamentos_concopia');
    }
};
