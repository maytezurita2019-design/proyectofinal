<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehiculo extends Model
{
    protected $table = 'vehiculos';

    protected $fillable = [
        'codigo',
        'placa',
        'tipo',
        'industria',
        'marca',
        'color',
        'unidad_id',
        'estado',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    public function unidad(): BelongsTo
    {
        return $this->belongsTo(Unidad::class, 'unidad_id');
    }

    public function valesCombustible(): HasMany
    {
        return $this->hasMany(ValeCombustible::class, 'vehiculo_id');
    }
}