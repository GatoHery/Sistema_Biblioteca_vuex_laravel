<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pedidoModelo extends Model
{
    use HasFactory;

    protected $table = 'pedido'; // Nombre de la tabla
    protected $fillable = ['FK_usuario', 'FK_libro']; // Campos permitidos para asignación masiva

    public function usuario()
    {
        return $this->belongsTo(User::class, 'FK_usuario');
    }

    public function libro()
    {
        return $this->belongsTo(Libro::class, 'FK_libro');
    }
}
