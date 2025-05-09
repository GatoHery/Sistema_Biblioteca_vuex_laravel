<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrestamoModelo;
use App\Models\User;
use App\Models\LibroModelo;

class prestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestamos = PrestamoModelo::select(
            'prestamo.id',
            'prestamo.precio',
            'prestamo.tipo',
            'users.nombre as usuario_nombre', // Nombre del usuario
            'libro.nombre as libro_nombre',  // Nombre del libro
            'libro.bibliografia as libro_bibliografia', // Bibliografía del libro
            'libro.especialidad as libro_especialidad', // Especialidad del libro
            'categoria.nombre as categoria_nombre', // Nombre de la categoría
            'proveedor.nombre as proveedor_nombre', // Nombre del proveedor
        )
        ->join('users', 'prestamo.FK_usuario', '=', 'users.id') // Join con la tabla users
        ->join('libro', 'prestamo.FK_libro', '=', 'libro.id')   // Join con la tabla libro
        ->join('categoria', 'libro.FK_categoria', '=', 'categoria.id') // Join con la tabla categoria
        ->join('proveedor', 'libro.FK_proveedor', '=', 'proveedor.id') // Join con la tabla proveedor
        ->get();

        return response()->json($prestamos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'precio' => 'required|numeric',
            'tipo' => 'required|string',
            'FK_usuario' => 'required|exists:users,id',
            'FK_libro' => 'required|exists:libro,id',
        ]);

        try {
            $prestamo = PrestamoModelo::create($request->all());
            return response()->json([
                'message' => 'Prestamo creado con éxito',
                'data' => $prestamo
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el prestamo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prestamo = PrestamoModelo::with(['usuario', 'libro'])->find($id);
        if (!$prestamo) {
            return response()->json(['message' => 'Prestamo not found'], 404);
        }
        return response()->json($prestamo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $prestamo = PrestamoModelo::find($id);
        if (!$prestamo) {
            return response()->json(['message' => 'Prestamo not found'], 404);
        }

        $request->validate([
            'precio' => 'sometimes|required|numeric',
            'tipo' => 'sometimes|required|string',
            'FK_usuario' => 'sometimes|required|exists:users,id',
            'FK_libro' => 'sometimes|required|exists:libro,id',
        ]);

        $prestamo->update($request->all());
        return response()->json($prestamo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prestamo = PrestamoModelo::find($id);
        if (!$prestamo) {
            return response()->json(['message' => 'Prestamo not found'], 404);
        }

        $prestamo->delete();
        return response()->json(['message' => 'Prestamo deleted successfully']);
    }
}
