<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Servicio extends Model
{
    protected $fillable = [
        'nombre',
        'categoria',
        'descripcion',
        'precio_base',
        'imagen',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'precio_base' => 'decimal:2',
            'activo' => 'boolean',
        ];
    }

    public function clientes(): HasMany
{
    return $this->hasMany(Cliente::class);
}
}