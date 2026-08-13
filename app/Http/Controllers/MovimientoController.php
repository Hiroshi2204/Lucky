<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    public function index(Request $request)
    {
        $query = Movimiento::with('producto')
            ->orderBy('fecha', 'desc');

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('producto_id')) {
            $query->where(
                'producto_id',
                $request->producto_id
            );
        }

        if ($request->filled('fecha_inicio')) {
            $query->whereDate(
                'fecha',
                '>=',
                $request->fecha_inicio
            );
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate(
                'fecha',
                '<=',
                $request->fecha_fin
            );
        }

        return response()->json([
            'success' => true,
            'data' => $query->paginate(30)
        ]);
    }

    public function show(Movimiento $movimiento)
    {
        return response()->json([
            'success' => true,
            'data' => $movimiento->load('producto')
        ]);
    }
}
