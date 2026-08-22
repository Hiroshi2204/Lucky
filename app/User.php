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
    ];

    /*
    |--------------------------------------------------------------------------
    | JWT
    |--------------------------------------------------------------------------
    */

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    | Persona
    |--------------------------------------------------------------------------
    */

    public function persona()
    {
        return $this->belongsTo(
            Persona::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Rol
    |--------------------------------------------------------------------------
    */

    public function rol()
    {
        return $this->belongsTo(
            Rol::class,
            'rol_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Locales
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | Movimientos
    |--------------------------------------------------------------------------
    */

    public function movimientos()
    {
        return $this->hasMany(
            Movimiento::class,
            'user_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Ventas
    |--------------------------------------------------------------------------
    */

    public function ventas()
    {
        return $this->hasMany(
            Venta::class,
            'user_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Pagos
    |--------------------------------------------------------------------------
    */

    public function pagos()
    {
        return $this->hasMany(
            Pago::class,
            'user_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Password
    |--------------------------------------------------------------------------
    */

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
