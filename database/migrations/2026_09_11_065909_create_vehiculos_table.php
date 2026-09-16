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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();

            $table->string('codigo', 50)->unique();
            $table->string('placa', 20)->unique();

            $table->string('tipo_vehiculo', 100)->nullable();
            $table->string('industria', 100)->nullable();
            $table->string('marca', 100)->nullable();
            $table->string('color', 50)->nullable();

            $table->boolean('presenta_parte_diario')->default(false);
            $table->boolean('estado')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};