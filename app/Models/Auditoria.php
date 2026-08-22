<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    protected $table = 'auditorias';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'local_id',
        'accion',
        'tabla',
        'registro_id',
        'descripcion',
        'datos_anteriores',
        'datos_nuevos',
        'ip',
        'user_agent',
        'created_at',
    ];

    protected $casts = [
        'datos_anteriores' => 'array',
        'datos_nuevos' => 'array',
        'created_at' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function local()
    {
        return $this->belongsTo(Local::class, 'local_id');
    }

    public static function registrar(
        string $accion,
        ?string $tabla = null,
        ?int $registroId = null,
        ?string $descripcion = null,
        ?array $datosAnteriores = null,
        ?array $datosNuevos = null
    ) {
        return self::create([

            'user_id' =>
            auth()->id(),

            'local_id' =>
            \App\Helpers\LocalHelper::id(),

            'accion' =>
            $accion,

            'tabla' =>
            $tabla,

            'registro_id' =>
            $registroId,

            'descripcion' =>
            $descripcion,

            'datos_anteriores' =>
            $datosAnteriores,

            'datos_nuevos' =>
            $datosNuevos,

            'ip' =>
            request()->ip(),

            'user_agent' =>
            request()->userAgent(),

            'created_at' =>
            now(),

        ]);
    }
}
