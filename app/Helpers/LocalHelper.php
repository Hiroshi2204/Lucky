<?php

namespace App\Helpers;

use App\Models\Local;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LocalHelper
{
    /**
     * Obtener ID del local actual.
     */
    public static function id()
    {
        // Primero intentamos obtener el local de la sesión
        $localId = session('local_id');

        if ($localId) {
            return $localId;
        }

        // Si no existe sesión, buscamos el local asignado al usuario
        if (!Auth::check()) {
            return null;
        }

        $localId = DB::table('usuario_local')
            ->where('user_id', Auth::id())
            ->where('estado', true)
            ->value('local_id');

        // Guardamos automáticamente el local en sesión
        if ($localId) {
            session([
                'local_id' => $localId
            ]);
        }

        return $localId;
    }


    /**
     * Obtener el local actual.
     */
    public static function actual()
    {
        $localId = self::id();

        if (!$localId) {
            return null;
        }

        return Local::find($localId);
    }


    /**
     * Obtener nombre del local actual.
     */
    public static function nombre()
    {
        return self::actual()?->nombre;
    }
}