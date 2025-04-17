<?php

namespace App\Http\Controllers;

use App\Models\Transaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransaccionController extends Controller
{
    public function index()
    {
        $transacciones = Transaccion::all();

        if ($transacciones->isEmpty()) {
            return response()->json([
                'message' => 'No hay transacciones registradas',
                'data'    => [],
                'status'  => 200
            ], 200);
        }

        return response()->json([
            'message' => 'Transacciones encontradas',
            'data'    => $transacciones,
            'status'  => 200
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'          => 'required|string|max:255',
            'descripcion'     => 'required|string',
            'tipo'            => 'required|in:compra,venta',
            'monto'           => 'required|numeric|min:0',
            'fecha'           => 'required|date',
            'caja_diaria_id'  => 'required|integer|exists:caja_diaria,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al registrar la transacción',
                'errors'  => $validator->errors(),
                'status'  => 400
            ], 400);
        }

        $transaccion = Transaccion::create($request->only([
            'nombre',
            'descripcion',
            'tipo',
            'monto',
            'fecha',
            'caja_diaria_id'
        ]));

        return response()->json([
            'message' => 'Transacción registrada correctamente',
            'data'    => $transaccion,
            'status'  => 201
        ], 201);
    }

    public function show($id)
    {
        $transaccion = Transaccion::find($id);

        if (!$transaccion) {
            return response()->json([
                'message' => 'Transacción no encontrada',
                'status'  => 404
            ], 404);
        }

        return response()->json([
            'message' => 'Transacción encontrada',
            'data'    => $transaccion,
            'status'  => 200
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $transaccion = Transaccion::find($id);

        if (!$transaccion) {
            return response()->json([
                'message' => 'Transacción no encontrada',
                'status'  => 404
            ], 404);
        }

        $rules = $request->isMethod('put') ? [
            'nombre'          => 'required|string|max:255',
            'descripcion'     => 'required|string',
            'tipo'            => 'required|in:compra,venta',
            'monto'           => 'required|numeric|min:0',
            'fecha'           => 'required|date',
            'caja_diaria_id'  => 'required|integer|exists:caja_diaria,id',
        ] : [
            'nombre'          => 'sometimes|string|max:255',
            'descripcion'     => 'sometimes|string',
            'tipo'            => 'sometimes|in:compra,venta',
            'monto'           => 'sometimes|numeric|min:0',
            'fecha'           => 'sometimes|date',
            'caja_diaria_id'  => 'sometimes|integer|exists:caja_diaria,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al actualizar la transacción',
                'errors'  => $validator->errors(),
                'status'  => 400
            ], 400);
        }

        $transaccion->update($request->only([
            'nombre',
            'descripcion',
            'tipo',
            'monto',
            'fecha',
            'caja_diaria_id'
        ]));

        return response()->json([
            'message' => 'Transacción actualizada correctamente',
            'data'    => $transaccion,
            'status'  => 200
        ], 200);
    }

    public function destroy($id)
    {
        $transaccion = Transaccion::find($id);

        if (!$transaccion) {
            return response()->json([
                'message' => 'Transacción no encontrada',
                'status'  => 404
            ], 404);
        }

        $transaccion->delete();

        return response()->json([
            'message' => 'Transacción eliminada correctamente',
            'status'  => 200
        ], 200);
    }
}
