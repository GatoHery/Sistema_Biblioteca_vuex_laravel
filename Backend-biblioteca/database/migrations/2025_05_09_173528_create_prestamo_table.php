<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prestamo', function (Blueprint $table) {
            $table->id();
            $table->decimal('precio');
            $table->string('tipo');
            $table->foreignId('FK_usuario')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('FK_libro')->constrained('libro', 'id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('prestamo')) {
            Schema::table('prestamo', function (Blueprint $table) {
                $table->dropForeign(['FK_usuario']); // Eliminar clave foránea de FK_usuario
                $table->dropForeign(['FK_libro']);   // Eliminar clave foránea de FK_libro
            });
        }
        Schema::dropIfExists('prestamo'); // Luego eliminar la tabla
    }
};
