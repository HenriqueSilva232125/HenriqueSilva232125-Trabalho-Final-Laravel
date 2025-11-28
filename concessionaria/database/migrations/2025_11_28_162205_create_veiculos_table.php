<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->id();
            $table->string('modelo');
            $table->year('ano');
            $table->decimal('preco', 10, 2);
            $table->unsignedBigInteger('marca_id');
            $table->string('foto')->nullable(); 
            $table->timestamps();

            $table->foreign('marca_id')->references('id')->on('marcas')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('veiculos');
    }
};

