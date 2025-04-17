<?php

namespace App\Http\Controllers;

use App\Models\DetallesCaja;
use App\Models\DetallesDiaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DetallesCajaController extends Controller
{
    public function index()
    {
        $DetallesCaja = DetallesCaja::all();

        if ($DetallesCaja->isEmpty()) {
            return response()->json([
                'message' => 'No hay registros de detalles de caja diaria',
                'data'    => [],
                'status'  => 200
            ], 200);
        }

        return response()->json([
            'message' => 'Registros encontrados',
            'data'    => $DetallesCaja,
            'status'  => 200
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'           => 'required|string|max:255',
            'descripcion'      => 'required|string',
            'tipo'             => 'required|in:ingreso,egreso',
            'monto'            => 'required|numeric|min:0',
            'fecha'            => 'required|date',
            'caja_diaria_id'   => 'required|integer|exists:caja_diaria,id',
            'transaccion_id'   => 'required|integer|exists:transaccion,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al registrar el detalle',
                'errors'  => $validator->errors(),
                'status'  => 400
            ], 400);
        }

        $registro = DetallesCaja::create($request->only([
            'nombre',
            'descripcion',
            'tipo',
            'monto',
            'fecha',
            'caja_diaria_id',
            'transaccion_id'
        ]));

        return response()->json([
            'message' => 'Detalle registrado correctamente',
            'data'    => $registro,
            'status'  => 201
        ], 201);
    }

    public function show($id)
    {
        $DetallesCaja = DetallesCaja::find($id);

        if (!$DetallesCaja) {
            return response()->json([
                'message' => 'Detalle no encontrado',
                'status'  => 404
            ], 404);
        }

        return response()->json([
            'message' => 'Detalle encontrado',
            'data'    => $DetallesCaja,
            'status'  => 200
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $DetallesCaja = DetallesCaja::find($id);

        if (!$DetallesCaja) {
            return response()->json([
                'message' => 'Detalle no encontrado',
                'status'  => 404
            ], 404);
        }

        $rules = $request->isMethod('put') ? [
            'nombre'           => 'required|string|max:255',
            'descripcion'      => 'required|string',
            'tipo'             => 'required|in:ingreso,egreso',
            'monto'            => 'required|numeric|min:0',
            'fecha'            => 'required|date',
            'caja_diaria_id'   => 'required|integer|exists:caja_diaria,id',
            'transaccion_id'   => 'required|integer|exists:transaccion,id',
        ] : [
            'nombre'           => 'sometimes|string|max:255',
            'descripcion'      => 'sometimes|string',
            'tipo'             => 'sometimes|in:ingreso,egreso',
            'monto'            => 'sometimes|numeric|min:0',
            'fecha'            => 'sometimes|date',
            'caja_diaria_id'   => 'sometimes|integer|exists:caja_diaria,id',
            'transaccion_id'   => 'sometimes|integer|exists:transaccion,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al actualizar el detalle',
                'errors'  => $validator->errors(),
                'status'  => 400
            ], 400);
        }

        $DetallesCaja->update($request->only([
            'nombre',
            'descripcion',
            'tipo',
            'monto',
            'fecha',
            'caja_diaria_id',
            'transaccion_id'
        ]));

        return response()->json([
            'message' => 'Detalle actualizado correctamente',
            'data'    => $DetallesCaja,
            'status'  => 200
        ], 200);
    }

    public function destroy($id)
    {
        $registro = DetallesCaja::find($id);

        if (!$registro) {
            return response()->json([
                'message' => 'Detalle no encontrado',
                'status'  => 404
            ], 404);
        }

        $registro->delete();

        return response()->json([
            'message' => 'Detalle eliminado correctamente',
            'status'  => 200
        ], 200);
    }
}
