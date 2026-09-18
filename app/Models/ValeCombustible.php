<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ValeCombustible extends Model
{
    protected $table = 'vales_combustible';

    protected $fillable = [
        'numero_vale',
        'fecha',
        'lote_vale_id',
        'vehiculo_id',
        'apertura_programatica_id',
        'usuario_id',
        'numero_factura',
        'cantidad_litros',
        'precio_unitario',
        'total',
        'kilometraje',
        'observacion',
    ];

    protected $casts = [
        'fecha' => 'date',
        'cantidad_litros' => 'decimal:4',
        'precio_unitario' => 'decimal:4',
        'total' => 'decimal:2',
        'kilometraje' => 'integer',
    ];

    public function loteVale(): BelongsTo
    {
        return $this->belongsTo(LoteVale::class, 'lote_vale_id');
    }

    public function vehiculo(): BelongsTo
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
    }

    public function aperturaProgramatica(): BelongsTo
    {
        return $this->belongsTo(
            AperturaProgramatica::class,
            'apertura_programatica_id'
        );
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}