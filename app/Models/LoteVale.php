<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LoteVale extends Model
{
    protected $table = 'lotes_vales';

    protected $fillable = [
        'numero_inicial',
        'numero_final',
        'fecha_recepcion',
        'periodo_id',
        'tipo_combustible_id',
        'estacion_servicio_id',
        'estado',
    ];

    protected $casts = [
        'fecha_recepcion' => 'date',
        'estado' => 'boolean',
    ];

    public function periodo(): BelongsTo
    {
        return $this->belongsTo(Periodo::class, 'periodo_id');
    }

    public function tipoCombustible(): BelongsTo
    {
        return $this->belongsTo(
            TipoCombustible::class,
            'tipo_combustible_id'
        );
    }

    public function estacionServicio(): BelongsTo
    {
        return $this->belongsTo(
            EstacionServicio::class,
            'estacion_servicio_id'
        );
    }

    public function valesCombustible(): HasMany
    {
        return $this->hasMany(ValeCombustible::class, 'lote_vale_id');
    }
}