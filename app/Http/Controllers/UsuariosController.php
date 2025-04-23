<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use Illuminate\Http\JsonResponse;

class UsuariosController extends Controller
{
    public function index(): JsonResponse
    {
        $usuarios = Usuario::all();

        if ($usuarios->isEmpty()) {
            return response()->json([
                'message' => 'No hay usuarios disponibles',
                'status'  => 200
            ], 200);
        }

        return response()->json($usuarios, 200);
    }

    public function store(StoreUsuarioRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data['password'] = bcrypt($data['password']);

        $usuario = Usuario::create($data);

        return response()->json([
            'message' => 'Usuario creado exitosamente',
            'usuario' => $usuario,
            'status'  => 201
        ], 201);
    }

    public function create()
    {
        //
    }

    public function show($id): JsonResponse
    {
        $usuario = Usuario::find($id);

        if (! $usuario) {
            return response()->json([
                'message' => 'Usuario no encontrado',
                'status'  => 404
            ], 404);
        }

        return response()->json($usuario, 200);
    }

    public function update(UpdateUsuarioRequest $request, $id): JsonResponse
    {
        $usuario = Usuario::find($id);

        if (! $usuario) {
            return response()->json([
                'message' => 'Usuario no encontrado',
                'status'  => 404
            ], 404);
        }

        $usuario->update($request->validated());

        return response()->json([
            'message' => 'Usuario actualizado correctamente',
            'usuario' => $usuario,
            'status'  => 200
        ], 200);
    }

    public function destroy($id): JsonResponse
    {
        $usuario = Usuario::find($id);

        if (! $usuario) {
            return response()->json([
                'message' => 'Usuario no encontrado',
                'status'  => 404
            ], 404);
        }

        $usuario->delete();
        return response()->json([
            'message' => 'Usuario eliminado correctamente',
            'status'  => 200
        ], 200);

        return response()->json(null, 204);
    }
}
