<?php

namespace App\Http\Controllers;

use App\Imports\EntradasImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlantillaEntradasExport;

class ImportacionController extends Controller
{
    public function entradas(Request $request)
    {
        $request->validate([
            'archivo' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:10240',
            ],
        ], [
            'archivo.required' =>
            'Debe seleccionar un archivo Excel.',

            'archivo.file' =>
            'El archivo enviado no es válido.',

            'archivo.mimes' =>
            'El archivo debe ser Excel (.xlsx, .xls) o CSV.',

            'archivo.max' =>
            'El archivo no puede superar los 10 MB.',
        ]);

        $import = new EntradasImport();

        Excel::import(
            $import,
            $request->file('archivo')
        );

        return view(
            'entradas.importar-resultado',
            [
                'import' => $import,
            ]
        );
    }

    public function plantillaEntradas()
    {
        return Excel::download(
            new PlantillaEntradasExport(),
            'plantilla_importacion_productos.xlsx'
        );
    }
}
