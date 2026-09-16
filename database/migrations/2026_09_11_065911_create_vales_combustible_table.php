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

            $table->unsignedBigInteger('numero_vale');

            $table->foreignId('vehiculo_id')
                ->constrained('vehiculos')
                ->restrictOnDelete();

            $table->foreignId('apertura_programatica_id')
                ->constrained('aperturas_programaticas')
                ->restrictOnDelete();

            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->date('fecha');

            $table->decimal('cantidad_litros', 12, 4)
                ->nullable();

            $table->decimal('precio_unitario', 12, 2)
                ->nullable();

            $table->decimal('costo_total', 14, 2)
                ->nullable();

            $table->string('numero_factura', 100)
                ->nullable();

            $table->decimal('kilometraje', 14, 2)
                ->nullable();

            $table->text('detalle')
                ->nullable();

            $table->text('observacion')
                ->nullable();

            $table->boolean('estado')
                ->default(true);

            $table->timestamps();

            $table->unique([
                'vehiculo_id',
                'numero_vale'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vales_combustible');
    }
};