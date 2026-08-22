<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioLocal extends Model
{
    use HasFactory;

    protected $table = 'usuario_local';

    protected $fillable = [
        'user_id',
        'local_id',
        'estado',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    public function usuario()
    {
        return $this->belongsTo(
            \App\User::class,
            'user_id'
        );
    }

    public function local()
    {
        return $this->belongsTo(
            Local::class,
            'local_id'
        );
    }
}