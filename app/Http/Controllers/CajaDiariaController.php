<?php

namespace App\Http\Controllers;

use App\Models\CajaDiaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CajaDiariaController extends Controller
{
    public function index()
    {
        $registros = CajaDiaria::all();

        if ($registros->isEmpty()) {
            return response()->json([
                'message' => 'No hay registros de caja diaria disponibles',
                'data'    => [],
                'status'  => 200
            ], 200);
        }

        return response()->json([
            'message' => 'Registros de caja diaria encontrados',
            'data'    => $registros,
            'status'  => 200
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'          => 'required|string|max:255',
            'fecha_apertura'  => 'required|date',
            'fecha_cierre'    => 'required|date',
            'saldo_inicial'   => 'required|numeric',
            'saldo_final'     => 'nullable|numeric',
            'observacion'     => 'required|string',
            'abierta_por'     => 'required|integer|exists:usuarios,id',
            'cerrada_por'     => 'nullable|integer|exists:usuarios,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al crear la caja diaria',
                'errors'  => $validator->errors(),
                'status'  => 400
            ], 400);
        }

        $registro = CajaDiaria::create($request->only([
            'nombre',
            'fecha_apertura',
            'fecha_cierre',
            'saldo_inicial',
            'saldo_final',
            'observacion',
            'abierta_por',
            'cerrada_por'
        ]));

        return response()->json([
            'message' => 'Caja diaria creada correctamente',
            'data'    => $registro,
            'status'  => 201
        ], 201);
    }

    public function show($id)
    {
        $registro = CajaDiaria::find($id);

        if (!$registro) {
            return response()->json([
                'message' => 'Caja diaria no encontrada',
                'status'  => 404
            ], 404);
        }

        return response()->json([
            'message' => 'Caja diaria encontrada',
            'data'    => $registro,
            'status'  => 200
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $registro = CajaDiaria::find($id);

        if (!$registro) {
            return response()->json([
                'message' => 'Caja diaria no encontrada',
                'status'  => 404
            ], 404);
        }

        $rules = $request->isMethod('put') ? [
            'nombre'          => 'required|string|max:255',
            'fecha_apertura'  => 'required|date',
            'fecha_cierre'    => 'required|date',
            'saldo_inicial'   => 'required|numeric',
            'saldo_final'     => 'nullable|numeric',
            'observacion'     => 'required|string',
            'abierta_por'     => 'required|integer|exists:usuarios,id',
            'cerrada_por'     => 'nullable|integer|exists:usuarios,id',
        ] : [
            'nombre'          => 'sometimes|string|max:255',
            'fecha_apertura'  => 'sometimes|date',
            'fecha_cierre'    => 'sometimes|date',
            'saldo_inicial'   => 'sometimes|numeric',
            'saldo_final'     => 'nullable|numeric',
            'observacion'     => 'sometimes|string',
            'abierta_por'     => 'sometimes|integer|exists:usuarios,id',
            'cerrada_por'     => 'nullable|integer|exists:usuarios,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al actualizar la caja diaria',
                'errors'  => $validator->errors(),
                'status'  => 400
            ], 400);
        }

        $registro->update($request->only([
            'nombre',
            'fecha_apertura',
            'fecha_cierre',
            'saldo_inicial',
            'saldo_final',
            'observacion',
            'abierta_por',
            'cerrada_por'
        ]));

        return response()->json([
            'message' => 'Caja diaria actualizada correctamente',
            'data'    => $registro,
            'status'  => 200
        ], 200);
    }

    public function destroy($id)
    {
        $registro = CajaDiaria::find($id);

        if (!$registro) {
            return response()->json([
                'message' => 'Caja diaria no encontrada',
                'status'  => 404
            ], 404);
        }

        $registro->delete();

        return response()->json([
            'message' => 'Caja diaria eliminada correctamente',
            'status'  => 200
        ], 200);
    }
}
