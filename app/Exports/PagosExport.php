<?php

namespace App\Exports;

use App\Models\Pago;
use App\Helpers\LocalHelper;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PagosExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize
{
    protected $fechaInicio;
    protected $fechaFin;
    protected $medioPago;

    public function __construct(
        $fechaInicio = null,
        $fechaFin = null,
        $medioPago = null
    ) {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->medioPago = $medioPago;
    }

    public function collection()
    {
        /*
        |--------------------------------------------------------------------------
        | LOCAL ACTUAL
        |--------------------------------------------------------------------------
        */

        $localId = LocalHelper::id();


        /*
        |--------------------------------------------------------------------------
        | CONSULTA
        |--------------------------------------------------------------------------
        |
        | Solo pagos pertenecientes a ventas:
        |
        | 1. ACTIVAS
        | 2. Del local actualmente seleccionado
        |
        */

        $query = Pago::with('venta')
            ->whereHas('venta', function ($q) use ($localId) {

                $q->where('estado', 'ACTIVA')
                    ->where('local_id', $localId);
            })
            ->orderBy('fecha', 'desc');


        /*
        |--------------------------------------------------------------------------
        | FILTRO FECHA INICIO
        |--------------------------------------------------------------------------
        */

        if ($this->fechaInicio) {

            $query->whereDate(
                'fecha',
                '>=',
                $this->fechaInicio
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTRO FECHA FIN
        |--------------------------------------------------------------------------
        */

        if ($this->fechaFin) {

            $query->whereDate(
                'fecha',
                '<=',
                $this->fechaFin
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTRO MEDIO DE PAGO
        |--------------------------------------------------------------------------
        */

        if ($this->medioPago) {

            $query->where(
                'medio_pago',
                $this->medioPago
            );
        }


        /*
        |--------------------------------------------------------------------------
        | RETORNAR PAGOS
        |--------------------------------------------------------------------------
        */

        return $query->get();
    }


    public function headings(): array
    {
        return [
            'ID Pago',
            'N.º Venta',
            'Fecha',
            'Medio de Pago',
            'Monto',
            'Observación',
        ];
    }


    public function map($pago): array
    {
        return [
            $pago->id,

            $pago->venta_id,

            optional($pago->fecha)->format('d/m/Y H:i'),

            $pago->medio_pago === 'OTRO'
                ? ($pago->medio_pago_otro ?: 'OTRO')
                : $pago->medio_pago,

            $pago->monto,

            $pago->observacion ?? '',
        ];
    }
}
