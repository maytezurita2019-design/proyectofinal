<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periodos', function (Blueprint $table) {
            $table->id();

            $table->unsignedTinyInteger('mes');
            $table->unsignedSmallInteger('gestion');

            $table->date('fecha_inicio');
            $table->date('fecha_fin');

            $table->boolean('estado')->default(true);

            $table->timestamps();

            $table->unique(['mes', 'gestion']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periodos');
    }
};
