<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pago;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';

    protected $fillable = [
        'user_id',
        'local_id',
        'estado',
        'fecha',
        'total',
        'descuento',
        'medio_pago',
        'medio_pago_otro',
        'estado_pago',
        'monto_pagado',
        'saldo_pendiente',
        'observacion',
    ];

    protected $casts = [
        'fecha' => 'datetime',
        'total' => 'decimal:2',
        'descuento' => 'decimal:2',
        'monto_pagado' => 'decimal:2',
        'saldo_pendiente' => 'decimal:2',
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class);
    }
    public function pagos()
    {
        return $this->hasMany(Pago::class);
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
