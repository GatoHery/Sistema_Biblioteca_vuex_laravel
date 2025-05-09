<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\categoriaModelo;

class categoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = categoriaModelo::all();
        return response()->json($categorias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $categoria = new categoriaModelo();
        $categoria->nombre = $request->nombre;
        $categoria->save();

        return response()->json([
            'message' => 'Categoria created successfully',
            'data' => $categoria
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categoria = categoriaModelo::find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoria not found'], 404);
        }

        return response()->json([
            'message' => 'Categoria retrieved successfully',
            'data' => $categoria
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $categoria = categoriaModelo::find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoria not found'], 404);
        }

        $categoria->nombre = $request->nombre;
        $categoria->save();

        return response()->json([
            'message' => 'Categoria updated successfully',
            'data' => $categoria
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoria = categoriaModelo::find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoria not found'], 404);
        }

        $categoria->delete();

        return response()->json(['message' => 'Categoria deleted successfully']);
    }
}
