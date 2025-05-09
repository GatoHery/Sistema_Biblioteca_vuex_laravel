<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\usuarioModelo;
use App\Models\pedidoModelo;
use App\Models\libroModelo;

class pedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = pedidoModelo::with(['usuario', 'libro'])->get();
        return response()->json($pedidos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'FK_usuario' => 'required|exists:users,id', // Cambiar 'usuario' a 'users' si la tabla es 'users'
            'FK_libro' => 'required|exists:libro,id', // Cambiar 'libro' a 'libros' si la tabla es 'libros'
        ]);

        try {
            $pedido = new pedidoModelo();
            $pedido->FK_usuario = $request->FK_usuario;
            $pedido->FK_libro = $request->FK_libro;
            $pedido->save();

            return response()->json([
                'message' => 'Pedido creado con éxito',
                'data' => $pedido
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el pedido',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pedido = pedidoModelo::with(['usuario', 'libro'])->find($id);

        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        return response()->json($pedido);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pedido = pedidoModelo::find($id);

        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        $request->validate([
            'FK_usuario' => 'sometimes|required|exists:usuario,id',
            'FK_libro' => 'sometimes|required|exists:libro,id',
        ]);

        if ($request->has('FK_usuario')) {
            $pedido->FK_usuario = $request->FK_usuario;
        }
        if ($request->has('FK_libro')) {
            $pedido->FK_libro = $request->FK_libro;
        }

        $pedido->save();

        return response()->json($pedido);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pedido = pedidoModelo::find($id);

        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        $pedido->delete();

        return response()->json(['message' => 'Pedido eliminado con éxito']);
    }
}
