<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    protected $table = 'movimientos';

    protected $fillable = [
        'producto_id',
        'tipo',
        'cantidad',
        'fecha',
        'observacion',
    ];

    protected $casts = [
        'cantidad' => 'decimal:3',
        'fecha' => 'datetime',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}