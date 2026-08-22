<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('locales', function (Blueprint $table) {
            $table->id();

            $table->string('codigo', 20)->unique();

            $table->string('nombre');

            $table->string('direccion')->nullable();

            $table->string('telefono', 30)->nullable();

            $table->boolean('estado')->default(true);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('locales');
    }
};