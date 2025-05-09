<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrestamoModelo extends Model
{
    use HasFactory;

    protected $table = 'prestamo';

    protected $fillable = [
        'precio',
        'tipo',
        'FK_usuario',
        'FK_libro',
    ];

    public function libro()
    {
        return $this->belongsTo(LibroModelo::class, 'FK_libro', 'id');
    }
    public function usuario()
    {
        return $this->belongsTo(User::class, 'FK_usuario', 'id');
    }

    public $timestamps = false;
}
