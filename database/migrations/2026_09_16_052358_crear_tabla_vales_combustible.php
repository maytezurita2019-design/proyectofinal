<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vales_combustible', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('numero_vale')->unique();
            $table->date('fecha');

            $table->foreignId('lote_vale_id')
                ->constrained('lotes_vales')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('vehiculo_id')
                ->constrained('vehiculos')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('apertura_programatica_id')
                ->constrained('aperturas_programaticas')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('usuario_id')
                ->constrained('usuarios')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('numero_factura', 50)->nullable();

            $table->decimal('cantidad_litros', 12, 4);
            $table->decimal('precio_unitario', 12, 4);
            $table->decimal('total', 14, 2);

            $table->unsignedBigInteger('kilometraje')->nullable();

            $table->text('observacion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vales_combustible');
    }
};