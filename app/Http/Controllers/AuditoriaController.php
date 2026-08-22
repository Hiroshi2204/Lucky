<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Helpers\LocalHelper;
use Illuminate\Http\Request;

class AuditoriaController extends Controller
{
    /**
     * LISTAR AUDITORÍAS
     */
    public function index(Request $request)
    {
        $localId = LocalHelper::id();

        $query = Auditoria::with('usuario')
            ->where(function ($q) use ($localId) {
                $q->where('local_id', $localId)
                    ->orWhereNull('local_id');
            })
            ->orderBy('created_at', 'desc');

        /*
        |--------------------------------------------------------------------------
        | FILTRAR POR ACCIÓN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('accion')) {
            $query->where('accion', $request->accion);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTRAR POR TABLA / MÓDULO
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tabla')) {
            $query->where('tabla', $request->tabla);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTRAR POR USUARIO
        |--------------------------------------------------------------------------
        */

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTRAR FECHA INICIO
        |--------------------------------------------------------------------------
        */

        if ($request->filled('fecha_inicio')) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->fecha_inicio
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTRAR FECHA FIN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('fecha_fin')) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->fecha_fin
            );
        }

        /*
        |--------------------------------------------------------------------------
        | BUSCAR
        |--------------------------------------------------------------------------
        */

        if ($request->filled('buscar')) {

            $buscar = $request->buscar;

            $query->where(function ($q) use ($buscar) {

                $q->where('descripcion', 'LIKE', "%{$buscar}%")
                    ->orWhere('ip', 'LIKE', "%{$buscar}%")
                    ->orWhere('registro_id', 'LIKE', "%{$buscar}%");
            });
        }

        $auditorias = $query
            ->paginate(30)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | DATOS PARA FILTROS
        |--------------------------------------------------------------------------
        */

        $usuarios = \App\User::whereHas('auditorias')
            ->orderBy('username')
            ->get();

        $acciones = Auditoria::where(function ($q) use ($localId) {
                $q->where('local_id', $localId)
                    ->orWhereNull('local_id');
            })
            ->select('accion')
            ->distinct()
            ->orderBy('accion')
            ->pluck('accion');

        $tablas = Auditoria::where(function ($q) use ($localId) {
                $q->where('local_id', $localId)
                    ->orWhereNull('local_id');
            })
            ->select('tabla')
            ->whereNotNull('tabla')
            ->distinct()
            ->orderBy('tabla')
            ->pluck('tabla');

        /*
        |--------------------------------------------------------------------------
        | API
        |--------------------------------------------------------------------------
        */

        if ($request->expectsJson()) {

            return response()->json([
                'success' => true,
                'data' => $auditorias
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | VISTA
        |--------------------------------------------------------------------------
        */

        return view(
            'auditorias.index',
            compact(
                'auditorias',
                'usuarios',
                'acciones',
                'tablas'
            )
        );
    }


    /**
     * MOSTRAR DETALLE DE UNA AUDITORÍA
     */
    public function show(Request $request, Auditoria $auditoria)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDAR LOCAL
        |--------------------------------------------------------------------------
        */

        $localId = LocalHelper::id();

        if (
            $auditoria->local_id !== null &&
            $auditoria->local_id != $localId
        ) {
            abort(404);
        }

        $auditoria->load('usuario', 'local');

        /*
        |--------------------------------------------------------------------------
        | API
        |--------------------------------------------------------------------------
        */

        if ($request->expectsJson()) {

            return response()->json([
                'success' => true,
                'data' => $auditoria
            ]);
        }

        return view(
            'auditorias.show',
            compact('auditoria')
        );
    }
}