<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'codigo',
        'descripcion',
        'espesor',
        'estado',
    ];

    protected $casts = [
        'espesor' => 'decimal:2',
        'estado' => 'boolean',
    ];
    protected $appends = [
        'stock_actual',
    ];

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }

    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class);
    }

    public function getStockActualAttribute()
    {
        $entradas = $this->movimientos()
            ->where('tipo', 'ENTRADA')
            ->sum('cantidad');

        $salidas = $this->movimientos()
            ->where('tipo', 'SALIDA')
            ->sum('cantidad');

        return (float) $entradas - (float) $salidas;
    }
}