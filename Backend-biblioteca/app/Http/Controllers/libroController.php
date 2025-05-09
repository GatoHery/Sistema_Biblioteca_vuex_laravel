<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\proveedorModelo;
use App\Models\autorModelo;
use App\Models\categoriaModelo;
use App\Models\libroModelo;

class libroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $libroModelo = libroModelo::select(
                'libro.id',
                'libro.nombre',
                'libro.cantidad',
                'libro.especialidad',
                'libro.bibliografia',
                'categoria.nombre as FK_categoria',
                'proveedor.nombre as FK_proveedor',
                'autor.nombre as FK_autor',
            )
            ->join('autor', 'libro.FK_autor', '=', 'autor.id')
            ->join('proveedor', 'libro.FK_proveedor', '=', 'proveedor.id')
            ->join('categoria', 'libro.FK_categoria', '=', 'categoria.id')
            ->get();

            if ($libroModelo->count() > 0) {
                return response()->json([
                    'code' => 200,
                    'data' => $libroModelo
                ], 200);
            } else {
                return response()->json([
                    'code' => 404,
                    'data' => 'No hay libros disponibles'
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'required|integer',
            'especialidad' => 'required|string|max:255',
            'bibliografia' => 'required|string|max:255',
            'FK_categoria' => 'required|integer|exists:categoria,id',
            'FK_proveedor' => 'required|integer|exists:proveedor,id',
            'FK_autor' => 'required|integer|exists:autor,id',
        ]);

        $libro = libroModelo::create($validatedData);

        \Log::info('Libro created successfully', ['data' => $libro]);

        return response()->json($libro, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $libro = libroModelo::with(['categoria', 'proveedor', 'autor'])->find($id);

        if (!$libro) {
            \Log::error('Libro not found', ['id' => $id]);
            return response()->json(['message' => 'Libro not found'], 404);
        }

        \Log::info('Libro retrieved successfully', ['data' => $libro]);

        return response()->json($libro);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'cantidad' => 'sometimes|required|integer',
            'especialidad' => 'sometimes|required|string|max:255',
            'bibliografia' => 'sometimes|required|string|max:255',
            'FK_categoria' => 'sometimes|required|integer|exists:categoria,id',
            'FK_proveedor' => 'sometimes|required|integer|exists:proveedor,id',
            'FK_autor' => 'sometimes|required|integer|exists:autor,id',
        ]);

        $libro = libroModelo::find($id);

        if (!$libro) {
            \Log::error('Libro not found', ['id' => $id]);
            return response()->json(['message' => 'Libro not found'], 404);
        }

        $libro->update($request->all());

        \Log::info('Libro updated successfully', ['data' => $libro]);

        return response()->json($libro);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $libro = libroModelo::find($id);

        if (!$libro) {
            \Log::error('Libro not found', ['id' => $id]);
            return response()->json(['message' => 'Libro not found'], 404);
        }

        $libro->delete();

        \Log::info('Libro deleted successfully', ['id' => $id]);

        return response()->json(['message' => 'Libro deleted successfully']);
    }
}
