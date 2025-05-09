<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class autorModelo extends Model
{
    use HasFactory;

    protected $table = 'autor';

    protected $fillable = [
        'id',
        'nombre',
        'apellido',
        'FK_proveedor'
    ];

    public function proveedor()
    {
        return $this->belongsTo(proveedorModelo::class, 'FK_proveedor', 'id');
    }
}
