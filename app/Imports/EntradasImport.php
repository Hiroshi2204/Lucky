<?php

namespace App\Imports;

use App\Models\Producto;
use App\Models\Movimiento;
use App\Helpers\LocalHelper;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class EntradasImport implements ToCollection, WithHeadingRow
{
    public int $procesadas = 0;
    public int $exitosas = 0;
    public int $errores = 0;

    public array $resultado = [];

    public function collection(Collection $rows)
    {
        /*
         * ==========================================================
         * LOCAL ACTIVO
         * ==========================================================
         */

        $localId = LocalHelper::id();

        if (!$localId) {
            throw new \Exception(
                'No hay un local seleccionado.'
            );
        }

        foreach ($rows as $index => $row) {

            $fila = $index + 2;

            $codigo = trim((string) ($row['codigo'] ?? ''));
            $descripcion = trim((string) ($row['descripcion'] ?? ''));
            $espesor = $row['espesor'] ?? null;
            $cantidad = $row['cantidad'] ?? null;

            $this->procesadas++;

            /*
             * =====================================================
             * VALIDACIONES
             * =====================================================
             */

            if ($codigo === '') {

                $this->registrarError(
                    $fila,
                    'El código es obligatorio.'
                );

                continue;
            }

            if ($descripcion === '') {

                $this->registrarError(
                    $fila,
                    'La descripción es obligatoria.',
                    $codigo
                );

                continue;
            }

            if (!is_numeric($espesor) || $espesor < 0) {

                $this->registrarError(
                    $fila,
                    'El espesor debe ser numérico y mayor o igual a 0.',
                    $codigo
                );

                continue;
            }

            if (!is_numeric($cantidad) || $cantidad <= 0) {

                $this->registrarError(
                    $fila,
                    'La cantidad debe ser numérica y mayor que 0.',
                    $codigo
                );

                continue;
            }

            try {

                $resultado = DB::transaction(function () use (
                    $codigo,
                    $descripcion,
                    $espesor,
                    $cantidad,
                    $fila,
                    $localId
                ) {

                    /*
                     * =================================================
                     * BUSCAR PRODUCTO SOLO EN EL LOCAL ACTIVO
                     * =================================================
                     */

                    $producto = Producto::where(
                        'codigo',
                        $codigo
                    )
                        ->where(
                            'local_id',
                            $localId
                        )
                        ->lockForUpdate()
                        ->first();

                    /*
                     * =================================================
                     * PRODUCTO NUEVO
                     * =================================================
                     */

                    if (!$producto) {

                        $producto = Producto::create([
                            'local_id' => $localId,
                            'codigo' => $codigo,
                            'descripcion' => $descripcion,
                            'espesor' => $espesor,
                            'estado' => true,
                        ]);

                        $mensaje =
                            'Producto creado y stock inicial registrado.';
                    } else {

                        /*
                         * =================================================
                         * PRODUCTO EXISTENTE
                         * =================================================
                         */

                        if (
                            (float) $producto->espesor
                            !==
                            (float) $espesor
                        ) {

                            throw new \Exception(
                                "El producto {$codigo} ya existe " .
                                    "en este local pero tiene un espesor diferente."
                            );
                        }

                        $mensaje =
                            'Producto existente. Stock agregado.';
                    }

                    /*
                     * =================================================
                     * REGISTRAR MOVIMIENTO EN EL LOCAL ACTIVO
                     * =================================================
                     */

                    Movimiento::create([
                        'local_id' => $localId,
                        'user_id' => auth()->id(),
                        'producto_id' => $producto->id,
                        'tipo' => 'ENTRADA',
                        'cantidad' => $cantidad,
                        'fecha' => now(),
                        'observacion' =>
                        'Importación Excel - fila ' . $fila,
                    ]);

                    return [
                        'fila' => $fila,
                        'codigo' => $codigo,
                        'estado' => 'OK',
                        'mensaje' => $mensaje,
                        'cantidad' => (float) $cantidad,
                    ];
                });

                /*
                 * =====================================================
                 * TRANSACCIÓN CORRECTA
                 * =====================================================
                 */

                $this->exitosas++;

                $this->resultado[] = $resultado;
            } catch (\Throwable $e) {

                $this->registrarError(
                    $fila,
                    $e->getMessage(),
                    $codigo
                );
            }
        }
    }

    private function registrarError(
        int $fila,
        string $mensaje,
        string $codigo = ''
    ): void {

        $this->errores++;

        $this->resultado[] = [
            'fila' => $fila,
            'codigo' => $codigo,
            'estado' => 'ERROR',
            'mensaje' => $mensaje,
        ];
    }
}
