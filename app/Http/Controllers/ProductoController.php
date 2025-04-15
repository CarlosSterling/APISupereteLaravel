<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::all();

        if ($productos->isEmpty()) {
            $data = [
                'message' => 'No hay productos disponibles',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        return response()->json($productos, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'         => 'required|string|max:255',
            'precio_compra'  => 'required|numeric|min:0',
            'precio_venta'   => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'categoria_id'   => 'required|exists:categorias,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al crear el producto',
                'status'  => 400,
                'errors'  => $validator->errors()
            ], 400);
        }

        $producto = Producto::create($request->only([
            'nombre',
            'precio_compra',
            'precio_venta',
            'stock',
            'categoria_id'
        ]));

        if (!$producto) {
            return response()->json([
                'message' => 'Error al crear el producto',
                'status'  => 500
            ], 500);
        }

        return response()->json([
            'message'  => 'Producto creado correctamente',
            'status'   => 201,
            'producto' => $producto
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            $data = [
                'message' => 'Producto no encontrado',
                'status'  => 404
            ];
            return response()->json($data, 200);
        }

        return response()->json($producto, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);

        if(!$producto) {
            return response()->json([
                'message' => 'Producto no encontrado',
                'status'  => 404
            ], 404);
        }

        $rules = $request->isMethod('put') ? [
            'nombre'         => 'required|string|max:255',
            'precio_compra'  => 'required|numeric|min:0',
            'precio_venta'   => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'categoria_id'   => 'required|exists:categorias,id',
        ] : [
            'nombre'         => 'sometimes|string|max:255',
            'precio_compra'  => 'sometimes|numeric|min:0',
            'precio_venta'   => 'sometimes|numeric|min:0',
            'stock'          => 'sometimes|integer|min:0',
            'categoria_id'   => 'sometimes|exists:categorias,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al actualizar el producto',
                'status'  => 400,
                'errors'  => $validator->errors()
            ], 400);
        }

        if ($request->has('nombre')) {
            $producto->nombre = $request->input('nombre');
        }
        if ($request->has('precio_compra')) {
            $producto->precio_compra = $request->input('precio_compra');
        }
        if ($request->has('precio_venta')) {
            $producto->precio_venta = $request->input('precio_venta');
        }
        if ($request->has('stock')) {
            $producto->stock = $request->input('stock');
        }
        if ($request->has('categoria_id')) {
            $producto->categoria_id = $request->input('categoria_id');
        }

        $producto->save();

        return response()->json([
            'message' => 'Producto actualizado correctamente',
            'status'  => 200,
            'producto' => $producto
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'message' => 'Producto no encontrado',
                'status'  => 404
            ], 404);
        }

        $producto->delete();

        return response()->json([
            'message' => 'Producto eliminado correctamente',
            'status'  => 200
        ], 200);
    }
}
