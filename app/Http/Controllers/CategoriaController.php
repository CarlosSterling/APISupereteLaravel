<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\JsonResponse;

class CategoriaController extends Controller
{
    public function index(): JsonResponse
    {
        $categorias = Categoria::all();

        if ($categorias->isEmpty()) {
            return response()->json([
                'message' => 'No hay categorías disponibles',
                'status'  => 200
            ], 200);
        }

        return response()->json([
            'data'   => $categorias,
            'status' => 200
        ], 200);
    }

    public function show($id): JsonResponse
    {
        $categoria = Categoria::find($id);

        if (! $categoria) {
            return response()->json([
                'message' => 'Categoría no encontrada',
                'status'  => 404
            ], 404);
        }

        return response()->json([
            'data'   => $categoria,
            'status' => 200
        ], 200);
    }


    public function store(StoreCategoriaRequest $request): JsonResponse
    {
        $categoria = Categoria::create($request->validated());

        return response()->json([
            'message' => 'Categoría creada con éxito',
            'data'    => $categoria,
            'status'  => 201
        ], 201);
    }


    public function update(UpdateCategoriaRequest $request, $id): JsonResponse
    {

        $categoria = Categoria::find($id);

        if (! $categoria) {
            return response()->json([
                'message' => 'Categoría no encontrada',
                'status'  => 404
            ], 404);
        }

        $categoria->update($request->validated());

        return response()->json([
            'message' => 'Categoría actualizada con éxito',
            'data'    => $categoria,
            'status'  => 200
        ], 200);
    }

    public function destroy($id): JsonResponse
    {
        $categoria = Categoria::find($id);

        if (! $categoria) {
            return response()->json([
                'message' => 'Categoría no encontrada',
                'status'  => 404
            ], 404);
        }

        $categoria->delete();

        return response()->json([
            'message' => 'Categoría eliminada con éxito',
            'status'  => 200
        ], 200);
    }
}
