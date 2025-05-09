<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class categoriaModelo extends Model
{
    use HasFactory;

    protected $table = 'categoria';

    protected $fillable = [
        'id',
        'nombre',
    ];
}
