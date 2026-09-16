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

            $table->unsignedInteger('numero_inicial');
            $table->unsignedInteger('numero_final');
            $table->unsignedInteger('cantidad_vales');

            $table->date('fecha_registro');

            $table->foreignId('usuario_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->boolean('estado')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lotes_vales');
    }
};
