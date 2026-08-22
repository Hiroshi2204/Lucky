<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    use HasFactory;

    protected $table = 'locales';

    protected $fillable = [
        'codigo',
        'nombre',
        'direccion',
        'telefono',
        'estado',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class,'local_id');
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    public function usuarios()
    {
        return $this->belongsToMany(
            \App\User::class,
            'usuario_local',
            'local_id',
            'user_id'
        )->withPivot('estado')->withTimestamps();
    }
}