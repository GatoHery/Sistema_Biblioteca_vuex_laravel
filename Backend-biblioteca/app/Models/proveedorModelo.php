<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class proveedorModelo extends Model
{
    use HasFactory;

    protected $table = 'proveedor';

    protected $fillable = [
        'id',
        'nombre',
        'codigo'
    ];
}
