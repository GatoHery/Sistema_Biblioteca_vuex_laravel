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
        Schema::create('libro', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255)->nullable(); // Make the column nullable
            $table->string('cantidad', 255)->nullable();
            $table->string('especialidad', 255)->nullable();
            $table->string('bibliografia', 255)->nullable();
            $table->unsignedBigInteger('FK_categoria')->nullable(); // Make FK_categoria nullable
            $table->unsignedBigInteger('FK_proveedor')->nullable();
            $table->unsignedBigInteger('FK_autor')->nullable();
            $table->timestamps();

            $table->foreign('FK_categoria')->references('id')->on('categoria')->onDelete('cascade');
            $table->foreign('FK_proveedor')->references('id')->on('proveedor')->onDelete('cascade');
            $table->foreign('FK_autor')->references('id')->on('autor')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libro');
    }
};
