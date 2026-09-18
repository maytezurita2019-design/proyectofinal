<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lotes_vales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('numero_inicial');
            $table->unsignedBigInteger('numero_final');
            $table->date('fecha_recepcion');

            $table->foreignId('periodo_id')
                ->constrained('periodos')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('tipo_combustible_id')
                ->constrained('tipos_combustible')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('estacion_servicio_id')
                ->constrained('estaciones_servicio')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lotes_vales');
    }
};