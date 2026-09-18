<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 30)->unique();
            $table->string('placa', 20)->unique();
            $table->string('tipo', 100)->nullable();
            $table->string('industria', 100)->nullable();
            $table->string('marca', 100)->nullable();
            $table->string('color', 50)->nullable();

            $table->foreignId('unidad_id')
                ->constrained('unidades')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};