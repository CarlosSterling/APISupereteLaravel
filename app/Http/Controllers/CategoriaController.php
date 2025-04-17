<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::all();

        if ($categorias->isEmpty()) {
            $date = [
                'message' => 'No hay categorias disponibles',
                'status' => 200
            ];
            return response()->json($date, 400);
        }

        return response()->json($categorias, 200);
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
            'nombre' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error al crear la categoria',
                'status' => 400,
                'errors' => $validator->errors()
            ];
            return response()->json($data, 400);
        }

        $categorias = Categoria::create([
            'nombre' => $request->nombre,
        ]);

        if (!$categorias) {
            $data = [
                'message' => 'Error al crear la categoria',
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $data = [
            'message' => 'Categoria creada con exito',
            'status' => 200,
            'data' => $categorias
        ];
        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $categorias = Categoria::find($id);

        if (!$categorias) {
            $data = [
                'message' => 'Categoria no encontrada',
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        return response()->json($categorias, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id) {}


    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        // Buscar la categoría por ID
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json([
                'message' => 'Categoría no encontrada',
                'status'  => 404
            ], 404);
        }

        // Validaciones diferentes para PUT y PATCH
        $rules = $request->isMethod('put')
            ? ['nombre' => 'required|string|max:255']
            : ['nombre' => 'sometimes|string|max:255'];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación',
                'errors'  => $validator->errors(),
                'status'  => 400
            ], 400);
        }

        /* Solo actualiza si el campo fue enviado
        if ($request->has('nombre')) {
            $categoria->nombre = $request->nombre;
        }*/

        $categoria->fill($request->only([
            'nombre'
        ]));

        $categoria->save();

        return response()->json([
            'message' => 'Categoría actualizada con éxito',
            'status'  => 200,
            'data'    => $categoria
        ], 200);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $categorias = Categoria::find($id);

        if (!$categorias) {
            $data = [
                'message' => 'Categoria no encontrada',
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $categorias->delete();

        $data = [
            'message' => 'Categoria eliminada con exito',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
