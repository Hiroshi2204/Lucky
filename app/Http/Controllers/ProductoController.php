<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // public function index()
    // {
    //     $productos = Producto::with('movimientos')
    //         ->orderBy('id', 'desc')
    //         ->paginate(20);

    //     $productos->getCollection()->transform(function ($producto) {

    //         $producto->stock_actual = $producto->stock_actual;

    //         return $producto;
    //     });

    //     return response()->json([
    //         'success' => true,
    //         'data' => $productos
    //     ]);
    // }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'codigo' => 'required|string|max:100|unique:productos,codigo',
    //         'descripcion' => 'required|string|max:255',
    //         'espesor' => 'required|numeric|min:0',
    //         'estado' => 'nullable|boolean',
    //     ]);

    //     $producto = Producto::create($validated);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Producto creado correctamente.',
    //         'data' => $producto
    //     ], 201);
    // }

    // public function show(Producto $producto)
    // {
    //     $producto->load('movimientos');

    //     return response()->json([
    //         'success' => true,
    //         'data' => [
    //             'producto' => $producto,
    //             'stock_actual' => $producto->stock_actual
    //         ]
    //     ]);
    // }

    // public function update(Request $request, Producto $producto)
    // {
    //     $validated = $request->validate([
    //         'codigo' => 'required|string|max:100|unique:productos,codigo,' . $producto->id,
    //         'descripcion' => 'required|string|max:255',
    //         'espesor' => 'required|numeric|min:0',
    //         'estado' => 'nullable|boolean',
    //     ]);

    //     $producto->update($validated);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Producto actualizado correctamente.',
    //         'data' => $producto
    //     ]);
    // }

    // public function destroy(Producto $producto)
    // {
    //     if ($producto->movimientos()->exists()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'No se puede eliminar el producto porque tiene movimientos registrados.'
    //         ], 422);
    //     }

    //     if ($producto->detalleVentas()->exists()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'No se puede eliminar el producto porque tiene ventas registradas.'
    //         ], 422);
    //     }

    //     $producto->delete();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Producto eliminado correctamente.'
    //     ]);
    // }

    // public function buscar(Request $request)
    // {
    //     $request->validate([
    //         'q' => 'required|string|min:1'
    //     ]);

    //     $texto = $request->q;

    //     $productos = Producto::where('estado', true)
    //         ->where(function ($query) use ($texto) {

    //             $query->where(
    //                 'codigo',
    //                 'like',
    //                 "%{$texto}%"
    //             )
    //                 ->orWhere(
    //                     'descripcion',
    //                     'like',
    //                     "%{$texto}%"
    //                 );
    //         })
    //         ->limit(30)
    //         ->get();

    //     $productos->transform(function ($producto) {

    //         $producto->stock_actual =
    //             $producto->stock_actual;

    //         return $producto;
    //     });

    //     return response()->json([
    //         'success' => true,
    //         'data' => $productos
    //     ]);
    // }

    // public function stock(Producto $producto)
    // {
    //     return response()->json([
    //         'success' => true,
    //         'data' => [
    //             'producto_id' => $producto->id,
    //             'codigo' => $producto->codigo,
    //             'descripcion' => $producto->descripcion,
    //             'stock_actual' => $producto->stock_actual
    //         ]
    //     ]);
    // }

    /**
     * LISTAR PRODUCTOS
     */
    public function index(Request $request)
    {
        $query = Producto::query();

        /*
        |--------------------------------------------------------------------------
        | BÚSQUEDA
        |--------------------------------------------------------------------------
        */

        if ($request->filled('buscar')) {

            $buscar = $request->buscar;

            $query->where(function ($q) use ($buscar) {

                $q->where('codigo', 'LIKE', "%{$buscar}%")
                    ->orWhere('descripcion', 'LIKE', "%{$buscar}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | ESTADO
        |--------------------------------------------------------------------------
        */

        if ($request->has('estado')) {

            $query->where(
                'estado',
                $request->estado
            );
        }

        /*
        |--------------------------------------------------------------------------
        | ORDEN
        |--------------------------------------------------------------------------
        */

        $productos = $query
            ->orderBy('codigo')
            ->paginate(20)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | API
        |--------------------------------------------------------------------------
        */

        if ($request->expectsJson()) {

            return response()->json([
                'success' => true,
                'data' => $productos
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | BLADE
        |--------------------------------------------------------------------------
        */

        return view(
            'productos.index',
            compact('productos')
        );
    }


    /**
     * FORMULARIO PARA CREAR PRODUCTO
     */
    public function create()
    {
        return view('productos.create');
    }


    /**
     * GUARDAR PRODUCTO
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'codigo' => [
                'required',
                'string',
                'max:100',
                'unique:productos,codigo'
            ],

            'descripcion' => [
                'required',
                'string',
                'max:255'
            ],

            'espesor' => [
                'required',
                'numeric',
                'min:0'
            ],

        ], [

            'codigo.required' =>
            'El código del producto es obligatorio.',

            'codigo.unique' =>
            'El código del producto ya existe.',

            'descripcion.required' =>
            'La descripción es obligatoria.',

            'espesor.required' =>
            'El espesor es obligatorio.',

            'espesor.numeric' =>
            'El espesor debe ser numérico.',

            'espesor.min' =>
            'El espesor no puede ser negativo.',
        ]);


        $producto = Producto::create([

            'codigo' =>
            $validated['codigo'],

            'descripcion' =>
            $validated['descripcion'],

            'espesor' =>
            $validated['espesor'],

            'estado' =>
            true,

        ]);


        /*
        |--------------------------------------------------------------------------
        | API
        |--------------------------------------------------------------------------
        */

        if ($request->expectsJson()) {

            return response()->json([

                'success' => true,

                'message' =>
                'Producto registrado correctamente.',

                'data' =>
                $producto

            ], 201);
        }


        /*
        |--------------------------------------------------------------------------
        | BLADE
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('productos.index')
            ->with(
                'success',
                'Producto registrado correctamente.'
            );
    }


    /**
     * MOSTRAR PRODUCTO
     */
    public function show(Request $request, Producto $producto)
    {

        $stock = $producto->stock_actual;

        $movimientos = $producto->movimientos()
            ->orderBy('fecha', 'desc')
            ->get();

        if ($request->expectsJson()) {

            return response()->json([

                'success' => true,

                'data' => [

                    'id' => $producto->id,

                    'codigo' => $producto->codigo,

                    'descripcion' => $producto->descripcion,

                    'espesor' => $producto->espesor,

                    'estado' => $producto->estado,

                    'stock_actual' => $stock,

                    'movimientos' => $movimientos,

                ]

            ]);
        }


        return view(
            'productos.show',
            compact(
                'producto',
                'stock',
                'movimientos'
            )
        );
    }


    /**
     * FORMULARIO PARA EDITAR
     */
    public function edit(Producto $producto)
    {
        return view(
            'productos.edit',
            compact('producto')
        );
    }


    /**
     * ACTUALIZAR PRODUCTO
     */
    public function update(Request $request, Producto $producto)
    {

        $validated = $request->validate([

            'codigo' => [
                'required',
                'string',
                'max:100',
                'unique:productos,codigo,' .
                    $producto->id
            ],

            'descripcion' => [
                'required',
                'string',
                'max:255'
            ],

            'espesor' => [
                'required',
                'numeric',
                'min:0'
            ],

        ]);


        $producto->update([

            'codigo' =>
            $validated['codigo'],

            'descripcion' =>
            $validated['descripcion'],

            'espesor' =>
            $validated['espesor'],

        ]);


        /*
        |--------------------------------------------------------------------------
        | API
        |--------------------------------------------------------------------------
        */

        if ($request->expectsJson()) {

            return response()->json([

                'success' => true,

                'message' =>
                'Producto actualizado correctamente.',

                'data' =>
                $producto

            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | BLADE
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('productos.index')
            ->with(
                'success',
                'Producto actualizado correctamente.'
            );
    }


    /**
     * DESACTIVAR PRODUCTO
     */
    public function destroy(Request $request, Producto $producto)
    {

        $producto->update([
            'estado' => false
        ]);

        if ($request->expectsJson()) {

            return response()->json([

                'success' => true,

                'message' =>
                'Producto desactivado correctamente.'

            ]);
        }

        return redirect()
            ->route('productos.index')
            ->with(
                'success',
                'Producto desactivado correctamente.'
            );
    }
    public function buscar(Request $request)
    {
        $codigo = $request->get('codigo');

        $productos = Producto::query()
            ->where('estado', true)
            ->where('codigo', 'LIKE', "%{$codigo}%")
            ->orderBy('codigo')
            ->limit(10)
            ->get();

        $productos->each(function ($producto) {

            $producto->stock_actual =
                $producto->stock_actual;
        });

        return response()->json([
            'success' => true,
            'data' => $productos
        ]);
    }
    /**
     * BUSCAR PRODUCTOS PARA VENTAS
     */
    public function buscarVenta(Request $request)
    {
        $buscar = trim(
            $request->get('buscar', '')
        );

        if ($buscar === '') {

            return response()->json([
                'success' => true,
                'data' => []
            ]);
        }

        $productos = Producto::query()

            ->where('estado', true)

            ->where(function ($query) use ($buscar) {

                $query->where(
                    'codigo',
                    'LIKE',
                    "%{$buscar}%"
                )

                    ->orWhere(
                        'descripcion',
                        'LIKE',
                        "%{$buscar}%"
                    );
            })

            ->orderBy('codigo')

            ->limit(10)

            ->get();

        $productos->each(function ($producto) {

            $producto->stock_actual =
                $producto->stock_actual;
        });

        return response()->json([

            'success' => true,

            'data' => $productos

        ]);
    }
}
