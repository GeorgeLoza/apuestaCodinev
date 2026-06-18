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
        Schema::create('partidos', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('api_id')
                ->unique();

            $table->foreignId('torneo_id')
                ->constrained('torneos');

            $table->foreignId('equipo_local_id')
                ->nullable()
                ->constrained('equipos');

            $table->foreignId('equipo_visitante_id')
                ->nullable()
                ->constrained('equipos');
            $table->string('local_label')
                ->nullable();

            $table->string('visitante_label')
                ->nullable();

            $table->string('grupo')
                ->nullable();

            $table->integer('jornada')
                ->nullable();

            $table->string('tipo');

            $table->dateTime('fecha_partido');

            $table->dateTime('fecha_cierre_apuestas');

            $table->integer('goles_local')
                ->nullable();

            $table->integer('goles_visitante')
                ->nullable();

            $table->string('estado')
                ->default('programado');

            $table->boolean('bloqueado')
                ->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
