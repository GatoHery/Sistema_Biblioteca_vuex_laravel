<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibroModelo extends Model
{
    use HasFactory;

    protected $table = 'libro'; // Nombre de la tabla
    protected $fillable = ['titulo', 'autor', 'editorial', 'anio_publicacion', 'cantidad']; // Campos permitidos
}
