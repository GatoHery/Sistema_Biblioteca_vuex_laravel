<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\proveedorModelo;

class proveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = proveedorModelo::all();
        return response()->json($proveedores);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:255',
        ]);

        $proveedor = proveedorModelo::create($request->all());

        \Log::info('Proveedor created successfully', ['data' => $proveedor]);

        return response()->json($proveedor, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $proveedor = proveedorModelo::find($id);

        if (!$proveedor) {
            \Log::error('Proveedor not found', ['id' => $id]);
            return response()->json(['message' => 'Proveedor not found'], 404);
        }

        \Log::info('Proveedor retrieved successfully', ['data' => $proveedor]);

        return response()->json($proveedor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'codigo' => 'sometimes|required|string|max:255',
        ]);

        $proveedor = proveedorModelo::find($id);

        if (!$proveedor) {
            \Log::error('Proveedor not found for update', ['id' => $id]);
            return response()->json(['message' => 'Proveedor not found'], 404);
        }

        $proveedor->update($request->all());

        \Log::info('Proveedor updated successfully', ['data' => $proveedor]);

        return response()->json($proveedor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proveedor = proveedorModelo::find($id);

        if (!$proveedor) {
            \Log::error('Proveedor not found for deletion', ['id' => $id]);
            return response()->json(['message' => 'Proveedor not found'], 404);
        }

        $proveedor->delete();

        \Log::info('Proveedor deleted successfully', ['id' => $id]);

        return response()->json(['message' => 'Proveedor deleted successfully']);
    }
}
