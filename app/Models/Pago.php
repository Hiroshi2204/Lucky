<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';

    protected $fillable = [
        'venta_id',
        'user_id',
        'local_id',
        'monto',
        'medio_pago',
        'medio_pago_otro',
        'fecha',
        'observacion',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha' => 'datetime',
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
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
