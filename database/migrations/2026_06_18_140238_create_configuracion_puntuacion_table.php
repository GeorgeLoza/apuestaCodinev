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
        Schema::create('configuracion_puntuacion', function (Blueprint $table) {

            $table->id();

            $table->unsignedTinyInteger('puntos_exacto')
                ->default(3);

            $table->unsignedTinyInteger('puntos_ganador')
                ->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracion_puntuacion');
    }
};
