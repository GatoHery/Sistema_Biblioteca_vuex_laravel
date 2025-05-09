<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\autorModelo;

class autorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $autores = autorModelo::select(
            'autor.id',
            'autor.nombre',
            'autor.apellido',
            'proveedor.nombre as FK_proveedor' // Seleccionar el nombre del proveedor
        )
        ->join('proveedor', 'autor.FK_proveedor', '=', 'proveedor.id') // Realizar el join con la tabla proveedor
        ->get();

        return response()->json($autores);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'FK_proveedor' => 'required|integer|exists:proveedor,id',
        ]);

        $autor = autorModelo::create($request->all());

        \Log::info('Autor created successfully', ['data' => $autor]);

        return response()->json($autor, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $autor = autorModelo::find($id);

        if (!$autor) {
            \Log::error('Autor not found', ['id' => $id]);
            return response()->json(['message' => 'Autor not found'], 404);
        }

        \Log::info('Autor retrieved successfully', ['data' => $autor]);

        return response()->json($autor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'apellido' => 'sometimes|required|string|max:255',
            'FK_proveedor' => 'sometimes|required|integer|exists:proveedor,id',
        ]);

        $autor = autorModelo::find($id);

        if (!$autor) {
            \Log::error('Autor not found', ['id' => $id]);
            return response()->json(['message' => 'Autor not found'], 404);
        }

        $autor->update($request->all());

        \Log::info('Autor updated successfully', ['data' => $autor]);

        return response()->json($autor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $autor = autorModelo::find($id);

        if (!$autor) {
            \Log::error('Autor not found for deletion', ['id' => $id]);
            return response()->json(['message' => 'Autor not found'], 404);
        }

        $autor->delete();

        \Log::info('Autor deleted successfully', ['id' => $id]);

        return response()->json(['message' => 'Autor deleted successfully']);
    }
}
