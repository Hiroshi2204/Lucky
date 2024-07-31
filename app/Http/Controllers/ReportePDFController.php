<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\RegistroEntradaDetalle;
use App\Models\RegistroSalidaDetalle;
use App\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportePDFController extends Controller
{
    public function reporte_equipos_entrada()
    {
        $productos = RegistroEntradaDetalle::with('producto', 'registro_entrada.proveedor')->get();
        //return response()->json($productos);
        $datos = [];

        foreach ($productos as $producto) {
            $precio = $producto->precio ?? null;
            $nom_producto = $producto->producto->nom_producto ?? null;
            $cod_producto = $producto->producto->cod_producto ?? null;
            $lote = $producto->producto->lote ?? null;
            $largo = $producto->largo ?? null;
            $fecha_entrada = $producto->registro_entrada->fecha_entrada ?? null;

            $datos[] = [
                "precio" => $precio ?? null,
                "nom_producto" => $nom_producto ?? null,
                "cod_producto" => $cod_producto ?? null,
                "lote" => $lote ?? null,
                "largo" => $largo ?? null,
                "fecha_entrada" => $fecha_entrada ?? null,
            ];
        }

        $pdf = Pdf::loadView('entrada_equipos', compact('datos'));
        return $pdf->stream('entrada_equipos.pdf');
    }
    public function reporte_equipos_stock()
    {
        $productos = Producto::with('color')
            ->where('estado_registro', 'A')
            ->get();

        $datos = [];

        foreach ($productos as $producto) {
            $nom_producto = $producto->nom_producto ?? null;
            $cod_producto = $producto->cod_producto ?? null;
            $largo = $producto->largo ?? null;
            $lote = $producto->lote ?? null;
            $espesor = $producto->espesor ?? null;
            $color = $producto->color->nombre ?? null;

            $datos[] = [
                "nom_producto" => $nom_producto ?? null,
                "cod_producto" => $cod_producto ?? null,
                "largo" => $largo ?? null,
                "lote" => $lote ?? null,
                "espesor" => $espesor ?? null,
                "color" => $color ?? null,
            ];
        }

        $pdf = Pdf::loadView('stock_equipos', compact('datos'));
        return $pdf->stream('stock_equipos');
    }
    public function reporte_equipos_precio()
    {
        $productos = Producto::with('color', 'registro_entreda_detalle', 'registro_salida_detalle')->where('estado_registro', 'A')->get();
        $datos = [];

        foreach ($productos as $producto) {

            $nom_producto = $producto->nom_producto ?? null;
            $cod_producto = $producto->cod_producto ?? null;
            $color = $producto->color->nombre ?? null;
            $largo = 0;
            $precio_total = 0;
            $ganancia_total = 0;

            if ($producto->registro_salida_detalle) {
                foreach ($producto->registro_salida_detalle as $detalle) {
                    $largo = $detalle->largo;
                    $ganancia_total = $detalle->largo * $detalle->precio;
                    $precio_total = $detalle->precio;
                }
            }

            $datos[] = [
                "nom_producto" => $nom_producto ?? null,
                "cod_producto" => $cod_producto ?? null,
                "color" => $color ?? null,
                "largo" => $largo ?? null,
                "precio_total" => $precio_total ?? null,
                "ganancia_total" => $ganancia_total ?? null,
            ];
        }

        $pdf = Pdf::loadView('stock_precio', compact('datos'));
        return $pdf->stream('stock_precio');
    }
    public function reporte_equipos_salida()
    {
        $productos = RegistroSalidaDetalle::with('producto', 'registro_salida.destinatario')->get();

        $datos = [];

        foreach ($productos as $producto) {
            $precio = $producto->precio ?? null;
            $nom_producto = $producto->producto->nom_producto ?? null;
            $cod_producto = $producto->producto->cod_producto ?? null;
            $lote = $producto->producto->lote ?? null;
            $largo = $producto->largo ?? null;
            $fecha_salida = $producto->registro_salida->fecha_salida ?? null;

            $datos[] = [
                "precio" => $precio ?? null,
                "nom_producto" => $nom_producto ?? null,
                "cod_producto" => $cod_producto ?? null,
                "lote" => $lote ?? null,
                "largo" => $largo ?? null,
                "fecha_salida" => $fecha_salida ?? null,
            ];
        }

        $pdf = Pdf::loadView('salida_equipos', compact('datos'));
        return $pdf->stream('salida_equipos');
    }
}
