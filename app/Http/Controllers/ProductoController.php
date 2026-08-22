<?php

namespace App\Http\Controllers;

use App\Helpers\LocalHelper;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Auditoria;

class ProductoController extends Controller
{
    /**
     * LISTAR PRODUCTOS
     */
    public function index(Request $request)
    {
        $localId = LocalHelper::id();

        $query = Producto::where('local_id', $localId);

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
        $localId = LocalHelper::id();

        $validated = $request->validate([

            'codigo' => [
                'required',
                'string',
                'max:100',
                Rule::unique('productos', 'codigo')
                    ->where(function ($query) use ($localId) {
                        return $query->where('local_id', $localId);
                    }),
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
            'El código del producto ya existe en este local.',

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

            'local_id' =>
            $localId,

            'codigo' =>
            $validated['codigo'],

            'descripcion' =>
            $validated['descripcion'],

            'espesor' =>
            $validated['espesor'],

            'estado' =>
            true,

        ]);

        Auditoria::registrar(
            'CREAR',
            'productos',
            $producto->id,
            'Creó el producto ' . $producto->codigo,
            null,
            $producto->toArray()
        );

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
        if ($producto->local_id != LocalHelper::id()) {
            abort(404);
        }

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
        if ($producto->local_id != LocalHelper::id()) {
            abort(404);
        }

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
        $localId = LocalHelper::id();

        if ($producto->local_id != $localId) {
            abort(404);
        }

        $validated = $request->validate([

            'codigo' => [
                'required',
                'string',
                'max:100',
                Rule::unique('productos', 'codigo')
                    ->where(function ($query) use ($localId) {
                        return $query->where('local_id', $localId);
                    })
                    ->ignore($producto->id),
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
            'El código del producto ya existe en este local.',

            'descripcion.required' =>
            'La descripción es obligatoria.',

            'espesor.required' =>
            'El espesor es obligatorio.',

            'espesor.numeric' =>
            'El espesor debe ser numérico.',

            'espesor.min' =>
            'El espesor no puede ser negativo.',
        ]);

        $datosAnteriores = $producto->toArray();
        $producto->update([

            'codigo' =>
            $validated['codigo'],

            'descripcion' =>
            $validated['descripcion'],

            'espesor' =>
            $validated['espesor'],

        ]);

        $datosNuevos = $producto->fresh()->toArray();

        Auditoria::registrar(
            'MODIFICAR',
            'productos',
            $producto->id,
            'Modificó el producto ' . $producto->codigo,
            $datosAnteriores,
            $datosNuevos
        );

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
        if ($producto->local_id != LocalHelper::id()) {
            abort(404);
        }

        $datosAnteriores = $producto->toArray();
        $producto->update([
            'estado' => false
        ]);

        Auditoria::registrar(
            'DESACTIVAR',
            'productos',
            $producto->id,
            'Desactivó el producto ' . $producto->codigo,
            $datosAnteriores,
            $producto->fresh()->toArray()
        );

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


    /**
     * BUSCAR PRODUCTOS POR CÓDIGO
     */
    public function buscar(Request $request)
    {
        $codigo = $request->get('codigo');

        $productos = Producto::query()
            ->where('local_id', LocalHelper::id())
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
    // public function buscarjson(Request $request)
    // {
    //     $localId = LocalHelper::id();

    //     return response()->json([
    //         'debug' => [
    //             'local_helper' => $localId,
    //             'session' => session('local_id'),
    //             'user_id' => auth()->id(),
    //             'username' => auth()->user()?->username,
    //         ],

    //         'productos' => Producto::where(
    //             'codigo',
    //             'LIKE',
    //             '%' . $request->codigo . '%'
    //         )->get([
    //             'id',
    //             'codigo',
    //             'descripcion',
    //             'espesor',
    //             'local_id',
    //             'estado'
    //         ])
    //     ]);
    // }


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

            ->where('local_id', LocalHelper::id())

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
