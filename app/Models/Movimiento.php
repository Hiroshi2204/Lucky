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
        'user_id',
        'local_id',
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

    public function usuario()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function local()
    {
        return $this->belongsTo(Local::class);
    }
}
