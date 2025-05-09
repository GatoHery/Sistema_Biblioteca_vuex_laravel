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
        Schema::create('autor', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255)->nullable(false);
            $table->string('apellido', 255)->nullable(false);
            $table->unsignedBigInteger('FK_proveedor')->nullable(false);
            $table->timestamps();

            $table->foreign('FK_proveedor')->references('id')->on('proveedor')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autor');
    }
};
