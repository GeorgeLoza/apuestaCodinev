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
        Schema::create('pronosticos', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained();

            $table->foreignId('partido_id')
                ->constrained('partidos');

            $table->unsignedTinyInteger('goles_local');

            $table->unsignedTinyInteger('goles_visitante');

            $table->unsignedTinyInteger('puntos')
                ->default(0);

            $table->string('resultado')
                ->nullable();

            $table->timestamps();

            $table->unique([
                'user_id',
                'partido_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('predictions');
    }
};
