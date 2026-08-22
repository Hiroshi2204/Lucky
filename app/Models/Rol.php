<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'rol';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'estado_registro',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function usuarios()
    {
        return $this->hasMany(
            \App\User::class,
            'rol_id'
        );
    }
}