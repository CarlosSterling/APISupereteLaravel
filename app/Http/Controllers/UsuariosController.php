<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = Usuarios::all();

        if ($usuarios->isEmpty()) {
            $data = [
                'message' => 'No hay usuarios disponibles',
                'status'  => 200
            ];
            return response()->json($data, 200);
        }
        return response()->json($usuarios);
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

            'password' => 'required|string|min:8|max:255',
            'username' => 'required|string|max:255|unique:usuarios,username',
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:usuarios,email',
            'rol'        => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al crear el usuario',
                'status'  => 400,
                'errors'  => $validator->errors()
            ], 400);
        }

        $usuario = Usuarios::create($request->only([

            'password',
            'username',
            'first_name',
            'last_name',
            'email',
            'rol',
        ]));

        if (!$usuario) {
            return response()->json([
                'message' => 'Error al crear el usuario',
                'status'  => 500
            ], 500);
        }

        return response()->json([
            'message' => 'Usuario creado exitosamente',
            'usuario' => $usuario,
            'status'  => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $usuario = Usuarios::find($id);

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuario no encontrado',
                'status'  => 404
            ], 404);
        }

        return response()->json($usuario);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usuarios $usuarios)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $usuarios = Usuarios::find($id);

        if (!$usuarios) {
            return response()->json([
                'message' => 'Usuario no encontrado',
                'status'  => 404
            ], 404);
        }

        $rules = $request->isMethod('put') ? [

            'password' => 'required|string|min:8|max:255',
            'username' => 'required|string|max:255|unique:usuarios,username',
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:usuarios,email',
            'rol'        => 'required|string|max:255',
        ] : [


            'password' => 'sometimes|string|min:8|max:255',
            'username' => 'sometimes|string|max:255|unique:usuarios,username',
            'first_name' => 'sometimes|string|max:255',
            'last_name'  => 'sometimes|string|max:255',
            'email'      => 'sometimes|string|email|max:255|unique:usuarios,email',
            'rol'        => 'sometimes|string|max:255',

        ];

        $validator = validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al actualizar el usuario',
                'status'  => 400,
                'errors'  => $validator->errors()
            ], 400);
        }

        $usuarios->fill($request->only([
            'password',
            'username',
            'first_name',
            'last_name',
            'email',
            'rol'
        ]));


        $usuarios->save();

        return response()->json([
            'message' => 'Usuario actualizado correctamente',
            'status'  => 200,
            'usuario' => $usuarios
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $usuarios = Usuarios::find($id);

        if (!$usuarios) {
            return response()->json([
                'message' => 'Usuario no encontrado',
                'status'  => 404
            ], 404);
        }
        $usuarios->delete();
    }
}
