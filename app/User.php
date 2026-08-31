<?php

namespace App;

use App\Models\Local;
use App\Models\Movimiento;
use App\Models\Pago;
use App\Models\Persona;
use App\Models\Rol;
use App\Models\Venta;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use App\Models\Auditoria;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'password',
        'persona_id',
        'rol_id',
        'estado_registro',
        'must_change_password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
        'email_verified_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'estado_registro' => 'boolean',
        'must_change_password' => 'boolean',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    public function locales()
    {
        return $this->belongsToMany(
            Local::class,
            'usuario_local',
            'user_id',
            'local_id'
        )
            ->withPivot('estado')
            ->withTimestamps();
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class, 'user_id');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'user_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'user_id');
    }

    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    public function auditorias()
    {
        return $this->hasMany(Auditoria::class, 'user_id');
    }
}
