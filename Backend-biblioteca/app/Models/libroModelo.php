<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class libroModelo extends Model
{
    use HasFactory;

    protected $table = 'libro';

    // Add the fillable property to allow mass assignment
    protected $fillable = [
        'nombre',
        'cantidad',
        'especialidad',
        'bibliografia',
        'FK_categoria',
        'FK_proveedor',
        'FK_autor',
    ];

    // Define relationships if needed
    public function categoria()
    {
        return $this->belongsTo(categoriaModelo::class, 'FK_categoria');
    }

    public function proveedor()
    {
        return $this->belongsTo(proveedorModelo::class, 'FK_proveedor');
    }

    public function autor()
    {
        return $this->belongsTo(autorModelo::class, 'FK_autor');
    }
}
